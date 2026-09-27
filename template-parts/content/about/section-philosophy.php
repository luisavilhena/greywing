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
$subtitle   = get_sub_field( 'subtitle' );
$text_left  = get_sub_field( 'text_left' );
$text_right = get_sub_field( 'text_right' );
$pull_quote = get_sub_field( 'pull_quote' );
?>
<section class="gw-card gw-sec gw-phil<?php echo greywing_section_theme_class( $theme ); ?>"<?php echo greywing_anchor_attr( $anchor ); ?>>
	<div class="gw-wrap">

		<?php if ( $title ) : ?>
			<h2 class="gw-h-sec gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( have_rows( 'steps' ) ) : ?>
			<div class="gw-steps">
				<?php
				$greywing_step_i = 0;
				while ( have_rows( 'steps' ) ) :
					the_row();
					$greywing_word = get_sub_field( 'word' );
					if ( ! $greywing_word ) {
						continue;
					}
					$greywing_step_o = max( 0.35, 1 - ( $greywing_step_i * 0.15 ) );
					?>
					<span class="gw-step" style="--gw-i:<?php echo esc_attr( $greywing_step_i ); ?>;--gw-o:<?php echo esc_attr( $greywing_step_o ); ?>"><?php echo esc_html( $greywing_word ); ?></span>
					<?php
					$greywing_step_i++;
				endwhile;
				?>
			</div>
		<?php endif; ?>

		<div class="gw-phil__grid">
			<?php if ( $subtitle ) : ?>
				<h3 class="gw-phil__subtitle gw-h-sub gw-bar gw-split no-line"><?php echo greywing_title_html( $subtitle ); ?></h3>
			<?php endif; ?>
			<?php if ( $text_left ) : ?>
				<div class="gw-phil__left gw-block"><?php echo greywing_richtext_reveal( wp_kses_post( $text_left ) ); ?></div>
			<?php endif; ?>
			<?php if ( $text_right ) : ?>
				<div class="gw-phil__right gw-block"><?php echo greywing_richtext_reveal( wp_kses_post( $text_right ) ); ?></div>
			<?php endif; ?>
		</div>

		<?php if ( $pull_quote ) : ?>
			<p class="gw-pull gw-split"><?php echo nl2br( esc_html( $pull_quote ) ); ?></p>
		<?php endif; ?>

	</div>
</section>
