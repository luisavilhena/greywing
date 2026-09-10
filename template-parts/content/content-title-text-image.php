<?php
/**
 * Componente: Título + texto + imagem.
 * Layout ACF: title_text_image.
 *
 * CSS: assets/css/components/content-title-text-image.css
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor        = get_sub_field( 'anchor' );
$title         = get_sub_field( 'title' );
$title_spacing = get_sub_field( 'title_spacing' ) ?: 'md';
$mobile_w_title = get_sub_field( 'mobile_width_title' );
$text          = get_sub_field( 'text' );
$mobile_w_text = get_sub_field( 'mobile_width_text' );
$image         = get_sub_field( 'image' );
$mobile_image  = get_sub_field( 'mobile_image' );
$mobile_order  = get_sub_field( 'mobile_order' );
$mobile_align  = get_sub_field( 'mobile_image_align' );
$mobile_w_image = get_sub_field( 'mobile_width_image' );

// Linha vazia (nenhum campo preenchido) = nenhum HTML renderizado.
if ( ! $title && ! $text && ! $image ) {
	return;
}
?>
<section class="gw-row gw-title-text-image"<?php echo greywing_anchor_attr( $anchor ); ?>>

	<?php if ( $title ) : ?>
		<h2 class="gw-title-text-image__title gw-mb-<?php echo esc_attr( $title_spacing ); ?><?php echo greywing_mobile_width_class( $mobile_w_title ); ?>"><?php echo nl2br( esc_html( $title ) ); ?></h2>
	<?php endif; ?>

	<?php if ( $text ) : ?>
		<div class="gw-title-text-image__text<?php echo greywing_mobile_width_class( $mobile_w_text ); ?>"><?php echo wp_kses_post( $text ); ?></div>
	<?php endif; ?>

	<?php if ( $image ) : ?>
		<figure class="gw-title-text-image__image<?php echo greywing_mobile_order_class( $mobile_order ); ?><?php echo greywing_mobile_align_class( $mobile_align ); ?><?php echo greywing_mobile_width_class( $mobile_w_image ); ?>">
			<picture>
				<?php if ( $mobile_image ) : ?>
					<source media="(max-width: 40em)" srcset="<?php echo esc_url( $mobile_image['url'] ); ?>">
				<?php endif; ?>
				<img
					src="<?php echo esc_url( $image['url'] ); ?>"
					alt="<?php echo esc_attr( $image['alt'] ); ?>"
					width="<?php echo esc_attr( $image['width'] ); ?>"
					height="<?php echo esc_attr( $image['height'] ); ?>"
					loading="lazy"
				>
			</picture>
		</figure>
	<?php endif; ?>

</section>
