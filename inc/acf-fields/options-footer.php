<?php
/**
 * Opções do Tema → Footer.
 *
 * O footer é conteúdo do site inteiro (aparece em toda página), não de uma
 * página específica — por isso mora numa Página de Opções do ACF Pro
 * (wp-admin → Opções do Tema), e não no Flexible Content de conteúdo da
 * página como os outros componentes.
 *
 * Mesma estrutura de antes: 3 colunas, cada uma com linha de destaque +
 * texto, ambos opcionais. O texto é WYSIWYG (não textarea simples) porque
 * no Figma a coluna 3 tem um link no MEIO da frase ("Please read our
 * [Important Disclosures & Terms of Use], which govern...") — com WYSIWYG
 * o editor seleciona o trecho e usa o botão de link do próprio WordPress,
 * exatamente como no design, sem precisar de um campo de link à parte.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greywing_footer_column_fields( $prefix ) {
	return array(
		array(
			'key'          => "field_gwftr_{$prefix}_lead",
			'label'        => 'Linha de destaque',
			'name'         => 'lead',
			'type'         => 'text',
			'instructions' => 'Opcional. Linha curta em negrito, ex.: "© 2026 Greywing Management SEZC. All rights reserved."',
		),
		greywing_field_richtext(
			"field_gwftr_{$prefix}_text",
			'text',
			'Texto',
			'Pra criar um link no meio do texto (como o de "Important Disclosures & Terms of Use"), selecione o trecho e use o botão de link da barra de ferramentas.'
		),
	);
}

function greywing_register_footer_options() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page(
			array(
				'page_title' => 'Opções do Tema',
				'menu_title' => 'Opções do Tema',
				'menu_slug'  => 'greywing-theme-options',
				'capability' => 'edit_theme_options',
				'icon_url'   => 'dashicons-admin-generic',
				'position'   => 61, // logo abaixo de Aparência
				'redirect'   => false,
			)
		);
	}

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_greywing_footer_options',
			'title'    => 'Footer',
			'fields'   => array(
				array(
					'key'        => 'field_gwftr_column_1',
					'label'      => 'Coluna 1',
					'name'       => 'column_1',
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => greywing_footer_column_fields( 'col1' ),
				),
				array(
					'key'        => 'field_gwftr_column_2',
					'label'      => 'Coluna 2',
					'name'       => 'column_2',
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => greywing_footer_column_fields( 'col2' ),
				),
				array(
					'key'        => 'field_gwftr_column_3',
					'label'      => 'Coluna 3',
					'name'       => 'column_3',
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => greywing_footer_column_fields( 'col3' ),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'greywing-theme-options',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'greywing_register_footer_options' );
