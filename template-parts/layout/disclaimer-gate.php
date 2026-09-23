<?php
/**
 * Aviso de elegibilidade — popup de tela cheia que aparece toda vez que o
 * site carrega. Coluna esquerda fixa (só o logo), coluna direita com
 * título + texto (rola se for mais alto que a tela) + 2 botões.
 *
 * "I Confirm and Enter" fecha o popup (mostra a página por trás).
 * "I Do Not Meet These Criteria" revela uma mensagem abaixo dos botões,
 * sem fechar o popup.
 *
 * Conteúdo vem de Opções do Tema → Aviso de elegibilidade — ver
 * inc/acf-fields/options-disclaimer.php. Comportamento: assets/js/disclaimer-gate.js.
 *
 * Incluído nos dois templates de página, antes de tudo — cobre a tela
 * inteira, inclusive por cima do menu.
 *
 * Quem já aceitou ou recusou nos últimos 15 dias (pra versão atual do
 * aviso) tem um cookie válido — ver inc/disclaimer-consent.php — e nem
 * chega a receber esse HTML na página.
 *
 * Exceção: as páginas que os links dentro do próprio texto do aviso
 * apontam (Termos de Uso, Aviso de Privacidade) também não recebem esse
 * HTML, mesmo sem cookie — a pessoa precisa poder ler essas páginas pra
 * decidir se aceita os critérios. Ver greywing_disclaimer_is_exempt_page()
 * em inc/disclaimer-consent.php.
 *
 * CSS: assets/css/components/disclaimer-gate.css
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( greywing_disclaimer_has_valid_consent() ) {
	return;
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
<div class="gw-disclaimer" id="gw-disclaimer-gate">
	<div class="gw-disclaimer__grid">

		<div class="gw-disclaimer__logo-col">
			<img class="gw-disclaimer__logo" src="<?php echo esc_url( GREYWING_THEME_URI . '/assets/img/logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="200" height="47">
		</div>

		<div class="gw-disclaimer__content-col">

			<?php if ( $title ) : ?>
				<h2 class="gw-disclaimer__title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( $text ) : ?>
				<div class="gw-disclaimer__text"><?php echo wp_kses_post( $text ); ?></div>
			<?php endif; ?>

			<?php if ( $accept_label || $reject_label ) : ?>
				<div class="gw-disclaimer__actions-row">
					<div class="gw-disclaimer__actions">
						<?php if ( $accept_label ) : ?>
							<button class="gw-disclaimer__button" type="button" data-gw-disclaimer-accept>
								<?php echo esc_html( $accept_label ); ?>
							</button>
						<?php endif; ?>
						<?php if ( $reject_label ) : ?>
							<button class="gw-disclaimer__button" type="button" data-gw-disclaimer-reject>
								<?php echo esc_html( $reject_label ); ?>
							</button>
						<?php endif; ?>
					</div>

					<?php if ( $reject_message ) : ?>
						<div class="gw-disclaimer__reject-message" hidden>
							<?php echo wp_kses_post( $reject_message ); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</div>

	</div>
</div>
