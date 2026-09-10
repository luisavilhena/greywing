/**
 * Aviso de elegibilidade (popup de tela cheia) — ver
 * template-parts/layout/disclaimer-gate.php.
 *
 * "I Confirm and Enter" registra a decisão (AJAX) e fecha o popup.
 * "I Do Not Meet These Criteria" registra a decisão e revela a mensagem
 * abaixo dos botões, sem fechar.
 *
 * O registro (banco + cookie de 15 dias) acontece no servidor — ver
 * inc/disclaimer-consent.php. `greywingDisclaimer` (ajaxUrl/nonce) vem de
 * wp_localize_script em inc/enqueue.php.
 *
 * Vanilla JS, sem dependência nenhuma — carregado em inc/enqueue.php.
 */
( function () {
	'use strict';

	var gate = document.getElementById( 'gw-disclaimer-gate' );

	if ( ! gate ) {
		return;
	}

	var acceptButton  = gate.querySelector( '[data-gw-disclaimer-accept]' );
	var rejectButton  = gate.querySelector( '[data-gw-disclaimer-reject]' );
	var rejectMessage = gate.querySelector( '.gw-disclaimer__reject-message' );

	/**
	 * Manda a decisão pro servidor gravar no banco (e, se aceite, setar o
	 * cookie de 15 dias). Não trava a interface esperando resposta: em caso
	 * de falha de rede a pessoa não fica presa no popup — só perde o
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

	if ( acceptButton ) {
		acceptButton.addEventListener( 'click', function () {
			sendDecision( 'accepted' );
			gate.classList.add( 'is-closed' );
		} );
	}

	if ( rejectButton && rejectMessage ) {
		rejectButton.addEventListener( 'click', function () {
			sendDecision( 'rejected' );
			rejectMessage.hidden = false;
		} );
	}
} )();
