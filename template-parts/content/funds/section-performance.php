<?php
/**
 * Funds — Seção 3: Performance Graph. Gráfico de linha desenhado por JS a
 * partir do retorno mensal real da Greywing + valor mensal dos benchmarks
 * (assets/js/performance-data.js), com tooltip ao passar o mouse e 3
 * períodos (1Y/3Y/Since inception) — mesma lógica do mockup original,
 * adaptada em assets/js/performance-chart.js.
 *
 * Título/subtítulo/nota continuam editáveis via ACF; os números do gráfico
 * em si não (ver decisão no arquivo de dados).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor   = get_sub_field( 'anchor' );
$theme    = get_sub_field( 'theme' );
$title    = get_sub_field( 'title' );
$subtitle = get_sub_field( 'subtitle' );
$note     = get_sub_field( 'note' );
?>
<section class="gw-card gw-sec gw-perf<?php echo greywing_section_theme_class( $theme ); ?>"<?php echo greywing_anchor_attr( $anchor ); ?>>
	<div class="gw-wrap gw-block">

		<?php if ( $title ) : ?>
			<h2 class="gw-h-sec gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( $subtitle ) : ?>
			<p class="gw-perf__sub gw-rv" id="gw-perf-sub"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>

		<div class="gw-perf__ranges" role="group" aria-label="Chart period">
			<button type="button" class="gw-perf__range" data-range="12" aria-pressed="false">1Y</button>
			<button type="button" class="gw-perf__range" data-range="36" aria-pressed="false">3Y</button>
			<button type="button" class="gw-perf__range is-active" data-range="all" aria-pressed="true">Since inception</button>
		</div>

		<ul class="gw-perf__legend">
			<li><i style="background:#C17400"></i>Greywing Spectrum Fund Ltd</li>
			<li><i style="background:#BEB09D"></i>MSCI World Index TR</li>
			<li><i style="background:#5F90BD"></i>Bloomberg Agricultural Index</li>
			<li><i style="background:#0E3258"></i>SOFR 1m +5%</li>
		</ul>

		<div class="gw-perf__chart-box gw-rv" id="gw-perf-chart-box">
			<svg id="gw-perf-chart" role="img" aria-label="Performance chart"></svg>
			<div class="gw-perf__tip" id="gw-perf-tip"></div>
		</div>

		<div class="gw-perf__meta">
			<span><strong>Period:</strong> <span id="gw-perf-period"></span></span>
			<span><strong>Greywing ending value:</strong> <span id="gw-perf-end"></span></span>
			<span><strong>Annualised return:</strong> <span id="gw-perf-ann"></span></span>
		</div>

		<?php if ( $note ) : ?>
			<p class="gw-perf__note"><?php echo esc_html( $note ); ?></p>
		<?php endif; ?>

	</div>
</section>
