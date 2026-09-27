/**
 * Gráfico de performance (linha, SVG) — página Funds, Seção "Performance
 * Graph". Ver template-parts/content/funds/section-performance.php.
 *
 * Dados vêm de inc/performance-data.php via wp_localize_script
 * (window.greywingPerformanceData): retorno mensal (%) por série. Este
 * arquivo só faz a parte visual — acumula os retornos num índice (base
 * USD 1.000), desenha as linhas, a legenda (clicável, mostra/esconde série),
 * os botões de período (1Y/3Y/5Y/Since inception) e o tooltip ao passar o
 * mouse.
 *
 * Se ainda não tiver retorno mensal cadastrado (arrays vazios — ver o TODO
 * em inc/performance-data.php), mostra "Chart data coming soon." no lugar do
 * gráfico, sem quebrar a página.
 *
 * Vanilla JS, sem dependência — carregado só na página de Funds (ver
 * inc/enqueue.php).
 */
( function () {
	'use strict';

	var data = window.greywingPerformanceData;
	var svg  = document.getElementById( 'gw-perf-chart' );

	if ( ! data || ! svg ) {
		return;
	}

	var wrap      = document.getElementById( 'gw-perf-chart-wrap' );
	var legendEl  = document.getElementById( 'gw-perf-legend' );
	var metaEl    = document.getElementById( 'gw-perf-meta' );
	var subEl     = document.getElementById( 'gw-perf-sub' );
	var tooltipEl = document.getElementById( 'gw-perf-tooltip' );
	var rangeBtns = document.querySelectorAll( '.gw-perf__range' );

	var seriesOrder = data.seriesOrder || [];
	var months      = seriesOrder.length ? ( data.monthlyReturns[ seriesOrder[0] ] || [] ).length : 0;

	if ( ! months ) {
		if ( wrap ) {
			wrap.innerHTML = '<p class="gw-perf__empty">Chart data coming soon.</p>';
		}
		return;
	}

	var W = 960;
	var H = 420;
	var PAD = { top: 16, right: 16, bottom: 28, left: 16 };

	// -------- índice acumulado (base 1000) a partir do retorno mensal -------
	var cumulative = {};
	seriesOrder.forEach( function ( key ) {
		var returns = data.monthlyReturns[ key ] || [];
		var value   = 1000;
		cumulative[ key ] = returns.map( function ( r ) {
			value = value * ( 1 + ( parseFloat( r ) || 0 ) / 100 );
			return value;
		} );
	} );

	// -------- rótulos de mês (AAAA-MM) a partir da data de início -------
	var labels = [];
	var start  = ( data.inception || '' ).split( '-' );
	var y0     = parseInt( start[0], 10 ) || 0;
	var m0     = ( parseInt( start[1], 10 ) || 1 ) - 1;
	for ( var i = 0; i < months; i++ ) {
		var d = new Date( y0, m0 + i, 1 );
		labels.push( d );
	}

	var hidden = {}; // séries escondidas pela legenda.
	var currentRange = 'si';

	function rangeSlice( range ) {
		var n;
		if ( 'si' === range ) {
			n = months;
		} else {
			n = { '1y': 12, '3y': 36, '5y': 60 }[ range ] || months;
		}
		var from = Math.max( 0, months - n );
		return { from: from, to: months };
	}

	function fmtUsd( v ) {
		return '$' + v.toLocaleString( 'en-US', { maximumFractionDigits: 0 } );
	}

	function fmtDate( d ) {
		return d.toLocaleDateString( 'en-US', { month: 'short', year: 'numeric' } );
	}

	function svgEl( tag, attrs ) {
		var el = document.createElementNS( 'http://www.w3.org/2000/svg', tag );
		Object.keys( attrs || {} ).forEach( function ( k ) {
			el.setAttribute( k, attrs[ k ] );
		} );
		return el;
	}

	var pointsByKey = {};

	function draw() {
		var slice = rangeSlice( currentRange );
		var from = slice.from;
		var to   = slice.to;
		var n    = to - from;

		var visibleKeys = seriesOrder.filter( function ( k ) { return ! hidden[ k ]; } );

		var min = Infinity;
		var max = -Infinity;
		visibleKeys.forEach( function ( key ) {
			for ( var i = from; i < to; i++ ) {
				var v = cumulative[ key ][ i ];
				if ( v < min ) min = v;
				if ( v > max ) max = v;
			}
		} );
		if ( ! isFinite( min ) ) { min = 0; max = 1; }
		if ( min === max ) { min -= 1; max += 1; }

		var innerW = W - PAD.left - PAD.right;
		var innerH = H - PAD.top - PAD.bottom;

		function x( i ) {
			return PAD.left + ( n > 1 ? ( ( i - from ) / ( n - 1 ) ) * innerW : innerW / 2 );
		}
		function y( v ) {
			return PAD.top + innerH - ( ( v - min ) / ( max - min ) ) * innerH;
		}

		svg.setAttribute( 'viewBox', '0 0 ' + W + ' ' + H );
		svg.innerHTML = '';
		pointsByKey = {};

		seriesOrder.forEach( function ( key ) {
			var pts = [];
			for ( var i = from; i < to; i++ ) {
				pts.push( [ x( i ), y( cumulative[ key ][ i ] ) ] );
			}
			pointsByKey[ key ] = pts;

			if ( hidden[ key ] ) {
				return;
			}
			var d = pts.map( function ( p, idx ) {
				return ( idx ? 'L' : 'M' ) + p[0].toFixed( 2 ) + ',' + p[1].toFixed( 2 );
			} ).join( ' ' );

			svg.appendChild( svgEl( 'path', {
				d: d,
				fill: 'none',
				stroke: data.seriesMeta[ key ].color,
				'stroke-width': 'greywing' === key ? 3 : 2,
				'stroke-linejoin': 'round',
				'stroke-linecap': 'round',
			} ) );
		} );

		// Área invisível pra capturar o mouse em toda a largura do gráfico.
		svg.appendChild( svgEl( 'rect', {
			x: PAD.left, y: PAD.top, width: innerW, height: innerH,
			fill: 'transparent', 'data-gw-hit': '1',
		} ) );

		updateMeta( from, to );
	}

	function updateMeta( from, to ) {
		if ( ! metaEl ) return;
		var startDate = labels[ from ];
		var endDate   = labels[ to - 1 ];
		var startVal  = cumulative.greywing ? cumulative.greywing[ from ] : null;
		var endVal    = cumulative.greywing ? cumulative.greywing[ to - 1 ] : null;
		var n         = to - from;

		var annualised = '—';
		if ( startVal && endVal && n > 1 ) {
			var years = n / 12;
			annualised = ( ( Math.pow( endVal / 1000, 1 / years ) - 1 ) * 100 ).toFixed( 1 ) + '%';
		}

		metaEl.innerHTML =
			'<span><strong>Period:</strong> ' + fmtDate( startDate ) + ' – ' + fmtDate( endDate ) + '</span>' +
			'<span><strong>Greywing ending value:</strong> ' + ( endVal ? fmtUsd( endVal ) : '—' ) + '</span>' +
			'<span><strong>Annualised return:</strong> ' + annualised + '</span>';

		if ( subEl ) {
			if ( 'si' === currentRange ) {
				subEl.textContent = subEl.getAttribute( 'data-original' ) || subEl.textContent;
			} else {
				var rangeLabel = { '1y': 'the last 12 months', '3y': 'the last 3 years', '5y': 'the last 5 years' }[ currentRange ] || 'since inception';
				subEl.textContent = 'Value of USD 1,000 invested over ' + rangeLabel + ', net of fees';
			}
		}
	}

	function buildLegend() {
		if ( ! legendEl ) return;
		legendEl.innerHTML = '';
		seriesOrder.forEach( function ( key ) {
			var meta = data.seriesMeta[ key ];
			var li = document.createElement( 'li' );
			li.className = 'gw-perf__legend-item';
			li.setAttribute( 'data-key', key );
			li.innerHTML = '<span class="gw-perf__dot" style="background:' + meta.color + '"></span>' + meta.label;
			li.addEventListener( 'click', function () {
				hidden[ key ] = ! hidden[ key ];
				li.classList.toggle( 'is-off', !! hidden[ key ] );
				draw();
			} );
			legendEl.appendChild( li );
		} );
	}

	function nearestIndex( from, to, clientX ) {
		var rect = svg.getBoundingClientRect();
		var relX = ( clientX - rect.left ) / rect.width * W;
		var innerW = W - PAD.left - PAD.right;
		var ratio = Math.max( 0, Math.min( 1, ( relX - PAD.left ) / innerW ) );
		var n = to - from;
		return from + Math.round( ratio * ( n - 1 ) );
	}

	svg.addEventListener( 'mousemove', function ( e ) {
		if ( ! tooltipEl ) return;
		var slice = rangeSlice( currentRange );
		var idx = nearestIndex( slice.from, slice.to, e.clientX );
		if ( idx < 0 || idx >= months ) return;

		var lines = seriesOrder
			.filter( function ( k ) { return ! hidden[ k ]; } )
			.map( function ( k ) {
				return data.seriesMeta[ k ].label + ': ' + fmtUsd( cumulative[ k ][ idx ] );
			} );

		tooltipEl.innerHTML = '<strong>' + fmtDate( labels[ idx ] ) + '</strong><br>' + lines.join( '<br>' );
		tooltipEl.hidden = false;
		tooltipEl.style.left = e.clientX - svg.getBoundingClientRect().left + 'px';
		tooltipEl.style.top  = e.clientY - svg.getBoundingClientRect().top + 'px';
	} );
	svg.addEventListener( 'mouseleave', function () {
		if ( tooltipEl ) tooltipEl.hidden = true;
	} );

	rangeBtns.forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			currentRange = btn.getAttribute( 'data-range' );
			rangeBtns.forEach( function ( b ) { b.classList.toggle( 'is-active', b === btn ); } );
			draw();
		} );
	} );

	if ( subEl ) {
		subEl.setAttribute( 'data-original', subEl.textContent );
	}

	buildLegend();
	draw();
} )();
