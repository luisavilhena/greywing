<?php
/**
 * Header do site: topo fixo com logo, menu (com submenus About/Funds) e
 * burger no mobile. Substitui o antigo site-menu.php + mobile-header.php
 * (menu lateral) — o layout novo não tem mais menu lateral.
 *
 * Itens e submenus vêm do menu nativo do WordPress, location "primary"
 * (Aparência → Menus). O item chamado "Login" ganha um ícone (ver
 * greywing_nav_item_classes() em inc/setup.php). O CTA "Apply for
 * investment" não é um item de menu — é fixo, igual em toda página.
 *
 * Comportamento (ficar sólido ao rolar, abrir/fechar no mobile):
 * assets/js/header.js.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$greywing_apply_url = get_permalink( get_page_by_path( 'contact' ) );
if ( ! $greywing_apply_url ) {
	$greywing_apply_url = home_url( '/contact/' );
}
?>
<header class="gw-hdr" id="gw-hdr">
	<div class="gw-wrap gw-hdr__in">

		<a class="gw-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php bloginfo( 'name' ); ?>">
			<?php greywing_logo_svg(); ?>
		</a>

		<nav class="gw-nav" id="gw-nav" aria-label="Menu principal">
			<ul>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'items_wrap'     => '%3$s',
						'depth'          => 2,
						'fallback_cb'    => false,
					)
				);
				?>
				<li class="gw-nav__apply">
					<a class="gw-pill" href="<?php echo esc_url( $greywing_apply_url ); ?>">
						<span class="gw-pill__roll"><span>Apply for investment</span></span>
						<span class="gw-pill__disc" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
						</span>
					</a>
				</li>
			</ul>
		</nav>

		<a class="gw-hdr__cta gw-pill" href="<?php echo esc_url( $greywing_apply_url ); ?>">
			<span class="gw-pill__roll"><span>Apply for investment</span></span>
			<span class="gw-pill__disc" aria-hidden="true">
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</span>
		</a>

		<button class="gw-burger" id="gw-burger" type="button" aria-label="Abrir menu" aria-expanded="false" aria-controls="gw-nav">
			<span class="gw-burger__bar"></span>
			<span class="gw-burger__bar"></span>
			<span class="gw-burger__bar"></span>
		</button>

	</div>
</header>
