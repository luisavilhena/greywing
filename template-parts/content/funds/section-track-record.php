<?php
/**
 * Funds — Seção 2: Track Record. Dois textos em negrito, 2 estatísticas
 * grandes (retorno anualizado/acumulado) e 3 retornos "rolling" (3/6/12 meses).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor    = get_sub_field( 'anchor' );
$theme     = get_sub_field( 'theme' );
$title     = get_sub_field( 'title' );
$lead_1    = get_sub_field( 'lead_1' );
$lead_2    = get_sub_field( 'lead_2' );
$stat1_num = get_sub_field( 'stat_1_num' );
$stat1_lbl = get_sub_field( 'stat_1_label' );
$stat2_num = get_sub_field( 'stat_2_num' );
$stat2_lbl = get_sub_field( 'stat_2_label' );
$roll3     = get_sub_field( 'rolling_3m' );
$roll6     = get_sub_field( 'rolling_6m' );
$roll12    = get_sub_field( 'rolling_12m' );
$as_of     = get_sub_field( 'as_of' );
?>
<section class="gw-card gw-sec gw-track<?php echo greywing_section_theme_class( $theme ); ?>"<?php echo greywing_anchor_attr( $anchor ); ?>>
	<div class="gw-wrap gw-block">

		<?php if ( $title ) : ?>
			<h2 class="gw-h-sec gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( $lead_1 ) : ?>
			<p class="gw-lead-strong gw-rv"><?php echo nl2br( esc_html( $lead_1 ) ); ?></p>
		<?php endif; ?>
		<?php if ( $lead_2 ) : ?>
			<p class="gw-lead-strong gw-rv"><?php echo esc_html( $lead_2 ); ?></p>
		<?php endif; ?>

		<?php if ( $stat1_num || $stat2_num ) : ?>
			<div class="gw-track__stats">
				<?php if ( $stat1_num ) : ?>
					<div class="gw-track__stat gw-rv">
						<p class="gw-track__stat-num"><?php echo esc_html( $stat1_num ); ?></p>
						<p class="gw-track__stat-label"><?php echo esc_html( $stat1_lbl ); ?></p>
					</div>
				<?php endif; ?>
				<?php if ( $stat2_num ) : ?>
					<div class="gw-track__stat gw-rv">
						<p class="gw-track__stat-num"><?php echo esc_html( $stat2_num ); ?></p>
						<p class="gw-track__stat-label"><?php echo esc_html( $stat2_lbl ); ?></p>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $roll3 || $roll6 || $roll12 ) : ?>
			<div class="gw-track__rolling gw-rv">
				<?php if ( $roll3 ) : ?><div><p class="gw-track__roll-num"><?php echo esc_html( $roll3 ); ?></p><p class="gw-track__roll-label">3 Months</p></div><?php endif; ?>
				<?php if ( $roll6 ) : ?><div><p class="gw-track__roll-num"><?php echo esc_html( $roll6 ); ?></p><p class="gw-track__roll-label">6 Months</p></div><?php endif; ?>
				<?php if ( $roll12 ) : ?><div><p class="gw-track__roll-num"><?php echo esc_html( $roll12 ); ?></p><p class="gw-track__roll-label">12 Months</p></div><?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $as_of ) : ?>
			<p class="gw-track__asof"><?php echo esc_html( $as_of ); ?></p>
		<?php endif; ?>

	</div>
</section>
