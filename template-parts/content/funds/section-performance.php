<?php
/**
 * Funds — Seção 3: Performance Graph. Não é mais um gráfico calculado por
 * JS a partir de números — cada botão mostra uma versão diferente do
 * gráfico, enviada pelo editor (ver "chart_versions" em
 * inc/acf-fields/funds-sections.php): imagem (upload) OU SVG colado como
 * código. As duas versões de cada linha já vêm todas renderizadas no HTML
 * (uma div por linha); clicar num botão só troca qual delas fica visível —
 * ver assets/js/performance-chart.js.
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

// Só considera versões que realmente têm o que mostrar: imagem enviada (se
// type=image) ou código de SVG colado (se type=svg).
$chart_versions = array_values(
	array_filter(
		(array) $chart_versions,
		function ( $version ) {
			if ( 'svg' === $version['type'] ) {
				return ! empty( $version['svg_code'] );
			}
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
						<button type="button" class="gw-perf__range<?php echo 0 === $i ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr( $i ); ?>">
							<?php echo esc_html( $version['label'] ? $version['label'] : ( $i + 1 ) ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="gw-perf__chart-wrap gw-rv" id="gw-perf-chart-wrap">
				<?php foreach ( $chart_versions as $i => $version ) : ?>
					<div class="gw-perf__slide<?php echo 0 === $i ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr( $i ); ?>">
						<?php if ( 'svg' === $version['type'] ) : ?>
							<?php echo greywing_kses_svg( $version['svg_code'] ); ?>
						<?php else : ?>
							<img src="<?php echo esc_url( $version['image']['url'] ); ?>" alt="<?php echo esc_attr( $version['label'] ? $version['label'] : 'Performance chart' ); ?>">
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>

		<?php endif; ?>

		<?php if ( $note ) : ?>
			<p class="gw-perf__note"><?php echo esc_html( $note ); ?></p>
		<?php endif; ?>

	</div>
</section>
