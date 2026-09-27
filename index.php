<?php
/**
 * Template fallback padrão do WordPress.
 *
 * A página principal do site usa page-templates/template-about.php. Este
 * arquivo só existe porque o WordPress exige um index.php no tema — não é
 * usado em nenhuma página real (todas têm um Template Name próprio). O tema
 * não tem header.php/footer.php: cada page-template monta o documento HTML
 * direto, incluindo template-parts/layout/site-header e site-footer.
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
