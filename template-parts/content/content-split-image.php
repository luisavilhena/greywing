<?php
/**
 * Componente: coluna esquerda com título + subtítulo + texto (+ texto
 * pequeno, empurrado pra baixo), coluna direita com imagem.
 * Layout ACF: split_image.
 *
 * CSS: assets/css/components/content-split-image.css
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor        = get_sub_field( 'anchor' );
$title         = get_sub_field( 'title' );
$title_spacing = get_sub_field( 'title_spacing' ) ?: 'md';
$mobile_w_title = get_sub_field( 'mobile_width_title' );
$title_image   = get_sub_field( 'title_image' );
$subtitle      = get_sub_field( 'subtitle' );
$mobile_w_subtitle = get_sub_field( 'mobile_width_subtitle' );
$mobile_align_subtitle = get_sub_field( 'mobile_align_subtitle' );
$text          = get_sub_field( 'text' );
$mobile_w_text = get_sub_field( 'mobile_width_text' );
$small_text    = get_sub_field( 'small_text' );
$image         = get_sub_field( 'image' );
$mobile_image  = get_sub_field( 'mobile_image' );
// Fallback 'invert': linhas de conteúdo salvas antes deste campo existir não
// têm valor gravado pra ele (o default_value do ACF só vale pra linha nova,
// não retroage em linha já salva) — sem isso, a imagem deixaria de subir pro
// topo no mobile no conteúdo já publicado (era um order:-1 fixo no CSS).
$mobile_order  = get_sub_field( 'mobile_order' ) ?: 'invert';
$mobile_align  = get_sub_field( 'mobile_image_align' );
$mobile_w_image = get_sub_field( 'mobile_width_image' );

// Linha vazia (nenhum campo preenchido) = nenhum HTML renderizado.
if ( ! $title && ! $title_image && ! $subtitle && ! $text && ! $small_text && ! $image ) {
	return;
}
?>
<section class="gw-row gw-split-image"<?php echo greywing_anchor_attr( $anchor ); ?>>

	<div class="gw-split-image__text">

		<div class="gw-split-image__top">
			<?php if ( $title ) : ?>
				<h2 class="gw-split-image__title gw-mb-<?php echo esc_attr( $title_spacing ); ?><?php echo greywing_mobile_width_class( $mobile_w_title ); ?>"><?php echo nl2br( esc_html( $title ) ); ?></h2>
			<?php endif; ?>
			<?php if ( $title_image ) : ?>
				<figure class="gw-split-image__title-image">
					<img
						src="<?php echo esc_url( $title_image['url'] ); ?>"
						alt="<?php echo esc_attr( $title_image['alt'] ); ?>"
						width="<?php echo esc_attr( $title_image['width'] ); ?>"
						height="<?php echo esc_attr( $title_image['height'] ); ?>"
						loading="lazy"
					>
				</figure>
			<?php endif; ?>
			<?php if ( $subtitle ) : ?>
				<h3 class="gw-split-image__subtitle<?php echo greywing_mobile_width_class( $mobile_w_subtitle ); ?><?php echo greywing_mobile_align_class( $mobile_align_subtitle ); ?>"><?php echo esc_html( $subtitle ); ?></h3>
			<?php endif; ?>
			<?php if ( $text ) : ?>
				<div class="gw-split-image__body<?php echo greywing_mobile_width_class( $mobile_w_text ); ?>"><?php echo wp_kses_post( $text ); ?></div>
			<?php endif; ?>
		</div>

		<?php if ( $small_text ) : ?>
			<div class="gw-split-image__small-text"><?php echo wp_kses_post( $small_text ); ?></div>
		<?php endif; ?>

	</div>

	<?php if ( $image ) : ?>
		<figure class="gw-split-image__image<?php echo greywing_mobile_order_class( $mobile_order ); ?><?php echo greywing_mobile_align_class( $mobile_align ); ?><?php echo greywing_mobile_width_class( $mobile_w_image ); ?>">
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
