<?php

use SANGO\App;
use SangoBlocks\App as SangoBlocksApp;
/**
 * head内に出力されるメタタグ系を制御する関数をこのファイルにまとめています。
 * - titleタグに出力されるタイトルの変更
 * - meta robot出力
 * - OGPタグ出力
 * - ページ分割した記事でrel next/prevを表示
 * - head内にタグを挿入（カスタマイザーの詳細設定）
 */

/*********************
 * titleタグを変更
 */
if ( ! function_exists( 'sng_document_title_separator' ) ) {
	function sng_document_title_separator( $sep ) {
		$sep = '|';
		return $sep;
	}
}

// 著者ページとアーカイブページのタイトルを変更
if ( ! function_exists( 'sng_document_title_parts' ) ) {
	function sng_document_title_parts( $title_part ) {
		if ( is_author() ) {
			$title_part['title'] .= 'の書いた記事';
		} elseif ( is_archive() ) {
			$title_part['title'] = '「' . $title_part['title'] . '」の記事一覧';
		}
		return $title_part;
	}
}

// タイトル全体を書き換え
if ( ! function_exists( 'sng_pre_get_document_title' ) ) {
	function sng_pre_get_document_title( $title ) {
		global $post;
		if ( is_category() && output_archive_title() ) {
			$title = output_archive_title();
		} elseif ( $post && get_post_meta( $post->ID, 'sng_title', true ) && is_singular() ) {
			$title = esc_attr( get_post_meta( $post->ID, 'sng_title', true ) );
		}
		return $title;
	}
}

if ( ! get_option( 'disable_sango_seo' ) ) {
	add_theme_support( 'title-tag' );
	add_filter( 'document_title_separator', 'sng_document_title_separator' );
	add_filter( 'document_title_parts', 'sng_document_title_parts' );
	add_filter( 'pre_get_document_title', 'sng_pre_get_document_title' );
}
// Canonical URL
function sng_filter_canonical_url( $default_url, $post ) {
	if ( ! is_singular() || ! $post ) {
		return $default_url;
	}
	$custom_url = get_post_meta( $post->ID, 'sng_canonical_url', true );
	return ( $custom_url && strlen( $custom_url ) > 1 ) ? $custom_url : $default_url;
}
if ( ! get_option( 'disable_sango_seo' ) ) {
	add_filter( 'get_canonical_url', 'sng_filter_canonical_url', 10, 2 );
}
/*********************
 * meta robotsを制御
 */
if ( ! function_exists( 'sng_meta_robots' ) ) {
	function sng_meta_robots() {
		global $post;
		$rogots_tags = null;

		if ( is_attachment() ) {
			$rogots_tags = 'noindex,nofollow';
		} elseif ( is_singular() ) {
			$robots_r = get_post_meta( $post->ID, 'noindex_options', true );
			if ( is_array( $robots_r ) ) {
				$rogots_tags = ( in_array( 'noindex', $robots_r ) && ! in_array( 'nofollow', $robots_r ) ) ? 'noindex,follow' : implode( ',', $robots_r );
			}
		} elseif ( is_paged() || is_tag() || is_date() ) {
			$rogots_tags = 'noindex,follow';
		} elseif ( is_search() ) {
			$rogots_tags = 'noindex,nofollow';
		} elseif ( is_category() ) {
			// カテゴリーページ
			// 初期設定ではインデックス
			// $rogots_tags = 'noindex,follow';
		}
		if ( $rogots_tags ) {
			echo '<meta name="robots" content="' . $rogots_tags . '" />';
		}
	} // END meta_robots()
}
add_action( 'wp_head', 'sng_meta_robots' );

/*********************
 * メタタグ & OGPタグを出力
 */
