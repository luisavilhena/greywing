<?php
/**
 * Percorre o Flexible Content "content_blocks" da página e chama o
 * template-part do componente correspondente a cada linha.
 *
 * Novo componente = novo "case" aqui + novo arquivo em
 * /template-parts/content/ + novo arquivo em /inc/acf-fields/
 * + novo arquivo em /assets/css/components/ (registrado em inc/enqueue.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! have_rows( 'content_blocks' ) ) {
	return;
}

while ( have_rows( 'content_blocks' ) ) :
	the_row();

	switch ( get_row_layout() ) {

		case 'two_columns':
			get_template_part( 'template-parts/content/content-two-columns' );
			break;

		case 'title_text_image':
			get_template_part( 'template-parts/content/content-title-text-image' );
			break;

		case 'title_zigzag':
			get_template_part( 'template-parts/content/content-zigzag' );
			break;

		case 'image_feature':
			get_template_part( 'template-parts/content/content-image-feature' );
			break;

		case 'title_only':
			get_template_part( 'template-parts/content/content-title-only' );
			break;

		case 'split_image':
			get_template_part( 'template-parts/content/content-split-image' );
			break;

		case 'track_record':
			get_template_part( 'template-parts/content/content-track-record' );
			break;

		case 'fund_information':
			get_template_part( 'template-parts/content/content-fund-information' );
			break;

		case 'contact_info':
			get_template_part( 'template-parts/content/content-contact-info' );
			break;
	}

endwhile;
