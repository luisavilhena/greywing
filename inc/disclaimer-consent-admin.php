<?php
/**
 * Tela de admin pra consultar os consentimentos gravados (ver
 * inc/disclaimer-consent.php) — é a "prova" de que um visitante aceitou (ou
 * recusou) o aviso, com IP, data/hora, versão do aviso e página. Inclui
 * exportação em CSV.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greywing_disclaimer_admin_menu() {
	add_submenu_page(
		'options-general.php',
		'Consentimentos do aviso de elegibilidade',
		'Consentimentos (Disclaimer)',
		'manage_options',
		'greywing-disclaimer-consents',
		'greywing_disclaimer_render_admin_page'
	);
}
add_action( 'admin_menu', 'greywing_disclaimer_admin_menu' );

/**
 * Exportação em CSV — roda em admin_init (antes de qualquer HTML) porque
 * precisa mandar headers de download.
 */
function greywing_disclaimer_maybe_export_csv() {
	if ( empty( $_GET['gw_export_consents'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	check_admin_referer( 'greywing_disclaimer_export' );

	global $wpdb;
	$table = greywing_disclaimer_table_name();
	$rows  = $wpdb->get_results( "SELECT * FROM $table ORDER BY created_at DESC", ARRAY_A ); // phpcs:ignore -- nome de tabela fixo, sem input do usuário.

	nocache_headers();
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=disclaimer-consents-' . gmdate( 'Y-m-d' ) . '.csv' );

	$out = fopen( 'php://output', 'w' );
	fputcsv( $out, array( 'Consent ID', 'Timestamp (UTC)', 'IP', 'User Agent', 'Disclaimer Version', 'Page URL', 'Decision' ) );

	foreach ( $rows as $row ) {
		fputcsv(
			$out,
			array(
				$row['consent_id'],
				$row['created_at'],
				$row['ip_address'],
				$row['user_agent'],
				$row['disclaimer_version'],
				$row['page_url'],
				'accepted' === $row['decision'] ? 'Accepted' : 'Rejected',
			)
		);
	}

	fclose( $out );
	exit;
}
add_action( 'admin_init', 'greywing_disclaimer_maybe_export_csv' );

function greywing_disclaimer_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	global $wpdb;
	$table    = greywing_disclaimer_table_name();
	$per_page = 50;
	$paged    = isset( $_GET['paged'] ) ? max( 1, (int) $_GET['paged'] ) : 1;
	$offset   = ( $paged - 1 ) * $per_page;

	$total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table" ); // phpcs:ignore -- nome de tabela fixo.
	$rows  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table ORDER BY created_at DESC LIMIT %d OFFSET %d", $per_page, $offset ), ARRAY_A ); // phpcs:ignore

	$export_url = wp_nonce_url( add_query_arg( 'gw_export_consents', '1' ), 'greywing_disclaimer_export' );
	?>
	<div class="wrap">
		<h1>Consentimentos do aviso de elegibilidade</h1>
		<p>Cada linha é um clique em "I Confirm and Enter" ou "I Do Not Meet These Criteria" no popup de aviso — serve como registro de que a pessoa viu e decidiu, com data/hora, IP e versão do texto exibido.</p>
		<p><a href="<?php echo esc_url( $export_url ); ?>" class="button button-primary">Exportar CSV</a></p>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th>Consent ID</th>
					<th>Timestamp (UTC)</th>
					<th>IP</th>
					<th>User Agent</th>
					<th>Versão</th>
					<th>Página</th>
					<th>Decisão</th>
				</tr>
			</thead>
			<tbody>
				<?php if ( empty( $rows ) ) : ?>
					<tr><td colspan="7">Nenhum registro ainda.</td></tr>
				<?php else : ?>
					<?php foreach ( $rows as $row ) : ?>
						<tr>
							<td><code><?php echo esc_html( $row['consent_id'] ); ?></code></td>
							<td><?php echo esc_html( $row['created_at'] ); ?></td>
							<td><?php echo esc_html( $row['ip_address'] ); ?></td>
							<td><?php echo esc_html( $row['user_agent'] ); ?></td>
							<td><?php echo esc_html( $row['disclaimer_version'] ); ?></td>
							<td><?php echo esc_html( $row['page_url'] ); ?></td>
							<td>
								<?php if ( 'accepted' === $row['decision'] ) : ?>
									<span style="color:#1a7a1a;font-weight:600;">Accepted</span>
								<?php else : ?>
									<span style="color:#a02222;font-weight:600;">Rejected</span>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
		<?php
		$total_pages = (int) ceil( $total / $per_page );
		if ( $total_pages > 1 ) :
			?>
			<p class="tablenav">
				<span class="pagination-links">
					<?php
					echo paginate_links(
						array(
							'base'      => add_query_arg( 'paged', '%#%' ),
							'format'    => '',
							'current'   => $paged,
							'total'     => $total_pages,
						)
					);
					?>
				</span>
			</p>
			<?php
		endif;
		?>
	</div>
	<?php
}
