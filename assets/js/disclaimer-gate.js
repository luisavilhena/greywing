/**
 * Aviso de elegibilidade (modal compacto) — ver
 * template-parts/layout/disclaimer-gate.php.
 *
 * "I Confirm and Enter" registra a decisão (AJAX) e fecha o modal.
 * "I Do Not Meet These Criteria" registra a decisão e troca pra view
 * "declined" (sem fechar o modal — a pessoa não pode entrar no site).
 * "Return to the criteria" só troca de volta pra view "info", sem registrar
 * decisão nova.
 *
 * O registro (banco + cookie de 15 dias) acontece no servidor — ver
 * inc/disclaimer-consent.php. `greywingDisclaimer` (ajaxUrl/nonce) vem de
 * wp_localize_script em inc/enqueue.php.
 *
 * O aviso agora está sempre no HTML (cache de página — ver
 * disclaimer-gate.php), mas pode já ter sido escondido por um script inline
 * que roda antes deste (lê o cookie na hora, sem esperar o JS do rodapé). Se
 * isso já aconteceu (gate.hidden), não tem nada a fazer aqui — a pessoa já
 * tinha decidido antes.
 *
 * Ao fechar, dispara "gw:gate-closed" no document — header.js e reveal.js
 * esperam esse evento antes de começar as animações de entrada (pra elas não
 * rodarem escondidas atrás do modal).
 *
 * Vanilla JS, sem dependência nenhuma — carregado em inc/enqueue.php.
 */
( function () {
	'use strict';

	var gate = document.getElementById( 'gw-disclaimer-gate' );

	if ( ! gate || gate.hidden ) {
		return;
	}

	document.body.classList.add( 'gw-locked' );

	var panel          = gate.querySelector( '.gw-gate__panel' );
	var acceptButton   = gate.querySelector( '[data-gw-disclaimer-accept]' );
	var rejectButton   = gate.querySelector( '[data-gw-disclaimer-reject]' );
	var backButton     = gate.querySelector( '[data-gw-disclaimer-back]' );

	/**
	 * Manda a decisão pro servidor gravar no banco (e, se aceite, setar o
	 * cookie de 15 dias). Não trava a interface esperando resposta: em caso
	 * de falha de rede a pessoa não fica presa no modal — só perde o
	 * registro dessa vez, o que é preferível a bloquear o acesso ao site.
	 */
	function sendDecision( decision ) {
		if ( typeof window.fetch !== 'function' || ! window.greywingDisclaimer ) {
			return;
		}

		var body = new window.URLSearchParams();
		body.set( 'action', 'greywing_disclaimer_consent' );
		body.set( 'nonce', window.greywingDisclaimer.nonce );
		body.set( 'decision', decision );
		body.set( 'page_url', window.location.href );

		window.fetch( window.greywingDisclaimer.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: body.toString(),
		} ).catch( function () {
			// Falha de rede: segue o fluxo normalmente, só não fica um registro salvo.
		} );
	}

	function switchView( name ) {
		gate.querySelectorAll( '[data-view]' ).forEach( function ( view ) {
			view.classList.toggle( 'on', view.getAttribute( 'data-view' ) === name );
		} );
		if ( panel ) {
			panel.scrollTop = 0;
			panel.focus();
		}
	}

	function closeGate() {
		gate.classList.add( 'gw-closing' );

		var done = false;
		function finish() {
			if ( done ) {
				return;
			}
			done = true;
			gate.hidden = true;
			document.body.classList.remove( 'gw-locked' );
			document.dispatchEvent( new CustomEvent( 'gw:gate-closed' ) );
		}

		gate.addEventListener( 'transitionend', finish, { once: true } );
		// Não confia só no transitionend (pode não disparar em todo navegador
		// se a transição já tiver acabado, ex.: prefers-reduced-motion).
		window.setTimeout( finish, 700 );
	}

	if ( acceptButton ) {
		acceptButton.addEventListener( 'click', function () {
			sendDecision( 'accepted' );
			closeGate();
		} );
	}

	if ( rejectButton ) {
		rejectButton.addEventListener( 'click', function () {
			sendDecision( 'rejected' );
			switchView( 'declined' );
		} );
	}

	if ( backButton ) {
		backButton.addEventListener( 'click', function () {
			switchView( 'info' );
		} );
	}
} )();
