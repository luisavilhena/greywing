<?php
/**
 * Opções do Tema → Aviso de elegibilidade (popup de tela cheia).
 *
 * Aparece toda vez que o site carrega, cobrindo a tela inteira — é o mesmo
 * conteúdo em qualquer página, por isso mora em Opções do Tema, não no
 * Flexible Content de uma página específica.
 *
 * Ver template-parts/layout/disclaimer-gate.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greywing_register_disclaimer_options() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// Nomes dos campos com prefixo "disclaimer_": Options Pages do ACF
	// salvam cada campo de nível superior direto na tabela wp_options
	// usando o NOME do campo (ex.: "options_title"), sem separar por grupo
	// de campos — um campo "title" aqui e um campo "title" em
	// options-login.php escreviam na mesma linha do banco, e um
	// sobrescrevia o outro. Foi exatamente isso que fez o popup de Login
	// mostrar o texto deste aviso.
	acf_add_local_field_group(
		array(
			'key'      => 'group_greywing_disclaimer_options',
			'title'    => 'Eligibility Notice (compact modal)',
			'fields'   => array(
				array(
					'key'          => 'field_gwdis_version',
					'label'        => 'Notice version',
					'name'         => 'disclaimer_version',
					'type'         => 'text',
					'instructions' => 'Change this whenever the notice text changes in a meaningful way (e.g. "1.0", "1.1", "2.0"). Anyone who already accepted an earlier version sees the notice again, even within the 15-day cookie window — this guarantees the saved consent matches the text the person actually read.',
					'default_value' => '1.0',
				),
				array(
					'key'   => 'field_gwdis_title',
					'label' => 'Title',
					'name'  => 'disclaimer_title',
					'type'  => 'text',
				),
				greywing_field_richtext(
					'field_gwdis_text',
					'disclaimer_text',
					'Text (paragraphs, numbered list, links...)',
					'To create the numbered list, use the toolbar\'s list button. For bold text and links, select the text and use the matching buttons.'
				),
				array(
					'key'   => 'field_gwdis_accept_label',
					'label' => 'Accept button text',
					'name'  => 'disclaimer_accept_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gwdis_reject_label',
					'label' => 'Decline button text',
					'name'  => 'disclaimer_reject_label',
					'type'  => 'text',
				),
				greywing_field_richtext(
					'field_gwdis_reject_message',
					'disclaimer_reject_message',
					'Message shown when clicking "decline"',
					'Shown below the buttons when the person clicks that they don\'t meet the criteria.'
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
add_action( 'acf/init', 'greywing_register_disclaimer_options' );
