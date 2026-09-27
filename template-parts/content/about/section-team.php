<?php
/**
 * About — Seção 5: Team. Última carta da pilha — fundo em degradê próprio
 * (não é uma das 8 cores compartilhadas, por isso não tem campo de tema).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor = get_sub_field( 'anchor' );
$title  = get_sub_field( 'title' );
$text   = get_sub_field( 'text' );
$lead   = get_sub_field( 'lead' );
$button = get_sub_field( 'button' );
?>
<section class="gw-card gw-sec gw-team"<?php echo greywing_anchor_attr( $anchor ); ?>>
	<div class="gw-wrap gw-team__in gw-block">

		<?php if ( $title ) : ?>
			<h2 class="gw-h-sec gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( $text ) : ?>
			<?php echo greywing_richtext_reveal( wp_kses_post( $text ) ); ?>
		<?php endif; ?>

		<?php if ( $lead ) : ?>
			<p class="gw-lead-strong gw-rv"><?php echo esc_html( $lead ); ?></p>
		<?php endif; ?>

		<?php if ( $button && ! empty( $button['url'] ) ) : ?>
			<a class="gw-btn gw-btn--on-dark gw-rv" href="<?php echo esc_url( $button['url'] ); ?>" target="<?php echo esc_attr( $button['target'] ? $button['target'] : '_self' ); ?>">
				<?php echo esc_html( $button['title'] ? $button['title'] : 'Contact us' ); ?>
			</a>
		<?php endif; ?>

	</div>
</section>
