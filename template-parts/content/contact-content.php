<?php
/**
 * Conteúdo da página Contact — título, nome da empresa e 3 colunas de texto.
 * Ver inc/acf-fields/contact-fields.php e assets/css/contact.css.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title   = get_field( 'title' );
$firm    = get_field( 'firm' );
$columns = get_field( 'columns' );
?>
<div class="gw-wrap gw-contact gw-block">

	<?php if ( $title ) : ?>
		<h1 class="gw-h-page gw-bar gw-split"><?php echo greywing_title_html( $title ); ?></h1>
	<?php endif; ?>

	<?php if ( $firm ) : ?>
		<p class="gw-contact__firm gw-lead-strong gw-rv"><?php echo esc_html( $firm ); ?></p>
	<?php endif; ?>

	<?php if ( $columns ) : ?>
		<div class="gw-contact__cols">
			<?php foreach ( $columns as $col ) : ?>
				<div class="gw-contact__col gw-rv">
					<?php if ( ! empty( $col['heading'] ) ) : ?>
						<h2 class="gw-contact__col-heading"><?php echo esc_html( $col['heading'] ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $col['text'] ) ) : ?>
						<div class="gw-block"><?php echo wp_kses_post( $col['text'] ); ?></div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>
