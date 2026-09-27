<?php
/**
 * Template Name: Greywing — Contact
 *
 * Página simples (sem pilha de seções) — só um título, o nome da empresa e
 * 3 colunas de texto (contato, endereço, endereço postal). Ver
 * template-parts/content/contact-content.php e inc/acf-fields/contact-fields.php.
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
<body <?php body_class( 'gw-page gw-page--contact' ); ?>>
<?php wp_body_open(); ?>

<?php get_template_part( 'template-parts/layout/disclaimer-gate' ); ?>

<?php get_template_part( 'template-parts/layout/site-header' ); ?>

<main class="gw-plain gw-t-dusk">
	<?php get_template_part( 'template-parts/content/contact-content' ); ?>
</main>

<?php get_template_part( 'template-parts/layout/site-footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>
