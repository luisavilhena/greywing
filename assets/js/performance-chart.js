/**
 * Gráfico de performance — página Funds, Seção "Performance Graph". Não
 * calcula nada: cada botão troca a imagem exibida (ver
 * template-parts/content/funds/section-performance.php e o repeater
 * "chart_versions" em inc/acf-fields/funds-sections.php — cada linha é uma
 * imagem/SVG enviada pelo editor).
 *
 * Vanilla JS, sem dependência — carregado só na página de Funds (ver
 * inc/enqueue.php).
 */
( function () {
	'use strict';

	var img     = document.getElementById( 'gw-perf-chart-img' );
	var buttons = document.querySelectorAll( '#gw-perf-ranges .gw-perf__range' );

	if ( ! img || ! buttons.length ) {
		return;
	}

	buttons.forEach( function ( button ) {
		button.addEventListener( 'click', function () {
			var src = button.getAttribute( 'data-image' );
			if ( ! src ) {
				return;
			}
			buttons.forEach( function ( b ) {
				b.classList.toggle( 'is-active', b === button );
			} );
			img.src = src;
			img.alt = button.textContent.trim();
		} );
	} );
} )();
