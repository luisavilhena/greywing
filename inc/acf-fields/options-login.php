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
	acf_add_local_field_group(
		array(
			'key'      => 'group_greywing_login_options',
			'title'    => 'Login (popup)',
			'fields'   => array(
				array(
					'key'   => 'field_gwlogin_title',
					'label' => 'Título',
					'name'  => 'title',
					'type'  => 'text',
				),
				greywing_field_richtext( 'field_gwlogin_text', 'text', 'Texto' ),
				array(
					'key'          => 'field_gwlogin_button',
					'label'        => 'Botão (ex.: "Access login page →")',
					'name'         => 'button',
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
