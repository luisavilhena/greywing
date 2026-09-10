<?php
/**
 * Componente: Duas colunas (título/subtítulo/texto por coluna), com título
 * opcional compartilhado acima das duas.
 * Layout ACF: two_columns.
 *
 * CSS: assets/css/components/content-two-columns.css
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor             = get_sub_field( 'anchor' );
$top_title         = get_sub_field( 'top_title' );
$top_title_spacing = get_sub_field( 'top_title_spacing' ) ?: 'md';
$align              = get_sub_field( 'top_title_align' ) ?: 'left';
$top_title_mobile_w = get_sub_field( 'top_title_mobile_width' );
$top_title_mobile_align = get_sub_field( 'top_title_mobile_align' );
$col_left           = get_sub_field( 'column_left' );
$col_right          = get_sub_field( 'column_right' );

$col_left_has_content  = ! empty( $col_left['title'] ) || ! empty( $col_left['subtitle'] ) || ! empty( $col_left['text'] );
$col_right_has_content = ! empty( $col_right['title'] ) || ! empty( $col_right['subtitle'] ) || ! empty( $col_right['text'] );

// Linha vazia (nenhum campo preenchido, nas 2 colunas nem no título) = nenhum HTML renderizado.
if ( ! $top_title && ! $col_left_has_content && ! $col_right_has_content ) {
	return;
}
?>
<section class="gw-row gw-two-columns"<?php echo greywing_anchor_attr( $anchor ); ?>>

	<?php if ( $top_title ) : ?>
		<h2 class="gw-two-columns__title gw-two-columns__title--<?php echo esc_attr( $align ); ?> gw-mb-<?php echo esc_attr( $top_title_spacing ); ?><?php echo greywing_mobile_width_class( $top_title_mobile_w ); ?><?php echo greywing_mobile_align_class( $top_title_mobile_align ); ?>">
			<?php echo nl2br( esc_html( $top_title ) ); ?>
		</h2>
	<?php endif; ?>

	<div class="gw-two-columns__cols">

		<div class="gw-two-columns__col">
			<?php if ( ! empty( $col_left['title'] ) ) : ?>
				<h2 class="gw-two-columns__col-title gw-mb-<?php echo esc_attr( $col_left['title_spacing'] ?: 'md' ); ?><?php echo greywing_mobile_width_class( $col_left['mobile_width_title'] ?? '' ); ?><?php echo greywing_mobile_align_class( $col_left['mobile_align_title'] ?? '' ); ?>"><?php echo nl2br( esc_html( $col_left['title'] ) ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $col_left['subtitle'] ) ) : ?>
				<h3 class="gw-two-columns__subtitle<?php echo greywing_mobile_width_class( $col_left['mobile_width_subtitle'] ?? '' ); ?><?php echo greywing_mobile_align_class( $col_left['mobile_align_subtitle'] ?? '' ); ?>"><?php echo esc_html( $col_left['subtitle'] ); ?></h3>
			<?php endif; ?>
			<?php if ( ! empty( $col_left['text'] ) ) : ?>
				<div class="gw-two-columns__text<?php echo greywing_mobile_width_class( $col_left['mobile_width_text'] ?? '' ); ?><?php echo greywing_mobile_align_class( $col_left['mobile_align_text'] ?? '' ); ?>"><?php echo wp_kses_post( $col_left['text'] ); ?></div>
			<?php endif; ?>
		</div>

		<div class="gw-two-columns__col">
			<?php if ( ! empty( $col_right['title'] ) ) : ?>
				<h2 class="gw-two-columns__col-title gw-mb-<?php echo esc_attr( $col_right['title_spacing'] ?: 'md' ); ?><?php echo greywing_mobile_width_class( $col_right['mobile_width_title'] ?? '' ); ?><?php echo greywing_mobile_align_class( $col_right['mobile_align_title'] ?? '' ); ?>"><?php echo nl2br( esc_html( $col_right['title'] ) ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $col_right['subtitle'] ) ) : ?>
				<h3 class="gw-two-columns__subtitle<?php echo greywing_mobile_width_class( $col_right['mobile_width_subtitle'] ?? '' ); ?><?php echo greywing_mobile_align_class( $col_right['mobile_align_subtitle'] ?? '' ); ?>"><?php echo esc_html( $col_right['subtitle'] ); ?></h3>
			<?php endif; ?>
			<?php if ( ! empty( $col_right['text'] ) ) : ?>
				<div class="gw-two-columns__text<?php echo greywing_mobile_width_class( $col_right['mobile_width_text'] ?? '' ); ?><?php echo greywing_mobile_align_class( $col_right['mobile_align_text'] ?? '' ); ?>"><?php echo wp_kses_post( $col_right['text'] ); ?></div>
			<?php endif; ?>
		</div>

	</div>

</section>
