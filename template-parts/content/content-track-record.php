<?php
/**
 * Componente: Track record — título + texto + números de performance.
 * Layout ACF: track_record.
 *
 * CSS: assets/css/components/content-track-record.css
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor        = get_sub_field( 'anchor' );
$title         = get_sub_field( 'title' );
$title_spacing = get_sub_field( 'title_spacing' ) ?: 'md';
$text          = get_sub_field( 'text' );
$as_of_label   = get_sub_field( 'as_of_label' );
$stats_left    = get_sub_field( 'stats_left' );
$stats_right   = get_sub_field( 'stats_right' );

// Linha vazia (nenhum campo preenchido) = nenhum HTML renderizado.
if ( ! $title && ! $text && ! $as_of_label && ! $stats_left && ! $stats_right ) {
	return;
}
?>
<section class="gw-row gw-track-record"<?php echo greywing_anchor_attr( $anchor ); ?>>

	<?php if ( $title ) : ?>
		<h2 class="gw-track-record__title gw-mb-<?php echo esc_attr( $title_spacing ); ?>"><?php echo nl2br( esc_html( $title ) ); ?></h2>
	<?php endif; ?>

	<?php if ( $text ) : ?>
		<div class="gw-track-record__text"><?php echo wp_kses_post( $text ); ?></div>
	<?php endif; ?>

	<?php if ( $as_of_label ) : ?>
		<p class="gw-track-record__as-of"><?php echo esc_html( $as_of_label ); ?></p>
	<?php endif; ?>

	<?php if ( $stats_left || $stats_right ) : ?>
		<div class="gw-track-record__stats">

			<?php foreach ( array( $stats_left, $stats_right ) as $stats ) : ?>
				<?php if ( $stats ) : ?>
					<div class="gw-track-record__stats-col">
						<?php foreach ( $stats as $stat ) : ?>
							<?php if ( ! empty( $stat['label'] ) || ! empty( $stat['value'] ) ) : ?>
								<div class="gw-track-record__stat">
									<span class="gw-track-record__stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
									<span class="gw-track-record__stat-value"><?php echo esc_html( $stat['value'] ); ?></span>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>

		</div>
	<?php endif; ?>

</section>
