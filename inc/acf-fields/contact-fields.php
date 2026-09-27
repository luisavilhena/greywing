<?php
/**
 * Campos da página "Contact" — página simples, sem seções empilhadas, por
 * isso são campos diretos (não Flexible Content). Ver
 * template-parts/content/contact-content.php e assets/css/contact.css.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greywing_register_contact_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_gwcontact_fields',
			'title'    => 'Contact Page',
			'fields'   => array(
				greywing_field_title( 'field_gwcontact_title', 'title', 'Title', ),
				array(
					'key'   => 'field_gwcontact_firm',
					'label' => 'Company name',
					'name'  => 'firm',
					'type'  => 'text',
					'default_value' => 'Greywing Management SEZC',
				),
				array(
					'key'          => 'field_gwcontact_columns',
					'label'        => 'Contact columns',
					'name'         => 'columns',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => 'Add column',
					'sub_fields'   => array(
						array(
							'key'   => 'field_gwcontact_col_heading',
							'label' => 'Column title',
							'name'  => 'heading',
							'type'  => 'text',
						),
						greywing_field_richtext( 'field_gwcontact_col_text', 'text', 'Text' ),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/template-contact.php',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'greywing_register_contact_fields' );
