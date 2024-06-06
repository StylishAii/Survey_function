<?php

use SANGO\App;

register_block_type(
	'sgb/content-block',
	array(
		'editor_script'   => 'sgb',
		'attributes'      => array(
			'contentBlockId'    => array(
				'type'    => 'number',
				'default' => -1,
			),
			'className'         => array(
				'type'    => 'string',
				'default' => '',
			),
			'css'               => array(
				'type'    => 'string',
				'default' => '',
			),
			'js'                => array(
				'type'    => 'string',
				'default' => '',
			),
			'scopedCSS'         => array(
				'type'    => 'string',
				'default' => '',
			),
			'adminCSS'          => array(
				'type'    => 'string',
				'default' => '',
			),
			'disableCSSAlert'   => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'customControls'    => array(
				'type'    => 'array',
				'default' => array(),
			),
			'sharedId'          => array(
				'type'    => 'string',
				'default' => '',
			),
			'blockId'           => array(
				'type'    => 'string',
				'default' => '',
			),
			'sharedId'          => array(
				'type'    => 'string',
				'default' => '',
			),
			'hideOnTop'         => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'hideCategories'    => array(
				'type'    => 'array',
				'default' => array(),
			),
			'spaceBottom'       => array(
				'type'    => 'number',
				'default' => 0,
			),
			'mobileSpaceBottom' => array(
				'type'    => 'number',
				'default' => 0,
			),
			'spaceBottomType'   => array(
				'type'    => 'string',
				'default' => 'em',
			),
		),
		'render_callback' => function ( $attributes ) {
			global $post;
			$cb = App::get( 'content-block' );
			$id = $attributes['contentBlockId'];
			$class_name = $attributes['className'];
			$hide_on_top = $attributes['hideOnTop'];
			$hide_categories = $attributes['hideCategories'];
			$content = $cb->get_content_block( $id, $class_name );
			$cat = get_query_var( 'cat' );
			$status = \SANGO\App::get( 'status' )->get_status();

			if ( is_admin() ) {
				return '';
			}

			// トップページの場合
			if ( $status['is_top'] && ! $status['is_paged'] ) {
				if ( $hide_on_top ) {
					return '';
				}
			}

			// カテゴリーページの場合
			if ( $cat ) {
				$category = get_category( $cat );
				foreach ( $hide_categories as $hide_category ) {
					if ( isset( $category->cat_ID ) && strval( $hide_category ) === strval( $category->cat_ID ) ) {
						return '';
					}
				}
				// 記事ページの場合
			} else {
				$categories = get_the_category();
				foreach ( $categories as $category ) {
					foreach ( $hide_categories as $hide_category ) {
						if ( strval( $hide_category ) === strval( $category->term_id ) ) {
								return '';
						}
					}
				}
			}
			return "<div class=\"{$class_name}\">$content</div>";
		},
	)
);
