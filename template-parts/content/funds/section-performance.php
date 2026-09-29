<?php
/**
 * Funds — Seção 3: Performance Graph. O editor cola o código SVG de cada
 * versão (uma por botão, ex.: "1Y"/"3Y"/"Since inception") direto no ACF
 * (repeater "chart_versions" em inc/acf-fields/funds-sections.php) — sem
 * upload, sem número pra manter atualizado.
 *
 * Cada versão tem sua própria legenda (cor + rótulo, também editável) — vem
 * junto com o botão, na ordem em que as linhas foram desenhadas no SVG.
 * A interatividade ao passar o mouse (linha-guia, pontos, cartão com os
 * valores) não é calculada: os valores e as posições já vêm embutidos nos
 * atributos data-* de cada .gw-perf-hit dentro do próprio SVG colado (put
 * lá por uma ferramenta à parte, não pelo WordPress) — assets/js/performance-chart.js
 * só lê esses atributos e monta o cartão, casando cada valor com o item da
 * legenda na mesma posição.
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

		<div class="gw-perf__head">
			<?php if ( $title ) : ?>
				<h2 class="gw-h-sec gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( count( $chart_versions ) > 1 ) : ?>
				<div class="gw-perf__ranges" id="gw-perf-ranges" role="group" aria-label="Chart period">
					<?php foreach ( $chart_versions as $i => $version ) : ?>
						<button type="button" class="gw-perf__range<?php echo 0 === $i ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr( $i ); ?>">
							<?php echo esc_html( $version['label'] ? $version['label'] : ( $i + 1 ) ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $subtitle ) : ?>
			<p class="gw-perf__sub gw-rv"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>

		<?php if ( $chart_versions ) : ?>
			<div class="gw-perf__chart-box gw-rv" id="gw-perf-chart-box">
				<?php foreach ( $chart_versions as $i => $version ) : ?>
					<div class="gw-perf__slide<?php echo 0 === $i ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr( $i ); ?>">
						<?php if ( ! empty( $version['legend'] ) ) : ?>
							<ul class="gw-perf__legend">
								<?php foreach ( $version['legend'] as $item ) : ?>
									<li><i style="background:<?php echo esc_attr( $item['color'] ); ?>"></i><?php echo esc_html( $item['label'] ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<div class="gw-perf__chart-inner">
							<?php echo greywing_kses_svg( $version['svg_code'] ); ?>
						</div>
						<?php if ( ! empty( $version['meta_period'] ) || ! empty( $version['meta_end'] ) || ! empty( $version['meta_ann'] ) ) : ?>
							<div class="gw-perf__meta">
								<?php if ( ! empty( $version['meta_period'] ) ) : ?><span><strong>Period:</strong> <?php echo esc_html( $version['meta_period'] ); ?></span><?php endif; ?>
								<?php if ( ! empty( $version['meta_end'] ) ) : ?><span><strong>Greywing ending value:</strong> <?php echo esc_html( $version['meta_end'] ); ?></span><?php endif; ?>
								<?php if ( ! empty( $version['meta_ann'] ) ) : ?><span><strong>Annualised return:</strong> <?php echo esc_html( $version['meta_ann'] ); ?></span><?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
				<div class="gw-perf__tip" id="gw-perf-tip"></div>
			</div>
		<?php endif; ?>

		<?php if ( $note ) : ?>
			<p class="gw-perf__note"><?php echo esc_html( $note ); ?></p>
		<?php endif; ?>

	</div>
</section>
