<?php
/**
 * Funds — Seção 4: Fund Information. Lista de fatos (rótulo/valor) + link
 * de download do Factsheet.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor         = get_sub_field( 'anchor' );
$theme          = get_sub_field( 'theme' );
$title          = get_sub_field( 'title' );
$facts          = get_sub_field( 'facts' );
$download_label = get_sub_field( 'download_label' );
$download_file  = get_sub_field( 'download_file' );
?>
<section class="gw-card gw-sec gw-facts<?php echo greywing_section_theme_class( $theme ); ?>"<?php echo greywing_anchor_attr( $anchor ); ?>>
	<div class="gw-wrap">

		<?php if ( $title ) : ?>
			<h2 class="gw-h-sec gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( $facts ) : ?>
			<dl class="gw-facts__list gw-block">
				<?php foreach ( $facts as $fact ) : ?>
					<div class="gw-facts__row gw-rv">
						<dt><?php echo esc_html( $fact['label'] ); ?></dt>
						<dd><?php echo esc_html( $fact['value'] ); ?></dd>
					</div>
				<?php endforeach; ?>
			</dl>
		<?php endif; ?>

		<?php if ( $download_file ) : ?>
			<a class="gw-alink gw-facts__download gw-rv" href="<?php echo esc_url( $download_file ); ?>" target="_blank" rel="noopener">
				<?php echo esc_html( $download_label ? $download_label : 'Download our latest Factsheet' ); ?>
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</a>
		<?php endif; ?>

	</div>
</section>
