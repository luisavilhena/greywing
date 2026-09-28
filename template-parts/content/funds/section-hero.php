<?php
/**
 * Funds — Seção 1: Hero. Primeira carta da pilha (classe "gw-hero" reaproveita
 * a regra de reveal.js que mostra a primeira seção já visível ao carregar,
 * sem esperar o scroll).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title  = get_sub_field( 'title' );
$kicker = get_sub_field( 'kicker' );
$text   = get_sub_field( 'text' );
$image  = get_sub_field( 'image' );
?>
<section class="gw-card gw-hero gw-f-hero">

	<?php if ( $image ) : ?>
		<div class="gw-f-hero__media gw-rv">
			<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
		</div>
	<?php endif; ?>

	<div class="gw-wrap gw-f-hero__grid">
		<div class="gw-f-hero__text gw-block">
			<?php if ( $title ) : ?>
				<h1 class="gw-h-page gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h1>
			<?php endif; ?>
			<?php if ( $kicker ) : ?>
				<p class="gw-kicker gw-rv"><?php echo esc_html( $kicker ); ?></p>
			<?php endif; ?>
			<?php if ( $text ) : ?>
				<?php echo greywing_richtext_reveal( wp_kses_post( $text ) ); ?>
			<?php endif; ?>
		</div>
	</div>

</section>
