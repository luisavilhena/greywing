<?php
/**
 * Funds — Seção 5: Interested in the Fund? Última carta da pilha.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor     = get_sub_field( 'anchor' );
$theme      = get_sub_field( 'theme' );
$title      = get_sub_field( 'title' );
$text       = get_sub_field( 'text' );
$fine_print = get_sub_field( 'fine_print' );
?>
<section class="gw-card gw-sec gw-interested<?php echo greywing_section_theme_class( $theme ); ?>"<?php echo greywing_anchor_attr( $anchor ); ?>>
	<div class="gw-wrap gw-block">

		<?php if ( $title ) : ?>
			<h2 class="gw-h-sec gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( $text ) : ?>
			<?php echo greywing_richtext_reveal( wp_kses_post( $text ) ); ?>
		<?php endif; ?>

		<?php if ( $fine_print ) : ?>
			<p class="gw-fine gw-rv"><?php echo nl2br( esc_html( $fine_print ) ); ?></p>
		<?php endif; ?>

	</div>
</section>
