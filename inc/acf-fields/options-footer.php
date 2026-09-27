<?php
/**
 * Opções do Tema → Footer.
 *
 * Conteúdo do site inteiro (aparece em toda página), por isso mora numa
 * Página de Opções do ACF Pro (wp-admin → Opções do Tema).
 *
 * Layout novo: o rodapé é uma coluna só (não mais 3) — uma linha em negrito
 * (copyright) + parágrafos de aviso legal, um dos quais tem um link no meio
 * pra "Important Disclosures & Terms of Use". Por isso um campo WYSIWYG só,
 * não mais 3 grupos de coluna — o editor seleciona o trecho e usa o botão
 * de link da barra de ferramentas pra criar esse link no meio da frase.
 *
 * É também aqui que a Página de Opções em si é registrada
 * (acf_add_options_page) — os outros arquivos de Opções (options-disclaimer.php)
 * só adicionam mais um grupo de campos na mesma página.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greywing_register_footer_options() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page(
			array(
				'page_title' => 'Theme Options',
				'menu_title' => 'Theme Options',
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
				greywing_field_richtext(
					'field_gwftr_text',
					'footer_text',
					'Footer text',
					'The first line automatically becomes bold. To create the "Important Disclosures & Terms of Use" link, select the text and use the toolbar\'s link button.'
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
