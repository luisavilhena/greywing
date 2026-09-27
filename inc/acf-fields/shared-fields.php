<?php
/**
 * Pedaços de campo ACF reaproveitados entre as seções das páginas.
 *
 * Layout novo: cada seção é única por página (não é mais um componente
 * reutilizável entre páginas) — por isso não existe mais um "content_blocks"
 * genérico. O que continua reaproveitado são só esses pedacinhos de campo
 * (título, âncora, texto corrido, cor de fundo da seção), usados por cada
 * arquivo de inc/acf-fields/*-sections.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Campo de título: textarea (não texto de uma linha só), pra dar pra
 * apertar Enter e quebrar o título em mais de uma linha.
 */
function greywing_field_title( $key, $name = 'title', $label = 'Title' ) {
	return array(
		'key'          => $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'textarea',
		'rows'         => 2,
		'instructions' => 'Press Enter to break the title into more than one line.',
	);
}

/**
 * Campo de texto corrido: WYSIWYG, pra dar pra formatar (negrito, link no
 * meio da frase, lista) em vez de só texto puro.
 */
function greywing_field_richtext( $key, $name = 'text', $label = 'Text', $instructions = '' ) {
	return array(
		'key'          => $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'wysiwyg',
		'tabs'         => 'visual',
		'toolbar'      => 'basic',
		'media_upload' => 0,
		'delay'        => 1,
		'instructions' => $instructions,
	);
}

/**
 * Campo de âncora: dá um "id" pra seção, pra poder linkar um item do menu
 * direto pra ela (ex.: "#about-us"). Ver greywing_anchor_attr() em
 * inc/setup.php.
 */
function greywing_field_anchor( $key, $name = 'anchor' ) {
	return array(
		'key'          => $key,
		'label'        => 'Anchor (optional)',
		'name'         => $name,
		'type'         => 'text',
		'instructions' => 'Lowercase letters and hyphens only, e.g. "about-us". Fill this in if a menu item needs to link directly to this section.',
		'wrapper'      => array( 'class' => 'gw-field-anchor' ),
	);
}

/**
 * Cor de fundo da seção — as 8 opções do layout novo (ver .gw-t-* em
 * assets/css/base.css). Reaproveitado em toda seção que precisar escolher
 * o próprio fundo.
 */
function greywing_field_section_theme( $key, $name = 'theme', $default_value = 'navy' ) {
	return array(
		'key'           => $key,
		'label'         => 'Section background color',
		'name'          => $name,
		'type'          => 'select',
		'choices'       => array(
			'navy'  => 'Navy (dark navy blue)',
			'deep'  => 'Deep navy (near-black)',
			'clay'  => 'Clay (earthy gradient)',
			'sand'  => 'Sand (medium beige)',
			'beige' => 'Beige (light beige)',
			'white' => 'White',
			'paper' => 'Paper (very light beige)',
			'dusk'  => 'Dusk (navy → clay gradient)',
		),
		'default_value' => $default_value,
		'ui'            => 1,
	);
}
