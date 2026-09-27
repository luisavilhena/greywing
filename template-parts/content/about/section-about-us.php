<?php
/**
 * About — Seção 2: About Us. Coluna da esquerda: título + 2 imagens
 * sobrepostas abaixo dele. Coluna da direita: frase de destaque + parágrafos.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor  = get_sub_field( 'anchor' );
$theme   = get_sub_field( 'theme' );
$title   = get_sub_field( 'title' );
$image_1 = get_sub_field( 'image_1' );
$image_2 = get_sub_field( 'image_2' );
$kicker  = get_sub_field( 'kicker' );
$text    = get_sub_field( 'text' );
?>
<section class="gw-card gw-sec gw-about-us<?php echo greywing_section_theme_class( $theme ); ?>"<?php echo greywing_anchor_attr( $anchor ); ?>>
	<div class="gw-wrap gw-about-us__grid">

		<?php if ( $title ) : ?>
			<div class="gw-about-us__title">
				<h2 class="gw-h-sec gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h2>
			</div>
		<?php endif; ?>

		<?php if ( $image_1 || $image_2 ) : ?>
			<div class="gw-about-us__media">
				<?php if ( $image_1 ) : ?>
					<img class="gw-about-us__img1 gw-rv" src="<?php echo esc_url( $image_1['url'] ); ?>" alt="<?php echo esc_attr( $image_1['alt'] ); ?>">
				<?php endif; ?>
				<?php if ( $image_2 ) : ?>
					<img class="gw-about-us__img2 gw-rv" src="<?php echo esc_url( $image_2['url'] ); ?>" alt="<?php echo esc_attr( $image_2['alt'] ); ?>">
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $kicker || $text ) : ?>
			<div class="gw-about-us__body gw-block">
				<?php if ( $kicker ) : ?>
					<p class="gw-about-us__kicker gw-rv"><?php echo esc_html( $kicker ); ?></p>
				<?php endif; ?>
				<?php if ( $text ) : ?>
					<?php echo greywing_richtext_reveal( wp_kses_post( $text ) ); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
