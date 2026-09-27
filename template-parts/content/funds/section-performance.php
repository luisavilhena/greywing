<?php
/**
 * Funds — Seção 3: Performance Graph. Não é mais um gráfico calculado por
 * JS a partir de números — cada botão mostra uma imagem/SVG diferente,
 * enviada pelo editor (ver "chart_versions" em inc/acf-fields/funds-sections.php).
 * Clique no botão troca a imagem: assets/js/performance-chart.js.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor         = get_sub_field( 'anchor' );
$theme          = get_sub_field( 'theme' );
$title          = get_sub_field( 'title' );
$subtitle       = get_sub_field( 'subtitle' );
$chart_versions = get_sub_field( 'chart_versions' );
$note           = get_sub_field( 'note' );

// Só considera versões que realmente têm imagem — uma linha sem imagem não
// tem o que mostrar no gráfico.
$chart_versions = array_values(
	array_filter(
		(array) $chart_versions,
		function ( $version ) {
			return ! empty( $version['image']['url'] );
		}
	)
);
?>
<section class="gw-card gw-sec gw-perf<?php echo greywing_section_theme_class( $theme ); ?>"<?php echo greywing_anchor_attr( $anchor ); ?>>
	<div class="gw-wrap gw-block">

		<?php if ( $title ) : ?>
			<h2 class="gw-h-sec gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( $subtitle ) : ?>
			<p class="gw-perf__sub gw-rv"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>

		<?php if ( $chart_versions ) : ?>

			<?php if ( count( $chart_versions ) > 1 ) : ?>
				<div class="gw-perf__ranges" id="gw-perf-ranges" role="group" aria-label="Chart period">
					<?php foreach ( $chart_versions as $i => $version ) : ?>
						<button type="button" class="gw-perf__range<?php echo 0 === $i ? ' is-active' : ''; ?>" data-image="<?php echo esc_url( $version['image']['url'] ); ?>">
							<?php echo esc_html( $version['label'] ? $version['label'] : ( $i + 1 ) ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="gw-perf__chart-wrap gw-rv">
				<img id="gw-perf-chart-img" src="<?php echo esc_url( $chart_versions[0]['image']['url'] ); ?>" alt="<?php echo esc_attr( $chart_versions[0]['label'] ? $chart_versions[0]['label'] : 'Performance chart' ); ?>">
			</div>

		<?php endif; ?>

		<?php if ( $note ) : ?>
			<p class="gw-perf__note"><?php echo esc_html( $note ); ?></p>
		<?php endif; ?>

	</div>
</section>
