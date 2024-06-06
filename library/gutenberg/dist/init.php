<?php
use SangoBlocks\App;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*　フロントと管理画面両方で必要なクラスを読み込み */
App::register( 'color', 'SangoBlocks\Color' );
App::register( 'format', 'SangoBlocks\Format' );
App::register( 'css', 'SangoBlocks\CustomCSS' );
App::register( 'js', 'SangoBlocks\CustomJS' );
App::register( 'posts', 'SangoBlocks\Posts' );
App::register( 'toc', 'SangoBlocks\Toc' );
App::register( 'fontawesome', 'SangoBlocks\FontAwesome' );
App::register( 'profile', 'SangoBlocks\Profile' );
App::register( 'rest', 'SangoBlocks\Rest' );
App::register( 'box', 'SangoBlocks\Box' );
App::register( 'list', 'SangoBlocks\SangoList' );
App::register( 'heading', 'SangoBlocks\Heading' );
App::register( 'button', 'SangoBlocks\Button' );
App::register( 'share', 'SangoBlocks\Share' );
App::register( 'conditional', 'SangoBlocks\Conditional' );

function sango_block_init() {
	$pluginUrl = get_template_directory_uri() . '/library/gutenberg/dist/';
	$dirName   = __DIR__;
	App::setRootPluginDir( $dirName );
	App::setRootPluginUrl( $pluginUrl );
	App::requireDir( $dirName . '/blocks' );
	/* ログイン時にのみ必要なクラスを読み込み */
	if ( is_user_logged_in() ) {
		App::register( 'editor', 'SangoBlocks\Editor' );
		App::register( 'variation', 'SangoBlocks\Variation' );
		App::register( 'preset_old', 'SangoBlocks\PresetOld' );
		App::register( 'preset', 'SangoBlocks\Preset' );
		App::register( 'migrate', 'SangoBlocks\Migrate' );
		App::register( 'gallery', 'SangoBlocks\Gallery' );
	}
	App::run();
}

function sango_block_setup() {
	$colors  = App::get( 'color' );
	$palette = $colors->get_editor_color();
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'editor-color-palette', $palette );
}

add_action( 'init', 'sango_block_init' );
add_action( 'after_setup_theme', 'sango_block_setup' );
