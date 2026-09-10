<?php
/**
 * Footer do site.
 *
 * Não é uma linha do Flexible Content da página — o conteúdo vem de
 * Opções do Tema (wp-admin → Opções do Tema → Footer), porque é o mesmo
 * em todas as páginas. Ver inc/acf-fields/options-footer.php.
 *
 * Mesma estrutura visual de antes: 3 colunas, cada uma com linha de
 * destaque + texto, ambos opcionais, ocupando só a área de conteúdo (os
 * mesmos 70% à direita usados pelo resto da página). O texto é WYSIWYG,
 * então pode ter link no meio da frase (como no Figma) — o campo já
 * devolve o HTML pronto, com o <a> incluído.
 *
 * CSS: assets/css/components/content-footer.css
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$column_1 = get_field( 'column_1', 'option' );
$column_2 = get_field( 'column_2', 'option' );
$column_3 = get_field( 'column_3', 'option' );

/**
 * Uma coluna tem conteúdo se tiver linha de destaque ou texto preenchido.
 */
function greywing_footer_column_has_content( $column ) {
	return ! empty( $column['lead'] ) || ! empty( $column['text'] );
}

if ( ! greywing_footer_column_has_content( $column_1 ) && ! greywing_footer_column_has_content( $column_2 ) && ! greywing_footer_column_has_content( $column_3 ) ) {
	return;
}
?>
<footer class="gw-row gw-footer">

	<?php foreach ( array( $column_1, $column_2, $column_3 ) as $column ) : ?>
		<?php if ( greywing_footer_column_has_content( $column ) ) : ?>
			<div class="gw-footer__col">
				<?php if ( ! empty( $column['lead'] ) ) : ?>
					<p class="gw-footer__lead"><?php echo esc_html( $column['lead'] ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $column['text'] ) ) : ?>
					<div class="gw-footer__text"><?php echo wp_kses_post( $column['text'] ); ?></div>
				<?php endif; ?>
			</div>
		<?php else : ?>
			<div class="gw-footer__col" aria-hidden="true"></div>
		<?php endif; ?>
	<?php endforeach; ?>

</footer>
