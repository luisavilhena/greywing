<?php
/**
 * Carregamento de CSS e JS.
 *
 * Cada componente (linha de conteúdo do Flexible Content) tem seu próprio
 * arquivo CSS dentro de /assets/css/components/. Esses arquivos só são
 * carregados na página quando o componente correspondente realmente é
 * usado no Flexible Content — assim cada CSS fica isolado e fácil de achar,
 * sem inflar todas as páginas com o CSS de componentes que não aparecem nela.
 *
 * Mapa "nome do layout no ACF" => "arquivo CSS do componente".
 */
function greywing_component_stylesheets() {
	return array(
		'two_columns'      => 'content-two-columns',
		'title_text_image' => 'content-title-text-image',
		'title_zigzag'     => 'content-zigzag',
		'image_feature'    => 'content-image-feature',
		'title_only'       => 'content-title-only',
		'split_image'      => 'content-split-image',
		'track_record'     => 'content-track-record',
		'fund_information' => 'content-fund-information',
		'contact_info'     => 'content-contact-info',
	);
}

/**
 * Versão de cache-busting de um arquivo do tema: usa a data de modificação
 * do próprio arquivo, então qualquer alteração no CSS já força o navegador
 * a buscar a versão nova, sem precisar lembrar de subir um número de versão
 * manualmente. Cai de volta pra GREYWING_THEME_VERSION se o arquivo não for
 * encontrado (não deveria acontecer, mas evita erro de aviso).
 *
 * @param string $relative_path Caminho relativo à raiz do tema, ex.: '/assets/css/base.css'.
 */
function greywing_asset_version( $relative_path ) {
	$file_path = GREYWING_THEME_DIR . $relative_path;
	return file_exists( $file_path ) ? filemtime( $file_path ) : GREYWING_THEME_VERSION;
}

function greywing_enqueue_styles() {
	$dir = GREYWING_THEME_URI . '/assets/css';

	// 1) Fontes (arquivo dedicado, só @font-face).
	wp_enqueue_style( 'greywing-fonts', $dir . '/fonts.css', array(), greywing_asset_version( '/assets/css/fonts.css' ) );

	// 2) Base: reset, variáveis (cores, tipografia fluida, espaçamentos) e tipografia global.
	wp_enqueue_style( 'greywing-base', $dir . '/base.css', array( 'greywing-fonts' ), greywing_asset_version( '/assets/css/base.css' ) );

	// 3) Layout: grid de 3 colunas (menu 30% + conteúdo 70%).
	wp_enqueue_style( 'greywing-layout', $dir . '/layout.css', array( 'greywing-base' ), greywing_asset_version( '/assets/css/layout.css' ) );

	// Painel deslizante genérico (.gw-drawer) — usado pelo popup de Login
	// (todo página, o menu é global) e pelo formulário de contato. Sempre
	// carrega, junto com o resto da casca do site.
	wp_enqueue_style( 'greywing-drawer', $dir . '/components/drawer.css', array( 'greywing-layout' ), greywing_asset_version( '/assets/css/components/drawer.css' ) );

	// Aviso de elegibilidade (popup de tela cheia) — aparece em toda página.
	wp_enqueue_style( 'greywing-disclaimer-gate', $dir . '/components/disclaimer-gate.css', array( 'greywing-layout' ), greywing_asset_version( '/assets/css/components/disclaimer-gate.css' ) );

	// O footer vem de Opções do Tema (aparece em toda página que usa algum
	// dos templates do tema), não do Flexible Content — por isso o CSS dele
	// carrega sempre, e não entra no mapa condicional do passo 4 abaixo.
	if ( is_page_template( array( 'page-templates/template-home.php', 'page-templates/template-legal.php' ) ) ) {
		wp_enqueue_style( 'greywing-content-footer', $dir . '/components/content-footer.css', array( 'greywing-layout' ), greywing_asset_version( '/assets/css/components/content-footer.css' ) );
	}

	// Página de texto com o editor padrão do WordPress (sem ACF) — título +
	// the_content(), estilizado à parte porque não é um componente ACF.
	if ( is_page_template( 'page-templates/template-legal.php' ) ) {
		wp_enqueue_style( 'greywing-native-content', $dir . '/components/native-content.css', array( 'greywing-layout' ), greywing_asset_version( '/assets/css/components/native-content.css' ) );
	}

	// 4) CSS de cada componente presente na página atual.
	if ( is_page() ) {
		$layouts_in_use = greywing_get_layouts_in_use( get_the_ID() );
		$stylesheets    = greywing_component_stylesheets();

		foreach ( $layouts_in_use as $layout_name ) {
			if ( isset( $stylesheets[ $layout_name ] ) ) {
				$handle        = 'greywing-' . $stylesheets[ $layout_name ];
				$relative_path = '/assets/css/components/' . $stylesheets[ $layout_name ] . '.css';
				wp_enqueue_style( $handle, $dir . '/components/' . $stylesheets[ $layout_name ] . '.css', array( 'greywing-layout' ), greywing_asset_version( $relative_path ) );
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'greywing_enqueue_styles' );

/**
 * Menu: abrir/fechar no mobile e scroll-spy dos sub-itens (ver
 * template-parts/layout/site-menu.php e assets/js/menu.js). Carrega em
 * toda página do tema, já que o menu aparece em todas.
 */
function greywing_enqueue_scripts() {
	wp_enqueue_script(
		'greywing-menu',
		GREYWING_THEME_URI . '/assets/js/menu.js',
		array(),
		greywing_asset_version( '/assets/js/menu.js' ),
		true
	);

	// Painel deslizante genérico (popup de Login, formulário de contato...).
	// Sempre carrega — o popup de Login abre a partir do menu em qualquer
	// página, e o script não faz nada em páginas sem nenhum "data-gw-form-trigger".
	wp_enqueue_script(
		'greywing-drawer',
		GREYWING_THEME_URI . '/assets/js/drawer.js',
		array(),
		greywing_asset_version( '/assets/js/drawer.js' ),
		true
	);

	// Aviso de elegibilidade (popup de tela cheia) — sempre carrega, aparece
	// em toda página. Registra a decisão (aceite/recusa) via AJAX — ver
	// inc/disclaimer-consent.php.
	wp_enqueue_script(
		'greywing-disclaimer-gate',
		GREYWING_THEME_URI . '/assets/js/disclaimer-gate.js',
		array(),
		greywing_asset_version( '/assets/js/disclaimer-gate.js' ),
		true
	);
	wp_localize_script(
		'greywing-disclaimer-gate',
		'greywingDisclaimer',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'greywing_disclaimer_consent' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'greywing_enqueue_scripts' );

/**
 * Retorna os nomes (acf_fc_layout) dos componentes usados no Flexible Content
 * "content_blocks" de um post, sem repetição.
 *
 * @param int $post_id
 * @return string[]
 */
function greywing_get_layouts_in_use( $post_id ) {
	if ( ! function_exists( 'get_field' ) ) {
		return array();
	}

	$blocks = get_field( 'content_blocks', $post_id );

	if ( empty( $blocks ) || ! is_array( $blocks ) ) {
		return array();
	}

	$layouts = wp_list_pluck( $blocks, 'acf_fc_layout' );

	return array_unique( $layouts );
}
