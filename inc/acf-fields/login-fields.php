<?php
/**
 * Campos da página "Login" — página simples, sem seções empilhadas. Ver
 * template-parts/content/login-content.php e assets/css/login.css.
 *
 * Antes o Login era um popup vindo de Opções do Tema; agora é uma página de
 * verdade (o layout novo não tem mais painel deslizante em lugar nenhum).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greywing_register_login_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_gwlogin_fields',
			'title'    => 'Página Login',
			'fields'   => array(
				greywing_field_title( 'field_gwlogin_title', 'title', 'Título' ),
				array(
					'key'   => 'field_gwlogin_lead',
					'label' => 'Texto acima do cartão',
					'name'  => 'lead',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_gwlogin_card_url',
					'label' => 'Link do portal',
					'name'  => 'card_url',
					'type'  => 'url',
				),
				array(
					'key'   => 'field_gwlogin_card_bar',
					'label' => 'Texto da barra do cartão (ex.: domínio do portal)',
					'name'  => 'card_bar',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gwlogin_card_kicker',
					'label' => 'Rótulo pequeno do cartão',
					'name'  => 'card_kicker',
					'type'  => 'text',
					'default_value' => 'Investor Portal',
				),
				array(
					'key'   => 'field_gwlogin_card_title',
					'label' => 'Título do cartão',
					'name'  => 'card_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gwlogin_card_cta',
					'label' => 'Texto do botão do cartão',
					'name'  => 'card_cta',
					'type'  => 'text',
					'default_value' => 'Access the portal',
				),
				greywing_field_richtext(
					'field_gwlogin_note',
					'note',
					'Texto de rodapé (abaixo do cartão)',
					'Pra criar o link de e-mail (ex.: "info@greywingfunds.com"), selecione o trecho e use o botão de link da barra de ferramentas.'
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/template-login.php',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'greywing_register_login_fields' );
