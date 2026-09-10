<?php
/**
 * Componente: Track record — título + texto + números de performance.
 *
 * Os números ficam em 2 grupos (repeaters) lado a lado, cada linha com
 * rótulo + valor e uma linha divisória embaixo — ex.: "Annualised return
 * since inception:" / "21,6%". O editor controla livremente quantas linhas
 * cada grupo tem.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greywing_track_record_stat_fields( $prefix ) {
	return array(
		array(
			'key'   => "field_gwtr_{$prefix}_label",
			'label' => 'Rótulo',
			'name'  => 'label',
			'type'  => 'text',
		),
		array(
			'key'   => "field_gwtr_{$prefix}_value",
			'label' => 'Valor',
			'name'  => 'value',
			'type'  => 'text',
		),
	);
}

return array(
	'key'        => 'layout_greywing_track_record',
	'name'       => 'track_record',
	'label'      => 'Track record (título + texto + números)',
	'display'    => 'block',
	'sub_fields' => array(
		greywing_field_anchor( 'field_gwtr_anchor' ),
		greywing_field_title( 'field_gwtr_title' ),
		greywing_field_title_spacing( 'field_gwtr_title_spacing' ),
		greywing_field_richtext( 'field_gwtr_text' ),
		array(
			'key'   => 'field_gwtr_as_of',
			'label' => 'Rótulo da data (ex.: "As of July 2026:")',
			'name'  => 'as_of_label',
			'type'  => 'text',
		),
		array(
			'key'          => 'field_gwtr_stats_left',
			'label'        => 'Números — coluna esquerda',
			'name'         => 'stats_left',
			'type'         => 'repeater',
			'layout'       => 'table',
			'button_label' => 'Adicionar número',
			'sub_fields'   => greywing_track_record_stat_fields( 'left' ),
		),
		array(
			'key'          => 'field_gwtr_stats_right',
			'label'        => 'Números — coluna direita',
			'name'         => 'stats_right',
			'type'         => 'repeater',
			'layout'       => 'table',
			'button_label' => 'Adicionar número',
			'sub_fields'   => greywing_track_record_stat_fields( 'right' ),
		),
	),
);
