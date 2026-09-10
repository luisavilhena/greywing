/**
 * Painel deslizante genérico (.gw-drawer — ver assets/css/components/drawer.css).
 * Usado hoje pelo formulário de contato e pelo popup de Login, mas serve
 * pra qualquer painel novo que precisar do mesmo comportamento.
 *
 * Qualquer elemento com "data-gw-form-trigger=id-do-painel" abre o painel
 * com esse id; o botão ".gw-drawer__close", um clique fora do painel ou a
 * tecla Esc fecham.
 *
 * Vanilla JS, sem dependência nenhuma — carregado em inc/enqueue.php.
 */
( function () {
	'use strict';

	var triggers = document.querySelectorAll( '[data-gw-form-trigger]' );

	if ( ! triggers.length ) {
		return;
	}

	function openDrawer( drawer ) {
		drawer.classList.add( 'is-open' );
		document.body.classList.add( 'gw-drawer-is-open' );
	}

	function closeDrawer( drawer ) {
		drawer.classList.remove( 'is-open' );
		document.body.classList.remove( 'gw-drawer-is-open' );
	}

	triggers.forEach( function ( trigger ) {
		var drawer = document.getElementById( trigger.getAttribute( 'data-gw-form-trigger' ) );
		if ( ! drawer ) {
			return;
		}

		trigger.addEventListener( 'click', function ( event ) {
			event.preventDefault();
			openDrawer( drawer );
		} );

		// Fecha no botão "X".
		var closeButton = drawer.querySelector( '.gw-drawer__close' );
		if ( closeButton ) {
			closeButton.addEventListener( 'click', function () {
				closeDrawer( drawer );
			} );
		}

		// Fecha clicando fora do painel (na camada de fundo).
		drawer.addEventListener( 'click', function ( event ) {
			if ( event.target === drawer ) {
				closeDrawer( drawer );
			}
		} );

		// Fecha com Esc.
		document.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' === event.key && drawer.classList.contains( 'is-open' ) ) {
				closeDrawer( drawer );
			}
		} );
	} );
} )();
