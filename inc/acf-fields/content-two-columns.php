<?php
/**
 * Componente: Duas colunas (subtítulo + texto), com título opcional acima.
 *
 * - Título (opcional): fica acima das 2 colunas, pode ocupar a largura toda
 *   da área de conteúdo, alinhado à esquerda ou à direita.
 * - Coluna esquerda: título próprio opcional + 1 subtítulo + 1 texto.
 * - Coluna direita: título próprio opcional + 1 subtítulo + 1 texto.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'key'        => 'layout_greywing_two_columns',
	'name'       => 'two_columns',
	'label'      => 'Duas colunas',
	'display'    => 'block',
	'sub_fields' => array(
		greywing_field_anchor( 'field_gw2c_anchor' ),
		greywing_field_title( 'field_gw2c_top_title', 'top_title', 'Título acima das colunas' ),
		greywing_field_title_spacing( 'field_gw2c_top_title_spacing', 'top_title_spacing' ),
		array(
			'key'           => 'field_gw2c_top_title_align',
			'label'         => 'Alinhamento do título',
			'name'          => 'top_title_align',
			'type'          => 'button_group',
			'choices'       => array(
				'left'  => 'Esquerda',
				'right' => 'Direita',
			),
			'default_value' => 'left',
			'layout'        => 'horizontal',
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_gw2c_top_title',
						'operator' => '!=empty',
					),
				),
			),
		),
		greywing_field_mobile_width( 'field_gw2c_top_title_mobile_w', 'top_title_mobile_width', 'Largura do título no mobile' ),
		greywing_field_mobile_align( 'field_gw2c_top_title_mobile_align', 'top_title_mobile_align', 'Alinhamento do título no mobile' ),
		array(
			'key'        => 'field_gw2c_column_left',
			'label'      => 'Coluna esquerda',
			'name'       => 'column_left',
			'type'       => 'group',
			'layout'     => 'block',
			'sub_fields' => array(
				greywing_field_title( 'field_gw2c_column_left_title', 'title', 'Título da coluna' ),
				greywing_field_title_spacing( 'field_gw2c_column_left_title_spacing', 'title_spacing' ),
				greywing_field_mobile_width( 'field_gw2c_column_left_title_mobile_w', 'mobile_width_title', 'Largura do título no mobile' ),
				greywing_field_mobile_align( 'field_gw2c_column_left_title_mobile_align', 'mobile_align_title', 'Alinhamento do título no mobile' ),
				array(
					'key'   => 'field_gw2c_column_left_subtitle',
					'label' => 'Subtítulo',
					'name'  => 'subtitle',
					'type'  => 'text',
				),
				greywing_field_mobile_width( 'field_gw2c_column_left_subtitle_mobile_w', 'mobile_width_subtitle', 'Largura do subtítulo no mobile' ),
				greywing_field_mobile_align( 'field_gw2c_column_left_subtitle_mobile_align', 'mobile_align_subtitle', 'Alinhamento do subtítulo no mobile' ),
				greywing_field_richtext( 'field_gw2c_column_left_text' ),
				greywing_field_mobile_width( 'field_gw2c_column_left_text_mobile_w', 'mobile_width_text', 'Largura do texto no mobile' ),
				greywing_field_mobile_align( 'field_gw2c_column_left_text_mobile_align', 'mobile_align_text', 'Alinhamento do texto no mobile' ),
			),
		),
		array(
			'key'        => 'field_gw2c_column_right',
			'label'      => 'Coluna direita',
			'name'       => 'column_right',
			'type'       => 'group',
			'layout'     => 'block',
			'sub_fields' => array(
				greywing_field_title( 'field_gw2c_column_right_title', 'title', 'Título da coluna' ),
				greywing_field_title_spacing( 'field_gw2c_column_right_title_spacing', 'title_spacing' ),
				greywing_field_mobile_width( 'field_gw2c_column_right_title_mobile_w', 'mobile_width_title', 'Largura do título no mobile' ),
				greywing_field_mobile_align( 'field_gw2c_column_right_title_mobile_align', 'mobile_align_title', 'Alinhamento do título no mobile' ),
				array(
					'key'   => 'field_gw2c_column_right_subtitle',
					'label' => 'Subtítulo',
					'name'  => 'subtitle',
					'type'  => 'text',
				),
				greywing_field_mobile_width( 'field_gw2c_column_right_subtitle_mobile_w', 'mobile_width_subtitle', 'Largura do subtítulo no mobile' ),
				greywing_field_mobile_align( 'field_gw2c_column_right_subtitle_mobile_align', 'mobile_align_subtitle', 'Alinhamento do subtítulo no mobile' ),
				greywing_field_richtext( 'field_gw2c_column_right_text' ),
				greywing_field_mobile_width( 'field_gw2c_column_right_text_mobile_w', 'mobile_width_text', 'Largura do texto no mobile' ),
				greywing_field_mobile_align( 'field_gw2c_column_right_text_mobile_align', 'mobile_align_text', 'Alinhamento do texto no mobile' ),
			),
		),
	),
);
