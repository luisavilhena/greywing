<?php
/**
 * Registro de consentimento do aviso de elegibilidade (disclaimer gate).
 *
 * - Cookie de 15 dias: quem já decidiu (aceitou OU recusou) não vê o aviso
 *   de novo enquanto o cookie for válido para a versão atual do aviso.
 * - Cada decisão (aceitar/recusar) também é gravada numa tabela própria do
 *   banco, com timestamp, IP, user agent, versão do aviso e URL da página —
 *   histórico que serve de prova de que a pessoa viu e decidiu.
 *
 * Não gravamos o país do visitante: estar fisicamente num país não diz nada
 * sobre nacionalidade/elegibilidade, então esse dado não tem valor de prova
 * aqui e só aumentaria o que coletamos sem necessidade.
 *
 * Ver template-parts/layout/disclaimer-gate.php (renderização + cookie
 * check) e assets/js/disclaimer-gate.js (chamada AJAX no clique).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GREYWING_DISCLAIMER_COOKIE', 'gw_disclaimer_consent' );
define( 'GREYWING_DISCLAIMER_COOKIE_DAYS', 15 );
define( 'GREYWING_DISCLAIMER_DB_VERSION', '1.0' );

/**
 * Nome completo da tabela de consentimentos, já com o prefixo do WP.
 */
function greywing_disclaimer_table_name() {
	global $wpdb;
	return $wpdb->prefix . 'greywing_disclaimer_consents';
}

/**
 * Cria (ou atualiza, via dbDelta) a tabela de consentimentos. dbDelta só
 * roda de fato quando GREYWING_DISCLAIMER_DB_VERSION muda em relação ao que
 * já rodou antes — checagem barata (get_option) em toda carga do admin.
 */
function greywing_disclaimer_maybe_create_table() {
	if ( get_option( 'greywing_disclaimer_db_version' ) === GREYWING_DISCLAIMER_DB_VERSION ) {
		return;
	}

	global $wpdb;
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';

	$table_name      = greywing_disclaimer_table_name();
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		consent_id VARCHAR(36) NOT NULL,
		created_at DATETIME NOT NULL,
		ip_address VARCHAR(45) NOT NULL,
		user_agent VARCHAR(255) NOT NULL,
		disclaimer_version VARCHAR(20) NOT NULL,
		page_url VARCHAR(255) NOT NULL,
		decision VARCHAR(20) NOT NULL,
		PRIMARY KEY  (id),
		KEY consent_id (consent_id),
		KEY created_at (created_at)
	) $charset_collate;";

	dbDelta( $sql );

	update_option( 'greywing_disclaimer_db_version', GREYWING_DISCLAIMER_DB_VERSION );
}
add_action( 'init', 'greywing_disclaimer_maybe_create_table' );

/**
 * IP do visitante. Prioriza X-Forwarded-For (site atrás de proxy/CDN em
 * produção) e cai pra REMOTE_ADDR — não é infalível contra spoofing, mas é
 * suficiente pro propósito de registro/auditoria, não de bloqueio de acesso.
 */
function greywing_get_visitor_ip() {
	if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$forwarded = explode( ',', wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
		$ip        = trim( $forwarded[0] );
	} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
		$ip = wp_unslash( $_SERVER['REMOTE_ADDR'] );
	} else {
		$ip = '';
	}

	return preg_match( '/^[a-fA-F0-9:.]{1,45}$/', $ip ) ? $ip : '';
}

/**
 * Versão atual do aviso (Opções do Tema). Sempre lida do servidor no
 * momento do registro — nunca confiamos num valor de versão vindo do
 * cliente, pra não permitir gravar consentimento associado à versão errada.
 */
function greywing_disclaimer_current_version() {
	$version = function_exists( 'get_field' ) ? get_field( 'version', 'option' ) : '';
	return $version ? $version : '1.0';
}

/**
 * A pessoa já decidiu (aceitou ou recusou) dentro dos últimos 15 dias, pra
 * versão atual do aviso? Se sim, o gate não precisa aparecer de novo.
 */
function greywing_disclaimer_has_valid_consent() {
	if ( empty( $_COOKIE[ GREYWING_DISCLAIMER_COOKIE ] ) ) {
		return false;
	}

	$cookie_value = sanitize_text_field( wp_unslash( $_COOKIE[ GREYWING_DISCLAIMER_COOKIE ] ) );
	$parts        = explode( ':', $cookie_value );
	$cookie_version = isset( $parts[0] ) ? $parts[0] : '';

	return $cookie_version !== '' && $cookie_version === greywing_disclaimer_current_version();
}

/**
 * Handler AJAX chamado pelo clique em "I Confirm and Enter" ou "I Do Not
 * Meet These Criteria" (assets/js/disclaimer-gate.js). Grava a decisão no
 * banco e, se foi aceite, seta o cookie de 15 dias.
 */
function greywing_disclaimer_handle_consent() {
	check_ajax_referer( 'greywing_disclaimer_consent', 'nonce' );

	$decision = isset( $_POST['decision'] ) ? sanitize_key( wp_unslash( $_POST['decision'] ) ) : '';
	if ( ! in_array( $decision, array( 'accepted', 'rejected' ), true ) ) {
		wp_send_json_error( array( 'message' => 'Decisão inválida.' ), 400 );
	}

	$page_url = isset( $_POST['page_url'] ) ? esc_url_raw( wp_unslash( $_POST['page_url'] ) ) : '';
	if ( ! $page_url ) {
		$page_url = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	}

	$consent_id = wp_generate_uuid4();
	$version    = greywing_disclaimer_current_version();

	global $wpdb;
	$wpdb->insert(
		greywing_disclaimer_table_name(),
		array(
			'consent_id'         => $consent_id,
			'created_at'         => current_time( 'mysql', true ), // UTC.
			'ip_address'         => greywing_get_visitor_ip(),
			'user_agent'         => isset( $_SERVER['HTTP_USER_AGENT'] ) ? substr( sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ), 0, 255 ) : '',
			'disclaimer_version' => $version,
			'page_url'           => substr( $page_url, 0, 255 ),
			'decision'           => $decision,
		),
		array( '%s', '%s', '%s', '%s', '%s', '%s', '%s' )
	);

	if ( 'accepted' === $decision ) {
		setcookie(
			GREYWING_DISCLAIMER_COOKIE,
			$version . ':' . $consent_id,
			array(
				'expires'  => time() + ( GREYWING_DISCLAIMER_COOKIE_DAYS * DAY_IN_SECONDS ),
				'path'     => '/',
				'secure'   => is_ssl(),
				'httponly' => true,
				'samesite' => 'Lax',
			)
		);
	}

	wp_send_json_success( array( 'consent_id' => $consent_id ) );
}
add_action( 'wp_ajax_greywing_disclaimer_consent', 'greywing_disclaimer_handle_consent' );
add_action( 'wp_ajax_nopriv_greywing_disclaimer_consent', 'greywing_disclaimer_handle_consent' );

require_once GREYWING_THEME_DIR . '/inc/disclaimer-consent-admin.php';
