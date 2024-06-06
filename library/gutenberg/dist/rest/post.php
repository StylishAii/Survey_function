<?php
/**
 * REST API
 */

use SangoBlocks\App;

App::get( 'rest' )->register(
	array(
		'path'       => 'search-posts',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$custom_post_slugs = get_option( 'sgb_post_type_select', '' );
			$custom_post_slugs = explode( ',', $custom_post_slugs );
			$post_types = array_merge( array( 'post', 'page' ), $custom_post_slugs );
			$type = isset( $params['type'] ) && $params['type'] ? array( $params['type'] ) : $post_types;
			$search = isset( $params['search'] ) && $params['search'] ? $params['search'] : '';
			$search_option = array();
			if ( is_numeric( $search ) ) {
				$search_option['p'] = $search;
			} else {
				$search_option['s'] = $search;
			}
			$args  = array_merge(
				$search_option,
				array(
					'post_status' => 'publish', // 公開済み
					'post_type'   => $type, // 投稿ページと固定ページ
				)
			);
			$query = new WP_Query( $args );
			return json_decode( json_encode( $query->get_posts() ) );
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'search-post',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$custom_post_slugs = get_option( 'sgb_post_type_select', '' );
			$custom_post_slugs = explode( ',', $custom_post_slugs );
			$post_types = array_merge( array( 'post', 'page' ), $custom_post_slugs );
			$type = isset( $params['type'] ) && $params['type'] ? array( $params['type'] ) : $post_types;
			if ( $params['id'] === '-1' ) {
				return null;
			}
			$args  = array_merge(
				array( 'p' => $params['id'] ),
				array(
					'post_status' => 'publish', // 公開済み
					'post_type'   => $type, // 投稿ページと固定ページ
				)
			);
			$query = new WP_Query( $args );
			$posts = $query->get_posts();
			if ( count( $posts ) === 0 ) {
				return null;
			}
			return json_decode( json_encode( $posts[0] ) );
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'block-posts',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$post = App::get( 'posts' );
			$posts = $post->get_block_posts(
				array(
					'skip_items'            => $params['skipItems'],
					'order'                 => $params['order'],
					'order_by'              => $params['orderBy'],
					'cats'                  => isset( $params['categories'] ) ? $params['categories'] : array(),
					'tags'                  => isset( $params['tags'] ) ? $params['tags'] : array(),
					'taxonomies'            => isset( $params['customTaxonomies'] ) ? $params['customTaxonomies'] : array(),
					'include_children'      => $params['includeChildren'] === 'true',
					'manual_pickup'         => $params['manualPickup'] === 'true',
					'pickups'               => $params['pickups'],
					'number_of_items'       => $params['numberOfItems'],
					'post_type'             => ! $params['postType'] ? array( 'post', 'page' ) : $params['postType'],
					'show_current_category' => $params['showCurrentCategory'] === 'true',
					'post_id'               => isset( $params['postId'] ) ? $params['postId'] : false,
				)
			);
			$show_alternate_title = $params['showAlternateTitle'] === 'true';
			$converted = array_map(
				function ( $p ) use ( $show_alternate_title ) {
					list($url, $title, $_img, $_date) = sng_get_entry_link_data( $p->ID, 'thumb-520', true );
					$src = featured_image_src( 'thumb-520', $p->ID );
					if ( $show_alternate_title ) {
						$title = get_post_meta( $p->ID, 'sng_alternate_title', true ) ?: $title;
					}
					return array(
						'url'   => $url,
						'title' => $title,
						'src'   => $src,
					);
				},
				$posts
			);
			return json_decode( json_encode( $converted ) );
		},
	)
);
