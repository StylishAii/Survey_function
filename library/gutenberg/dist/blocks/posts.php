<?php

use SangoBlocks\App;

register_block_type(
	'sgb/posts',
	array(
		'editor_script'   => 'sgb',
		'attributes'      => array(
			'layoutName'          => array(
				'type'    => 'string',
				'default' => 'card',
			),
			'numberOfItems'       => array(
				'type'    => 'number',
				'default' => 6,
			),
			'skipItems'           => array(
				'type'    => 'number',
				'default' => 0,
			),
			'orderBy'             => array(
				'type'    => 'string',
				'default' => 'date',
			),
			'order'               => array(
				'type'    => 'string',
				'default' => 'DESC',
			),
			'showSideDate'        => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'showDate'            => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'countSpan'           => array(
				'type'    => 'number',
				'default' => 7,
			),
			'categories'          => array(
				'type'    => 'array',
				'default' => array(),
				'items'   => array(
					'type' => 'number',
				),
			),
			'includeChildren'     => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'tags'                => array(
				'type'    => 'array',
				'default' => array(),
				'items'   => array(
					'type' => 'number',
				),
			),
			'css'                 => array(
				'type'    => 'string',
				'default' => '',
			),
			'js'                  => array(
				'type'    => 'string',
				'default' => '',
			),
			'scopedCSS'           => array(
				'type'    => 'string',
				'default' => '',
			),
			'adminCSS'            => array(
				'type'    => 'string',
				'default' => '',
			),
			'disableCSSAlert'     => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'customControls'      => array(
				'type'    => 'array',
				'default' => array(),
			),
			'blockId'             => array(
				'type'    => 'string',
				'default' => '',
			),
			'sharedId'            => array(
				'type'    => 'string',
				'default' => '',
			),
			'showInfeed'          => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'manualPickup'        => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'pickups'             => array(
				'type'    => 'array',
				'default' => array(),
			),
			'slidesToShow'        => array(
				'type'    => 'number',
				'default' => 3,
			),
			'slidesToShowMobile'  => array(
				'type'    => 'number',
				'default' => 3,
			),
			'dots'                => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'arrows'              => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'align'               => array(
				'type'    => 'string',
				'default' => 'wide',
			),
			'centerMode'          => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'autoplay'            => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'autoplaySpeed'       => array(
				'type'    => 'number',
				'default' => 3,
			),
			'postType'            => array(
				'type'    => 'string',
				'default' => 'post',
			),
			'showNum'             => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'showViews'           => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'headingTitle'        => array(
				'type'    => 'string',
				'default' => '',
			),
			'headingIcon'         => array(
				'type'    => 'string',
				'default' => '',
			),
			'headingBgColor'      => array(
				'type'    => 'string',
				'default' => '',
			),
			'headingColor'        => array(
				'type'    => 'string',
				'default' => '',
			),
			'hideHeading'         => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'headingCenter'       => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'spaceBottom'         => array(
				'type'    => 'number',
				'default' => 0,
			),
			'mobileSpaceBottom'   => array(
				'type'    => 'number',
				'default' => 0,
			),
			'spaceBottomType'     => array(
				'type'    => 'string',
				'default' => 'em',
			),
			'column'              => array(
				'type'    => 'number',
				'default' => 2,
			),
			'columnMobile'        => array(
				'type'    => 'number',
				'default' => 1,
			),
			'showCategory'        => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'showNewLabel'        => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'showAlternateTitle'  => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'showDate'            => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'showCurrentCategory' => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'sliderType'          => array(
				'type'    => 'string',
				'default' => 'slick',
			),
			'customTaxonomies'    => array(
				'type'    => 'array',
				'default' => array(),
			),
			'perMove'             => array(
				'type'    => 'number',
				'default' => 1,
			),
			'perMoveMobile'       => array(
				'type'    => 'number',
				'default' => 1,
			),
			'sliderEffect'        => array(
				'type'    => 'string',
				'default' => 'loop',
			),
			'notFoundMessage'     => array(
				'type'    => 'string',
				'default' => '',
			),
		),
		'render_callback' => function ( $attributes ) {
			$style_name = $attributes['layoutName'];
			$number_of_items = $attributes['numberOfItems'];
			$skip_items = $attributes['skipItems'];
			$order = $attributes['order'];
			$order_by = $attributes['orderBy'];
			$show_side_date = $attributes['showSideDate'];
			$show_num = $attributes['showNum'];
			$show_views = $attributes['showViews'];
			$cats = $attributes['categories'];
			$include_children = $attributes['includeChildren'];
			$show_infeed = $attributes['showInfeed'];
			$tags = $attributes['tags'];
			$manual_pickup = $attributes['manualPickup'];
			$pickups = $attributes['pickups'];
			$slides_to_show = $attributes['slidesToShow'];
			$slides_to_show_mobile = $attributes['slidesToShowMobile'];
			$center_mode = $attributes['centerMode'];
			$align = $attributes['align'];
			$dots = $attributes['dots'];
			$arrows = $attributes['arrows'];
			$autoplay = $attributes['autoplay'];
			$autoplay_speed = $attributes['autoplaySpeed'];
			$post_type = $attributes['postType'];
			$heading_title = $attributes['headingTitle'];
			$heading_icon = $attributes['headingIcon'];
			$heading_center = $attributes['headingCenter'];
			$heading_bg_color = $attributes['headingBgColor'];
			$heading_color = $attributes['headingColor'];
			$hide_heading = $attributes['hideHeading'];
			$column = $attributes['column'];
			$columnMobile = $attributes['columnMobile'];
			$showCategory = $attributes['showCategory'];
			$showNewLabel = $attributes['showNewLabel'];
			$showAlternateTitle = $attributes['showAlternateTitle'];
			$showDate = $attributes['showDate'];
			$showCurrentCategory = $attributes['showCurrentCategory'];
			$sliderType = $attributes['sliderType'];
			$customTaxonomies = $attributes['customTaxonomies'];
			$perMove = $attributes['perMove'];
			$perMoveMobile = $attributes['perMoveMobile'];
			$sliderEffect = $attributes['sliderEffect'];
			$notFoundMessage = $attributes['notFoundMessage'];
			$post = App::get( 'posts' );
			$posts = $post->get_block_posts(
				array(
					'skip_items'            => $skip_items,
					'order'                 => $order,
					'order_by'              => $order_by,
					'cats'                  => $cats,
					'tags'                  => $tags,
					'show_current_category' => $showCurrentCategory,
					'include_children'      => $include_children,
					'manual_pickup'         => $manual_pickup,
					'pickups'               => $pickups,
					'number_of_items'       => $number_of_items,
					'post_type'             => ! $post_type ? array( 'post', 'page' ) : $post_type,
					// 'taxonomies' => array()
					'taxonomies'            => $customTaxonomies,
				)
			);
			if ( count( $posts ) === 0 ) {
				if ( is_user_logged_in() ) {
					return '<div style="background-color: #ffebeb; padding: 10px 20px;">（管理者にのみ表示）表示する記事がありません。</div>';
				}
				return apply_filters( 'sng_notfound_posts', $notFoundMessage );
			}
			if ( $style_name === 'slider' ) {
				if ( $sliderType === 'slick' ) {
					$result = App::get( 'posts' )->get_posts_slider(
						$posts,
						array(
							'slidesToShow'       => $slides_to_show,
							'slidesToShowMobile' => $slides_to_show_mobile,
							'showInfeed'         => $show_infeed,
							'dots'               => $dots,
							'arrows'             => $arrows,
							'align'              => $align,
							'centerMode'         => $center_mode,
							'autoplay'           => $autoplay,
							'autoplaySpeed'      => $autoplay_speed,
							'showAlternateTitle' => $showAlternateTitle,
							'perMove'            => $perMove,
							'perMoveMobile'      => $perMoveMobile,
						)
					);
				} elseif ( $sliderType === 'splide' ) {
					$result = App::get( 'posts' )->get_posts_splide_slider(
						$posts,
						array(
							'slidesToShow'       => $slides_to_show,
							'slidesToShowMobile' => $slides_to_show_mobile,
							'showInfeed'         => $show_infeed,
							'dots'               => $dots,
							'arrows'             => $arrows,
							'align'              => $align,
							'centerMode'         => $center_mode,
							'autoplay'           => $autoplay,
							'autoplaySpeed'      => $autoplay_speed,
							'showAlternateTitle' => $showAlternateTitle,
							'perMove'            => $perMove,
							'perMoveMobile'      => $perMoveMobile,
							'sliderEffect'       => $sliderEffect,
						)
					);
				}
				// deprecated
			} elseif ( $style_name === 'related' ) {
				$result = App::get( 'posts' )->get_posts_related(
					$posts,
					array(
						'showInfeed'         => $show_infeed,
						'showAlternateTitle' => $showAlternateTitle,
					)
				);
			} elseif ( $style_name === 'side' ) {
				$result = App::get( 'posts' )->get_posts_side(
					$posts,
					array(
						'showNum'            => $show_num,
						'showViews'          => $show_views,
						'showDate'           => $show_side_date,
						'headingTitle'       => $heading_title,
						'headingIcon'        => $heading_icon,
						'headingCenter'      => $heading_center,
						'headingBgColor'     => $heading_bg_color,
						'headingColor'       => $heading_color,
						'hideHeading'        => $hide_heading,
						'showAlternateTitle' => $showAlternateTitle,
					)
				);
			} else {
				$result = App::get( 'posts' )->get_posts_grid(
					$posts,
					array(
						'type'               => $style_name,
						'infeed'             => $show_infeed,
						'showViews'          => $show_views,
						'showDate'           => $showDate,
						'showCategory'       => $showCategory,
						'showNewLabel'       => $showNewLabel,
						'column'             => $column,
						'columnMobile'       => $columnMobile,
						'showAlternateTitle' => $showAlternateTitle,
					)
				);
			}
			return $result;
		},
	)
);

function sng_posts_slider_render( $block_content, $block ) {
	if ( isset( $block['blockName'] ) && $block['blockName'] === 'sgb/posts' && isset( $block['attrs']['layoutName'] ) && $block['attrs']['layoutName'] === 'slider' ) {
		if ( isset( $block['attrs']['sliderType'] ) && $block['attrs']['sliderType'] === 'splide' ) {
			wp_enqueue_style( 'splide-style', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/css/themes/splide-default.min.css' );
			wp_enqueue_script(
				'sng-splide', // Handle.
				'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/js/splide.min.js'
			);
		} else {
			wp_enqueue_style( 'slick-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css' );
			wp_enqueue_style( 'slick-theme-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css' );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script(
				'sng-slick', // Handle.
				'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js'
			);
		}
	}
	return $block_content;
}

add_filter( 'render_block', 'sng_posts_slider_render', 10, 2 );
