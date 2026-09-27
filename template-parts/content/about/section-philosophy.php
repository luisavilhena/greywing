<?php
/**
 * About — Seção 3: Investment Philosophy. Título + "passos" (Understand.
 * Identify. Structure. Manage.), subtítulo + 2 colunas de texto, e uma frase
 * de destaque ocupando a linha inteira embaixo.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor     = get_sub_field( 'anchor' );
$theme      = get_sub_field( 'theme' );
$title      = get_sub_field( 'title' );
$steps      = get_sub_field( 'steps' );
$subtitle   = get_sub_field( 'subtitle' );
$text_left  = get_sub_field( 'text_left' );
$text_right = get_sub_field( 'text_right' );
$pull_quote = get_sub_field( 'pull_quote' );

// "Understand. Identify. Structure. Manage." -> uma palavra-frase por vez,
// cada uma com sua opacidade/atraso (ver .gw-step em assets/css/about.css).
$steps_words = $steps ? preg_split( '/(?<=\.)\s+/', trim( $steps ) ) : array();
?>
<section class="gw-card gw-sec gw-phil<?php echo greywing_section_theme_class( $theme ); ?>"<?php echo greywing_anchor_attr( $anchor ); ?>>
	<div class="gw-wrap">

		<?php if ( $title ) : ?>
			<h2 class="gw-h-sec gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( $steps_words ) : ?>
			<p class="gw-steps gw-block">
				<?php foreach ( $steps_words as $i => $word ) : ?>
					<span class="gw-step gw-rv" style="--gw-d:<?php echo esc_attr( $i * 140 ); ?>ms"><?php echo esc_html( $word ); ?></span>
					<?php if ( 1 === $i ) : ?><br class="gw-br"><?php endif; ?>
				<?php endforeach; ?>
			</p>
		<?php endif; ?>

		<div class="gw-grid12">
			<div class="gw-col-title">
				<?php if ( $subtitle ) : ?>
					<h3 class="gw-h-sub gw-bar gw-split"><?php echo greywing_title_html( $subtitle ); ?></h3>
				<?php endif; ?>
				<?php if ( $text_left ) : ?>
					<div class="gw-block"><?php echo greywing_richtext_reveal( wp_kses_post( $text_left ) ); ?></div>
				<?php endif; ?>
			</div>
			<?php if ( $text_right ) : ?>
				<div class="gw-col-body">
					<div class="gw-block"><?php echo greywing_richtext_reveal( wp_kses_post( $text_right ) ); ?></div>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $pull_quote ) : ?>
			<p class="gw-pull gw-rv"><?php echo nl2br( esc_html( $pull_quote ) ); ?></p>
		<?php endif; ?>

	</div>
</section>
