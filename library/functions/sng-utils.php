<?php
/**
 * このファイルではサイト全体で使える汎用メソッドをまとめています
 */

// 現在のページのURLを取得する
if ( ! function_exists( 'sng_get_current_url' ) ) {
	function sng_get_current_url() {
		if ( is_front_page() || is_home() ) { // トップページ
			return home_url( '/' );
		} elseif ( is_category() ) { // カテゴリーページ
			return get_category_link( get_query_var( 'cat' ) );
		} elseif ( is_author() ) { // 著者ページ
			return get_author_posts_url( get_the_author_meta( 'ID' ) );
		} else { // 投稿ページ等
			return get_permalink();
		}
	}
}

// 現在のページのタイトルを取得する
if ( ! function_exists( 'sng_get_page_title' ) ) {
	function sng_get_page_title() {
		if ( is_front_page() || is_home() ) {
			$catchy = ( get_bloginfo( 'description' ) ) ? '｜' . get_bloginfo( 'description' ) : '';
			return get_bloginfo( 'name' ) . $catchy;
		}
		if ( is_category() ) {
			return ( output_archive_title() ) ? output_archive_title() : '「' . single_cat_title( '', false ) . '」の記事一覧';
		}
		if ( is_author() ) {
			return get_the_author_meta( 'display_name' ) . 'の書いた記事一覧';
		}
		if ( is_archive() ) {
			return get_the_archive_title();
		}
		global $post;
		if ( $post ) { // 投稿ページ
			$title = get_post_meta( $post->ID, 'sng_title', true );
			if ( $title ) {
				return $title;
			}
			return $post->post_title;
		}
		// 見つからなかった場合はサイトタイトルだけ返す
		return get_bloginfo( 'name' );
	}
}

// 現在のページからカテゴリーのオプションを取得する
if ( ! function_exists( 'sng_get_cat_fields' ) ) {
	function sng_get_cat_fields() {
		$cat_term = get_term( get_query_var( 'cat' ), 'category' );
		if ( ! isset( $cat_term->taxonomy ) ) {
			return array(
				'category_hide_posts'  => 'false',
				'category_hide_header' => 'false',
				'category_hide_infeed' => 'false',
				'category_page'        => '',
				'category_og_image'    => '',
			);
		}
		$cat_meta          = get_option( $cat_term->taxonomy . '_' . $cat_term->term_id );
		$hide_posts        = isset( $cat_meta['category_hide_posts'] ) ? $cat_meta['category_hide_posts'] : 'false';
		$hide_header       = isset( $cat_meta['category_hide_header'] ) ? $cat_meta['category_hide_header'] : 'false';
		$hide_infeed       = isset( $cat_meta['category_hide_infeed'] ) ? $cat_meta['category_hide_infeed'] : 'false';
		$category_page     = isset( $cat_meta['category_page'] ) ? $cat_meta['category_page'] : '';
		$category_og_image = isset( $cat_meta['category_og_image'] ) ? $cat_meta['category_og_image'] : '';

		return array(
			'category_hide_posts'  => $hide_posts,
			'category_hide_header' => $hide_header,
			'category_hide_infeed' => $hide_infeed,
			'category_page'        => $category_page,
			'category_og_image'    => $category_og_image,
		);
	}
}
/**
 * CSSやJSを簡易的に圧縮する
 */
function sng_minify_css( $css ) {
	$css = preg_replace( '/\s{2,}/s', ' ', $css );
	$css = preg_replace( '/\s*([:;{}])\s*/', '$1', $css );
	$css = preg_replace( '/;}/', '}', $css );
	return $css;
}