// og:image
if ( ! function_exists( 'sng_set_ogp_image' ) ) {
	function sng_set_ogp_image() {
		global $post;
		$status = App::get( 'status' )->get_status();
		if ( $status['is_category_top'] ) {
			$cat_fields = sng_get_cat_fields();
			$ogp        = $cat_fields['category_og_image'];
			if ( $ogp ) {
				$ogp_image = wp_get_attachment_image_src( $ogp, 'full' );
				if ( isset( $ogp_image[0] ) ) {
					return $ogp_image[0];
				}
			}
		}
		if ( is_singular() ) {
			if ( get_post_meta( $post->ID, 'post_og_image', true ) ) {
				$ogp_image = wp_get_attachment_image_src( get_post_meta( $post->ID, 'post_og_image', true ), 'full' );
				if ( isset( $ogp_image[0] ) ) {
					return $ogp_image[0];
				}
			}
			return featured_image_src( 'large' );
		}
		if ( get_option( 'set_home_ogp_image' ) ) {
			return get_option( 'set_home_ogp_image' );
		} elseif ( get_option( 'thumb_upload' ) ) {
			return get_option( 'thumb_upload' );
		} elseif ( get_option( 'logo_image_media_upload' ) ) {
			$media_id  = get_option( 'logo_image_media_upload' );
			$media_url = esc_url_raw( wp_get_attachment_url( $media_id ) );
			return $media_url;
		} elseif ( get_option( 'logo_image_upload' ) ) {
			return get_option( 'logo_image_upload' );
		} else {
			return get_template_directory_uri() . '/library/images/default.jpg';
		}
	}
}

// og:description
if ( ! function_exists( 'sng_set_ogp_description' ) ) {
	function sng_set_ogp_description() {
		global $post;
		if ( is_singular() ) {
			// 投稿ページ
			if ( get_post_meta( $post->ID, 'sng_meta_description', true ) ) {
				return get_post_meta( $post->ID, 'sng_meta_description', true );
			}
			setup_postdata( $post );
			SangoBlocksApp::get( 'css' )->set_enabled( false );
			$excerpt = get_the_excerpt();
			SangoBlocksApp::get( 'css' )->set_enabled( true );
			wp_reset_postdata();
			return $excerpt;
		} elseif ( is_front_page() || is_home() ) {
			// トップページ
			if ( get_option( 'home_description' ) ) {
				return get_option( 'home_description' );
			}
			if ( get_bloginfo( 'description' ) ) {
				return get_bloginfo( 'description' );
			}
		} elseif ( is_category() ) {
			// カテゴリーページ
			$cat_term = get_term( get_query_var( 'cat' ), 'category' );
			$cat_meta = get_option( $cat_term->taxonomy . '_' . $cat_term->term_id );
			if ( ! empty( $cat_meta['category_description'] ) ) {
				return esc_attr( $cat_meta['category_description'] );
			} else {
				return get_bloginfo( 'name' ) . 'の「' . single_cat_title( '', false ) . '」についての投稿一覧です。';
			}
		} elseif ( is_tag() ) {
			// タグページ
			return wp_strip_all_tags( term_description() );
		} elseif ( is_author() && get_the_author_meta( 'description' ) ) {
			// 著者ページ
			return get_the_author_meta( 'description' );
		}
		return '';
	}
}

// og:url
if ( ! function_exists( 'sng_set_ogp_url' ) ) {
	function sng_set_ogp_url() {
		return sng_get_current_url();
	}
}

// og:title
if ( ! function_exists( 'sng_set_ogp_title_tag' ) ) {
	function sng_set_ogp_title_tag() {
		return sng_get_page_title();
	}
}

// meta description
if ( ! function_exists( 'sng_get_meta_description' ) ) {
	function sng_get_meta_description() {
		global $post;
		if ( is_singular() && get_post_meta( $post->ID, 'sng_meta_description', true ) ) {
			// 投稿ページ
			return get_post_meta( $post->ID, 'sng_meta_description', true );
		} elseif ( is_front_page() || is_home() ) {
			// トップページ
			if ( get_option( 'home_description' ) ) {
				return get_option( 'home_description' );
			}
			if ( get_bloginfo( 'description' ) ) {
				return get_bloginfo( 'description' );
			}
		} elseif ( is_category() ) {
			// カテゴリページ
			$cat_term = get_term( get_query_var( 'cat' ), 'category' );
			$cat_meta = get_option( $cat_term->taxonomy . '_' . $cat_term->term_id );
			return isset( $cat_meta['category_description'] ) ? $cat_meta['category_description'] : null;
		} elseif ( is_tag() ) {
			return wp_strip_all_tags( term_description() );
		}
		return null;
		// これ以外のページではメタデスクリプションを出力しない
		// メタデスクリプションは指定しなくても、Googleが自動で説明文を生成してくれるため
	}
}

