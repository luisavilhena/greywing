<?php
/**
 * Campos da página "Funds" — 5 seções únicas, empilhadas (ver
 * template-parts/content/funds/*.php e assets/css/funds.css).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greywing_register_funds_sections() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_gwfunds_sections',
			'title'    => 'Página Funds — Seções',
			'fields'   => array(
				array(
					'key'          => 'field_gwfunds_sections',
					'label'        => 'Seções da página',
					'name'         => 'sections',
					'type'         => 'flexible_content',
					'button_label' => 'Adicionar seção',
					'layouts'      => array(
						// Seção 1 — Hero do fundo.
						array(
							'key'        => 'layout_gwfunds_1',
							'name'       => 'section_1',
							'label'      => 'Seção 1 — Hero',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_title( 'field_gwfunds1_title', 'title', 'Título' ),
								array(
									'key'   => 'field_gwfunds1_kicker',
									'label' => 'Subtítulo pequeno',
									'name'  => 'kicker',
									'type'  => 'text',
									'default_value' => 'Multi-Strategy Commodity Fund',
								),
								greywing_field_richtext( 'field_gwfunds1_text', 'text', 'Texto (parágrafos)' ),
								array(
									'key'           => 'field_gwfunds1_image',
									'label'         => 'Imagem',
									'name'          => 'image',
									'type'          => 'image',
									'return_format' => 'array',
								),
							),
						),
						// Seção 2 — Track Record.
						array(
							'key'        => 'layout_gwfunds_2',
							'name'       => 'section_2',
							'label'      => 'Seção 2 — Track Record',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_anchor( 'field_gwfunds2_anchor' ),
								greywing_field_section_theme( 'field_gwfunds2_theme', 'theme', 'navy' ),
								greywing_field_title( 'field_gwfunds2_title', 'title', 'Título' ),
								array(
									'key'   => 'field_gwfunds2_lead1',
									'label' => 'Texto em negrito 1',
									'name'  => 'lead_1',
									'type'  => 'textarea',
									'rows'  => 2,
								),
								array(
									'key'   => 'field_gwfunds2_lead2',
									'label' => 'Texto em negrito 2 (ex.: "As of July 2026:")',
									'name'  => 'lead_2',
									'type'  => 'text',
								),
								array(
									'key'   => 'field_gwfunds2_stat1_num',
									'label' => 'Número 1',
									'name'  => 'stat_1_num',
									'type'  => 'text',
									'default_value' => '21.6%',
								),
								array(
									'key'   => 'field_gwfunds2_stat1_lbl',
									'label' => 'Legenda 1',
									'name'  => 'stat_1_label',
									'type'  => 'text',
									'default_value' => 'Annualised return since inception',
								),
								array(
									'key'   => 'field_gwfunds2_stat2_num',
									'label' => 'Número 2',
									'name'  => 'stat_2_num',
									'type'  => 'text',
									'default_value' => '379.5%',
								),
								array(
									'key'   => 'field_gwfunds2_stat2_lbl',
									'label' => 'Legenda 2',
									'name'  => 'stat_2_label',
									'type'  => 'text',
									'default_value' => 'Cumulative return since inception',
								),
								array(
									'key'   => 'field_gwfunds2_roll3',
									'label' => 'Rolling 3 Months',
									'name'  => 'rolling_3m',
									'type'  => 'text',
								),
								array(
									'key'   => 'field_gwfunds2_roll6',
									'label' => 'Rolling 6 Months',
									'name'  => 'rolling_6m',
									'type'  => 'text',
								),
								array(
									'key'   => 'field_gwfunds2_roll12',
									'label' => 'Rolling 12 Months',
									'name'  => 'rolling_12m',
									'type'  => 'text',
								),
								array(
									'key'   => 'field_gwfunds2_asof',
									'label' => 'Texto "As of..."',
									'name'  => 'as_of',
									'type'  => 'text',
								),
							),
						),
						// Seção 3 — Performance Graph.
						array(
							'key'        => 'layout_gwfunds_3',
							'name'       => 'section_3',
							'label'      => 'Seção 3 — Performance Graph',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_anchor( 'field_gwfunds3_anchor' ),
								greywing_field_section_theme( 'field_gwfunds3_theme', 'theme', 'white' ),
								greywing_field_title( 'field_gwfunds3_title', 'title', 'Título' ),
								array(
									'key'   => 'field_gwfunds3_sub',
									'label' => 'Texto abaixo do título',
									'name'  => 'subtitle',
									'type'  => 'text',
									'default_value' => 'Value of USD 1,000 invested since inception, net of fees',
								),
								array(
									'key'   => 'field_gwfunds3_note',
									'label' => 'Nota abaixo do gráfico',
									'name'  => 'note',
									'type'  => 'text',
									'default_value' => 'Greywing Spectrum Fund Ltd compounded from monthly net returns. Past performance is not necessarily indicative of future results.',
								),
							),
						),
						// Seção 4 — Fund Information.
						array(
							'key'        => 'layout_gwfunds_4',
							'name'       => 'section_4',
							'label'      => 'Seção 4 — Fund Information',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_anchor( 'field_gwfunds4_anchor' ),
								greywing_field_section_theme( 'field_gwfunds4_theme', 'theme', 'sand' ),
								greywing_field_title( 'field_gwfunds4_title', 'title', 'Título' ),
								array(
									'key'          => 'field_gwfunds4_facts',
									'label'        => 'Fatos do fundo',
									'name'         => 'facts',
									'type'         => 'repeater',
									'layout'       => 'table',
									'button_label' => 'Adicionar linha',
									'sub_fields'   => array(
										array(
											'key'   => 'field_gwfunds4_fact_label',
											'label' => 'Rótulo',
											'name'  => 'label',
											'type'  => 'text',
										),
										array(
											'key'   => 'field_gwfunds4_fact_value',
											'label' => 'Valor',
											'name'  => 'value',
											'type'  => 'text',
										),
									),
								),
								array(
									'key'   => 'field_gwfunds4_dl_label',
									'label' => 'Texto do link de download',
									'name'  => 'download_label',
									'type'  => 'text',
									'default_value' => 'Download our latest Factsheet',
								),
								array(
									'key'   => 'field_gwfunds4_dl_file',
									'label' => 'Arquivo do Factsheet',
									'name'  => 'download_file',
									'type'  => 'file',
									'return_format' => 'url',
								),
							),
						),
						// Seção 5 — Interested in the Fund.
						array(
							'key'        => 'layout_gwfunds_5',
							'name'       => 'section_5',
							'label'      => 'Seção 5 — Interested in the Fund',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_anchor( 'field_gwfunds5_anchor' ),
								greywing_field_section_theme( 'field_gwfunds5_theme', 'theme', 'clay' ),
								greywing_field_title( 'field_gwfunds5_title', 'title', 'Título' ),
								greywing_field_richtext( 'field_gwfunds5_text', 'text', 'Texto (parágrafos)' ),
								array(
									'key'   => 'field_gwfunds5_fine',
									'label' => 'Texto pequeno (aviso legal)',
									'name'  => 'fine_print',
									'type'  => 'textarea',
									'rows'  => 4,
								),
							),
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/template-funds.php',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'greywing_register_funds_sections' );
