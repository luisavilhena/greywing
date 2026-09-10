<?php
/**
 * Template fallback padrão do WordPress.
 *
 * A página principal do site usa page-templates/template-home.php.
 * Este arquivo só existe porque o WordPress exige um index.php no tema.
 * O tema ainda não tem header.php/footer.php (menu e footer ficam para
 * depois), então o documento HTML é montado direto aqui.
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
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<main>
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_title( '<h1>', '</h1>' );
			the_content();
		endwhile;
	endif;
	?>
</main>

<?php wp_footer(); ?>
</body>
</html>
