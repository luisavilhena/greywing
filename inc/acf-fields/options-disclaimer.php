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

	acf_add_local_field_group(
		array(
			'key'      => 'group_greywing_disclaimer_options',
			'title'    => 'Aviso de elegibilidade (popup de tela cheia)',
			'fields'   => array(
				array(
					'key'          => 'field_gwdis_version',
					'label'        => 'Versão do aviso',
					'name'         => 'version',
					'type'         => 'text',
					'instructions' => 'Muda sempre que o texto do aviso mudar de forma relevante (ex.: "1.0", "1.1", "2.0"). Quem já aceitou uma versão anterior vê o aviso de novo, mesmo dentro dos 15 dias do cookie — é o que garante que o consentimento salvo corresponde ao texto que a pessoa realmente leu.',
					'default_value' => '1.0',
				),
				array(
					'key'   => 'field_gwdis_title',
					'label' => 'Título',
					'name'  => 'title',
					'type'  => 'text',
				),
				greywing_field_richtext(
					'field_gwdis_text',
					'text',
					'Texto (parágrafos, lista numerada, links...)',
					'Pra criar a lista numerada, use o botão de lista da barra de ferramentas. Pra negrito e links, selecione o trecho e use os botões correspondentes.'
				),
				array(
					'key'   => 'field_gwdis_accept_label',
					'label' => 'Texto do botão de aceitar',
					'name'  => 'accept_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gwdis_reject_label',
					'label' => 'Texto do botão de não aceitar',
					'name'  => 'reject_label',
					'type'  => 'text',
				),
				greywing_field_richtext(
					'field_gwdis_reject_message',
					'reject_message',
					'Mensagem ao clicar em "não aceitar"',
					'Aparece abaixo dos botões quando a pessoa clica que não atende aos critérios.'
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