if ( ! function_exists( 'sng_site_name_schema' ) ) {
	function sng_site_name_schema() {
		$url       = get_site_url();
		$site_name = get_option( 'sng_site_name' );
		if ( ! $site_name ) {
			return '';
		}

		return "<script type=\"application/ld+json\">
  {
    \"@context\" : \"https://schema.org\",
    \"@type\" : \"WebSite\",
    \"name\" : \"{$site_name}\",
    \"url\" : \"{$url}\",
    \"potentialAction\": {
      \"@type\": \"SearchAction\",
      \"target\": {
        \"@type\": \"EntryPoint\",
        \"urlTemplate\": \"$url/?s={search_term_string}\"
      },
      \"query-input\": \"required name=search_term_string\"
    }
  }
</script>";
	}
}

function sng_get_x_card_type() {
	if ( is_singular() ) {
		global $post;
		$x_share_type = get_post_meta( $post->ID, 'sng_x_share_type', true );
		if ( $x_share_type ) {
			return $x_share_type;
		}
		$default_share_type = get_option( 'x_share_type', 'summary_large_image' );
		return $default_share_type;
	}
	$x_share_type = get_option( 'x_share_type', 'summary_large_image' );
	return $x_share_type;
}

if ( ! function_exists( 'sng_meta_ogp' ) ) {
	function sng_meta_ogp() {
		$insert = '';
		if ( sng_get_meta_description() ) {
			$insert = '<meta name="description" content="' . esc_attr( sng_get_meta_description() ) . '" />';
		}
		$ogp_descr    = sng_set_ogp_description();
		$ogp_img      = sng_set_ogp_image();
		$ogp_title    = sng_set_ogp_title_tag();
		$ogp_url      = sng_set_ogp_url();
		$ogp_type     = ( is_front_page() || is_home() ) ? 'website' : 'article';
		$x_share_type = sng_get_x_card_type();

		// 出力するOGPタグをまとめる
		$insert .= '<meta property="og:title" content="' . esc_attr( $ogp_title ) . '" />' . "\n";
		$insert .= '<meta property="og:description" content="' . esc_attr( $ogp_descr ) . '" />' . "\n";
		$insert .= '<meta property="og:type" content="' . $ogp_type . '" />' . "\n";
		$insert .= '<meta property="og:url" content="' . esc_url( $ogp_url ) . '" />' . "\n";
		$insert .= '<meta property="og:image" content="' . esc_url( $ogp_img ) . '" />' . "\n";
		$insert .= '<meta name="thumbnail" content="' . esc_url( $ogp_img ) . '" />' . "\n";
		$insert .= '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
		$insert .= '<meta name="twitter:card" content="' . $x_share_type . '" />' . "\n";

		// facebookのappdid
		if ( get_option( 'fb_app_id' ) ) {
			$insert .= '<meta property="fb:app_id" content="' . get_option( 'fb_app_id' ) . '">';
		}

		if ( get_theme_mod( 'google_search_verification_code' ) ) {
			$insert .= '<meta name="google-site-verification" content="' . get_theme_mod( 'google_search_verification_code' ) . '" />' . "\n";
		}

		if ( is_front_page() || is_home() ) {
			$insert .= sng_site_name_schema();
		}

		// 出力
		if ( is_front_page() || is_home() || is_singular() || is_category() || is_author() || is_tag() ) {
			echo $insert;
		}
	} //END sng_meta_ogp
}

if ( ! get_option( 'disable_sango_seo' ) ) {
	add_action( 'wp_head', 'sng_meta_ogp' );
}

