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
			'title'    => 'Funds Page — Sections',
			'fields'   => array(
				array(
					'key'          => 'field_gwfunds_sections',
					'label'        => 'Page sections',
					'name'         => 'sections',
					'type'         => 'flexible_content',
					'button_label' => 'Add section',
					'layouts'      => array(
						// Seção 1 — Hero do fundo.
						array(
							'key'        => 'layout_gwfunds_1',
							'name'       => 'section_1',
							'label'      => 'Section 1 — Hero',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_title( 'field_gwfunds1_title', 'title', 'Title' ),
								array(
									'key'   => 'field_gwfunds1_kicker',
									'label' => 'Small subtitle',
									'name'  => 'kicker',
									'type'  => 'text',
									'default_value' => 'Multi-Strategy Commodity Fund',
								),
								greywing_field_richtext( 'field_gwfunds1_text', 'text', 'Text (paragraphs)' ),
								array(
									'key'           => 'field_gwfunds1_image',
									'label'         => 'Image',
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
							'label'      => 'Section 2 — Track Record',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_anchor( 'field_gwfunds2_anchor' ),
								greywing_field_section_theme( 'field_gwfunds2_theme', 'theme', 'navy' ),
								greywing_field_title( 'field_gwfunds2_title', 'title', 'Title' ),
								array(
									'key'   => 'field_gwfunds2_lead1',
									'label' => 'Bold text 1',
									'name'  => 'lead_1',
									'type'  => 'textarea',
									'rows'  => 2,
								),
								array(
									'key'   => 'field_gwfunds2_lead2',
									'label' => 'Bold text 2 (e.g. "As of July 2026:")',
									'name'  => 'lead_2',
									'type'  => 'text',
								),
								array(
									'key'   => 'field_gwfunds2_stat1_num',
									'label' => 'Number 1',
									'name'  => 'stat_1_num',
									'type'  => 'text',
									'default_value' => '21.6%',
								),
								array(
									'key'   => 'field_gwfunds2_stat1_lbl',
									'label' => 'Caption 1',
									'name'  => 'stat_1_label',
									'type'  => 'text',
									'default_value' => 'Annualised return since inception',
								),
								array(
									'key'   => 'field_gwfunds2_stat2_num',
									'label' => 'Number 2',
									'name'  => 'stat_2_num',
									'type'  => 'text',
									'default_value' => '379.5%',
								),
								array(
									'key'   => 'field_gwfunds2_stat2_lbl',
									'label' => 'Caption 2',
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
									'label' => '"As of..." text',
									'name'  => 'as_of',
									'type'  => 'text',
								),
							),
						),
						// Seção 3 — Performance Graph.
						array(
							'key'        => 'layout_gwfunds_3',
							'name'       => 'section_3',
							'label'      => 'Section 3 — Performance Graph',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_anchor( 'field_gwfunds3_anchor' ),
								greywing_field_section_theme( 'field_gwfunds3_theme', 'theme', 'white' ),
								greywing_field_title( 'field_gwfunds3_title', 'title', 'Title' ),
								array(
									'key'   => 'field_gwfunds3_sub',
									'label' => 'Text below the title',
									'name'  => 'subtitle',
									'type'  => 'text',
									'default_value' => 'Value of USD 1,000 invested since inception, net of fees',
								),
								array(
									'key'          => 'field_gwfunds3_versions',
									'label'        => 'Chart versions (one button each)',
									'name'         => 'chart_versions',
									'type'         => 'repeater',
									'layout'       => 'block',
									'button_label' => 'Add version',
									'instructions' => 'One row per button below the chart (e.g. "1Y", "3Y", "Since inception"...). Paste the full <svg>...</svg> code exported from wherever the chart is built — it renders directly on the page, no file upload. The first row is shown by default; if there\'s only one row, no buttons are shown.',
									'sub_fields'   => array(
										array(
											'key'   => 'field_gwfunds3_version_label',
											'label' => 'Button label',
											'name'  => 'label',
											'type'  => 'text',
										),
										array(
											'key'          => 'field_gwfunds3_version_svg',
											'label'        => 'SVG code',
											'name'         => 'svg_code',
											'type'         => 'textarea',
											'rows'         => 8,
											'instructions' => 'Paste the full <svg>...</svg> code here.',
										),
									),
								),
								array(
									'key'   => 'field_gwfunds3_meta_period',
									'label' => 'Period (below the chart)',
									'name'  => 'meta_period',
									'type'  => 'text',
									'instructions' => 'E.g. "Aug 2018 – Jul 2026". Leave empty to hide this line.',
								),
								array(
									'key'   => 'field_gwfunds3_meta_end',
									'label' => 'Greywing ending value',
									'name'  => 'meta_end',
									'type'  => 'text',
									'instructions' => 'E.g. "$4,780". Leave empty to hide.',
								),
								array(
									'key'   => 'field_gwfunds3_meta_ann',
									'label' => 'Annualised return',
									'name'  => 'meta_ann',
									'type'  => 'text',
									'instructions' => 'E.g. "21.6%". Leave empty to hide.',
								),
								array(
									'key'   => 'field_gwfunds3_note',
									'label' => 'Note below the chart',
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
							'label'      => 'Section 4 — Fund Information',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_anchor( 'field_gwfunds4_anchor' ),
								greywing_field_section_theme( 'field_gwfunds4_theme', 'theme', 'sand' ),
								greywing_field_title( 'field_gwfunds4_title', 'title', 'Title' ),
								array(
									'key'          => 'field_gwfunds4_facts',
									'label'        => 'Fund facts',
									'name'         => 'facts',
									'type'         => 'repeater',
									'layout'       => 'table',
									'button_label' => 'Add row',
									'sub_fields'   => array(
										array(
											'key'   => 'field_gwfunds4_fact_label',
											'label' => 'Label',
											'name'  => 'label',
											'type'  => 'text',
										),
										array(
											'key'   => 'field_gwfunds4_fact_value',
											'label' => 'Value',
											'name'  => 'value',
											'type'  => 'text',
										),
									),
								),
								array(
									'key'           => 'field_gwfunds4_dl_link',
									'label'         => 'Download link (button)',
									'name'          => 'download_link',
									'type'          => 'link',
									'instructions'  => 'Points to the factsheet — either an uploaded file\'s URL (upload it under Media, copy its URL here) or any external link.',
									'default_value' => array(
										'title'  => 'Download our latest Factsheet',
										'url'    => '',
										'target' => '_blank',
									),
								),
							),
						),
						// Seção 5 — Interested in the Fund.
						array(
							'key'        => 'layout_gwfunds_5',
							'name'       => 'section_5',
							'label'      => 'Section 5 — Interested in the Fund',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_anchor( 'field_gwfunds5_anchor' ),
								greywing_field_section_theme( 'field_gwfunds5_theme', 'theme', 'clay' ),
								greywing_field_title( 'field_gwfunds5_title', 'title', 'Title' ),
								greywing_field_richtext( 'field_gwfunds5_text', 'text', 'Text (paragraphs)' ),
								array(
									'key'   => 'field_gwfunds5_fine',
									'label' => 'Small print (legal notice)',
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
