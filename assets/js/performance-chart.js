/**
 * Gráfico de performance — página Funds, Seção "Performance Graph".
 * Adaptado do mockup original (mesma lógica de desenho, tooltip e animação
 * de entrada) — só tira as partes específicas da SPA de página única
 * (roteador de hash, `.page.on`, `setupCards` chamado daqui) já que aqui
 * cada página é uma URL de verdade.
 *
 * Dados brutos (retorno mensal da Greywing + valor mensal dos benchmarks):
 * assets/js/performance-data.js, carregado antes deste arquivo — ver
 * inc/enqueue.php.
 *
 * Vanilla JS, sem dependência — carregado só na página de Funds.
 */
( function () {
	'use strict';

	var raw = window.greywingPerformanceRaw;
	var box = document.getElementById( 'gw-perf-chart-box' );
	var svg = document.getElementById( 'gw-perf-chart' );
	var tip = document.getElementById( 'gw-perf-tip' );

	if ( ! raw || ! box || ! svg ) {
		return;
	}

	var R = raw.R;
	var MON = raw.MON;
	var BENCH = raw.BENCH;
	var NS = 'http://www.w3.org/2000/svg';

	var SERIES = [
		{ k: 'sofr', name: 'SOFR 1m +5%', c: '#0E3258', w: 2 },
		{ k: 'bbg', name: 'Bloomberg Agricultural Index', c: '#5F90BD', w: 2 },
		{ k: 'msci', name: 'MSCI World Index TR', c: '#BEB09D', w: 2 },
		{ k: 'gw', name: 'Greywing Spectrum Fund Ltd', c: '#C17400', w: 2.6 },
	];

	// -------- monta os pontos (retorno acumulado + benchmarks alinhados) -------
	var pts = [ { y: 2018, m: 6, r: 0 } ];
	Object.keys( R ).forEach( function ( y ) {
		var start = ( +y === 2018 ) ? 7 : 0;
		R[ y ].forEach( function ( r, i ) {
			pts.push( { y: +y, m: start + i, r: r } );
		} );
	} );
	( function () {
		var v = 1000;
		pts.forEach( function ( p, i ) {
			if ( i ) {
				v *= 1 + p.r / 100;
			}
			p.gw = v;
			p.msci = BENCH.msci[ i ];
			p.bbg = BENCH.bbg[ i ];
			p.sofr = BENCH.sofr[ i ];
		} );
	} )();

	var range = 'all';

	function el( n, a, p ) {
		var e = document.createElementNS( NS, n );
		for ( var k in a ) {
			e.setAttribute( k, a[ k ] );
		}
		( p || svg ).appendChild( e );
		return e;
	}
	function lbl( p ) {
		return MON[ p.m ] + ' ' + p.y;
	}
	function usd( v ) {
		return '$' + Math.round( v ).toLocaleString( 'en-US' );
	}

	function drawChart() {
		var W = box.clientWidth;
		if ( ! W ) {
			return;
		}
		var small = W < 640;
		var H = small ? 330 : Math.min( 470, Math.max( 360, W * 0.34 ) );
		var mL = small ? 58 : 78;
		var mR = small ? 14 : 24;
		var mT = 16;
		var mB = 44;

		var sub = 'all' === range ? pts : pts.slice( pts.length - 1 - ( +range ) );
		var base = sub[ 0 ];
		var data = sub.map( function ( p ) {
			var d = { p: p };
			SERIES.forEach( function ( s ) {
				d[ s.k ] = p[ s.k ] * 1000 / base[ s.k ];
			} );
			return d;
		} );

		var all = [];
		data.forEach( function ( d ) {
			SERIES.forEach( function ( s ) {
				all.push( d[ s.k ] );
			} );
		} );
		var min = Math.min.apply( null, all );
		var max = Math.max.apply( null, all );
		var span = max - min;
		var step = [ 50, 100, 250, 500, 1000 ].find( function ( s ) {
			return span / s <= 9;
		} ) || 1000;
		var lo = Math.floor( min / step ) * step;
		var hi = Math.ceil( max / step ) * step;
		if ( 'all' === range ) {
			lo = Math.min( lo, 500 );
			hi = Math.max( hi, 5000 );
			step = 500;
		}

		var x = function ( i ) {
			return mL + ( W - mL - mR ) * i / ( data.length - 1 );
		};
		var y = function ( val ) {
			return mT + ( H - mT - mB ) * ( 1 - ( val - lo ) / ( hi - lo ) );
		};

		svg.setAttribute( 'viewBox', '0 0 ' + W + ' ' + H );
		svg.setAttribute( 'width', W );
		svg.setAttribute( 'height', H );
		svg.innerHTML = '';

		var fs = small ? 12 : 14;
		var ff = 'Roboto, Arial, sans-serif';

		for ( var t = lo; t <= hi + 1; t += step ) {
			if ( t > lo ) {
				el( 'line', { x1: mL, x2: W - mR, y1: y( t ), y2: y( t ), stroke: '#121D2B', 'stroke-opacity': 0.08, 'stroke-width': 1 } );
			}
			el( 'line', { x1: mL - 6, x2: mL, y1: y( t ), y2: y( t ), stroke: '#121D2B', 'stroke-width': 1 } );
			var tx = el( 'text', { x: mL - 12, y: y( t ) + 5, 'text-anchor': 'end', 'font-size': fs, fill: '#121D2B', 'font-family': ff } );
			tx.textContent = usd( t );
		}
		el( 'line', { x1: mL, x2: mL, y1: mT, y2: H - mB, stroke: '#121D2B', 'stroke-width': 1.2 } );
		el( 'line', { x1: mL, x2: W - mR, y1: H - mB, y2: H - mB, stroke: '#121D2B', 'stroke-width': 1.2 } );

		var every = '12' === range ? 3 : ( '36' === range ? 6 : 12 );
		var lastX = -999;
		data.forEach( function ( d, i ) {
			var ok = ( '12' === range || '36' === range ) ? ( ( data.length - 1 - i ) % every === 0 ) : ( 6 === d.p.m );
			if ( ! ok ) {
				return;
			}
			var px = x( i );
			if ( px - lastX < ( small ? 44 : 60 ) ) {
				return;
			}
			lastX = px;
			el( 'line', { x1: px, x2: px, y1: H - mB, y2: H - mB + 6, stroke: '#121D2B', 'stroke-width': 1 } );
			var tx2 = el( 'text', { x: px, y: H - mB + 26, 'text-anchor': 'middle', 'font-size': fs, fill: '#121D2B', 'font-family': ff } );
			tx2.textContent = MON[ d.p.m ] + ' ' + String( d.p.y ).slice( 2 );
		} );

		var paths = [];
		SERIES.forEach( function ( s ) {
			var line = data.map( function ( d, i ) {
				return ( i ? 'L' : 'M' ) + x( i ).toFixed( 1 ) + ' ' + y( d[ s.k ] ).toFixed( 1 );
			} ).join( '' );
			paths.push( el( 'path', { d: line, fill: 'none', stroke: s.c, 'stroke-width': small ? s.w * 0.85 : s.w, 'stroke-linejoin': 'round', 'stroke-linecap': 'round' } ) );
		} );

		var guide = el( 'line', { y1: mT, y2: H - mB, stroke: '#121D2B', 'stroke-width': 1, 'stroke-dasharray': '3 4', opacity: 0 } );
		var dots = SERIES.map( function ( s ) {
			return el( 'circle', { r: 4.5, fill: '#fff', stroke: s.c, 'stroke-width': 2.2, opacity: 0 } );
		} );
		var hit = el( 'rect', { x: mL, y: mT, width: W - mL - mR, height: H - mT - mB, fill: 'transparent' } );

		function move( ev ) {
			var r = svg.getBoundingClientRect();
			var sc = r.width / W;
			var px = ( ev.clientX - r.left ) / sc;
			var i = Math.round( ( px - mL ) / ( W - mL - mR ) * ( data.length - 1 ) );
			i = Math.max( 0, Math.min( data.length - 1, i ) );
			var d = data[ i ];
			guide.setAttribute( 'x1', x( i ) );
			guide.setAttribute( 'x2', x( i ) );
			guide.setAttribute( 'opacity', 0.5 );
			SERIES.forEach( function ( s, j ) {
				dots[ j ].setAttribute( 'cx', x( i ) );
				dots[ j ].setAttribute( 'cy', y( d[ s.k ] ) );
				dots[ j ].setAttribute( 'opacity', 1 );
			} );
			if ( tip ) {
				tip.innerHTML = '<div class="gw-perf__tip-date">' + lbl( d.p ) + '</div>' + SERIES.slice().reverse().map( function ( s ) {
					return '<div class="gw-perf__tip-row"><span><i style="background:' + s.c + '"></i>' + s.name + '</span><b>' + usd( d[ s.k ] ) + '</b></div>';
				} ).join( '' );
				tip.style.left = Math.max( 170, Math.min( W - 170, x( i ) ) ) + 'px';
				tip.style.top = Math.min( y( d.gw ), y( d.msci ) ) + 'px';
				tip.style.opacity = 1;
			}
		}
		function leave() {
			guide.setAttribute( 'opacity', 0 );
			dots.forEach( function ( c ) {
				c.setAttribute( 'opacity', 0 );
			} );
			if ( tip ) {
				tip.style.opacity = 0;
			}
		}
		hit.addEventListener( 'pointermove', move );
		hit.addEventListener( 'pointerdown', move );
		hit.addEventListener( 'pointerleave', leave );

		var last = data[ data.length - 1 ];
		var n = data.length - 1;
		var ann = Math.pow( last.gw / 1000, 12 / n ) - 1;

		var elPeriod = document.getElementById( 'gw-perf-period' );
		var elEnd = document.getElementById( 'gw-perf-end' );
		var elAnn = document.getElementById( 'gw-perf-ann' );
		var elSub = document.getElementById( 'gw-perf-sub' );
		if ( elPeriod ) {
			elPeriod.textContent = lbl( data[ 0 ].p ) + ' – ' + lbl( last.p );
		}
		if ( elEnd ) {
			elEnd.textContent = usd( last.gw );
		}
		if ( elAnn ) {
			elAnn.textContent = ( ann * 100 ).toFixed( 1 ) + '%';
		}
		if ( elSub ) {
			elSub.textContent = 'Value of USD 1,000 invested ' + ( 'all' === range ? 'since inception' : 'from ' + lbl( data[ 0 ].p ) ) + ', net of fees';
		}

		if ( ! window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
			paths.forEach( function ( path ) {
				if ( ! path.getTotalLength ) {
					return;
				}
				var L = path.getTotalLength();
				path.style.strokeDasharray = L;
				path.style.strokeDashoffset = L;
				path.getBoundingClientRect();
				path.style.transition = 'stroke-dashoffset 1.4s cubic-bezier(.4,0,.2,1)';
				path.style.strokeDashoffset = 0;
			} );
		}
	}

	document.querySelectorAll( '[data-range]' ).forEach( function ( b ) {
		b.addEventListener( 'click', function () {
			range = b.dataset.range;
			document.querySelectorAll( '[data-range]' ).forEach( function ( o ) {
				o.classList.toggle( 'is-active', o === b );
				o.setAttribute( 'aria-pressed', o === b ? 'true' : 'false' );
			} );
			drawChart();
		} );
	} );

	window.addEventListener( 'load', drawChart );
	var rt;
	window.addEventListener( 'resize', function () {
		clearTimeout( rt );
		rt = setTimeout( drawChart, 150 );
	} );
} )();
