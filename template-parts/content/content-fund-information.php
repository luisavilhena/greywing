<?php
/**
 * Componente: Fund information — título + tabela (rótulo/valor) + link de
 * download opcional.
 * Layout ACF: fund_information.
 *
 * CSS: assets/css/components/content-fund-information.css
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor        = get_sub_field( 'anchor' );
$title         = get_sub_field( 'title' );
$title_spacing = get_sub_field( 'title_spacing' ) ?: 'md';
$rows          = get_sub_field( 'rows' );
$download_link = get_sub_field( 'download_link' );

// Linha vazia (nenhum campo preenchido) = nenhum HTML renderizado.
if ( ! $title && ! $rows && ! $download_link ) {
	return;
}
?>
<section class="gw-row gw-fund-information"<?php echo greywing_anchor_attr( $anchor ); ?>>

	<?php if ( $title ) : ?>
		<h2 class="gw-fund-information__title gw-mb-<?php echo esc_attr( $title_spacing ); ?>"><?php echo nl2br( esc_html( $title ) ); ?></h2>
	<?php endif; ?>

	<?php if ( $rows ) : ?>
		<table class="gw-fund-information__table">
			<tbody>
				<?php foreach ( $rows as $row ) : ?>
					<?php if ( ! empty( $row['label'] ) || ! empty( $row['value'] ) ) : ?>
						<tr>
							<th scope="row"><?php echo esc_html( $row['label'] ); ?></th>
							<td><?php echo esc_html( $row['value'] ); ?></td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>

	<?php if ( ! empty( $download_link['url'] ) ) : ?>
		<a
			class="gw-fund-information__download"
			href="<?php echo esc_url( $download_link['url'] ); ?>"
			<?php echo ! empty( $download_link['target'] ) ? ' target="' . esc_attr( $download_link['target'] ) . '" rel="noopener"' : ''; ?>
		>
			<svg class="gw-fund-information__download-icon" width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
				<path d="M6.15998 14.1605L-1.94758e-05 8.68047V7.14047L5.55998 11.9805V0.000468254H6.75998V11.9605L12.32 7.14047V8.68047L6.15998 14.1605Z" fill="currentColor" />
			</svg>
			<?php echo esc_html( $download_link['title'] ); ?>
		</a>
	<?php endif; ?>

</section>
