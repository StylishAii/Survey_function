<?php
use SANGO\App;
/**
 * セットアップ
 */
function sng_after_setup() {
	define( 'SGB_DISABLE_OLD_CSS', get_option( 'sng_disable_old_css', false ) );
	App::register( 'rest', 'SANGO\Rest' );
	App::register( 'js', 'SANGO\JS' );
	App::register( 'migrate', 'SANGO\Migrate' );
	App::register( 'cache', 'SANGO\Cache' );
	App::register( 'file', 'SANGO\File' );
	App::register( 'status', 'SANGO\Status' );
	App::register( 'content-block', 'SANGO\ContentBlock' );
	App::register( 'layout', 'SANGO\Layout' );
	App::register( 'field', 'SANGO\Field' );
	if ( is_user_logged_in() ) {
		App::register( 'plugin', 'SANGO\Plugin' );
		App::register( 'builder', 'SANGO\Builder' );
		App::register( 'sanitize', 'SANGO\Sanitize' );
		App::register( 'customizer_builder', 'SANGO\CustomizerBuilder' );
		App::register( 'customizer_custom', 'SANGO\Custom\Customizer' );
		App::register( 'admin_custom', 'SANGO\Custom\Admin' );
		App::register( 'widget', 'SANGO\Widget' );
		App::register( 'customizer', 'SANGO\Customizer' );
		App::register( 'export', 'SANGO\Export' );
		App::register( 'import', 'SANGO\Import' );
		App::register( 'rollback', 'SANGO\Rollback' );
	}
	App::run();
	// キャッシュ削除URLのチェック
	sng_cache_clear_url_check();
	// キャッシュがある場合はキャッシュを利用する
	sng_retrive_cache();
	// SETUP1) headの不要タグを除去
	add_action( 'init', 'sng_head_cleanup' );

	// SETUP2) RSSからWPのバージョンを削除
	add_filter( 'the_generator', 'sng_rss_version' );

	// SETUP3) 最近のコメントウィジェットに適用されるCSSを削除
	add_filter( 'wp_head', 'sng_remove_wp_widget_recent_comments_style', 1 );
	add_action( 'wp_head', 'sng_remove_recent_comments_style', 1 );

	// SETUP4) ギャラリースタイルに適用されるCSSを削除
	add_filter( 'gallery_style', 'sng_gallery_style' );

	// SETUP5) 各種THEME SUPPORT
	sng_theme_support();

	// SETUP6) URLの変換
	add_filter( 'clean_url', 'sng_hook_strip_ampersand', 99, 3 );
}
// end sng_after_setup
add_action( 'after_setup_theme', 'sng_after_setup' );
/*****************************
 * SETUP1) headの不要タグを除去
 ******************************/
function sng_head_cleanup() {
	// カテゴリ等のフィードを削除
	// 以下一文をコメントアウトすれば表示されるように
	remove_action( 'wp_head', 'feed_links_extra', 3 );

	// リモート投稿用のリンクの出力は一応残しておきます
	// remove_action( 'wp_head', 'rsd_link' );

	// Windows Live Writer用のリンクを削除（使わないですよね）
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// 前後の記事等へのrel linkを削除
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

	// WPのバージョン表示も削除
	remove_action( 'wp_head', 'wp_generator' );

	// CSSやJSファイルに付与されるWordPressのバージョンを消す
	// 下記の関数を指定
	add_filter( 'style_loader_src', 'sng_remove_wp_ver_css_js', 9999 );
	add_filter( 'script_loader_src', 'sng_remove_wp_ver_css_js', 9999 );
} /* end sng head cleanup */

function sng_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) && ! strpos( $src, 'wp-includes' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}

	return $src;
}

/*****************************
 * SETUP2) RSSからWPのバージョンを削除
 ******************************/
function sng_rss_version() {
	return '';}

/*****************************
 * SETUP3) 「最近のコメント」ウィジェットに適用されるCSSを削除
 ******************************/
function sng_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}
function sng_remove_recent_comments_style() {
	global $wp_widget_factory;
	if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
}

/*****************************
 * SETUP4) ギャラリーに適用されるCSSを削除
 ******************************/
function sng_gallery_style( $css ) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

/*****************************
 * SETUP5) THEME SUPPORT
 ******************************/
function sng_theme_support() {

	// サムネイル画像を使用可能に
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'thumb-940', 940 ); // 関連記事等で利用
	add_image_size( 'thumb-520', 520, 300, true ); // 関連記事等で利用
	add_image_size( 'thumb-160', 160, 160, true ); // サムネイルサイズ

	function sng_custom_image_sizes( $sizes ) {
		return array_merge(
			$sizes,
			array(
				'thumb-520' => '520 x 300px',
				'thumb-160' => '160 x 160px',
			)
		);
	}
	add_filter( 'image_size_names_choose', 'sng_custom_image_sizes' );

	// SVGをアップロードできるように
	function enable_svg( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
	add_filter( 'upload_mimes', 'enable_svg' );

	// カスタム背景
	add_theme_support(
		'custom-background',
		array(
			'default-image'          => '',
			'default-color'          => '',
			'wp-head-callback'       => '_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		)
	);

	// rssリンクをhead内に出力
	add_theme_support( 'automatic-feed-links' );

	// メニューを登録
	register_nav_menus(
		array(
			'desktop-nav'  => 'ヘッダーメニュー（PCでのみ表示）',
			'mobile-nav'   => 'スライドメニュー（モバイルのみ）',
			'footer-links' => 'フッターメニュー（ページ最下部）',
			'mobile-fixed' => 'モバイル用フッター固定メニュー',
		)
	);

	// HTML5マークアップをサポート
	add_theme_support(
		'html5',
		array(
			'comment-list',
			'search-form',
			'comment-form',
		)
	);
} /* end theme support */

/*****************************
 * SETUP5) URLの変換
 ******************************/
function sng_hook_strip_ampersand( $url, $original_url, $_context ) {
	if ( strstr( $url, 'sango-theme' ) !== false ) {
		$url = str_replace( '&#038;', '&', $url );
	}
	return $url;
}


function sng_custom_robots_txt( $output ) {
	if ( get_option( 'enable_chatgpt_crawling', false ) ) {
		return $output;
	}
	$output .= "\nUser-agent: GPTBot\n";
	$output .= "Disallow: /\n";
	return $output;
}
add_filter( 'robots_txt', 'sng_custom_robots_txt' );
