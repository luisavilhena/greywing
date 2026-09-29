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
 * HTML de um título que pode ter mais de uma linha (campo textarea — ver
 * greywing_field_title()). Cada Enter no campo vira um <br>. Já escapa o
 * texto, então o retorno pode ir direto num echo.
 *
 * A classe "gw-br" no <br> é o que assets/js/reveal.js procura pra não
 * tentar quebrar a quebra de linha em "palavras" ao montar o efeito
 * .gw-split.
 *
 * @param string $value Valor bruto do campo (pode ter \n).
 * @return string HTML pronto pra ecoar dentro de um h1/h2/h3.
 */
function greywing_title_html( $value ) {
	$value = trim( (string) $value );
	if ( '' === $value ) {
		return '';
	}
	$lines = preg_split( '/\r\n|\r|\n/', $value );
	$lines = array_map( 'esc_html', $lines );
	return implode( '<br class="gw-br">', $lines );
}

/**
 * Marca cada <p> de um HTML (já sanitizado com wp_kses_post) com a classe
 * "gw-rv" — o parágrafo entra com blur+fade+leve subida conforme a seção
 * aparece na tela (ver .gw-rv em base.css e o atraso automático por
 * parágrafo em assets/js/reveal.js, que só funciona dentro de um wrapper
 * ".gw-block").
 *
 * @param string $html HTML já sanitizado (wp_kses_post).
 * @return string Mesmo HTML, com "gw-rv" em cada <p>.
 */
function greywing_richtext_reveal( $html ) {
	return str_replace( '<p>', '<p class="gw-rv">', $html );
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

/**
 * Sanitiza código de SVG colado pelo editor (ver campo "svg_code" da Seção
 * 3 de Funds, inc/acf-fields/funds-sections.php) antes de ecoar direto no
 * HTML da página — wp_kses_post() sozinho não serve pra isso porque a lista
 * padrão de tags permitidas do WordPress nem inclui <svg> (some a tag
 * inteira), então aqui a gente define a própria lista.
 *
 * @param string $svg_code Código bruto colado no campo.
 * @return string SVG sanitizado, pronto pra ecoar direto no HTML.
 */
function greywing_kses_svg( $svg_code ) {
	// Atributos de aparência que praticamente qualquer elemento de forma
	// pode ter — evita repetir a mesma listona em cada tag abaixo.
	$shape_attrs = array(
		'fill' => true, 'fill-opacity' => true, 'stroke' => true, 'stroke-width' => true,
		'stroke-opacity' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true,
		'stroke-dasharray' => true, 'stroke-dashoffset' => true, 'opacity' => true,
		'class' => true, 'id' => true, 'style' => true, 'transform' => true,
	);
	$allowed = array(
		'svg'            => array(
			'xmlns' => true, 'viewbox' => true, 'width' => true, 'height' => true,
			'fill' => true, 'stroke' => true, 'class' => true, 'id' => true,
			'preserveaspectratio' => true, 'aria-hidden' => true, 'aria-labelledby' => true, 'role' => true, 'style' => true,
		),
		'g'              => $shape_attrs,
		'path'           => array_merge( $shape_attrs, array( 'd' => true ) ),
		// data-x/data-date/data-values/data-ys: usados pela interatividade ao
		// passar o mouse no gráfico de performance (assets/js/performance-chart.js)
		// — cada retângulo carrega a data + os valores já calculados daquele
		// ponto, sem precisar de nenhum cálculo feito no navegador.
		'rect'           => array_merge( $shape_attrs, array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'ry' => true, 'data-x' => true, 'data-date' => true, 'data-values' => true, 'data-ys' => true ) ),
		'circle'         => array_merge( $shape_attrs, array( 'cx' => true, 'cy' => true, 'r' => true ) ),
		'ellipse'        => array_merge( $shape_attrs, array( 'cx' => true, 'cy' => true, 'rx' => true, 'ry' => true ) ),
		'line'           => array_merge( $shape_attrs, array( 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true ) ),
		'polyline'       => array_merge( $shape_attrs, array( 'points' => true ) ),
		'polygon'        => array_merge( $shape_attrs, array( 'points' => true ) ),
		'text'           => array_merge( $shape_attrs, array( 'x' => true, 'y' => true, 'dx' => true, 'dy' => true, 'font-size' => true, 'font-family' => true, 'font-weight' => true, 'text-anchor' => true ) ),
		'tspan'          => array_merge( $shape_attrs, array( 'x' => true, 'y' => true, 'dx' => true, 'dy' => true ) ),
		'defs'           => array(),
		'clippath'       => array( 'id' => true ),
		'lineargradient' => array( 'id' => true, 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'gradientunits' => true, 'gradienttransform' => true ),
		'radialgradient' => array( 'id' => true, 'cx' => true, 'cy' => true, 'r' => true, 'gradientunits' => true, 'gradienttransform' => true ),
		'stop'           => array( 'offset' => true, 'stop-color' => true, 'stop-opacity' => true, 'style' => true ),
		// <title> aninhado dentro de um elemento de forma vira o tooltip
		// nativo do navegador ao passar o mouse — sem isso não tem como
		// mostrar legenda nenhuma ao passar o mouse no gráfico.
		'title'          => array(),
		'desc'           => array( 'id' => true ),
	);
	return wp_kses( $svg_code, $allowed );
}

