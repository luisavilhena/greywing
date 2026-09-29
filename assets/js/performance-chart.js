/**
 * Gráfico de performance — página Funds, Seção "Performance Graph". Não
 * calcula nada: cada versão é um SVG colado pelo editor (ver "chart_versions"
 * em inc/acf-fields/funds-sections.php), já renderizado no HTML como uma
 * ".gw-perf__slide" — ver template-parts/content/funds/section-performance.php.
 * Clicar num botão só troca qual slide fica visível.
 *
 * Vanilla JS, sem dependência — carregado só na página de Funds (ver
 * inc/enqueue.php).
 */
( function () {
	'use strict';

	var box     = document.getElementById( 'gw-perf-chart-box' );
	var buttons = document.querySelectorAll( '#gw-perf-ranges .gw-perf__range' );

	if ( ! box || ! buttons.length ) {
		return;
	}

	var slides = box.querySelectorAll( '.gw-perf__slide' );

	buttons.forEach( function ( button ) {
		button.addEventListener( 'click', function () {
			var index = button.getAttribute( 'data-index' );

			buttons.forEach( function ( b ) {
				b.classList.toggle( 'is-active', b === button );
			} );
			slides.forEach( function ( slide ) {
				slide.classList.toggle( 'is-active', slide.getAttribute( 'data-index' ) === index );
			} );
		} );
	} );
} )();
