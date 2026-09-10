<?php
/**
 * Opções do Tema → Login (popup).
 *
 * Conteúdo do popup que abre ao clicar em "Login" no menu — é o mesmo em
 * toda página do site (o menu é global), por isso mora em Opções do Tema
 * e não no Flexible Content de uma página específica.
 *
 * O popup em si usa o painel deslizante genérico (.gw-drawer — ver
 * assets/css/components/drawer.css) — ver template-parts/layout/login-popup.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greywing_register_login_options() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// A Página de Opções em si já é registrada em options-footer.php —
	// aqui só registramos mais um grupo de campos na mesma página.
	//
	// Nomes dos campos com prefixo "login_": Options Pages do ACF salvam
	// cada campo de nível superior direto na tabela wp_options usando o
	// NOME do campo (ex.: "options_title"), sem separar por grupo de campos
	// — um campo "title" aqui e um campo "title" em options-disclaimer.php
	// escreviam na mesma linha do banco, e um sobrescrevia o outro. Foi
	// exatamente isso que fez o popup de Login mostrar o texto do aviso de
	// elegibilidade.
	acf_add_local_field_group(
		array(
			'key'      => 'group_greywing_login_options',
			'title'    => 'Login (popup)',
			'fields'   => array(
				array(
					'key'   => 'field_gwlogin_title',
					'label' => 'Título',
					'name'  => 'login_title',
					'type'  => 'text',
				),
				greywing_field_richtext( 'field_gwlogin_text', 'login_text', 'Texto' ),
				array(
					'key'          => 'field_gwlogin_button',
					'label'        => 'Botão (ex.: "Access login page →")',
					'name'         => 'login_button',
					'type'         => 'link',
					'instructions' => 'Pra onde o botão leva — normalmente a página de login de verdade.',
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
add_action( 'acf/init', 'greywing_register_login_options' );
