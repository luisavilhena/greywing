<?php
/**
 * Rodapé do site: coluna única, mesmo conteúdo em toda página — vem de
 * Opções do Tema → Footer (ver inc/acf-fields/options-footer.php).
 * Substitui o antigo content-footer.php (3 colunas).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$greywing_footer_text = get_field( 'footer_text', 'option' );

if ( ! $greywing_footer_text ) {
	return;
}
?>
<footer class="gw-footer">
	<div class="gw-wrap gw-footer__in gw-block">
		<?php echo wp_kses_post( $greywing_footer_text ); ?>
	</div>
</footer>
