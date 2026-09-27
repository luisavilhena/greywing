<?php
/**
 * Registro dos campos ACF Pro do tema.
 *
 * Layout novo: cada página tem seu próprio grupo de campos (não é mais um
 * "content_blocks" único e genérico pra todas) — cada seção é exclusiva da
 * página onde vive. Este arquivo só junta os pedaços reaproveitados
 * (shared-fields.php) e os grupos de Opções do Tema; cada arquivo
 * "*-sections.php"/"*-fields.php" registra o próprio grupo de campos.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Pedaços de campo reaproveitados entre seções (título, âncora, texto, cor).
require_once GREYWING_THEME_DIR . '/inc/acf-fields/shared-fields.php';

// Campos exclusivos de cada página — cada arquivo já se registra sozinho
// (add_action('acf/init', ...) dentro dele mesmo), então só precisam ser
// incluídos aqui.
require_once GREYWING_THEME_DIR . '/inc/acf-fields/about-sections.php';
require_once GREYWING_THEME_DIR . '/inc/acf-fields/funds-sections.php';
require_once GREYWING_THEME_DIR . '/inc/acf-fields/contact-fields.php';
require_once GREYWING_THEME_DIR . '/inc/acf-fields/login-fields.php';

// Footer e Aviso de elegibilidade: conteúdo do site inteiro, numa Página de
// Opções (Opções do Tema), não de uma página específica.
require_once GREYWING_THEME_DIR . '/inc/acf-fields/options-footer.php';
require_once GREYWING_THEME_DIR . '/inc/acf-fields/options-disclaimer.php';
