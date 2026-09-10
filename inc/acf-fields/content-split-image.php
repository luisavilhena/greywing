<?php
/**
 * Componente: Coluna direita com imagem, coluna esquerda com título +
 * subtítulo + texto.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'key'        => 'layout_greywing_split_image',
	'name'       => 'split_image',
	'label'      => 'Texto à esquerda + imagem à direita',
	'display'    => 'block',
	'sub_fields' => array(
		greywing_field_anchor( 'field_gwsi_anchor' ),
		greywing_field_title( 'field_gwsi_title', 'title', 'Título (coluna esquerda)' ),
		greywing_field_title_spacing( 'field_gwsi_title_spacing' ),
		greywing_field_mobile_width( 'field_gwsi_mobile_w_title', 'mobile_width_title', 'Largura do título no mobile' ),
		array(
			'key'           => 'field_gwsi_title_image',
			'label'         => 'Imagem abaixo do título (coluna esquerda)',
			'name'          => 'title_image',
			'type'          => 'image',
			'instructions'  => 'Opcional. Fica entre o título e o subtítulo/texto, com 60px de espaço no desktop e 30px no mobile até o texto.',
			'return_format' => 'array',
			'preview_size'  => 'medium',
		),
		array(
			'key'   => 'field_gwsi_subtitle',
			'label' => 'Subtítulo (coluna esquerda)',
			'name'  => 'subtitle',
			'type'  => 'text',
		),
		greywing_field_mobile_width( 'field_gwsi_mobile_w_subtitle', 'mobile_width_subtitle', 'Largura do subtítulo no mobile' ),
		greywing_field_mobile_align( 'field_gwsi_mobile_align_subtitle', 'mobile_align_subtitle', 'Alinhamento do subtítulo no mobile' ),
		greywing_field_richtext( 'field_gwsi_text', 'text', 'Texto (coluna esquerda)' ),
		greywing_field_mobile_width( 'field_gwsi_mobile_w_text', 'mobile_width_text', 'Largura do texto no mobile' ),
		greywing_field_richtext(
			'field_gwsi_small_text',
			'small_text',
			'Texto pequeno (coluna esquerda)',
			'Opcional. Fica com espaço entre ele e o texto de cima (empurrado pra baixo, alinhado com a base da imagem). Fonte de 10px, menor que o texto normal — ex.: aviso legal.'
		),
		array(
			'key'           => 'field_gwsi_image',
			'label'         => 'Imagem (coluna direita)',
			'name'          => 'image',
			'type'          => 'image',
			'return_format' => 'array',
			'preview_size'  => 'large',
		),
		greywing_field_mobile_image( 'field_gwsi_mobile_image' ),
		greywing_field_mobile_order( 'field_gwsi_mobile_order', 'mobile_order', 'invert' ),
		greywing_field_mobile_align( 'field_gwsi_mobile_align' ),
		greywing_field_mobile_width( 'field_gwsi_mobile_w_image', 'mobile_width_image', 'Largura da imagem no mobile' ),
	),
);
