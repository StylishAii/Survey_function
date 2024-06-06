<?php
require_once 'vendor/autoload.php';
require_once 'library/functions/sng-utils.php';
require_once 'library/functions/head.php';
require_once 'library/functions/sng-functions.php';
require_once 'library/functions/sng-tab.php';
require_once 'library/functions/entry-functions.php';
require_once 'library/functions/widget-settings.php';
require_once 'library/functions/sng-style-scripts.php';
require_once 'library/functions/customizer-styles.php';
require_once 'library/functions/style-shortcode.php';
require_once 'library/functions/breadcrumb.php';
require_once 'library/functions/share-buttons.php';
require_once 'library/functions/category.php';
require_once 'library/functions/cache.php';
require_once 'library/functions/performance.php';
require_once 'library/functions/widget.php';
require_once 'library/functions/setup.php';
require_once 'library/gutenberg/sango-theme-gutenberg.php';

if (is_user_logged_in()) {
	require_once 'library/functions/classic-editor-styles.php';
	require_once 'library/functions/custom-fields.php';
	require_once 'library/functions/category-fields.php';
	require_once 'library/functions/admin.php';
}

if (get_theme_mod('sng_disable_comments', false)) {
	require_once 'library/functions/disable-comments.php';
}

/* ------------------------------ Do not touch here ------------------------------ */
if (is_user_logged_in()) {
	require_once 'vendor/yahnis-elsts/plugin-update-checker/plugin-update-checker.php';
	$update_file = 'https://storage.googleapis.com/sango-theme-fd439535gasls/wp-sango-theme-update-information-43fadgd.json';
	if (get_option('sng_update_method_include_major_version')) {
		// v4リリース前にここを書き換える
		$update_file = 'https://storage.googleapis.com/sango-theme-fd439535gasls/wp-sango-theme-update-information-43fadgd.json';
	}
	$theme_ver = wp_get_theme('sango-theme')->Version;
	// 意図的に3.0未満に設定された場合は見にいくURLを変える
	if (version_compare($theme_ver, '2.9999.9999', '<')) {
		$update_file = 'https://quirky-goodall-9f2b7e.netlify.com/wp-sango-theme-update-information-43fadgd.json';
	}
	$myUpdateChecker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
		$update_file,
		__FILE__,
		'sango-theme'
	);
}
?>