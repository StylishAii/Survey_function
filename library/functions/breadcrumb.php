<?php
/**
 * このファイルではパンくずリストの出力についての関数をまとめています
 */

// パンくずリスト内の1つ1つのリンクを生成する
if ( ! function_exists( 'sng_bc_item' ) ) {
	function sng_bc_item( $name, $url, $position = '1' ) {
		return '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . $url . '" itemprop="item"><span itemprop="name">' . $name . '</span></a><meta itemprop="position" content="' . $position . '" /></li>';
	}
}

// カテゴリーのパンくず用リストを生成する
if ( ! function_exists( 'sng_get_bc_category' ) ) {
	function sng_get_bc_category() {
		$cat = get_queried_object();
		if ( $cat->parent == 0 ) {
			return '';
		}
		$result    = '';
		$ancestors = array_reverse( get_ancestors( $cat->cat_ID, 'category' ) );
		$i         = 2;
		foreach ( $ancestors as $ancestor ) {
			$result .= sng_bc_item( esc_attr( get_cat_name( $ancestor ) ), esc_url( get_category_link( $ancestor ) ), $i );
			++$i;
		}
		return $result;
	}
}

// 日付のパンくず用リストを生成する
if ( ! function_exists( 'sng_get_bc_date' ) ) {
	function sng_get_bc_date() {
		// 日付ページ
		$result = '';
		$year   = get_query_var( 'year' );
		if ( is_day() || is_month() ) {
			$result .= sng_bc_item( $year . '年', get_year_link( $year ), '2' );
		}
		if ( is_day() ) {
			$result .= sng_bc_item( get_query_var( 'monthnum' ) . '月', get_month_link( $year, get_query_var( 'monthnum' ) ), '3' );
		}
		return $result;
	}
}

// 固定ページのパンくず用リストを生成する
if ( ! function_exists( 'sng_get_bc_page' ) ) {
	function sng_get_bc_page() {
		global $post;
		if ( $post->post_parent == 0 ) {
			return '';
		}
		$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
		$i         = 2;
		$result    = '';
		foreach ( $ancestors as $ancestor ) {
			$result .= sng_bc_item( esc_attr( get_the_title( $ancestor ) ), esc_url( get_permalink( $ancestor ) ), $i );
			++$i;
		}
		return $result;
	}
}

// 投稿ページのパンくず用リストを生成する
if ( ! function_exists( 'sng_get_bc_single' ) ) {
	function sng_get_bc_single() {
		global $post;
		$categories = get_the_category( $post->ID );
		if ( ! $categories ) {
			return '';
		}
		$cat    = $categories[0];
		$result = '';
		$i      = 2;
		if ( $cat->parent != 0 ) {
			$ancestors = array_reverse( get_ancestors( $cat->cat_ID, 'category' ) );
			foreach ( $ancestors as $ancestor ) {
				$result .= sng_bc_item( esc_attr( get_cat_name( $ancestor ) ), esc_url( get_category_link( $ancestor ) ), $i );
				++$i;
			}
		}
		$result .= sng_bc_item( esc_attr( $cat->cat_name ), esc_url( get_category_link( $cat->term_id ) ), $i );
		return $result;
	}
}

// パンくずリストを出力する
if ( ! function_exists( 'breadcrumb' ) ) {
	function breadcrumb() {
		if ( is_home() || is_admin() ) {
			return; // トップページ、管理画面では表示しない
		}
		$str  = '<nav id="breadcrumb" class="breadcrumb"><ul itemscope itemtype="http://schema.org/BreadcrumbList">';
		$str .= sng_bc_item( 'ホーム', home_url(), '1' ); // ホームのパンくずは共通して表示
		if ( is_category() ) {
			$str .= sng_get_bc_category();
		} elseif ( is_tag() ) {
			$str .= '<li><i class="fa fa-tag"></i> タグ</li>';
		} elseif ( is_date() ) {
			$str .= sng_get_bc_date();
		} elseif ( is_author() ) {
			$str .= '<li>著者</li>';
		} elseif ( is_page() ) {
			$str .= sng_get_bc_page();
		} elseif ( is_single() ) {
			$str .= sng_get_bc_single();
		} else {
			$str .= '<li>' . wp_title( '', false ) . '</li>';
		}
		$str .= '</ul></nav>';

		echo apply_filters( 'sng_breadcrumb', $str );
	}
}
