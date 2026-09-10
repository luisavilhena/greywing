<?php
/**
 * Greywing theme bootstrap.
 *
 * Mantém o functions.php enxuto: cada responsabilidade fica no seu próprio
 * arquivo dentro de /inc, e os campos de cada componente ACF ficam em
 * /inc/acf-fields, um arquivo por componente.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GREYWING_THEME_VERSION', '1.0.0' );
define( 'GREYWING_THEME_DIR', get_template_directory() );
define( 'GREYWING_THEME_URI', get_template_directory_uri() );

require_once GREYWING_THEME_DIR . '/inc/setup.php';
require_once GREYWING_THEME_DIR . '/inc/enqueue.php';
require_once GREYWING_THEME_DIR . '/inc/acf-fields.php';
require_once GREYWING_THEME_DIR . '/inc/disclaimer-consent.php';
