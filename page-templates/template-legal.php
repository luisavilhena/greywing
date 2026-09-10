<?php
/**
 * Template Name: Greywing — Página de texto (editor padrão do WordPress)
 *
 * Mesma casca das outras páginas do tema — grid de 3 colunas, menu
 * reservado + footer global vindo de Opções do Tema — mas o miolo NÃO usa
 * ACF: o conteúdo é editado normalmente pelo editor de blocos do WordPress
 * (título da página + the_content()). Pensado pra páginas de texto corrido
 * longo, tipo "Important Disclosures & Terms of Use", onde não faz sentido
 * modelar cada parágrafo como campo — é mais rápido editar direto no bloco.
 *
 * CSS: assets/css/components/native-content.css
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

		<article class="gw-row gw-native-content">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<div class="gw-native-content__body">
					<h1 class="gw-native-content__title"><?php the_title(); ?></h1>
						<?php the_content(); ?>
					</div>
					<?php
				endwhile;
			endif;
			?>
		</article>

		<?php get_template_part( 'template-parts/content/content-footer' ); ?>

	</main>

</div>

<?php get_template_part( 'template-parts/layout/login-popup' ); ?>

<?php wp_footer(); ?>
</body>
</html>
