/**
 * Gráfico de performance — página Funds, Seção "Performance Graph". Cada
 * versão é um SVG colado pelo editor (repeater "chart_versions" em
 * inc/acf-fields/funds-sections.php), com sua própria legenda (cor+rótulo,
 * também editável) — ver template-parts/content/funds/section-performance.php.
 *
 * A interatividade ao passar o mouse (linha-guia, pontos, cartão com os
 * valores) não é calculada aqui: os valores/posições de cada ponto já vêm
 * embutidos nos atributos data-* de cada retângulo ".gw-perf-hit rect" (e
 * o grupo ".gw-perf-guide", com a linha e os pontos escondidos) dentro do
 * próprio SVG colado. Este arquivo só:
 *  1) troca qual ".gw-perf__slide" fica visível quando clica num botão;
 *  2) ao passar o mouse num slide, lê o retângulo mais próximo, casa cada
 *     valor com o item da legenda na mesma posição, e monta o cartão.
 *
 * Vanilla JS, sem dependência — carregado só na página de Funds.
 */
( function () {
	'use strict';

	var box     = document.getElementById( 'gw-perf-chart-box' );
	var tip     = document.getElementById( 'gw-perf-tip' );
	var buttons = document.querySelectorAll( '#gw-perf-ranges .gw-perf__range' );

	if ( ! box ) {
		return;
	}

	var slides = box.querySelectorAll( '.gw-perf__slide' );

	function activeSlide() {
		return box.querySelector( '.gw-perf__slide.is-active' );
	}

	function legendOf( slide ) {
		return Array.prototype.map.call( slide.querySelectorAll( '.gw-perf__legend li' ), function ( li ) {
			var dot = li.querySelector( 'i' );
			return {
				color: dot ? dot.style.background : '',
				label: li.textContent.trim(),
			};
		} );
	}

	function usd( n ) {
		return '$' + Number( n ).toLocaleString( 'en-US' );
	}

	function bindSlide( slide ) {
		var svg = slide.querySelector( 'svg' );
		if ( ! svg || slide.dataset.gwBound ) {
			return;
		}
		slide.dataset.gwBound = '1';

		var guide    = svg.querySelector( '.gw-perf-guide' );
		var guideLine = svg.querySelector( '.gw-perf-guide-line' );
		var guideDots = svg.querySelectorAll( '.gw-perf-guide-dot' );
		var legend    = legendOf( slide );

		function show( rect ) {
			var x      = parseFloat( rect.getAttribute( 'data-x' ) );
			var date   = rect.getAttribute( 'data-date' );
			var values = ( rect.getAttribute( 'data-values' ) || '' ).split( ',' );
			var ys     = ( rect.getAttribute( 'data-ys' ) || '' ).split( ',' );

			if ( guide ) {
				guideLine.setAttribute( 'x1', x );
				guideLine.setAttribute( 'x2', x );
				guideDots.forEach( function ( dot, i ) {
					if ( ys[ i ] !== undefined ) {
						dot.setAttribute( 'cx', x );
						dot.setAttribute( 'cy', ys[ i ] );
					}
				} );
				guide.style.opacity = '1';
			}

			if ( ! tip ) {
				return;
			}

			var rows = legend.map( function ( item, i ) {
				if ( values[ i ] === undefined ) {
					return '';
				}
				return '<div class="gw-perf__tip-row"><span><i style="background:' + item.color + '"></i>' + item.label + '</span><b>' + usd( values[ i ] ) + '</b></div>';
			} ).join( '' );
			tip.innerHTML = '<div class="gw-perf__tip-date">' + date + '</div>' + rows;

			var svgRect = svg.getBoundingClientRect();
			var boxRect = box.getBoundingClientRect();
			var vb      = svg.viewBox.baseVal;
			var scale   = vb.width ? svgRect.width / vb.width : 1;
			var left    = ( svgRect.left - boxRect.left ) + x * scale;
			var top     = svgRect.top - boxRect.top;

			tip.style.left = Math.max( 90, Math.min( boxRect.width - 90, left ) ) + 'px';
			tip.style.top  = top + 'px';
			tip.style.opacity = '1';
		}

		function hide() {
			if ( guide ) {
				guide.style.opacity = '0';
			}
			if ( tip ) {
				tip.style.opacity = '0';
			}
		}

		svg.addEventListener( 'pointermove', function ( e ) {
			var rect = e.target.closest ? e.target.closest( '.gw-perf-hit rect' ) : null;
			if ( rect ) {
				show( rect );
			}
		} );
		svg.addEventListener( 'pointerleave', hide );
	}

	slides.forEach( bindSlide );

	buttons.forEach( function ( button ) {
		button.addEventListener( 'click', function () {
			var index = button.getAttribute( 'data-index' );

			buttons.forEach( function ( b ) {
				b.classList.toggle( 'is-active', b === button );
			} );
			slides.forEach( function ( slide ) {
				slide.classList.toggle( 'is-active', slide.getAttribute( 'data-index' ) === index );
			} );
			if ( tip ) {
				tip.style.opacity = '0';
			}
			var active = activeSlide();
			if ( active ) {
				bindSlide( active );
			}
		} );
	} );
} )();
