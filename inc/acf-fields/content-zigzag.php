<?php
/**
 * Componente: Título de largura livre + repeater em zigzag.
 *
 * - Título: pode ocupar toda a largura da área de conteúdo.
 * - Repeater de blocos (imagem + subtítulo + texto): o 1º bloco cai na
 *   coluna esquerda, o 2º na coluna direita, o 3º na esquerda de novo, e
 *   assim por diante — o zigzag é resolvido no template/CSS via a posição
 *   do bloco no repeater (par/ímpar), sem precisar de campo extra.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'key'        => 'layout_greywing_title_zigzag',
	'name'       => 'title_zigzag',
	'label'      => 'Título + zigzag',
	'display'    => 'block',
	'sub_fields' => array(
		greywing_field_anchor( 'field_gwzz_anchor' ),
		greywing_field_title( 'field_gwzz_title' ),
		greywing_field_title_spacing( 'field_gwzz_title_spacing' ),
		array(
			'key'          => 'field_gwzz_blocks',
			'label'        => 'Blocos do zigzag',
			'name'         => 'blocks',
			'type'         => 'repeater',
			'layout'       => 'block',
			'button_label' => 'Adicionar bloco',
			'sub_fields'   => array(
				array(
					'key'           => 'field_gwzz_block_image',
					'label'         => 'Imagem',
					'name'          => 'image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'   => 'field_gwzz_block_subtitle',
					'label' => 'Subtítulo',
					'name'  => 'subtitle',
					'type'  => 'text',
				),
				greywing_field_richtext( 'field_gwzz_block_text' ),
			),
		),
	),
);
