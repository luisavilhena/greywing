/**
 * Menu do site: abrir/fechar o painel mobile (hambúrguer) e scroll-spy dos
 * sub-itens (deixa em negrito o sub-item da seção que está na tela).
 *
 * Vanilla JS, sem dependência nenhuma — carregado em inc/enqueue.php.
 */
( function () {
	'use strict';

	/* 1) Menu mobile (abrir/fechar) ---------------------------------- */

	var toggle = document.querySelector( '.gw-menu-toggle' );
	var menu = document.getElementById( 'gw-menu' );

	function closeMenu() {
		document.body.classList.remove( 'gw-menu-is-open' );
		if ( toggle ) {
			toggle.setAttribute( 'aria-expanded', 'false' );
		}
	}

	if ( toggle && menu ) {
		toggle.addEventListener( 'click', function () {
			var isOpen = document.body.classList.toggle( 'gw-menu-is-open' );
			toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		} );

		// Fecha o painel ao clicar em qualquer link do menu.
		menu.querySelectorAll( 'a' ).forEach( function ( link ) {
			link.addEventListener( 'click', closeMenu );
		} );

		// Fecha com Esc.
		document.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' === event.key ) {
				closeMenu();
			}
		} );
	}

	/* 2) Scroll-spy dos sub-itens -------------------------------------- */

	var subLinks = document.querySelectorAll( '.gw-menu__nav .sub-menu a[href*="#"]' );

	if ( ! subLinks.length || ! ( 'IntersectionObserver' in window ) ) {
		return;
	}

	var linkByTargetId = {};

	subLinks.forEach( function ( link ) {
		var hash = link.getAttribute( 'href' ).split( '#' )[ 1 ];
		if ( hash ) {
			linkByTargetId[ hash ] = link;
		}
	} );

	var observer = new IntersectionObserver(
		function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( ! entry.isIntersecting ) {
					return;
				}
				var activeLink = linkByTargetId[ entry.target.id ];
				if ( ! activeLink ) {
					return;
				}
				subLinks.forEach( function ( link ) {
					link.classList.remove( 'is-active' );
				} );
				activeLink.classList.add( 'is-active' );
			} );
		},
		// Considera "atual" a seção que está passando pela faixa perto do
		// topo da tela — nem precisa estar totalmente visível.
		{ rootMargin: '-15% 0px -70% 0px', threshold: 0 }
	);

	Object.keys( linkByTargetId ).forEach( function ( id ) {
		var section = document.getElementById( id );
		if ( section ) {
			observer.observe( section );
		}
	} );
} )();
