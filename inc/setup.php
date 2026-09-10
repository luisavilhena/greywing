<?php
/**
 * Configuração básica do tema (theme supports, image sizes, etc).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greywing_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	// Menu vertical fixo à esquerda (ver template-parts/layout/site-menu.php).
	// É editado normalmente em Aparência → Menus — os itens de topo (About,
	// Funds...) apontam pra página; os sub-itens são links personalizados
	// pra "#âncora" dentro dessa mesma página (ver campo "Âncora" de cada
	// componente, em inc/acf-fields/shared-fields.php).
	register_nav_menus(
		array(
			'primary'    => 'Menu principal (coluna da esquerda)',
			'invest_now' => 'Invest now (link solto, empurrado pro fim do menu)',
		)
	);

	// Tamanho de imagem usado pelos componentes que ocupam toda a largura da página de conteúdo.
	add_image_size( 'greywing-full', 1800, 1800, false );
}
add_action( 'after_setup_theme', 'greywing_theme_setup' );

/**
 * Libera upload de SVG na biblioteca de mídia — usado pelos ícones do
 * componente "título + zigzag" (ex.: os ícones do bloco "What We Believe").
 * Só quem já tem permissão de enviar mídia no wp-admin pode fazer isso.
 */
function greywing_allow_svg_upload( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'greywing_allow_svg_upload' );

/**
 * Monta o atributo `id="..."` de uma linha de conteúdo a partir do campo
 * "Âncora" (ver greywing_field_anchor() em inc/acf-fields/shared-fields.php).
 * sanitize_title() normaliza o que a pessoa digitou (deixa minúsculo, troca
 * espaço por hífen, etc.) — assim o id sempre fica um slug válido pra usar
 * num link "#..." no menu.
 *
 * @param string $anchor Valor bruto do campo "Âncora".
 * @return string Atributo pronto pra colar dentro de uma tag, ex.: ' id="what-we-believe"', ou string vazia se não tiver âncora.
 */
function greywing_anchor_attr( $anchor ) {
	return $anchor ? ' id="' . esc_attr( sanitize_title( $anchor ) ) . '"' : '';
}

/**
 * Classe CSS de ordem no mobile (imagem antes do resto do conteúdo) — ver
 * greywing_field_mobile_order() em inc/acf-fields/shared-fields.php e
 * .gw-mobile-order-invert em assets/css/base.css. "normal" (ou vazio) não
 * adiciona classe nenhuma — mantém a ordem natural do HTML.
 *
 * @param string $value Valor do campo "mobile_order" ('normal' ou 'invert').
 * @return string Classe pronta pra colar na lista de classes, com espaço na frente, ou string vazia.
 */
function greywing_mobile_order_class( $value ) {
	return ( 'invert' === $value ) ? ' gw-mobile-order-invert' : '';
}

/**
 * Classe CSS de alinhamento da imagem no mobile — ver
 * greywing_field_mobile_align() em inc/acf-fields/shared-fields.php e
 * .gw-mobile-align-* em assets/css/base.css.
 *
 * @param string $value Valor do campo "mobile_image_align" ('left' ou 'right').
 * @return string Classe pronta pra colar na lista de classes, com espaço na frente, ou string vazia.
 */
function greywing_mobile_align_class( $value ) {
	return $value ? ' gw-mobile-align-' . sanitize_html_class( $value ) : '';
}

/**
 * Classe CSS de largura no mobile — ver greywing_field_mobile_width() em
 * inc/acf-fields/shared-fields.php e .gw-mobile-w-* em assets/css/base.css.
 * "100" (ou vazio) não adiciona classe nenhuma — é a largura padrão, sem
 * essa regra.
 *
 * @param string $value Valor do campo de largura mobile ('100', '80' ou '70').
 * @return string Classe pronta pra colar na lista de classes, com espaço na frente, ou string vazia.
 */
function greywing_mobile_width_class( $value ) {
	return ( $value && '100' !== $value ) ? ' gw-mobile-w-' . sanitize_html_class( $value ) : '';
}

/**
 * Faz o item "Login" do menu abrir o popup (.gw-drawer#gw-login-popup, ver
 * template-parts/layout/login-popup.php) em vez de navegar.
 *
 * Convenção: em Aparência → Menus, dê ao item de menu a URL "#login-popup"
 * — este filtro troca essa URL pelo "data-gw-form-trigger" que
 * assets/js/drawer.js já sabe abrir. Assim não depende do texto do item
 * (que continua livre pra editar).
 */
function greywing_login_menu_item_attributes( $atts, $item ) {
	if ( '#login-popup' === $item->url ) {
		$atts['href']                  = '#gw-login-popup';
		$atts['data-gw-form-trigger']  = 'gw-login-popup';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'greywing_login_menu_item_attributes', 10, 2 );
