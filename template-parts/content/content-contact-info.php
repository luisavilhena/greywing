<?php
/**
 * Componente: Informações de contato — título + blocos (rótulo + texto) +
 * link. Layout ACF: contact_info.
 *
 * Mesma grade de 2 colunas do resto do site, mas tudo fica só na primeira
 * coluna (ver CSS) — a segunda fica vazia de propósito.
 *
 * Se o campo "Formulário" tiver um shortcode, o link não navega: ele abre
 * o painel deslizante genérico (.gw-drawer, ver assets/css/components/drawer.css
 * e assets/js/drawer.js) com esse formulário dentro. Usa a variação
 * "--fade" (mesma do popup de Login): aparece só com fade, ocupando a
 * segunda coluna da página (35vw, largura padrão do painel) — sem escurecer
 * o resto da tela.
 *
 * CSS: assets/css/components/content-contact-info.css (só o específico —
 * o painel em si é o componente genérico "drawer").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$anchor         = get_sub_field( 'anchor' );
$title          = get_sub_field( 'title' );
$title_spacing  = get_sub_field( 'title_spacing' ) ?: 'md';
$blocks         = get_sub_field( 'blocks' );
$link           = get_sub_field( 'link' );
$form_intro     = get_sub_field( 'form_intro' );
$form_shortcode = get_sub_field( 'form_shortcode' );

// Linha vazia (nenhum campo preenchido) = nenhum HTML renderizado.
if ( ! $title && ! $blocks && ! $link ) {
	return;
}

$drawer_id = 'gw-contact-form-drawer';
?>
<section class="gw-row gw-contact-info"<?php echo greywing_anchor_attr( $anchor ); ?>>

	<div class="gw-contact-info__col">

		<?php if ( $title ) : ?>
			<h2 class="gw-contact-info__title gw-mb-<?php echo esc_attr( $title_spacing ); ?>"><?php echo nl2br( esc_html( $title ) ); ?></h2>
		<?php endif; ?>

		<?php if ( $blocks ) : ?>
			<div class="gw-contact-info__blocks">
				<?php foreach ( $blocks as $block ) : ?>
					<?php if ( ! empty( $block['label'] ) || ! empty( $block['text'] ) ) : ?>
						<div class="gw-contact-info__block">
							<?php if ( ! empty( $block['label'] ) ) : ?>
								<p class="gw-contact-info__label"><?php echo esc_html( $block['label'] ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $block['text'] ) ) : ?>
								<div class="gw-contact-info__text"><?php echo wp_kses_post( $block['text'] ); ?></div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $link['url'] ) ) : ?>
			<a
				class="gw-contact-info__link"
				href="<?php echo $form_shortcode ? '#' . esc_attr( $drawer_id ) : esc_url( $link['url'] ); ?>"
				<?php echo $form_shortcode ? ' data-gw-form-trigger="' . esc_attr( $drawer_id ) . '"' : ''; ?>
				<?php echo ( ! $form_shortcode && ! empty( $link['target'] ) ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener"' : ''; ?>
			>
				<?php echo esc_html( $link['title'] ); ?>
			</a>
		<?php endif; ?>

	</div>

</section>

<?php if ( $form_shortcode ) : ?>
	<div class="gw-drawer gw-drawer--fade" id="<?php echo esc_attr( $drawer_id ); ?>">
		<div class="gw-drawer__panel">
			<button class="gw-drawer__close" type="button" aria-label="Fechar formulário">
				<span aria-hidden="true">✕</span>
			</button>
			<?php if ( $form_intro ) : ?>
				<div class="gw-drawer__intro"><?php echo wp_kses_post( $form_intro ); ?></div>
			<?php endif; ?>
			<div class="gw-drawer__body">
				<?php echo do_shortcode( $form_shortcode ); ?>
			</div>
		</div>
	</div>
<?php endif; ?>