if ( ! function_exists( 'sng_disable_animation' ) ) {
	function sng_disable_animation() {
		if ( ! get_option( 'disable_animation' ) ) {
			return;
		}
		?>
	<style>
	.home #container .header, #divheader, .sidelong__article:first-child, .sidelong__article:nth-child(2), .cardtype__article, .sidelong__article, .fab-btn, #header-image, #divheader, .post-tab, .mobile-nav ul, .wp-block-sgb-hero .header-image {
		animation: none;
	}
	</style>
		<?php
	}
}
add_action( 'wp_head', 'sng_disable_animation' );

/*********************
 * 分割した記事でrel next/prevを表示
 *********************/
function rel_next_prev() {
	if ( is_singular() ) {
		global $post;
		global $page; // 現在のページ番号
		$pages = substr_count( $post->post_content, '<!--nextpage-->' ) + 1; // 総ページ数
		if ( $pages > 1 ) { // 複数ページあるとき
			if ( $page == $pages ) { // 最後のページの場合
				if ( $page == 2 ) { // 2ページ目の場合
					echo '<link rel="prev" href="' . esc_url( get_permalink() ) . '">';
				} else { // 最後2ページ目以外
					next_prev_permalink( 'prev', $page );
				}
			} elseif ( $page == 1 || $page == 0 ) { // 最後ではない場合
				// 1ページ目の場合
					next_prev_permalink( '', $page );
			} elseif ( $page == 2 ) { // 2ページ目＆最後のページでない
				echo '<link rel="prev" href="' . esc_url( get_permalink() ) . '">';
				next_prev_permalink( 'next', $page );
			} else { // 3ページ目以降＆最後のページではないとき
				next_prev_permalink( 'prev', $page );
				next_prev_permalink( '', $page );
			}
		}
	}
}
add_action( 'wp_head', 'rel_next_prev' );
// ページのnext/prevのリンクを出力（上記関数で利用）
function next_prev_permalink( $direction, $page ) {
	if ( $direction == 'prev' ) {
		$num = $page - 1;
	} else {
		$num = ( $page == 0 ) ? $page + 2 : $page + 1;
	}
	if ( get_option( 'permalink_structure' ) == '' ) {
		$url = add_query_arg( 'page', $num, get_permalink() );
	} else {
		$url = trailingslashit( get_permalink() ) . user_trailingslashit( $num, 'single_paged' );
	}
	if ( $direction == 'prev' ) {
		$output = '<link rel="prev" href="' . $url . '">';
	} else {
		$output = '<link rel="next" href="' . $url . '">';
	}
	echo $output;
}

// head内にタグを挿入（カスタマイザーの詳細設定）
if ( get_option( 'insert_tag_tohead' ) ) {
	add_action( 'wp_head', 'sng_insert_tag_tohead' );
	function sng_insert_tag_tohead() {
		echo get_option( 'insert_tag_tohead' );
	}
}

// head内にタグを挿入（カスタマイザーの広告設定）
if ( get_theme_mod( 'google_ad_code' ) ) {
	add_action( 'wp_head', 'sng_insert_ad_tag_tohead' );
	function sng_insert_ad_tag_tohead() {
		global $post;
		if ( ! isset( $post ) || ! isset( $post->ID ) ) {
			return;
		}
		$show_ads = ( get_post_meta( $post->ID, 'disable_ads', true ) ) ? null : '1';
		if ( ! $show_ads ) {
			return;
		}
		echo get_theme_mod( 'google_ad_code' );
	}
}

// DNSプリフェッチ
if ( get_theme_mod( 'sng_dns_prefetch' ) ) {
	add_action( 'wp_head', 'sng_insert_dns_prefetch_links' );
	function sng_insert_dns_prefetch_links() {
		$link_text = get_theme_mod( 'sng_dns_prefetch' );
		$links     = explode( "\n", $link_text );
		$html      = '';
		foreach ( $links as $link ) {
			$html .= "<link rel=\"dns-prefetch\" href=\"$link\" />";
		}
		echo $html;
	}
}
