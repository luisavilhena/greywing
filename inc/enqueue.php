<?php
/**
 * Carregamento de CSS e JS.
 *
 * Layout novo: cada página tem um CSS próprio (assets/css/{about,funds,
 * contact,login}.css) só com o que é exclusivo dela — o que é global
 * (tokens, header, empilhamento de seções, animações de reveal, aviso de
 * elegibilidade, rodapé) mora em base.css e carrega sempre.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Versão de cache-busting de um arquivo do tema: usa a data de modificação
 * do próprio arquivo — qualquer alteração já força o navegador a buscar a
 * versão nova, sem precisar lembrar de subir um número manualmente.
 *
 * @param string $relative_path Caminho relativo à raiz do tema, ex.: '/assets/css/base.css'.
 */
function greywing_asset_version( $relative_path ) {
	$file_path = GREYWING_THEME_DIR . $relative_path;
	return file_exists( $file_path ) ? filemtime( $file_path ) : GREYWING_THEME_VERSION;
}

function greywing_enqueue_styles() {
	$dir = GREYWING_THEME_URI . '/assets/css';

	// Google Fonts (Roboto) — o layout novo não usa mais fonte de título
	// separada (GT Sectra Display saiu), só pesos diferentes de Roboto.
	wp_enqueue_style(
		'greywing-fonts',
		'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'greywing-base', $dir . '/base.css', array( 'greywing-fonts' ), greywing_asset_version( '/assets/css/base.css' ) );

	// CSS exclusivo de cada página — só carrega no template correspondente.
	$page_styles = array(
		'page-templates/template-about.php'   => 'about',
		'page-templates/template-funds.php'   => 'funds',
		'page-templates/template-contact.php' => 'contact',
		'page-templates/template-login.php'   => 'login',
		'page-templates/template-legal.php'   => 'legal',
	);
	foreach ( $page_styles as $template => $slug ) {
		if ( is_page_template( $template ) ) {
			wp_enqueue_style( 'greywing-' . $slug, $dir . '/' . $slug . '.css', array( 'greywing-base' ), greywing_asset_version( '/assets/css/' . $slug . '.css' ) );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'greywing_enqueue_styles' );

function greywing_enqueue_scripts() {
	$js = GREYWING_THEME_URI . '/assets/js';

	// Animações de reveal (palavras/parágrafos) — em toda página.
	wp_enqueue_script( 'greywing-reveal', $js . '/reveal.js', array(), greywing_asset_version( '/assets/js/reveal.js' ), true );

	// Header: fica sólido ao rolar + menu mobile (burger). Em toda página.
	wp_enqueue_script( 'greywing-header', $js . '/header.js', array(), greywing_asset_version( '/assets/js/header.js' ), true );

	// Empilhamento de seções (.gw-card) — só nas páginas que têm mais de
	// uma seção empilhável (About e Funds); o script não faz nada em
	// páginas sem ".gw-stack".
	wp_enqueue_script( 'greywing-stack', $js . '/stack.js', array(), greywing_asset_version( '/assets/js/stack.js' ), true );

	// Aviso de elegibilidade — sempre carrega, aparece em toda página.
	// Registra a decisão (aceite/recusa) via AJAX — ver inc/disclaimer-consent.php.
	wp_enqueue_script( 'greywing-disclaimer-gate', $js . '/disclaimer-gate.js', array(), greywing_asset_version( '/assets/js/disclaimer-gate.js' ), true );
	wp_localize_script(
		'greywing-disclaimer-gate',
		'greywingDisclaimer',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'greywing_disclaimer_consent' ),
		)
	);

	// Gráfico de performance (troca de imagem por botão) — só na página de Funds.
	if ( is_page_template( 'page-templates/template-funds.php' ) ) {
		wp_enqueue_script( 'greywing-performance-chart', $js . '/performance-chart.js', array(), greywing_asset_version( '/assets/js/performance-chart.js' ), true );
	}
}
add_action( 'wp_enqueue_scripts', 'greywing_enqueue_scripts' );
