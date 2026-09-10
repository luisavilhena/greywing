<?php
/**
 * Componente: Informações de contato — título + repeater de blocos
 * (rótulo + texto, ex.: "Street address" + o endereço) + um link no fim.
 *
 * Usado na página de Contato: mesma grade de 2 colunas do resto do site,
 * mas todo o conteúdo fica só na primeira coluna (ver CSS).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'key'        => 'layout_greywing_contact_info',
	'name'       => 'contact_info',
	'label'      => 'Informações de contato (título + blocos + link)',
	'display'    => 'block',
	'sub_fields' => array(
		greywing_field_anchor( 'field_gwci_anchor' ),
		greywing_field_title( 'field_gwci_title' ),
		greywing_field_title_spacing( 'field_gwci_title_spacing' ),
		array(
			'key'          => 'field_gwci_blocks',
			'label'        => 'Blocos de informação',
			'name'         => 'blocks',
			'type'         => 'repeater',
			'layout'       => 'block',
			'button_label' => 'Adicionar bloco',
			'sub_fields'   => array(
				array(
					'key'   => 'field_gwci_block_label',
					'label' => 'Rótulo (em negrito)',
					'name'  => 'label',
					'type'  => 'text',
				),
				greywing_field_richtext( 'field_gwci_block_text' ),
			),
		),
		array(
			'key'          => 'field_gwci_link',
			'label'        => 'Link (ex.: "Request information →")',
			'name'         => 'link',
			'type'         => 'link',
			'instructions' => 'Opcional. Se o campo "Formulário" abaixo estiver preenchido, este link não navega — ele abre o formulário num painel deslizante em vez de seguir a URL.',
		),
		greywing_field_richtext(
			'field_gwci_form_intro',
			'form_intro',
			'Texto acima do formulário',
			'Opcional. Aparece dentro do painel deslizante, acima do formulário — ex.: "Complete the form below and we will be in touch shortly."'
		),
		array(
			'key'          => 'field_gwci_form_shortcode',
			'label'        => 'Formulário (shortcode do Contact Form 7)',
			'name'         => 'form_shortcode',
			'type'         => 'text',
			'instructions' => 'Opcional. Ex.: [contact-form-7 id="ae2e88f" title="Contact"]. Se preenchido, o link acima abre esse formulário num painel deslizante em vez de navegar.',
		),
	),
);
