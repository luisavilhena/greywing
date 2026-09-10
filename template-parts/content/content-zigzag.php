<?php
/**
 * Componente: Título de largura livre + repeater em zigzag
 * (imagem + subtítulo + texto, alternando coluna esquerda/direita).
 * Layout ACF: title_zigzag.
 *
 * O 1º bloco cai na coluna esquerda, o 2º na direita, o 3º na esquerda...
 * isso é resolvido só com CSS (:nth-child), sem precisar de campo extra
 * no repeater — ver assets/css/components/content-zigzag.css.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor        = get_sub_field( 'anchor' );
$title         = get_sub_field( 'title' );
$title_spacing = get_sub_field( 'title_spacing' ) ?: 'md';

// Linha vazia (sem título e sem nenhum bloco no repeater) = nenhum HTML renderizado.
if ( ! $title && ! have_rows( 'blocks' ) ) {
	return;
}
?>
<section class="gw-row gw-zigzag"<?php echo greywing_anchor_attr( $anchor ); ?>>

	<?php if ( $title ) : ?>
		<h2 class="gw-zigzag__title gw-mb-<?php echo esc_attr( $title_spacing ); ?>"><?php echo nl2br( esc_html( $title ) ); ?></h2>
	<?php endif; ?>

	<?php if ( have_rows( 'blocks' ) ) : ?>
		<div class="gw-zigzag__blocks">
			<?php
			while ( have_rows( 'blocks' ) ) :
				the_row();

				$image    = get_sub_field( 'image' );
				$subtitle = get_sub_field( 'subtitle' );
				$text     = get_sub_field( 'text' );

				// Bloco vazio dentro do repeater = também não renderiza nada.
				if ( ! $image && ! $subtitle && ! $text ) {
					continue;
				}
				?>
				<div class="gw-zigzag__block">

					<?php if ( $image ) : ?>
						<figure class="gw-zigzag__block-image">
							<img
								src="<?php echo esc_url( $image['url'] ); ?>"
								alt="<?php echo esc_attr( $image['alt'] ); ?>"
								width="<?php echo esc_attr( $image['width'] ); ?>"
								height="<?php echo esc_attr( $image['height'] ); ?>"
								loading="lazy"
							>
						</figure>
					<?php endif; ?>

					<div class="gw-zigzag__block-content">
						<?php if ( $subtitle ) : ?>
							<h3 class="gw-zigzag__block-subtitle"><?php echo esc_html( $subtitle ); ?></h3>
						<?php endif; ?>
						<?php if ( $text ) : ?>
							<div class="gw-zigzag__block-text"><?php echo wp_kses_post( $text ); ?></div>
						<?php endif; ?>
					</div>

				</div>
				<?php
			endwhile;
			?>
		</div>
	<?php endif; ?>

</section>
