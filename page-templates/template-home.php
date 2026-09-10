<?php
/**
 * Template Name: Greywing — Página padrão (menu + conteúdo + footer)
 *
 * Estrutura da página: grid de 3 colunas.
 *  - .gw-menu    → 30% da tela, à esquerda, fixa na altura da página.
 *                  Ver template-parts/layout/site-menu.php.
 *  - .gw-content → 70% da tela, à direita. É aqui que entram as linhas de
 *                  conteúdo, cada uma um componente ACF (Flexible Content),
 *                  e por último o footer (esse vem de Opções do Tema, não
 *                  do Flexible Content — é o mesmo em todas as páginas).
 *
 * Nenhum texto é escrito aqui — tudo vem dos campos ACF de cada componente,
 * carregados em template-parts/layout/content-loop.php e, para o footer,
 * em template-parts/content/content-footer.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'gw-page' ); ?>>
<?php wp_body_open(); ?>

<?php get_template_part( 'template-parts/layout/disclaimer-gate' ); ?>

<?php get_template_part( 'template-parts/layout/mobile-header' ); ?>

<div class="gw-grid">

	<aside class="gw-menu" id="gw-menu" aria-label="Menu">
		<?php get_template_part( 'template-parts/layout/site-menu' ); ?>
	</aside>

	<main class="gw-content">
		<?php get_template_part( 'template-parts/layout/content-loop' ); ?>
		<?php get_template_part( 'template-parts/content/content-footer' ); ?>
	</main>

</div>

<?php get_template_part( 'template-parts/layout/login-popup' ); ?>

<?php wp_footer(); ?>
</body>
</html>
