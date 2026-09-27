<?php
/**
 * About — Seção 4: Why Greywing. Número em destaque + legenda de um lado,
 * parágrafos do outro.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor      = get_sub_field( 'anchor' );
$theme       = get_sub_field( 'theme' );
$title       = get_sub_field( 'title' );
$figure      = get_sub_field( 'figure' );
$figure_note = get_sub_field( 'figure_note' );
$text        = get_sub_field( 'text' );
?>
<section class="gw-card gw-sec gw-why<?php echo greywing_section_theme_class( $theme ); ?>"<?php echo greywing_anchor_attr( $anchor ); ?>>
	<div class="gw-wrap gw-grid12">

		<div class="gw-col-title">
			<?php if ( $title ) : ?>
				<h2 class="gw-h-sec gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h2>
			<?php endif; ?>
			<?php if ( $figure ) : ?>
				<p class="gw-why__figure gw-rv"><?php echo esc_html( $figure ); ?></p>
			<?php endif; ?>
			<?php if ( $figure_note ) : ?>
				<p class="gw-why__figure-note gw-rv"><?php echo esc_html( $figure_note ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( $text ) : ?>
			<div class="gw-col-body gw-block">
				<?php echo greywing_richtext_reveal( wp_kses_post( $text ) ); ?>
			</div>
		<?php endif; ?>

	</div>
</section>
