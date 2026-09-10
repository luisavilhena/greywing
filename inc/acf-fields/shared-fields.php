<?php
/**
 * Pedaços de campo ACF reaproveitados em vários componentes.
 *
 * Ficam aqui pra não repetir a mesma definição em cada arquivo de
 * /inc/acf-fields/ — qualquer ajuste no campo de título, no de texto corrido
 * ou no de espaçamento é feito uma vez só e vale pra todos os componentes
 * que usam.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Campo de título: textarea (não texto de uma linha só), pra dar pra
 * apertar Enter e quebrar o título em mais de uma linha.
 *
 * @param string $key   Chave única do campo (ACF exige chave única no site inteiro).
 * @param string $name  Nome do campo.
 * @param string $label Rótulo mostrado no admin.
 */
function greywing_field_title( $key, $name = 'title', $label = 'Título' ) {
	return array(
		'key'          => $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'textarea',
		'rows'         => 2,
		'instructions' => 'Aperte Enter pra quebrar o título em mais de uma linha.',
	);
}

/**
 * Campo de texto corrido: WYSIWYG (não textarea simples), pra dar pra
 * formatar — negrito, itálico, link no meio da frase, lista — em vez de
 * só texto puro. Barra de ferramentas básica, sem upload de mídia (esse
 * campo é só pra texto).
 *
 * @param string $key          Chave única do campo.
 * @param string $name         Nome do campo.
 * @param string $label        Rótulo mostrado no admin.
 * @param string $instructions Texto de ajuda opcional, mostrado no admin.
 */
function greywing_field_richtext( $key, $name = 'text', $label = 'Texto', $instructions = '' ) {
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
 * Campo de âncora: dá um "id" pra linha de conteúdo, pra poder linkar um
 * item do menu direto pra essa seção (ex.: "#what-we-believe"). Fica em
 * todo componente porque qualquer um deles pode virar destino de um item
 * de menu — ver template-parts/layout/site-menu.php.
 *
 * @param string $key  Chave única do campo.
 * @param string $name Nome do campo.
 */
function greywing_field_anchor( $key, $name = 'anchor' ) {
	return array(
		'key'          => $key,
		'label'        => 'Âncora (opcional)',
		'name'         => $name,
		'type'         => 'text',
		'instructions' => 'Só letras minúsculas e hífen, ex.: "what-we-believe". Preencha se algum item do menu precisar apontar pra esta linha.',
		'wrapper'      => array( 'class' => 'gw-field-anchor' ),
	);
}

/**
 * Campo de espaçamento abaixo do título: o editor escolhe um tamanho e o
 * CSS aplica o valor certo pra desktop e mobile — ver as classes .gw-mb-*
 * em assets/css/base.css.
 *
 * @param string $key  Chave única do campo.
 * @param string $name Nome do campo.
 */
function greywing_field_title_spacing( $key, $name = 'title_spacing' ) {
	return array(
		'key'           => $key,
		'label'         => 'Espaço abaixo do título',
		'name'          => $name,
		'type'          => 'button_group',
		'choices'       => array(
			'xl' => 'XL — 120px / 60px',
			'lg' => 'LG — 85px / 40px',
			'md' => 'MD — 60px / 30px',
			's'  => 'S — 20px / 20px',
		),
		'default_value' => 'md',
		'layout'        => 'horizontal',
		'instructions'  => 'Espaço entre o título e o que vem a seguir (valor de desktop / valor de mobile).',
	);
}

/**
 * Campo de imagem alternativa pro mobile — opcional. Quando preenchido, o
 * template usa <picture> pra servir essa imagem só em telas de até 40em
 * (mobile) e a imagem normal ("desktop") em telas maiores; vazio, usa a
 * mesma imagem nos dois.
 *
 * @param string $key  Chave única do campo.
 * @param string $name Nome do campo.
 */
function greywing_field_mobile_image( $key, $name = 'mobile_image' ) {
	return array(
		'key'           => $key,
		'label'         => 'Imagem alternativa para mobile (opcional)',
		'name'          => $name,
		'type'          => 'image',
		'instructions'  => 'Se vazio, usa a mesma imagem de cima também no mobile.',
		'return_format' => 'array',
		'preview_size'  => 'medium',
	);
}

/**
 * Campo de ordem no mobile: a imagem sobe pra antes do resto do conteúdo
 * (título/texto) quando a seção empilha em telas pequenas, ou mantém a
 * ordem normal. Ver .gw-mobile-order-invert em assets/css/base.css.
 *
 * @param string $key           Chave única do campo.
 * @param string $name          Nome do campo.
 * @param string $default_value 'normal' ou 'invert' — qual já é o comportamento atual do componente sem esse campo (evita mudar a aparência de conteúdo já publicado ao adicionar o campo).
 */
function greywing_field_mobile_order( $key, $name = 'mobile_order', $default_value = 'normal' ) {
	return array(
		'key'           => $key,
		'label'         => 'Ordem da imagem no mobile',
		'name'          => $name,
		'type'          => 'button_group',
		'choices'       => array(
			'normal' => 'Ordem normal',
			'invert' => 'Imagem primeiro',
		),
		'default_value' => $default_value,
		'layout'        => 'horizontal',
		'instructions'  => 'Em telas pequenas, quando o conteúdo empilha: se a imagem aparece antes ou depois do título/texto.',
	);
}

/**
 * Campo de alinhamento no mobile (esquerda/direita) — reaproveitado pra
 * título, texto e imagem (cada um com o seu — por isso $name e $label têm
 * valor padrão pensado pro uso mais comum, imagem, mas dá pra sobrescrever).
 * Só faz diferença visual quando o elemento não ocupa 100% da largura (ver
 * greywing_field_mobile_width()). Ver .gw-mobile-align-* em assets/css/base.css.
 *
 * @param string $key   Chave única do campo.
 * @param string $name  Nome do campo.
 * @param string $label Rótulo mostrado no admin.
 */
function greywing_field_mobile_align( $key, $name = 'mobile_image_align', $label = 'Alinhamento da imagem no mobile' ) {
	return array(
		'key'           => $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'button_group',
		'choices'       => array(
			'left'  => 'Esquerda',
			'right' => 'Direita',
		),
		'default_value' => 'left',
		'layout'        => 'horizontal',
		'instructions'  => 'Só tem efeito visível se a largura no mobile (abaixo) for menor que 100%.',
	);
}

/**
 * Campo de largura no mobile (100%/80%/70%) — reaproveitado pra título,
 * texto e imagem separadamente (cada elemento tem o seu, por isso $name e
 * $label são obrigatórios, não têm valor padrão). Ver .gw-mobile-w-* em
 * assets/css/base.css.
 *
 * @param string $key   Chave única do campo.
 * @param string $name  Nome do campo.
 * @param string $label Rótulo mostrado no admin (ex.: "Largura do título no mobile").
 */
function greywing_field_mobile_width( $key, $name, $label ) {
	return array(
		'key'           => $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'button_group',
		'choices'       => array(
			'100' => '100%',
			'80'  => '80%',
			'70'  => '70%',
		),
		'default_value' => '100',
		'layout'        => 'horizontal',
	);
}
