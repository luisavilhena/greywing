<?php
/**
 * Aviso de elegibilidade — modal compacto centralizado (layout novo).
 *
 * Duas views dentro do mesmo modal, alternadas por JS (sem recarregar
 * página): "info" (padrão) e "declined" (depois de clicar em "I Do Not Meet
 * These Criteria"). Não existe uma terceira view "terms" clonando o texto de
 * Termos de Uso como no mockup original — lá fazia sentido porque tudo era
 * uma página só (SPA); aqui os Termos já são uma página de verdade
 * (/terms/), então o link "Terms of Use" dentro do texto do aviso
 * (disclaimer_text, editável) navega direto pra ela — a própria página de
 * Termos é isenta do gate (ver greywing_disclaimer_is_exempt_page()), então
 * dá pra ler e voltar sem travar em lugar nenhum.
 *
 * Continua usando o mesmo backend de sempre (cookie de 15 dias + tabela no
 * banco) — só o HTML/CSS mudou. Ver inc/disclaimer-consent.php (registro) e
 * assets/js/disclaimer-gate.js (comportamento do modal).
 *
 * Conteúdo: Opções do Tema → Aviso de elegibilidade
 * (inc/acf-fields/options-disclaimer.php).
 *
 * IMPORTANTE sobre cache de página (WP Rocket/W3TC/LiteSpeed/etc.): em
 * produção o HTML desta página pode ser servido do cache, sem o PHP rodar de
 * novo — então NÃO dá pra decidir aqui, no servidor, se o aviso aparece ou
 * não com base no cookie de quem está vendo a página (isso faria todo mundo
 * ver a versão em cache gerada pela primeira visita, aceite ou não). Por
 * isso o aviso é SEMPRE renderizado no HTML (igual pra qualquer visitante,
 * cacheável), e quem decide se ele fica visível é o script inline logo
 * abaixo, rodando no navegador de cada pessoa a partir do cookie real dela.
 * Só a isenção por página (is_exempt_page) continua decidida no servidor,
 * porque não depende de quem está vendo — é a mesma pra todo mundo.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( greywing_disclaimer_is_exempt_page() ) {
	return;
}

$title          = get_field( 'disclaimer_title', 'option' );
$text           = get_field( 'disclaimer_text', 'option' );
$accept_label   = get_field( 'disclaimer_accept_label', 'option' );
$reject_label   = get_field( 'disclaimer_reject_label', 'option' );
$reject_message = get_field( 'disclaimer_reject_message', 'option' );

if ( ! $title && ! $text ) {
	return;
}
?>
<div class="gw-gate" id="gw-disclaimer-gate">
	<div class="gw-gate__panel" role="dialog" aria-modal="true" aria-labelledby="gw-gate-title" tabindex="-1">

		<span class="gw-logo" aria-hidden="true"><?php greywing_logo_svg(); ?></span>

		<div data-view="info" class="on gw-block">

			<?php if ( $title ) : ?>
				<h2 id="gw-gate-title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( $text ) : ?>
				<?php echo wp_kses_post( $text ); ?>
			<?php endif; ?>

			<?php if ( $accept_label || $reject_label ) : ?>
				<div class="gw-gate__actions">
					<?php if ( $accept_label ) : ?>
						<button class="gw-btn gw-btn--solid" type="button" data-gw-disclaimer-accept>
							<?php echo esc_html( $accept_label ); ?>
						</button>
					<?php endif; ?>
					<?php if ( $reject_label ) : ?>
						<button class="gw-btn gw-btn--ghost" type="button" data-gw-disclaimer-reject>
							<?php echo esc_html( $reject_label ); ?>
						</button>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</div>

		<div data-view="declined" class="gw-block gw-declined">
			<h2>Access Restricted</h2>
			<?php if ( $reject_message ) : ?>
				<?php echo wp_kses_post( $reject_message ); ?>
			<?php endif; ?>
			<div class="gw-gate__actions">
				<button class="gw-btn gw-btn--ghost" type="button" data-gw-disclaimer-back>
					Return to the criteria
				</button>
			</div>
		</div>

	</div>
</div>
<script>
/* Resolve a visibilidade do aviso no navegador de cada visitante, a partir
   do cookie real dela — roda inline (não espera o JS do rodapé) pra não
   piscar o aviso na tela antes de esconder, em quem já decidiu antes.
   Mesma lógica de leitura do cookie que greywing_disclaimer_has_valid_consent()
   em PHP (inc/disclaimer-consent.php), só que lida no cliente porque, com
   cache de página, o servidor pode não rodar pra essa visita. */
( function () {
	'use strict';
	var gate = document.getElementById( 'gw-disclaimer-gate' );
	if ( ! gate ) return;

	var match = document.cookie.match( /(?:^|; )gw_disclaimer_consent=([^;]*)/ );
	var cookieVersion = match ? decodeURIComponent( match[1] ).split( ':' )[0] : '';

	if ( cookieVersion && cookieVersion === <?php echo wp_json_encode( greywing_disclaimer_current_version() ); ?> ) {
		gate.hidden = true;
	}
} )();
</script>
