<?php
/**
 * Template Name: Greywing — About
 *
 * 5 seções únicas empilhadas (efeito de "passar por cima" — ver .gw-stack
 * em assets/css/base.css e assets/js/stack.js). Cada seção é um layout do
 * Flexible Content "sections" (inc/acf-fields/about-sections.php),
 * renderizado por template-parts/content/about/section-*.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Layout (nome do campo) => arquivo em template-parts/content/about/.
$greywing_about_layouts = array(
	'section_1' => 'hero',
	'section_2' => 'about-us',
	'section_3' => 'philosophy',
	'section_4' => 'why',
	'section_5' => 'team',
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'gw-page gw-page--about' ); ?>>
<?php wp_body_open(); ?>

<?php get_template_part( 'template-parts/layout/disclaimer-gate' ); ?>

<?php get_template_part( 'template-parts/layout/site-header' ); ?>

<main class="gw-stack">
	<?php
	if ( have_rows( 'sections' ) ) :
		while ( have_rows( 'sections' ) ) :
			the_row();
			$greywing_layout = get_row_layout();
			if ( isset( $greywing_about_layouts[ $greywing_layout ] ) ) {
				get_template_part( 'template-parts/content/about/section-' . $greywing_about_layouts[ $greywing_layout ] );
			}
		endwhile;
	endif;
	?>
</main>

<?php get_template_part( 'template-parts/layout/site-footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>
