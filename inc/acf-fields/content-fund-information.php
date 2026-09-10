<?php
/**
 * Componente: Fund information — título + tabela (repeater de linhas
 * rótulo/valor) + link opcional pra baixar o factsheet.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'key'        => 'layout_greywing_fund_information',
	'name'       => 'fund_information',
	'label'      => 'Fund information (título + tabela)',
	'display'    => 'block',
	'sub_fields' => array(
		greywing_field_anchor( 'field_gwfi_anchor' ),
		greywing_field_title( 'field_gwfi_title' ),
		greywing_field_title_spacing( 'field_gwfi_title_spacing' ),
		array(
			'key'          => 'field_gwfi_rows',
			'label'        => 'Linhas da tabela',
			'name'         => 'rows',
			'type'         => 'repeater',
			'layout'       => 'table',
			'button_label' => 'Adicionar linha',
			'sub_fields'   => array(
				array(
					'key'   => 'field_gwfi_row_label',
					'label' => 'Rótulo',
					'name'  => 'label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gwfi_row_value',
					'label' => 'Valor',
					'name'  => 'value',
					'type'  => 'text',
				),
			),
		),
		array(
			'key'          => 'field_gwfi_download_link',
			'label'        => 'Link de download (ex.: factsheet)',
			'name'         => 'download_link',
			'type'         => 'link',
			'instructions' => 'Opcional. Aparece como um botão abaixo da tabela.',
		),
	),
);
