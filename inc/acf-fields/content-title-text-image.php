<?php
/**
 * Componente: Título + texto + imagem.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'key'        => 'layout_greywing_title_text_image',
	'name'       => 'title_text_image',
	'label'      => 'Título + texto + imagem',
	'display'    => 'block',
	'sub_fields' => array(
		greywing_field_anchor( 'field_gwtti_anchor' ),
		greywing_field_title( 'field_gwtti_title' ),
		greywing_field_title_spacing( 'field_gwtti_title_spacing' ),
		greywing_field_mobile_width( 'field_gwtti_mobile_w_title', 'mobile_width_title', 'Largura do título no mobile' ),
		greywing_field_richtext( 'field_gwtti_text' ),
		greywing_field_mobile_width( 'field_gwtti_mobile_w_text', 'mobile_width_text', 'Largura do texto no mobile' ),
		array(
			'key'           => 'field_gwtti_image',
			'label'         => 'Imagem',
			'name'          => 'image',
			'type'          => 'image',
			'return_format' => 'array',
			'preview_size'  => 'large',
		),
		greywing_field_mobile_image( 'field_gwtti_mobile_image' ),
		greywing_field_mobile_order( 'field_gwtti_mobile_order' ),
		greywing_field_mobile_align( 'field_gwtti_mobile_align' ),
		greywing_field_mobile_width( 'field_gwtti_mobile_w_image', 'mobile_width_image', 'Largura da imagem no mobile' ),
	),
);
