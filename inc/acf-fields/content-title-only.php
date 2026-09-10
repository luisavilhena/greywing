<?php
/**
 * Componente: Só título, em destaque especial — diferente dos outros, este
 * título NÃO ocupa o espaço das 2 colunas (fica mais contido).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'key'        => 'layout_greywing_title_only',
	'name'       => 'title_only',
	'label'      => 'Só título, especial',
	'display'    => 'block',
	'sub_fields' => array(
		greywing_field_anchor( 'field_gwto_anchor' ),
		greywing_field_title( 'field_gwto_title' ),
		greywing_field_title_spacing( 'field_gwto_title_spacing' ),
	),
);
