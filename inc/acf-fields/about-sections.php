<?php
/**
 * Campos da página "About" — 5 seções únicas, empilhadas (ver
 * template-parts/content/about/*.php e assets/css/about.css).
 *
 * Cada seção é um layout de Flexible Content nomeado por ordem (section_1..5)
 * — não são componentes reutilizáveis, só um jeito organizado de editar uma
 * sequência fixa de seções bem diferentes entre si.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greywing_register_about_sections() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_gwabout_sections',
			'title'    => 'About Page — Sections',
			'fields'   => array(
				array(
					'key'          => 'field_gwabout_sections',
					'label'        => 'Page sections',
					'name'         => 'sections',
					'type'         => 'flexible_content',
					'button_label' => 'Add section',
					'layouts'      => array(
						// Seção 1 — Hero.
						array(
							'key'        => 'layout_gwabout_1',
							'name'       => 'section_1',
							'label'      => 'Section 1 — Hero',
							'display'    => 'block',
							'sub_fields' => array(
								array(
									'key'   => 'field_gwabout1_image',
									'label' => 'Background image',
									'name'  => 'image',
									'type'  => 'image',
									'return_format' => 'array',
								),
								greywing_field_title( 'field_gwabout1_title', 'title', 'Title' ),
								array(
									'key'   => 'field_gwabout1_sub',
									'label' => 'Text below the title',
									'name'  => 'sub',
									'type'  => 'textarea',
									'rows'  => 2,
								),
								array(
									'key'   => 'field_gwabout1_apply_label',
									'label' => 'Link text',
									'name'  => 'apply_label',
									'type'  => 'text',
									'default_value' => 'Apply for investment',
								),
								array(
									'key'   => 'field_gwabout1_apply_url',
									'label' => '"Apply for investment" button link',
									'name'  => 'apply_url',
									'type'  => 'url',
									'default_value' => '/contact/',
								),
							),
						),
						// Seção 2 — About Us.
						array(
							'key'        => 'layout_gwabout_2',
							'name'       => 'section_2',
							'label'      => 'Section 2 — About Us',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_anchor( 'field_gwabout2_anchor' ),
								greywing_field_section_theme( 'field_gwabout2_theme', 'theme', 'navy' ),
								greywing_field_title( 'field_gwabout2_title', 'title', 'Title' ),
								array(
									'key'           => 'field_gwabout2_image1',
									'label'         => 'Image 1 (larger, right column)',
									'name'          => 'image_1',
									'type'          => 'image',
									'return_format' => 'array',
								),
								array(
									'key'           => 'field_gwabout2_image2',
									'label'         => 'Image 2 (smaller, bottom-left corner)',
									'name'          => 'image_2',
									'type'          => 'image',
									'return_format' => 'array',
								),
								array(
									'key'   => 'field_gwabout2_kicker',
									'label' => 'Highlight phrase',
									'name'  => 'kicker',
									'type'  => 'text',
									'default_value' => 'Commodity Specialists.',
								),
								greywing_field_richtext( 'field_gwabout2_text', 'text', 'Text (paragraphs)' ),
							),
						),
						// Seção 3 — Investment Philosophy.
						array(
							'key'        => 'layout_gwabout_3',
							'name'       => 'section_3',
							'label'      => 'Section 3 — Investment Philosophy',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_anchor( 'field_gwabout3_anchor' ),
								greywing_field_section_theme( 'field_gwabout3_theme', 'theme', 'clay' ),
								greywing_field_title( 'field_gwabout3_title', 'title', 'Title' ),
								array(
									'key'          => 'field_gwabout3_steps',
									'label'        => 'Steps',
									'name'         => 'steps',
									'type'         => 'repeater',
									'layout'       => 'table',
									'button_label' => 'Add word',
									'instructions' => 'One word (or short phrase, e.g. "Understand.") per row. They show 2 at a time, side by side, and animate in one at a time as the section scrolls into view.',
									'sub_fields'   => array(
										array(
											'key'   => 'field_gwabout3_step_word',
											'label' => 'Word',
											'name'  => 'word',
											'type'  => 'text',
										),
									),
								),
								array(
									'key'   => 'field_gwabout3_sub',
									'label' => 'Subtitle (right column)',
									'name'  => 'subtitle',
									'type'  => 'text',
									'default_value' => 'Expressing Our Views',
								),
								greywing_field_richtext( 'field_gwabout3_left', 'text_left', 'Text (left column)' ),
								greywing_field_richtext( 'field_gwabout3_right', 'text_right', 'Text (right column)' ),
								array(
									'key'   => 'field_gwabout3_pull',
									'label' => 'Highlight quote (bottom, full width)',
									'name'  => 'pull_quote',
									'type'  => 'textarea',
									'rows'  => 3,
								),
							),
						),
						// Seção 4 — Why Greywing.
						array(
							'key'        => 'layout_gwabout_4',
							'name'       => 'section_4',
							'label'      => 'Section 4 — Why Greywing',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_anchor( 'field_gwabout4_anchor' ),
								greywing_field_section_theme( 'field_gwabout4_theme', 'theme', 'sand' ),
								greywing_field_title( 'field_gwabout4_title', 'title', 'Title' ),
								array(
									'key'   => 'field_gwabout4_figure',
									'label' => 'Highlight figure (e.g. "21%")',
									'name'  => 'figure',
									'type'  => 'text',
								),
								array(
									'key'   => 'field_gwabout4_figure_note',
									'label' => 'Figure caption',
									'name'  => 'figure_note',
									'type'  => 'text',
								),
								greywing_field_richtext( 'field_gwabout4_text', 'text', 'Text (paragraphs)' ),
							),
						),
						// Seção 5 — Team.
						array(
							'key'        => 'layout_gwabout_5',
							'name'       => 'section_5',
							'label'      => 'Section 5 — Team',
							'display'    => 'block',
							'sub_fields' => array(
								greywing_field_anchor( 'field_gwabout5_anchor' ),
								greywing_field_title( 'field_gwabout5_title', 'title', 'Title' ),
								greywing_field_richtext( 'field_gwabout5_text', 'text', 'Text (paragraphs)' ),
								array(
									'key'   => 'field_gwabout5_lead',
									'label' => 'Closing bold line',
									'name'  => 'lead',
									'type'  => 'text',
								),
								array(
									'key'          => 'field_gwabout5_button',
									'label'        => 'Button',
									'name'         => 'button',
									'type'         => 'link',
									'default_value' => array( 'title' => 'Contact us', 'url' => '/contact/' ),
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
						'value'    => 'page-templates/template-about.php',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'greywing_register_about_sections' );
