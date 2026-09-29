<?php
/**
 * Funds — Seção 3: Performance Graph. O gráfico não é mais calculado a
 * partir de números — o editor cola o código SVG de cada versão (uma por
 * botão, ex.: "1Y"/"3Y"/"Since inception") direto no ACF (repeater
 * "chart_versions" em inc/acf-fields/funds-sections.php). Todas as versões
 * já vêm renderizadas no HTML (uma ".gw-perf__slide" por linha); clicar num
 * botão só troca qual fica visível — ver assets/js/performance-chart.js.
 *
 * Período/valor final/retorno anualizado (linha "meta" abaixo do gráfico)
 * também viram texto editável — antes eram calculados dos números, agora
 * não tem número nenhum pra calcular a partir.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor         = get_sub_field( 'anchor' );
$theme          = get_sub_field( 'theme' );
$title          = get_sub_field( 'title' );
$subtitle       = get_sub_field( 'subtitle' );
$chart_versions = get_sub_field( 'chart_versions' );
$meta_period    = get_sub_field( 'meta_period' );
$meta_end       = get_sub_field( 'meta_end' );
$meta_ann       = get_sub_field( 'meta_ann' );
$note           = get_sub_field( 'note' );

// Só considera versões que realmente têm código de SVG colado.
$chart_versions = array_values(
	array_filter(
		(array) $chart_versions,
		function ( $version ) {
			return ! empty( $version['svg_code'] );
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

			<div class="gw-perf__chart-box gw-rv" id="gw-perf-chart-box">
				<?php foreach ( $chart_versions as $i => $version ) : ?>
					<div class="gw-perf__slide<?php echo 0 === $i ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr( $i ); ?>">
						<?php echo greywing_kses_svg( $version['svg_code'] ); ?>
					</div>
				<?php endforeach; ?>
			</div>

		<?php endif; ?>

		<?php if ( $meta_period || $meta_end || $meta_ann ) : ?>
			<div class="gw-perf__meta">
				<?php if ( $meta_period ) : ?><span><strong>Period:</strong> <?php echo esc_html( $meta_period ); ?></span><?php endif; ?>
				<?php if ( $meta_end ) : ?><span><strong>Greywing ending value:</strong> <?php echo esc_html( $meta_end ); ?></span><?php endif; ?>
				<?php if ( $meta_ann ) : ?><span><strong>Annualised return:</strong> <?php echo esc_html( $meta_ann ); ?></span><?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $note ) : ?>
			<p class="gw-perf__note"><?php echo esc_html( $note ); ?></p>
		<?php endif; ?>

	</div>
</section>
