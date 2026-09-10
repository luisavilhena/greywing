<?php
/**
 * Popup de Login — abre ao clicar em "Login" no menu (qualquer página, já
 * que o menu é global). Usa o painel deslizante genérico (.gw-drawer, ver
 * assets/css/components/drawer.css e assets/js/drawer.js).
 *
 * Conteúdo vem de Opções do Tema → Login (popup) — ver
 * inc/acf-fields/options-login.php. O item "Login" do menu é ligado a este
 * painel via o filtro greywing_login_menu_item_attributes() em inc/setup.php,
 * que procura o item cuja URL seja "#login-popup".
 *
 * Incluído nos dois templates de página, junto com o menu.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title  = get_field( 'login_title', 'option' );
$text   = get_field( 'login_text', 'option' );
$button = get_field( 'login_button', 'option' );

if ( ! $title && ! $text && ! $button ) {
	return;
}
?>
<div class="gw-drawer gw-drawer--fade" id="gw-login-popup">
	<div class="gw-drawer__panel gw-drawer__panel--content-width gw-drawer__panel--login">
		<button class="gw-drawer__close" type="button" aria-label="Fechar">
			<span aria-hidden="true">✕</span>
		</button>

		<?php if ( $title ) : ?>
			<h2 class="gw-drawer__title"><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( $text ) : ?>
			<div class="gw-drawer__intro"><?php echo wp_kses_post( $text ); ?></div>
		<?php endif; ?>

		<?php if ( ! empty( $button['url'] ) ) : ?>
			<a
				class="gw-drawer__button"
				href="<?php echo esc_url( $button['url'] ); ?>"
				<?php echo ! empty( $button['target'] ) ? ' target="' . esc_attr( $button['target'] ) . '" rel="noopener"' : ''; ?>
			>
				<?php echo esc_html( $button['title'] ); ?>
			</a>
		<?php endif; ?>
	</div>
</div>
