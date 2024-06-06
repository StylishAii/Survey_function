<?php

namespace SangoBlocks;

class Editor {

	public function init() {
		add_action( 'enqueue_block_assets', array( $this, 'load_editor_asset' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'setup_editor_asset' ) );
		add_filter( 'admin_body_class', array( $this, 'add_fontawesome_class_to_body' ) );
		if ( function_exists( 'get_default_block_categories' ) && function_exists( 'get_block_editor_settings' ) ) {
			add_filter( 'block_categories_all', array( $this, 'register_block_category' ) );
		} else {
			add_filter( 'block_categories', array( $this, 'register_block_category' ) );
		}
	}

	public function load_editor_asset() {
		wp_enqueue_style(
			'sango_theme_gutenberg-style',
			App::getUrl( 'build/style-blocks.css' )
		);
		wp_enqueue_style(
			'sango_theme_icon_style',
			App::getUrl( 'icon.build.css' )
		);
	}

	public function add_fontawesome_class_to_body( $classes ) {
		// FontAwesome5を使用している場合"fa5"を付与
		$classes .= get_option( 'use_fontawesome4' ) ? ' fa4 ' : ' fa5 ';
		return $classes;
	}

	public function register_block_category( $categories ) {
		$categories[] = array(
			'slug'  => 'sgb_custom',
			'title' => 'SANGOカスタムブロック',
		);
		$categories[] = array(
			'slug'  => 'sgb_customize',
			'title' => 'カスタマイズ',
		);
		return $categories;
	}

	public function get_editor_inline_css() {
		$style = '
    .sgb-full-bg__content--edit {
      max-width: var(--wp--custom--wrap--default-width) !important;
      margin: auto !important;
      padding-left: var(--wp--custom--wrap--padding-side) !important;
      padding-right: var(--wp--custom--wrap--padding-side) !important;
    }
      .sgb-tab__content {
        padding: 25px 0 10px 0;
      }
    ';
		return $style;
	}

	public function setup_editor_asset() {
		global $pagenow;
		global $post;

		// Scripts.
		$deps = $pagenow === 'widgets.php' ? array( 'wp-blocks', 'wp-element', 'wp-rich-text', 'wp-plugins', 'wp-edit-widgets' ) : array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-rich-text', 'wp-plugins', 'wp-edit-post' );

		wp_enqueue_script( 'css-validator' );
		wp_enqueue_script(
			'sango_theme_gutenberg-block-js', // Handle.
			App::getUrl( 'build/blocks.js' ),
			$deps
		);

		// 親テーマのget_optionの値を全てエディターのJSにわたす->必要に応じてブロックで利用
		// $editor_include_options = wp_load_alloptions();
		$cats       = get_categories(
			array(
				'hide_empty' => 0,
			)
		);
		$categories = array();
		foreach ( $cats as $cat ) {
			$categories[] = $cat;
		}
		$tgs  = get_tags();
		$tags = array();
		foreach ( $tgs as $tag ) {
			$tags[] = $tag;
		}
		$editor_include_options = array(
			'site_url'                        => site_url(),
			'say_image_upload'                => get_option( 'say_image_upload' ),
			'say_name'                        => get_option( 'say_name' ),
			'image_dir'                       => @App::getDirUrl( 'images' ),
			'categories'                      => $categories,
			'users'                           => get_users(),
			'tags'                            => $tags,
			'custom_formats'                  => @App::get( 'format' )->get(),
			'colors'                          => @App::get( 'color' )->get_default_editor_color(),
			'custom_colors'                   => @App::get( 'color' )->get(),
			'infeed_enabled'                  => get_theme_mod( 'enable_ad_infeed', false ),
			'sango_version'                   => wp_get_theme( get_template() )->get( 'Version' ),
			'page_now'                        => $pagenow === 'widgets.php' ? 'widgets' : 'post',
			'post_type'                       => $post ? $post->post_type : '',
			'use_toc'                         => get_option( 'not_use_sgb_toc' ) ? false : true,
			'api_key'                         => @App::get( 'gallery' )->getKey(),
			'variations'                      => @App::get( 'variation' )->get_all(),
			'shares'                          => @App::get( 'share' )->get_all(),
			'post_types'                      => get_option( 'sgb_post_type_select' ),
			'sgb_custom_hide_highlight'       => get_option( 'sgb_custom_hide_highlight' ),
			'sgb_custom_hide_link_button'     => get_option( 'sgb_custom_hide_link_button' ),
			'sgb_custom_hide_star'            => get_option( 'sgb_custom_hide_star' ),
			'sgb_custom_hide_table_highlight' => get_option( 'sgb_custom_hide_table_highlight' ),
		);
		wp_localize_script( 'sango_theme_gutenberg-block-js', 'sgb_parent_options', $editor_include_options );
		wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
		wp_enqueue_style( 'wp-codemirror' );
		// Block Editor Styles.
		wp_enqueue_style(
			'sango_theme_gutenberg-block-editor-style', // Handle.
			App::getUrl( 'build/blocks.css' ),
			array( 'wp-edit-blocks' )
		);

		$fontfamily = '.editor-styles-wrapper {
      --sgb-font-family: var(--wp--preset--font-family--default);
    }';
		if ( sng_is_selected_font( 'notosansjp' ) ) {
			$fontfamily = '.editor-styles-wrapper {
        --sgb-font-family: var(--wp--preset--font-family--notosans);
      }';
		}
		if ( sng_is_selected_font( 'mplusrounded1c' ) ) {
			$fontfamily = '.editor-styles-wrapper {
        --sgb-font-family: var(--wp--preset--font-family--mplusrounded);
      }';
		}
		// Custom styles from SANGO theme.
		wp_add_inline_style( 'sango_theme_gutenberg-block-editor-style', $fontfamily );
		wp_add_inline_style( 'sango_theme_gutenberg-block-editor-style', App::get( 'color' )->get_editor_front_global_vars() );
		wp_add_inline_style( 'sango_theme_gutenberg-block-editor-style', $this->get_editor_inline_css() );
	}
}
