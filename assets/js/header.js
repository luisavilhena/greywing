/**
 * Header do site: fica sólido depois de rolar um pouco, e o menu mobile
 * (burger) abre/fecha. Ver template-parts/layout/site-header.php.
 *
 * Vanilla JS, sem dependência — carregado em inc/enqueue.php.
 */
( function () {
	'use strict';

	var hdr = document.getElementById( 'gw-hdr' );
	var burger = document.getElementById( 'gw-burger' );
	var nav = document.getElementById( 'gw-nav' );

	if ( ! hdr ) return;

	function onScroll() {
		hdr.classList.toggle( 'gw-solid', window.scrollY > 40 );
	}
	window.addEventListener( 'scroll', onScroll, { passive: true } );
	onScroll();

	if ( burger && nav ) {
		function closeMenu() {
			document.body.classList.remove( 'gw-menu-open' );
			burger.setAttribute( 'aria-expanded', 'false' );
		}
		burger.addEventListener( 'click', function () {
			var open = document.body.classList.toggle( 'gw-menu-open' );
			burger.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );
		nav.querySelectorAll( 'a' ).forEach( function ( a ) {
			a.addEventListener( 'click', closeMenu );
		} );
		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key ) closeMenu();
		} );
	}

	// Entrada do header (logo/menu/CTA) — só depois que a página estiver
	// pronta pra mostrar (ver disclaimer-gate.js / reveal.js).
	function ready() {
		document.body.classList.add( 'gw-ready' );
	}
	if ( document.getElementById( 'gw-disclaimer-gate' ) ) {
		document.addEventListener( 'gw:gate-closed', ready, { once: true } );
	} else {
		ready();
	}
} )();
