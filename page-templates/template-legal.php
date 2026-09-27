<?php
/**
 * Template Name: Greywing — Página de texto (editor padrão do WordPress)
 *
 * Mesma casca das outras páginas do tema (header + footer) — mas o miolo NÃO
 * usa ACF: o conteúdo é editado normalmente pelo editor de blocos do
 * WordPress (título da página + the_content()). Pensado pra texto corrido
 * longo, tipo "Important Disclosures & Terms of Use", onde não faz sentido
 * modelar cada parágrafo como campo.
 *
 * CSS: assets/css/legal.css
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
<body <?php body_class( 'gw-page gw-page--legal' ); ?>>
<?php wp_body_open(); ?>

<?php get_template_part( 'template-parts/layout/disclaimer-gate' ); ?>

<?php get_template_part( 'template-parts/layout/site-header' ); ?>

<main class="gw-plain gw-t-beige">
	<div class="gw-wrap gw-legal gw-block">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<h1 class="gw-h-page gw-bar gw-split"><?php the_title(); ?></h1>
				<div class="gw-legal__body">
					<?php the_content(); ?>
				</div>
				<?php
			endwhile;
		endif;
		?>
	</div>
</main>

<?php get_template_part( 'template-parts/layout/site-footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>
