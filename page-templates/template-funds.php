<?php
/**
 * Template Name: Greywing — Funds
 *
 * 5 seções únicas empilhadas, igual ao template-about.php — ver esse arquivo
 * pra mais contexto sobre o mecanismo de empilhamento. Seções vêm do
 * Flexible Content "sections" (inc/acf-fields/funds-sections.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$greywing_funds_layouts = array(
	'section_1' => 'hero',
	'section_2' => 'track-record',
	'section_3' => 'performance',
	'section_4' => 'fund-information',
	'section_5' => 'interested',
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'gw-page gw-page--funds' ); ?>>
<?php wp_body_open(); ?>

<?php get_template_part( 'template-parts/layout/disclaimer-gate' ); ?>

<?php get_template_part( 'template-parts/layout/site-header' ); ?>

<main class="gw-stack">
	<?php
	if ( have_rows( 'sections' ) ) :
		while ( have_rows( 'sections' ) ) :
			the_row();
			$greywing_layout = get_row_layout();
			if ( isset( $greywing_funds_layouts[ $greywing_layout ] ) ) {
				get_template_part( 'template-parts/content/funds/section-' . $greywing_funds_layouts[ $greywing_layout ] );
			}
		endwhile;
	endif;
	?>
</main>

<?php get_template_part( 'template-parts/layout/site-footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>
