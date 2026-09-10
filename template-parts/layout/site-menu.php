<?php
/**
 * Menu vertical fixo, coluna da esquerda (.gw-menu). Usado pelos dois
 * templates de página (template-home.php e template-legal.php).
 *
 * - Itens de topo (About, Funds, Contact...) e sub-itens vêm de um menu
 *   nativo do WordPress (Aparência → Menus, local "Menu principal").
 * - "Invest now" é outro menu nativo à parte (local "Invest now"), num
 *   componente próprio — fica separado do resto e empurrado pro fim da
 *   coluna do menu (ver .gw-menu__inner em assets/css/layout.css).
 * - O item de topo da página atual fica em negrito automaticamente (classe
 *   current-menu-item / current_page_item que o próprio wp_nav_menu() já
 *   adiciona) — e é isso que faz os sub-itens dele aparecerem (ver CSS).
 * - Qual sub-item fica em negrito conforme o scroll (e o scroll suave ao
 *   clicar) é feito em assets/js/menu.js.
 * - No mobile isso tudo vira um painel que abre com o botão de menu
 *   (assets/js/menu.js cuida do abrir/fechar).
 *
 * CSS: assets/css/layout.css (a própria estrutura do menu mora lá, junto
 * com o resto do layout de 3 colunas).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="gw-menu__inner">

	<div class="gw-menu__top">

		<a class="gw-menu__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<img src="<?php echo esc_url( GREYWING_THEME_URI . '/assets/img/logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="200" height="47">
		</a>

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="gw-menu__nav" aria-label="Menu principal">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'depth'          => 2,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
		<?php endif; ?>
		<?php if ( has_nav_menu( 'invest_now' ) ) : ?>
		<nav class="gw-menu__invest" aria-label="Invest now">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'invest_now',
					'container'      => false,
					'depth'          => 1,
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>
	<?php endif; ?>

	</div>


</div>
