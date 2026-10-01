<?php
/**
 * GitHub-powered theme updates.
 *
 * Uses the same wp-config.php constants as every TargetWeb theme:
 *   define( 'TARGETWEB_GITHUB_TOKEN', 'ghp_...' );
 *   define( 'TARGETWEB_GITHUB_BRANCH', 'main' );
 *
 * TARGETWEB_GITHUB_REPO is ignored here on purpose. That constant points at
 * whichever theme last documented it (usually TargetWeb-WP-Theme). Each theme
 * already knows its own GitHub repo, so one token covers all of them.
 */
defined( 'ABSPATH' ) || exit;

add_action( 'admin_notices', 'targetweb_update_token_notice' );
add_action( 'admin_init', 'targetweb_update_token_notice_dismiss' );

if ( ! function_exists( 'targetweb_github_token_configured' ) ) {
	function targetweb_github_token_configured() {
		return defined( 'TARGETWEB_GITHUB_TOKEN' ) && TARGETWEB_GITHUB_TOKEN;
	}
}

if ( ! function_exists( 'targetweb_update_token_notice_dismiss' ) ) {
	function targetweb_update_token_notice_dismiss() {
		if ( ! current_user_can( 'update_themes' ) ) {
			return;
		}
		if ( empty( $_GET['targetweb_dismiss_update_notice'] ) || empty( $_GET['_wpnonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'targetweb_dismiss_update_notice' ) ) {
			return;
		}
		update_option( 'targetweb_hide_update_token_notice', 1, false );
	}
}

if ( ! function_exists( 'targetweb_update_token_notice' ) ) {
	function targetweb_update_token_notice() {
		if ( ! current_user_can( 'update_themes' ) ) {
			return;
		}
		if ( targetweb_github_token_configured() ) {
			return;
		}
		if ( get_option( 'targetweb_hide_update_token_notice' ) ) {
			return;
		}

		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || ! in_array( $screen->id, array( 'themes', 'update-core', 'dashboard' ), true ) ) {
			return;
		}

		$dismiss_url = wp_nonce_url(
			add_query_arg( 'targetweb_dismiss_update_notice', '1' ),
			'targetweb_dismiss_update_notice'
		);

		echo '<div class="notice notice-warning is-dismissible"><p>';
		echo esc_html__( 'TargetWeb updates come from a private GitHub repository. Add a read-only GitHub token in wp-config.php so this site can receive theme updates:', 'targetweb' );
		echo '</p><p><code>define( \'TARGETWEB_GITHUB_TOKEN\', \'your-fine-grained-token\' );</code></p>';
		echo '<p><a href="' . esc_url( $dismiss_url ) . '">' . esc_html__( 'Dismiss this notice', 'targetweb' ) . '</a></p>';
		echo '</div>';
	}
}

$puc_loader = get_stylesheet_directory() . '/inc/lib/plugin-update-checker/plugin-update-checker.php';
if ( ! is_readable( $puc_loader ) ) {
	return;
}

require_once $puc_loader;

if ( ! class_exists( '\YahnisElsts\PluginUpdateChecker\v5\PucFactory' ) ) {
	return;
}

$targetweb_github_branch = ( defined( 'TARGETWEB_GITHUB_BRANCH' ) && TARGETWEB_GITHUB_BRANCH )
	? TARGETWEB_GITHUB_BRANCH
	: 'main';

$targetweb_update_checker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
	'https://github.com/zzunair/Lead-Gen-1/',
	get_stylesheet_directory() . '/style.css',
	get_stylesheet()
);

$targetweb_update_checker->setBranch( $targetweb_github_branch );

$vcs_api = $targetweb_update_checker->getVcsApi();
if ( $vcs_api && method_exists( $vcs_api, 'enableReleaseAssets' ) ) {
	$vcs_api->enableReleaseAssets( '/\.zip($|[?&#])/i' );
}

if ( defined( 'TARGETWEB_GITHUB_TOKEN' ) && TARGETWEB_GITHUB_TOKEN ) {
	$targetweb_update_checker->setAuthentication( TARGETWEB_GITHUB_TOKEN );
}
