<?php
/**
 * Dados do gráfico de performance (Fund → Performance Graph).
 *
 * Fica num arquivo PHP dedicado, não num repeater do ACF: são ~90 meses × 4
 * séries, e quem atualiza esse número todo mês é o time do fundo mexendo
 * direto aqui, não um editor de conteúdo pela tela do wp-admin (ver decisão
 * #4 do plano de reconstrução do layout). Os textos ao redor do gráfico
 * (título, subtítulo, nota) continuam no ACF da Seção 3 — ver
 * inc/acf-fields/funds-sections.php.
 *
 * Formato: um array de retorno mensal (%) por série, em ordem cronológica a
 * partir de $greywing_performance_inception. assets/js/performance-chart.js
 * converte isso em valor acumulado (USD 1.000 investidos no início).
 *
 * IMPORTANTE: os arrays abaixo estão vazios de propósito — não inventamos
 * número de performance de fundo de investimento. Preencha um valor por mês
 * (ex.: 1.8 pra +1,8%, -0.4 pra -0,4%) antes de publicar esta seção; até lá
 * o gráfico mostra "Chart data coming soon." (ver performance-chart.js).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greywing_performance_chart_data() {
	return array(
		'inception'   => '2018-08', // AAAA-MM do primeiro mês da série.
		'seriesOrder' => array( 'greywing', 'msci', 'bloomberg_ag', 'sofr' ),
		'seriesMeta'  => array(
			'greywing'     => array(
				'label' => 'Greywing Spectrum Fund',
				'color' => '#C17400',
			),
			'msci'         => array(
				'label' => 'MSCI World TR',
				'color' => '#BEB09D',
			),
			'bloomberg_ag' => array(
				'label' => 'Bloomberg Agricultural',
				'color' => '#5F90BD',
			),
			'sofr'         => array(
				'label' => 'SOFR 1m+5%',
				'color' => '#0E3258',
			),
		),
		// Retorno mensal (%) de cada série — um número por mês, mesmo
		// comprimento em todas as séries. TODO: preencher com os dados reais.
		'monthlyReturns' => array(
			'greywing'     => array(),
			'msci'         => array(),
			'bloomberg_ag' => array(),
			'sofr'         => array(),
		),
	);
}
