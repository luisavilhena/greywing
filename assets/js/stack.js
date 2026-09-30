/**
 * Empilhamento de seções: dentro de um wrapper ".gw-stack", cada seção
 * ".gw-card" é sticky — a próxima "desliza por cima" da anterior conforme
 * rola. A variável --gw-p (0 a 1) mede o quanto a próxima seção já cobriu a
 * atual, e o CSS (base.css) usa isso pra encolher levemente e escurecer a
 * seção de baixo.
 *
 * Cada URL do site é uma página de verdade (não é SPA) — não tem roteador
 * de hash aqui, só o cálculo de --gw-p e o scroll suave até uma âncora
 * (usado pelos sub-itens do menu, tipo "#about-us").
 *
 * Não faz nada em página sem ".gw-stack" (Contact, Login, Termos).
 *
 * Vanilla JS, sem dependência — carregado em inc/enqueue.php.
 */
( function () {
	'use strict';

	var reduce = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var stack = document.querySelector( '.gw-stack' );
	var cards = [];

	function setupCards() {
		if ( ! stack ) return;
		cards = Array.prototype.slice.call( stack.querySelectorAll( ':scope > .gw-card' ) );
		var vh = window.innerHeight;
		// Um card sticky só consegue mostrar uma "janela" congelada de si
		// mesmo (do tamanho da tela) enquanto gruda — se o conteúdo dele for
		// mais alto que isso, tem ou o topo ou o fim escondido pra sempre,
		// não dá pra rolar dentro dele pra ver o resto. Então: card mais alto
		// que a tela vira "gw-card--tall" (position:relative via CSS, ver
		// base.css) — deixa de grudar e passa a rolar normal, mostrando tudo.
		// Card do tamanho da tela continua sticky normalmente (nada muda).
		cards.forEach( function ( c, i ) {
			c.style.zIndex = i + 1;
			c.style.top = '0px';
			c.classList.toggle( 'gw-card--tall', c.offsetHeight > vh + 1 );
		} );
		onScroll();
	}

	function naturalTop( el ) {
		var y = el.parentElement.offsetTop;
		var n = el;
		while ( ( n = n.previousElementSibling ) ) y += n.offsetHeight;
		return y;
	}

	/**
	 * Rola suavemente até um elemento — se for (ou estiver dentro de) um
	 * ".gw-card", usa a posição "natural" dele na pilha (não a posição
	 * atual na tela, que pode estar deslocada pelo sticky).
	 */
	function goTo( el, smooth ) {
		var card = el.classList.contains( 'gw-card' ) ? el : el.closest( '.gw-card' );
		var y;
		if ( card ) {
			y = naturalTop( card ) + ( el === card ? 0 : el.offsetTop );
		} else {
			y = el.getBoundingClientRect().top + window.scrollY - 96;
		}
		window.scrollTo( { top: y, behavior: ( smooth && ! reduce ) ? 'smooth' : 'auto' } );
	}

	var ticking = false;
	function onScroll() {
		if ( ! cards.length || ticking ) return;
		ticking = true;
		requestAnimationFrame( function () {
			ticking = false;
			var vh = window.innerHeight;
			cards.forEach( function ( c, i ) {
				var next = cards[ i + 1 ];
				var p = 0;
				if ( next ) {
					var t = next.getBoundingClientRect().top;
					p = Math.max( 0, Math.min( 1, 1 - t / vh ) );
				}
				c.style.setProperty( '--gw-p', reduce ? 0 : p.toFixed( 3 ) );
			} );
		} );
	}
	window.addEventListener( 'scroll', onScroll, { passive: true } );

	// Clique num link pra uma âncora da própria página (ex.: sub-item do
	// menu "#about-us"): rola suave até a posição certa, considerando a
	// pilha, em vez do salto seco padrão do navegador.
	document.addEventListener( 'click', function ( e ) {
		var a = e.target.closest( 'a[href*="#"]' );
		if ( ! a ) return;
		var url = new URL( a.href, location.href );
		if ( url.pathname !== location.pathname || ! url.hash ) return;
		var target = document.getElementById( url.hash.slice( 1 ) );
		if ( ! target ) return;
		e.preventDefault();
		goTo( target, true );
		history.pushState( null, '', url.hash );
	} );

	function init() {
		setupCards();
		if ( location.hash ) {
			var target = document.getElementById( location.hash.slice( 1 ) );
			if ( target ) requestAnimationFrame( function () { goTo( target, false ); } );
		}
	}

	window.addEventListener( 'load', init );
	document.querySelectorAll( 'img' ).forEach( function ( im ) {
		im.addEventListener( 'load', setupCards );
	} );
	var rt;
	window.addEventListener( 'resize', function () {
		clearTimeout( rt );
		rt = setTimeout( setupCards, 150 );
	} );
} )();
