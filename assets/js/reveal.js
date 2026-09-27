/**
 * Animações de entrada do texto ao rolar a página.
 *
 * Dois efeitos, ligados por classe:
 *  - .gw-split: cada palavra "sobe" de dentro de uma máscara, com atraso
 *    crescente por palavra (--gw-i) — usado em títulos.
 *  - .gw-rv: o elemento aparece com blur + fade + leve subida — usado em
 *    parágrafos, dentro de um wrapper .gw-block (cada .gw-rv direto dentro
 *    do bloco ganha um atraso crescente automático, se não tiver um --gw-d
 *    já definido inline pelo PHP).
 *
 * O CSS de ambos fica em assets/css/base.css — este arquivo só faz o setup
 * (quebrar o texto em palavras) e dispara a classe ".in" via
 * IntersectionObserver conforme cada elemento entra na tela.
 *
 * Se o aviso de elegibilidade (#gw-disclaimer-gate) estiver na página, o
 * disparo espera o evento "gw:gate-closed" (ver disclaimer-gate.js) — sem
 * isso, elementos escondidos atrás do aviso já apareceriam "revelados" (o
 * IntersectionObserver não sabe que tem um modal por cima).
 */
( function () {
	'use strict';

	var reduce = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/* ---------- quebra os títulos em palavras mascaradas ---------- */
	document.querySelectorAll( '.gw-split' ).forEach( function ( el ) {
		var i = 0;
		var base = parseInt( el.dataset.d || '0', 10 );
		( function walk( node ) {
			Array.prototype.slice.call( node.childNodes ).forEach( function ( n ) {
				if ( n.nodeType === 3 ) {
					var parts = n.textContent.split( /(\s+)/ );
					var frag = document.createDocumentFragment();
					parts.forEach( function ( p ) {
						if ( ! p ) return;
						if ( /^\s+$/.test( p ) ) {
							frag.appendChild( document.createTextNode( ' ' ) );
							return;
						}
						var w = document.createElement( 'span' );
						w.className = 'gw-w';
						var wi = document.createElement( 'span' );
						wi.className = 'gw-wi';
						wi.textContent = p;
						wi.style.setProperty( '--gw-i', i++ );
						if ( base ) wi.style.setProperty( '--gw-d', base + 'ms' );
						w.appendChild( wi );
						frag.appendChild( w );
					} );
					n.parentNode.replaceChild( frag, n );
				} else if ( n.nodeType === 1 && ! n.classList.contains( 'gw-br' ) ) {
					walk( n );
				}
			} );
		} )( el );
	} );

	/* ---------- atraso automático entre parágrafos de um mesmo bloco ---------- */
	document.querySelectorAll( '.gw-block' ).forEach( function ( b ) {
		var k = 0;
		b.querySelectorAll( ':scope > .gw-rv' ).forEach( function ( p ) {
			if ( ! p.style.getPropertyValue( '--gw-d' ) ) p.style.setProperty( '--gw-d', ( k++ * 110 ) + 'ms' );
		} );
	} );

	/* ---------- dispara conforme entra na tela ---------- */
	function startReveals() {
		// A primeira seção (hero) já entra visível, sem esperar o scroll.
		document.querySelectorAll( '.gw-hero .gw-split, .gw-hero .gw-rv, .gw-hero .gw-bar' ).forEach( function ( e ) {
			e.classList.add( 'in' );
		} );

		var els = document.querySelectorAll( '.gw-split, .gw-rv, .gw-bar, .gw-steps' );
		if ( reduce || ! ( 'IntersectionObserver' in window ) ) {
			els.forEach( function ( e ) { e.classList.add( 'in' ); } );
			return;
		}
		var io = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( en ) {
					if ( en.isIntersecting ) {
						en.target.classList.add( 'in' );
						io.unobserve( en.target );
					}
				} );
			},
			{ rootMargin: '0px 0px -8% 0px', threshold: 0.12 }
		);
		els.forEach( function ( e ) { io.observe( e ); } );
	}

	if ( document.getElementById( 'gw-disclaimer-gate' ) ) {
		document.addEventListener( 'gw:gate-closed', startReveals, { once: true } );
	} else {
		startReveals();
	}
} )();
