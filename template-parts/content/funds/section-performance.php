<?php
/**
 * Funds — Seção 3: Performance Graph. Gráfico SVG (assets/js/performance-chart.js,
 * dados de inc/performance-data.php), com botões de período e legenda
 * montados por JS.
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

		<div class="gw-perf__controls">
			<div class="gw-perf__ranges" role="group" aria-label="Período do gráfico">
				<button type="button" class="gw-perf__range" data-range="1y">1Y</button>
				<button type="button" class="gw-perf__range" data-range="3y">3Y</button>
				<button type="button" class="gw-perf__range" data-range="5y">5Y</button>
				<button type="button" class="gw-perf__range is-active" data-range="si">Since inception</button>
			</div>
			<ul class="gw-perf__legend" id="gw-perf-legend"></ul>
		</div>

		<div class="gw-perf__chart-wrap" id="gw-perf-chart-wrap">
			<svg id="gw-perf-chart" viewBox="0 0 960 420" preserveAspectRatio="none" role="img" aria-label="Gráfico de performance"></svg>
			<div class="gw-perf__tooltip" id="gw-perf-tooltip" hidden></div>
		</div>

		<div class="gw-perf__meta" id="gw-perf-meta"></div>

		<?php if ( $note ) : ?>
			<p class="gw-perf__note"><?php echo esc_html( $note ); ?></p>
		<?php endif; ?>

	</div>
</section>
