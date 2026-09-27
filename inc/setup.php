<?php
/**
 * Setup do tema: theme supports, menu nativo e helpers pequenos
 * reaproveitados pelos template-parts.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greywing_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	register_nav_menus(
		array(
			'primary' => 'Menu principal (header)',
		)
	);

	add_image_size( 'greywing-full', 1800, 1800, false );
}
add_action( 'after_setup_theme', 'greywing_theme_setup' );

function greywing_allow_svg_upload( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'greywing_allow_svg_upload' );

/**
 * Atributo "id" pronto pra colar numa tag, a partir do campo "Âncora" de
 * uma seção — vira o alvo de um link do menu (ex.: "#about-us").
 *
 * @param string $anchor Valor bruto do campo "Âncora".
 * @return string Atributo id="...", ou string vazia se não tiver âncora.
 */
function greywing_anchor_attr( $anchor ) {
	return $anchor ? ' id="' . esc_attr( sanitize_title( $anchor ) ) . '"' : '';
}

/**
 * Classe CSS de cor de fundo da seção — ver greywing_field_section_theme()
 * em inc/acf-fields/shared-fields.php e as classes .gw-t-* em
 * assets/css/base.css.
 *
 * @param string $value Valor do campo (ex.: 'navy', 'clay'...).
 * @return string Classe pronta pra colar na lista de classes, com espaço na frente.
 */
function greywing_section_theme_class( $value ) {
	return ' gw-t-' . sanitize_html_class( $value ?: 'navy' );
}

/**
 * Logo em SVG inline (não <img>) — o CSS pinta o logo com "currentColor"
 * (branco no modal do aviso, bege no header), o que só funciona com o SVG
 * inline no HTML, não referenciado por src.
 */
function greywing_logo_svg() {
	static $svg = null;
	if ( null === $svg ) {
		$path = GREYWING_THEME_DIR . '/assets/img/logo.svg';
		$svg  = file_exists( $path ) ? file_get_contents( $path ) : '';
	}
	echo $svg; // phpcs:ignore -- arquivo fixo do tema, não input de usuário.
}

/**
 * Marca de submenu do header: WordPress chama a "sub-menu" por padrão, o
 * CSS do layout novo espera "gw-nav__sub" (ver .gw-nav__sub em base.css).
 */
function greywing_nav_submenu_class( $classes ) {
	$classes[] = 'gw-nav__sub';
	return $classes;
}
add_filter( 'nav_menu_submenu_css_class', 'greywing_nav_submenu_class' );

/**
 * aria-current="page" no link do menu ativo — o CSS usa esse atributo pra
 * desenhar o sublinhado do item atual (ver .gw-nav>ul>li>a[aria-current] em
 * base.css).
 */
function greywing_nav_link_attributes( $atts, $item ) {
	if ( in_array( 'current-menu-item', $item->classes, true ) || in_array( 'current-menu-ancestor', $item->classes, true ) ) {
		$atts['aria-current'] = 'page';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'greywing_nav_link_attributes', 10, 2 );

/**
 * O item "Login" do menu ganha a classe "gw-nav__login" (ícone + texto,
 * estilo diferente dos outros itens — ver .gw-nav__login em base.css).
 * Identificado pelo título porque é editado em Aparência → Menus, não tem
 * um ID fixo.
 */
function greywing_nav_item_classes( $classes, $item ) {
	if ( 0 === strcasecmp( trim( $item->title ), 'login' ) ) {
		$classes[] = 'gw-nav__login';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'greywing_nav_item_classes', 10, 2 );
