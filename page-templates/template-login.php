<?php
/**
 * Template Name: Greywing — Login
 *
 * Página simples (sem pilha de seções) — substitui o antigo popup de Login.
 * Não é um formulário: é um cartão que leva pro portal externo do fundo
 * (Dynamo). Ver template-parts/content/login-content.php e
 * inc/acf-fields/login-fields.php.
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
<body <?php body_class( 'gw-page gw-page--login' ); ?>>
<?php wp_body_open(); ?>

<?php get_template_part( 'template-parts/layout/disclaimer-gate' ); ?>

<?php get_template_part( 'template-parts/layout/site-header' ); ?>

<main class="gw-plain gw-t-dusk">
	<?php get_template_part( 'template-parts/content/login-content' ); ?>
</main>

<?php get_template_part( 'template-parts/layout/site-footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>
