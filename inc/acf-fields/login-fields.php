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
			'title'    => 'Login Page',
			'fields'   => array(
				greywing_field_title( 'field_gwlogin_title', 'title', 'Title' ),
				array(
					'key'   => 'field_gwlogin_lead',
					'label' => 'Text above the card',
					'name'  => 'lead',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_gwlogin_card_url',
					'label' => 'Portal link',
					'name'  => 'card_url',
					'type'  => 'url',
				),
				array(
					'key'   => 'field_gwlogin_card_bar',
					'label' => 'Card bar text (e.g. portal domain)',
					'name'  => 'card_bar',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gwlogin_card_kicker',
					'label' => 'Card small label',
					'name'  => 'card_kicker',
					'type'  => 'text',
					'default_value' => 'Investor Portal',
				),
				array(
					'key'   => 'field_gwlogin_card_title',
					'label' => 'Card title',
					'name'  => 'card_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_gwlogin_card_cta',
					'label' => 'Card button text',
					'name'  => 'card_cta',
					'type'  => 'text',
					'default_value' => 'Access the portal',
				),
				greywing_field_richtext(
					'field_gwlogin_note',
					'note',
					'Footer text (below the card)',
					'To create the email link (e.g. "info@greywingfunds.com"), select the text and use the toolbar\'s link button.'
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
