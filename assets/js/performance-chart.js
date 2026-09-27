/**
 * Gráfico de performance — página Funds, Seção "Performance Graph". Não
 * calcula nada: cada botão mostra uma versão diferente do gráfico (imagem
 * OU SVG colado como código), enviada pelo editor (ver "chart_versions" em
 * inc/acf-fields/funds-sections.php). Todas as versões já vêm renderizadas
 * no HTML (uma div ".gw-perf__slide" por linha, em
 * template-parts/content/funds/section-performance.php) — clicar num botão
 * só troca qual delas fica visível, sem precisar montar HTML/SVG via JS.
 *
 * Vanilla JS, sem dependência — carregado só na página de Funds (ver
 * inc/enqueue.php).
 */
( function () {
	'use strict';

	var wrap    = document.getElementById( 'gw-perf-chart-wrap' );
	var buttons = document.querySelectorAll( '#gw-perf-ranges .gw-perf__range' );

	if ( ! wrap || ! buttons.length ) {
		return;
	}

	var slides = wrap.querySelectorAll( '.gw-perf__slide' );

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
