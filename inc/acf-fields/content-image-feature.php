<?php
/**
 * Componente: Título na coluna direita + imagem em destaque.
 *
 * - Título: fica na coluna da direita.
 * - Imagem: pode ocupar todo o espaço disponível (as duas colunas).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'key'        => 'layout_greywing_image_feature',
	'name'       => 'image_feature',
	'label'      => 'Título à direita + imagem em destaque',
	'display'    => 'block',
	'sub_fields' => array(
		greywing_field_anchor( 'field_gwif_anchor' ),
		greywing_field_title( 'field_gwif_title', 'title', 'Título (coluna direita)' ),
		greywing_field_title_spacing( 'field_gwif_title_spacing' ),
		greywing_field_mobile_width( 'field_gwif_mobile_w_title', 'mobile_width_title', 'Largura do título no mobile' ),
		array(
			'key'           => 'field_gwif_image',
			'label'         => 'Imagem',
			'name'          => 'image',
			'type'          => 'image',
			'return_format' => 'array',
			'preview_size'  => 'large',
		),
		greywing_field_mobile_image( 'field_gwif_mobile_image' ),
		greywing_field_mobile_order( 'field_gwif_mobile_order' ),
		greywing_field_mobile_align( 'field_gwif_mobile_align' ),
		greywing_field_mobile_width( 'field_gwif_mobile_w_image', 'mobile_width_image', 'Largura da imagem no mobile' ),
	),
);
