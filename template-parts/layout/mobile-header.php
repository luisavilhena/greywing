<?php
/**
 * Barra fixa só do mobile: logo à esquerda + botão hambúrguer à direita,
 * sempre visível (com o menu aberto ou fechado).
 *
 * Fica FORA de .gw-menu de propósito — o painel do menu abre/fecha com
 * fade (opacity), então nada impede um elemento fixo ficar dentro dele,
 * mas como essa barra precisa continuar visível mesmo com o menu FECHADO
 * (opacity: 0), ela mora fora, como irmã de .gw-menu.
 *
 * CSS: assets/css/layout.css. Comportamento de abrir/fechar: assets/js/menu.js.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="gw-mobile-header">

	<a class="gw-mobile-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
		<img src="<?php echo esc_url( GREYWING_THEME_URI . '/assets/img/logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="200" height="47">
	</a>

	<button class="gw-menu-toggle" type="button" aria-expanded="false" aria-controls="gw-menu" aria-label="Abrir menu">
		<img src="<?php echo esc_url( GREYWING_THEME_URI . '/assets/img/hamburger.svg' ); ?>" alt="" width="27" height="17">
	</button>

</div>
