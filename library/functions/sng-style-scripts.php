<?php
/**
 * このファイルでは各種CSSやJSファイルを読み込むための関数を記載しています。
 * 各種CSS/JS
 * Google Font
 * Font Awesome
 * Classic Editorのスタイル
 * Gutenberg用のスタイルはSANGO Gutenbergプラグインを導入することで読み込まれるようになります。
 */

use SANGO\App;
use SangoBlocks\App as SangoBlocksApp;

// 基本的なスタイルの読み込み
add_action( 'wp_enqueue_scripts', 'sng_basic_scripts_and_styles', 1 );
if ( ! function_exists( 'sng_basic_scripts_and_styles' ) ) {
	function sng_basic_scripts_and_styles() {
		global $wp;
		if ( ! is_admin() || defined( 'IFRAME_REQUEST' ) ) {
			$theme_ver            = wp_get_theme( 'sango-theme' )->Version;
			$read_minified_css    = get_option( 'read_minified_css' );
			$style_css            = $read_minified_css ? 'style.min.css' : 'style.css';
			$entry_option_css     = $read_minified_css ? 'entry-option.min.css' : 'entry-option.css';
			$old_css              = $read_minified_css ? 'style-old.min.css' : 'style-old.css';
			$style_css_url        = App::getUrl( $style_css );
			$entry_option_css_url = App::getUrl( $entry_option_css );
			$old_css_url          = App::getUrl( $old_css );
			$file                 = App::get( 'file' );

			if ( get_option( 'sng_css_inline', false ) ) {
				$style_css_text        = $file->get_file_content( 'style.min.css' );
				$entry_option_css_text = $file->get_file_content( 'entry-option.min.css' );
				$old_css_text          = $file->get_file_content( 'style-old.min.css' );
				$blocks_css_text       = $file->get_file_content( 'library/gutenberg/dist/build/style-blocks.css' );

				wp_register_style( 'sng-stylesheet', false );
				wp_enqueue_style( 'sng-stylesheet' );
				wp_add_inline_style( 'sng-stylesheet', $style_css_text );

				wp_register_style( 'sng-option', false );
				wp_add_inline_style( 'sng-option', $entry_option_css_text );
				wp_enqueue_style( 'sng-option' );

				if ( ! SGB_DISABLE_OLD_CSS ) {
					wp_register_style( 'sng-old-css', false );
					wp_add_inline_style( 'sng-old-css', $old_css_text );
					wp_enqueue_style( 'sng-old-css' );
				}

				wp_register_style( 'sango_theme_gutenberg-style', false );
				wp_add_inline_style( 'sango_theme_gutenberg-style', $blocks_css_text );
				wp_enqueue_style( 'sango_theme_gutenberg-style' );

			} else {
				wp_enqueue_style(
					'sng-stylesheet',
					$style_css_url,
					array(),
					'',
					'all'
				);
				// 投稿
				wp_enqueue_style(
					'sng-option',
					$entry_option_css_url,
					array( 'sng-stylesheet' ),
					'',
					'all'
				);
				if ( ! SGB_DISABLE_OLD_CSS ) {
					wp_enqueue_style(
						'sng-old-css',
						$old_css_url,
						array(),
						'',
						'all'
					);
				}
				wp_enqueue_style(
					'sango_theme_gutenberg-style',
					SangoBlocksApp::getUrl( 'build/style-blocks.css' )
				);
			}

			if ( get_option( 'sng_js_inline', false ) ) {
				$blocks_js_text       = $file->get_file_content( 'library/gutenberg/dist/client.build.js' );
				$flying_pages_js_text = $file->get_file_content( 'library/js/flying-pages.min.js' );
				wp_register_script( 'sango_theme_client-block-js', false, array(), SGB_VER_NUM, true );
				wp_add_inline_script( 'sango_theme_client-block-js', $blocks_js_text );
				wp_enqueue_script( 'sango_theme_client-block-js', array(), SGB_VER_NUM, true );
				wp_localize_script(
					'sango_theme_client-block-js',
					'sgb_client_options',
					array(
						'site_url'            => site_url(),
						'is_logged_in'        => is_user_logged_in(),
						'post_id'             => get_the_ID(),
						'save_post_views'     => get_option( 'sgb_post_views_history' ),
						'save_favorite_posts' => get_option( 'sgb_post_favorite' ),
					)
				);
				if ( get_theme_mod( 'sng_flying_pages', false ) && ! is_user_logged_in() ) {
						wp_register_script( 'sango_theme_flying_pages-js', false );
						wp_add_inline_script( 'sango_theme_flying_pages-js', $flying_pages_js_text );
						wp_enqueue_script( 'sango_theme_flying_pages-js' );
				}
			} else {
				wp_enqueue_script(
					'sango_theme_client-block-js', // Handle.
					SangoBlocksApp::getUrl( 'client.build.js' ),
					array(),
					SGB_VER_NUM,
					true
				);
				wp_localize_script(
					'sango_theme_client-block-js',
					'sgb_client_options',
					array(
						'site_url'            => site_url(),
						'is_logged_in'        => is_user_logged_in(),
						'post_id'             => get_the_ID(),
						'save_post_views'     => get_option( 'sgb_post_views_history' ),
						'save_favorite_posts' => get_option( 'sgb_post_favorite' ),
					)
				);
				if ( get_theme_mod( 'sng_flying_pages', false ) ) {
					wp_enqueue_script(
						'sango_theme_flying_pages-js', // Handle.
						App::getUrl( 'library/js/flying-pages.min.js' ),
						array(),
						SGB_VER_NUM,
						true
					);
				}
			}

			// jQuery
			if ( ! get_option( 'sng_disable_jquery', false ) ) {
				wp_enqueue_script( 'jquery' );
			}
			// コメント用
			if ( is_singular() and comments_open() and ( get_option( 'thread_comments' ) == 1 ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		} // endif isAdmin
	}
}// END sng_basic_scripts_and_styles

function sng_is_selected_font( $name ) {
	return ( get_theme_mod( 'sng_font_family' ) == $name );
}

// Google Font
add_action( 'wp_enqueue_scripts', 'sng_load_google_font', 1 );
if ( ! function_exists( 'sng_load_google_font' ) ) {
	function sng_load_google_font() {
		$no_google_font = get_option( 'no_google_font', false );
		if ( $no_google_font ) {
			return;
		}
		$font_text = 'Quicksand:500,700';
		if ( sng_is_selected_font( 'notosansjp' ) ) {
			$font_text .= '|Noto+Sans+JP:400,700';
		} elseif ( sng_is_selected_font( 'mplusrounded1c' ) ) {
			$font_text .= '|M+PLUS+Rounded+1c:400,700';
		}
		wp_enqueue_style(
			'sng-googlefonts',
			'https://fonts.googleapis.com/css?family=' . $font_text . '&display=swap',
			array(),
			'',
			'all'
		);
	}
}

// FontAwesome
function sng_font_awesome_cdn_url() {
	if ( get_option( 'use_fontawesome4' ) ) {
		return 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';
	}
	if ( get_theme_mod( 'fontawesome_read_method' ) === 'limited' ) {
		return get_template_directory_uri() . '/library/css/fa-sango.css';
	}
	if ( get_theme_mod( 'fontawesome_read_method' ) === 'local' ) {
		return get_stylesheet_directory_uri() . '/library/css/fa-sango.css';
	}
	$fontawesome_ver = get_option( 'fontawesome5_ver_num' ) ? preg_replace( '/( |　)/', '', get_option( 'fontawesome5_ver_num' ) ) : '6.1.1';
	return 'https://use.fontawesome.com/releases/v' . $fontawesome_ver . '/css/all.css';
}

add_action( 'wp_enqueue_scripts', 'sng_font_awesome', 1 );
if ( ! function_exists( 'sng_font_awesome' ) ) {
	function sng_font_awesome() {
		wp_enqueue_style(
			'sng-fontawesome',
			sng_font_awesome_cdn_url(),
			array()
		);
	}
}

add_action( 'wp_enqueue_scripts', 'sng_scroll_hint', 1 );
if ( ! function_exists( 'sng_scroll_hint' ) ) {
	function sng_scroll_hint() {
		global $post;
		$enable_scroll_hint_load = false;
		if ( $post && $post->ID ) {
			$enable_scroll_hint = get_post_meta( $post->ID, 'sng_enable_post_scrollhint_js', true );
			if ( $enable_scroll_hint ) {
				$enable_scroll_hint_load = true;
			}
		}
		if ( ! get_option( 'enable_scroll_hint_js' ) && ! $enable_scroll_hint_load ) {
			return;
		}
		wp_enqueue_script( 'scroll-hint', '//unpkg.com/scroll-hint@1.2.4/js/scroll-hint.min.js', '', '20210130', false );
		wp_enqueue_style( 'scroll-hint', '//unpkg.com/scroll-hint@1.2.4/css/scroll-hint.css', '', '20210130', false );
	}
}

add_action( 'wp_enqueue_scripts', 'sng_smartphoto', 1 );
if ( ! function_exists( 'sng_smartphoto' ) ) {
	function sng_smartphoto() {
		global $post;
		$enable_smartphoto_load = false;
		if ( $post && $post->ID ) {
			$enable_smartphoto = get_post_meta( $post->ID, 'sng_enable_post_smartphoto_js', true );
			if ( $enable_smartphoto ) {
				$enable_smartphoto_load = true;
			}
		}
		if ( ! get_option( 'enable_smartphoto_js' ) && ! $enable_smartphoto_load ) {
			return;
		}
		wp_enqueue_script( 'smartphoto', '//unpkg.com/smartphoto@1.6.2/js/smartphoto.min.js', '', '20210130', false );
		wp_enqueue_style( 'smartphoto', '//unpkg.com/smartphoto@1.6.2/css/smartphoto.min.css', '', '20210130', false );
	}
}

add_filter( 'script_loader_tag', 'sng_add_defer_to_script', 10, 3 );
function sng_add_defer_to_script( $tag, $handle, $src ) {
	if ( 'smartphoto' === $handle || 'scroll-hint' === $handle ) {
		$tag = '<script defer src="' . esc_url( $src ) . '"></script>';
	}
	return $tag;
}


/**
 * // FontAwesomeの非同期読み込み
 * add_action('wp_footer', 'sng_async_load_fontawesome');
 * function sng_async_load_fontawesome() {
 *   echo '<script> (function() { var css = document.createElement("link"); css.href = "' . sng_font_awesome_cdn_url() . '"; css.rel = "stylesheet"; css.type = "text/css"; document.getElementsByTagName("head")[0].appendChild(css); })(); </script>';
 * }
 */

// Classic Editor style
add_action( 'admin_init', 'sng_classic_editor_styles' );
if ( ! function_exists( 'sng_classic_editor_styles' ) ) {
	function sng_classic_editor_styles() {
		add_editor_style( get_template_directory_uri() . '/library/css/editor-style.css' );
		// Font Awesome4.7に対応
		add_editor_style( 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	}
}
