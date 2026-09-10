<?php
/**
 * Componente: Só título, em destaque especial (não ocupa a largura das
 * 2 colunas — fica mais contido).
 * Layout ACF: title_only.
 *
 * CSS: assets/css/components/content-title-only.css
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor        = get_sub_field( 'anchor' );
$title         = get_sub_field( 'title' );
$title_spacing = get_sub_field( 'title_spacing' ) ?: 'md';

if ( ! $title ) {
	return;
}
?>
<section class="gw-row gw-title-only"<?php echo greywing_anchor_attr( $anchor ); ?>>
	<h2 class="gw-title-only__title gw-mb-<?php echo esc_attr( $title_spacing ); ?>"><?php echo nl2br( esc_html( $title ) ); ?></h2>
</section>
