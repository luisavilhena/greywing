<?php
/**
 * About — Seção 1: Hero. Primeira carta da pilha, já visível ao carregar
 * (sem esperar o scroll — ver .gw-hero em assets/js/reveal.js).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$image       = get_sub_field( 'image' );
$title       = get_sub_field( 'title' );
$sub         = get_sub_field( 'sub' );
$apply_label = get_sub_field( 'apply_label' );
$apply_url   = get_sub_field( 'apply_url' );
?>
<section class="gw-card gw-hero"<?php echo $image ? ' style="background-image:url(' . esc_url( $image['url'] ) . ')"' : ''; ?>>
	<div class="gw-hero__scrim" aria-hidden="true"></div>
	<div class="gw-wrap gw-hero__in gw-block">

		<?php if ( $title ) : ?>
			<h1 class="gw-h-display gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h1>
		<?php endif; ?>

		<?php if ( $sub ) : ?>
			<p class="gw-hero__sub gw-rv"><?php echo nl2br( esc_html( $sub ) ); ?></p>
		<?php endif; ?>

		<?php if ( $apply_label && $apply_url ) : ?>
			<a class="gw-alink gw-hero__apply gw-rv" href="<?php echo esc_url( $apply_url ); ?>">
				<?php echo esc_html( $apply_label ); ?>
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</a>
		<?php endif; ?>

	</div>
</section>
