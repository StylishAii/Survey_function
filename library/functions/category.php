<?php
/**
 * Category functions
 */

use SANGO\App;

if ( ! function_exists( 'sng_category_query' ) ) {
	/**
	 * Retrieves the category query.
	 */
	function sng_category_query() {
		$status = App::get( 'status' )->get_status();
		if ( $status['is_category_top'] ) {
			global $post;
			global $wp_query;
			$cat_fields    = sng_get_cat_fields();
			$category_page = isset( $cat_fields['category_page'] ) ? $cat_fields['category_page'] : '';
			if ( ! $category_page ) {
				return;
			}
			$post = get_post( $category_page );
			if ( ! $post ) {
				return;
			}
			$wp_query = new WP_Query(
				array(
					'post_type' => 'page',
					'post__in'  => array( $post->ID ),
				)
			);
		}
	}
}

if ( ! function_exists( 'sng_category_template' ) ) {
	function sng_category_template( $single ) {
		if ( is_category() && ! is_paged() && ! is_tag() ) {
			global $wp_query;
			global $post;
			$cat_fields    = sng_get_cat_fields();
			$category_page = isset( $cat_fields['category_page'] ) ? $cat_fields['category_page'] : '';
			if ( ! $category_page ) {
				return $single;
			}
			$theme_path    = get_template_directory();
			$template_path = get_post_meta( $category_page, '_wp_page_template', true );
			if ( $template_path === 'default' || ! $template_path ) {
				return $theme_path . '/page.php';
			} else {
				return $theme_path . '/' . $template_path;
			}
		}
		return $single;
	}
}

add_filter( 'archive_template', 'sng_category_template' );
