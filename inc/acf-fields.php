<?php
/**
 * Registro dos campos ACF Pro do tema.
 *
 * A página é montada com um único campo Flexible Content ("content_blocks"):
 * cada "layout" do Flexible Content é um componente de linha de conteúdo.
 * Os campos de cada componente ficam isolados em /inc/acf-fields/*.php —
 * este arquivo só junta tudo e registra o grupo de campos.
 *
 * Registrado via PHP (acf_add_local_field_group) para viver dentro do tema,
 * versionado junto com o código.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Pedaços de campo reaproveitados entre componentes (título, espaçamento).
require_once GREYWING_THEME_DIR . '/inc/acf-fields/shared-fields.php';

// Footer e popup de Login: campos à parte, numa Página de Opções (Opções do
// Tema), porque são conteúdo do site inteiro — não fazem parte do Flexible
// Content da página.
require_once GREYWING_THEME_DIR . '/inc/acf-fields/options-footer.php';
require_once GREYWING_THEME_DIR . '/inc/acf-fields/options-login.php';
require_once GREYWING_THEME_DIR . '/inc/acf-fields/options-disclaimer.php';

add_action( 'acf/init', 'greywing_register_acf_fields' );

function greywing_register_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$components_dir = GREYWING_THEME_DIR . '/inc/acf-fields/';

	// Cada arquivo devolve o array de definição de UM layout do Flexible Content.
	$layouts = array(
		require $components_dir . 'content-two-columns.php',
		require $components_dir . 'content-title-text-image.php',
		require $components_dir . 'content-zigzag.php',
		require $components_dir . 'content-image-feature.php',
		require $components_dir . 'content-title-only.php',
		require $components_dir . 'content-split-image.php',
		require $components_dir . 'content-track-record.php',
		require $components_dir . 'content-fund-information.php',
		require $components_dir . 'content-contact-info.php',
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_greywing_page_content',
			'title'    => 'Conteúdo da página',
			'fields'   => array(
				array(
					'key'          => 'field_greywing_content_blocks',
					'label'        => 'Linhas de conteúdo',
					'name'         => 'content_blocks',
					'type'         => 'flexible_content',
					'instructions' => 'Cada linha adicionada aqui é um componente de conteúdo da página — os componentes abaixo não são exclusivos desta página, podem ser reaproveitados em qualquer outra. O menu (Aparência → Menus) e o footer (Opções do Tema) são os mesmos em todas as páginas, não fazem parte deste campo.',
					'layouts'      => $layouts,
					'button_label' => 'Adicionar linha de conteúdo',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'page',
					),
				),
			),
		)
	);
}
