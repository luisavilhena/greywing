<?php
/**
 * Conteúdo da página Login — cartão que leva pro portal externo (Dynamo).
 * Ver inc/acf-fields/login-fields.php e assets/css/login.css.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title       = get_field( 'title' );
$lead        = get_field( 'lead' );
$card_url    = get_field( 'card_url' );
$card_bar    = get_field( 'card_bar' );
$card_kicker = get_field( 'card_kicker' );
$card_title  = get_field( 'card_title' );
$card_cta    = get_field( 'card_cta' );
$note        = get_field( 'note' );
?>
<div class="gw-wrap gw-login gw-block">

	<?php if ( $title ) : ?>
		<h1 class="gw-h-page gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h1>
	<?php endif; ?>

	<?php if ( $lead ) : ?>
		<p class="gw-login__lead gw-rv"><?php echo nl2br( esc_html( $lead ) ); ?></p>
	<?php endif; ?>

	<?php if ( $card_url ) : ?>
		<a class="gw-login__card gw-rv" href="<?php echo esc_url( $card_url ); ?>" target="_blank" rel="noopener">
			<?php if ( $card_bar ) : ?>
				<span class="gw-login__card-bar">
					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><rect x="5" y="11" width="14" height="9" rx="1.5" stroke="currentColor" stroke-width="1.6"/><path d="M8 11V7a4 4 0 0 1 8 0v4" stroke="currentColor" stroke-width="1.6"/></svg>
					<?php echo esc_html( $card_bar ); ?>
				</span>
			<?php endif; ?>
			<?php if ( $card_kicker ) : ?>
				<span class="gw-login__card-kicker"><?php echo esc_html( $card_kicker ); ?></span>
			<?php endif; ?>
			<?php if ( $card_title ) : ?>
				<span class="gw-login__card-title"><?php echo esc_html( $card_title ); ?></span>
			<?php endif; ?>
			<?php if ( $card_cta ) : ?>
				<span class="gw-login__card-cta">
					<?php echo esc_html( $card_cta ); ?>
					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</span>
			<?php endif; ?>
		</a>
	<?php endif; ?>

	<?php if ( $note ) : ?>
		<div class="gw-login__note gw-rv"><?php echo wp_kses_post( $note ); ?></div>
	<?php endif; ?>

</div>
