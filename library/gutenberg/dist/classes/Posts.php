<?php

namespace SangoBlocks;

class Posts {
	function init() {}

	function get_posts_grid( $array_posts, $option ) {
		if ( ! $array_posts ) {
			return '';
		}
		$type              = $option['type'];
		$is_date           = $option['showDate'];
		$infeed            = $option['infeed'];
		$column            = $option['column'];
		$columnMobile      = $option['columnMobile'];
		$showCategory      = $option['showCategory'];
		$showNewLabel      = $option['showNewLabel'];
		$showAltenateTitle = $option['showAlternateTitle'];
		$showDate          = $option['showDate'];
		$ad                = get_theme_mod( 'ad_infeed' );
		$ad2               = get_theme_mod( 'ad_infeed2' );
		$ad3               = get_theme_mod( 'ad_infeed3' );
		$ad4               = get_theme_mod( 'ad_infeed4' );
		$ad_pos1           = get_theme_mod( 'ad_infeed_pos1', -1 );
		$ad_pos2           = get_theme_mod( 'ad_infeed_pos2', -1 );
		$ad_pos3           = get_theme_mod( 'ad_infeed_pos3', -1 );
		$ad_enabled        = get_theme_mod( 'enable_ad_infeed', false ) && $infeed;
		$ad_pos_array      = $ad_enabled ? array( $ad_pos1, $ad_pos2, $ad_pos3 ) : array();

		$output = '';
		switch ( $type ) {
			case 'card':
				$shown_count = 0;
				$class_name  = 'catpost-cards';
				if ( $column ) {
					$class_name .= " catpost-cards--column-{$column}";
				}
				if ( $columnMobile ) {
					$class_name .= " catpost-cards--column-mobile-{$columnMobile}";
				}
				foreach ( $array_posts as $i => $post ) {
					if ( $ad && is_numeric( array_search( $i + 1 + $shown_count, $ad_pos_array ) ) ) {
						++$shown_count;
						$output .= "<div class=\"c_linkto\">$ad</div>";
					}
					$output .= sng_card_link(
						array(
							'id'                 => $post->ID,
							'is_date'            => $is_date,
							'is_category'        => $showCategory,
							'is_new'             => $showNewLabel,
							'is_alternate_title' => $showAltenateTitle,
						)
					);
				}
				$output = '<div class="' . $class_name . '">' . $output . '</div>';
				break;
			case 'card2':
				$shown_count = 0;
				foreach ( $array_posts as $i => $post ) {
					if ( $ad3 && is_numeric( array_search( $i + 1 + $shown_count, $ad_pos_array ) ) ) {
						++$shown_count;
						$output .= "<div class=\"sidelong__article\">$ad3</div>";
					}
					$output .= sng_longcard_link(
						array(
							'id'                 => $post->ID,
							'is_alternate_title' => $showAltenateTitle,
							'is_date'            => $showDate,
							'is_category'        => $showCategory,
							'is_new'             => $showNewLabel,
						)
					);
				}
				break;
			case 'card3':
				$shown_count = 0;
				$class_name  = 'sidelong sidelong--shade';
				foreach ( $array_posts as $i => $post ) {
					if ( $ad2 && is_numeric( array_search( $i + 1 + $shown_count, $ad_pos_array ) ) ) {
						++$shown_count;
						$output .= "<div class=\"sidelong__article\">$ad2</div>";
					}
					$output .= sng_longcard_link_half(
						array(
							'id'                 => $post->ID,
							'is_alternate_title' => $showAltenateTitle,
							'is_date'            => $showDate,
							'is_category'        => $showCategory,
							'is_new'             => $showNewLabel,
						)
					);
				}
				$output = '<div class="' . $class_name . '">' . $output . '</div>';
				break;
			case 'card4':
				$shown_count = 0;
				$class_name  = 'catpost-cards catpost-cards--flat';
				if ( $column ) {
					$class_name .= " catpost-cards--column-{$column}";
				}
				if ( $columnMobile ) {
					$class_name .= " catpost-cards--column-mobile-{$columnMobile}";
				}
				foreach ( $array_posts as $i => $post ) {
					if ( $ad && is_numeric( array_search( $i + 1 + $shown_count, $ad_pos_array ) ) ) {
						++$shown_count;
						$output .= "<div class=\"c_linkto\">$ad</div>";
					}
					$output .= sng_card_link(
						array(
							'id'                 => $post->ID,
							'is_date'            => $is_date,
							'is_category'        => $showCategory,
							'is_new'             => $showNewLabel,
							'is_alternate_title' => $showAltenateTitle,
						)
					);
				}
				$output = '<div class="' . $class_name . '">' . $output . '</div>';
				break;
			default:
				foreach ( $array_posts as $post ) {
					$output .= sng_entry_link(
						array(
							'id'                 => $post->ID,
							'is_date'            => $is_date,
							'is_alternate_title' => $showAltenateTitle,
							'is_category'        => $showCategory,
							'is_new'             => $showNewLabel,
						)
					);
				}
		}
		return $output;
	}

	function get_posts_splide_slider( $array_posts, $option ) {
		$shown_count          = 0;
		$slidesToShow         = $option['slidesToShow'];
		$slidesToShowMobile   = $option['slidesToShowMobile'];
		$centerMode           = $option['centerMode'];
		$padding              = $centerMode ? "padding: '3rem', gap: '1rem'," : '';
		$align                = $option['align'];
		$infeed               = $option['showInfeed'];
		$arrows               = isset( $option['arrows'] ) ? var_export( $option['arrows'], true ) : 'true';
		$autoplay             = var_export( $option['autoplay'], true );
		$autoplay_speed       = $option['autoplaySpeed'] * 1000;
		$show_alternate_title = $option['showAlternateTitle'];
		$perMove              = $option['perMove'];
		$perMoveMobile        = $option['perMoveMobile'];
		$sliderEffect         = $option['sliderEffect'];
		$dots                 = var_export( $option['dots'], true );
		$ad5                  = get_theme_mod( 'ad_infeed5' );
		$ad_pos1              = get_theme_mod( 'ad_infeed_pos1', -1 );
		$ad_pos2              = get_theme_mod( 'ad_infeed_pos2', -1 );
		$ad_pos3              = get_theme_mod( 'ad_infeed_pos3', -1 );
		$ad_enabled           = get_theme_mod( 'enable_ad_infeed', false ) && $infeed;
		$ad_pos_array         = $ad_enabled ? array( $ad_pos1, $ad_pos2, $ad_pos3 ) : array();
		$output               = '';
		$id                   = wp_unique_id( 'sgb-splide-id' );
		$js                   = <<< EOM
    sng.domReady(() => {
      const splide = new Splide("#$id .js-sng-splide", {
        $padding
        type: "$sliderEffect",
        rewind: true,
        autoplay: $autoplay,
        pagination: $dots,
        perPage: $slidesToShow,
        arrows:  $arrows,
        interval: $autoplay_speed,
        perMove: $perMove,
        breakpoints: {
          768: {
            perPage: $slidesToShowMobile,
            perMove: $perMoveMobile,
          }
        }
      })
      splide.mount();
    });
EOM;
		App::get( 'js' )->register( $id, $js, false );
		foreach ( $array_posts as $i => $post ) {
			if ( $ad5 && is_numeric( array_search( $i + 1 + $shown_count, $ad_pos_array ) ) ) {
				++$shown_count;
				$output .= "<li>$ad5</li>";
			}
			list($url, $title, $_img, $_date) = sng_get_entry_link_data( $post->ID, 'thumb-520', true );
			if ( $show_alternate_title ) {
				$title = get_post_meta( $post->ID, 'sng_alternate_title', true ) ?: $title;
			}
			$src = featured_image_src( 'thumb-520', $post->ID );
			$img = '<img data-lazy="' . $src . '" src="' . $src . '" alt="' . $title . '" width="520" height="300" >';
			ob_start();
			?>
		<div class="splide__slide">
		<a href="<?php echo $url; ?>">
			<figure class="rlmg">
			<?php echo $img; ?>
			</figure>
			<div class="rep"><p><?php echo $title; ?></p></div>
		</a>
		</div>
			<?php
			$slide  = ob_get_contents();
			$output = $output . apply_filters( 'sng_post_splide', $slide, $post->ID );
			ob_end_clean();
		}
		$output = "<div class=\"related-posts align$align\" id=\"$id\">
      <div class=\"js-sng-splide splide\">
        <div class=\"splide__track\">
          <div class=\"splide__list\">
            $output
          </div>
        </div>
      </div>
    </div>";

		return $output;
	}

	function get_posts_slider( $array_posts, $option ) {
		$shown_count          = 0;
		$slidesToShow         = $option['slidesToShow'];
		$slidesToShowMobile   = $option['slidesToShowMobile'];
		$centerMode           = var_export( $option['centerMode'], true );
		$align                = $option['align'];
		$infeed               = $option['showInfeed'];
		$arrows               = var_export( $option['arrows'], true );
		$autoplay             = var_export( $option['autoplay'], true );
		$autoplay_speed       = $option['autoplaySpeed'] * 1000;
		$show_alternate_title = $option['showAlternateTitle'];
		$dots                 = var_export( $option['dots'], true );
		$perMove              = $option['perMove'];
		$perMoveMobile        = $option['perMoveMobile'];
		$ad5                  = get_theme_mod( 'ad_infeed5' );
		$ad_pos1              = get_theme_mod( 'ad_infeed_pos1', -1 );
		$ad_pos2              = get_theme_mod( 'ad_infeed_pos2', -1 );
		$ad_pos3              = get_theme_mod( 'ad_infeed_pos3', -1 );
		$ad_enabled           = get_theme_mod( 'enable_ad_infeed', false ) && $infeed;
		$ad_pos_array         = $ad_enabled ? array( $ad_pos1, $ad_pos2, $ad_pos3 ) : array();
		$output               = '';

		foreach ( $array_posts as $i => $post ) {
			if ( $ad5 && is_numeric( array_search( $i + 1 + $shown_count, $ad_pos_array ) ) ) {
				++$shown_count;
				$output .= "<li>$ad5</li>";
			}
			list($url, $title, $_img, $_date) = sng_get_entry_link_data( $post->ID, 'thumb-520', true );
			if ( $show_alternate_title ) {
				$title = get_post_meta( $post->ID, 'sng_alternate_title', true ) ?: $title;
			}
			$src = featured_image_src( 'thumb-520', $post->ID );
			$img = '<img data-lazy="' . $src . '" src="' . $src . '" alt="' . $title . '" width="520" height="300" >';
			ob_start();
			?>
		<li>
		<a href="<?php echo $url; ?>">
			<figure class="rlmg">
			<?php echo $img; ?>
			</figure>
			<div class="rep"><p><?php echo $title; ?></p></div>
		</a>
		</li>
			<?php
			$output .= ob_get_contents();
			ob_end_clean();
		}
		$output = "<div class=\"related-posts type_a slide block-posts align$align\"><div class=\"js-sng-post-slider\" data-slick='{ \"slidesToShow\": $slidesToShow, \"dots\": $dots, \"arrows\": $arrows, \"autoplay\": $autoplay, \"autoplaySpeed\": $autoplay_speed, \"centerMode\": $centerMode, \"slidesToScroll\": $perMove, \"responsive\": [{\"breakpoint\":768,\"settings\":{\"slidesToShow\": $slidesToShowMobile, \"slidesToScroll\": $perMoveMobile }}]}'>$output</div></div>";
		return $output;
	}
	function get_posts_related( $array_posts, $option ) {
		$ad4                  = get_theme_mod( 'ad_infeed4' );
		$infeed               = $option['showInfeed'];
		$ad_pos1              = get_theme_mod( 'ad_infeed_pos1', -1 );
		$ad_pos2              = get_theme_mod( 'ad_infeed_pos2', -1 );
		$ad_pos3              = get_theme_mod( 'ad_infeed_pos3', -1 );
		$ad_enabled           = get_theme_mod( 'enable_ad_infeed', false ) && $infeed;
		$ad_pos_array         = $ad_enabled ? array( $ad_pos1, $ad_pos2, $ad_pos3 ) : array();
		$show_alternate_title = $option['showAlternateTitle'];
		$shown_count          = 0;
		$output               = '';

		foreach ( $array_posts as $i => $post ) {
			if ( $ad4 && is_numeric( array_search( $i + 1 + $shown_count, $ad_pos_array ) ) ) {
				++$shown_count;
				$output .= "<li>$ad4</li>";
			}
			list($url, $title, $img, $date) = sng_get_entry_link_data( $post->ID, 'thumb-520', true );
			if ( $show_alternate_title ) {
				$title = get_post_meta( $post->ID, 'sng_alternate_title', true ) ?: $title;
			}
			ob_start();
			?>
		<li>
		<a href="<?php echo $url; ?>">
			<figure class="rlmg">
			<?php echo $img; ?>
			</figure>
			<div class="rep"><p><?php echo $title; ?></p></div>
		</a>
		</li>
			<?php
			$output .= ob_get_contents();
			ob_end_clean();
		}
		$output = "<div class=\"related-posts type_a slide block-posts\"><ul>$output</ul></div>";
		return $output;
	}
	function get_posts_side( $array_posts, $option ) {
		$shown_count          = 0;
		$show_num             = $option['showNum'];
		$show_views           = $option['showViews'];
		$heading_title        = $option['headingTitle'];
		$heading_icon         = $option['headingIcon'];
		$heading_center       = $option['headingCenter'];
		$heading_bg_color     = $option['headingBgColor'];
		$heading_color        = $option['headingColor'];
		$hide_heading         = $option['hideHeading'];
		$show_date            = $option['showDate'];
		$show_alternate_title = $option['showAlternateTitle'];
		$output               = '';

		foreach ( $array_posts as $i => $post ) {
			list($url, $title, $img, $date) = sng_get_entry_link_data( $post->ID, 'thumb-520', true );
			if ( $show_alternate_title ) {
				$title = get_post_meta( $post->ID, 'sng_alternate_title', true ) ?: $title;
			}
			ob_start();
			?>
		<li>
			<?php
			if ( $show_num ) {
				++$i;
				if ( $i <= 3 ) {
					echo '<span class="rank dfont accent-bc">' . $i . '</span>';
				} else {
					echo '<span class="rank dfont">' . $i . '</span>';
				}
			}
			?>
		<a href="<?php echo $url; ?>">
			<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
			<figure class="my-widget__img">
				<img width="160" height="160" src="<?php echo get_the_post_thumbnail_url( $post->ID, 'thumb-160' ); ?>" alt="<?php echo $post->post_title; ?>" <?php sng_lazy_attr(); ?>>
			</figure>
			<?php elseif ( get_option( 'show_default_thumb_on_widget_posts' ) ) : ?>
			<figure class="my-widget__img">
				<img width="160" height="160" src="<?php echo featured_image_src( 'thumb-160', $post->ID ); ?>" <?php sng_lazy_attr(); ?>>
			</figure>
			<?php else : ?>
			<figure class="my-widget__img">
				<img width="160" height="160" src="<?php echo featured_image_src( 'thumb-160' ); ?>" alt="<?php echo $post->post_title; ?>" <?php sng_lazy_attr(); ?>>
			</figure>
			<?php endif; ?>
			<div class="my-widget__text">
			<?php echo $title; ?>
			<?php
			if ( $show_views ) {
				echo '<span class="dfont views">' . get_post_meta( $post->ID, 'post_views_count', true ) . ' views</span>';}
			?>
			<?php
			if ( $show_date ) {
				echo '<span class="dfont post-date">' . get_the_time( get_option( 'date_format' ), $post->ID ) . '</span>';}
			?>
			</div>
		</a>
		</li>
			<?php
			$output .= ob_get_contents();
			ob_end_clean();
		}
		$additional_class = $show_num ? 'show_num' : '';
		$title            = '';
		if ( $heading_title && ! $hide_heading ) {
			$center = $heading_center ? 'sgb-post-side__title--center' : '';
			$style  = $heading_color || $heading_bg_color ? "style=\"background-color: $heading_bg_color; color: $heading_color;\"" : '';
			$icon   = $heading_icon ? "<i class=\"$heading_icon\"></i>" : '';
			$title  = "<h4 class=\"sgb-post-side__title $center\" $style>{$icon}{$heading_title}</h4>";
		}
		$output = "<div class=\"widget my_popular_posts $additional_class\">$title<ul class=\"my-widget\">$output</ul></div>";
		return $output;
	}

	function get_block_posts( $option ) {
		$query                 = array();
		$favorites             = array();
		$views                 = array();
		$number_of_items       = $option['number_of_items'];
		$order                 = $option['order'];
		$order_by              = $option['order_by'];
		$skip_items            = $option['skip_items'];
		$include_children      = $option['include_children'];
		$cats                  = $option['cats'];
		$tags                  = $option['tags'];
		$pickups               = $option['pickups'];
		$manual_pickup         = $option['manual_pickup'];
		$show_current_category = $option['show_current_category'];
		$post_type             = $option['post_type'];
		$post_id               = isset( $option['post_id'] ) ? $option['post_id'] : false;
		$taxonomies            = $option['taxonomies'];
		if ( ! $manual_pickup && $order_by !== 'views' && $order_by !== 'favorite' ) {
			$query = array(
				'post_type'   => $post_type,
				'post_status' => 'publish',
				'numberposts' => $number_of_items,
				'order'       => $order,
			);
			if ( count( $taxonomies ) > 0 ) {
				// $query = array_merge($query, array(
				// 'tax_query' => array(
				// 'relation' => 'OR',
				// ),
				// ));
				$query['tax_query'] = array();
				foreach ( $taxonomies as $taxonomy ) {
					$query['tax_query'][] = array(
						'taxonomy' => $taxonomy['taxonomy'],
						'field'    => 'slug',
						'terms'    => $taxonomy['terms'],
					);
				}
			}
			if ( $order_by === 'popular' ) {
				$query = array_merge(
					$query,
					array(
						'meta_key' => 'post_views_count',
						'orderby'  => 'meta_value_num',
					)
				);
			} else {
				$query = array_merge(
					$query,
					array(
						'orderby' => $order_by,
					)
				);
			}
			if ( $skip_items > 0 ) {
				$query = array_merge(
					$query,
					array(
						'offset' => $skip_items,
					)
				);
			}
			if ( $show_current_category ) {
				if ( isset( get_the_category( $post_id )[0] ) ) {
					$cat_array = get_the_category( $post_id );
					$cats      = array_map(
						function ( $cat ) {
							return $cat->term_id;
						},
						$cat_array
					);
				}
			} else {
				// 子カテゴリを含める（オプション）
				if ( count( $cats ) > 0 && $include_children ) {
					foreach ( $cats as $parent_id ) {
						$child_ids = get_term_children( $parent_id, 'category' );
						$cats      = array_merge( $cats, $child_ids );
					}
				}
			}
			if ( count( $cats ) > 0 ) {
				$query = array_merge(
					$query,
					array(
						'category__in' => $cats,
					)
				);
			}
			if ( count( $tags ) > 0 ) {
				$query = array_merge(
					$query,
					array(
						'tag__in' => $tags,
					)
				);
			}
		} elseif ( $order_by === 'views' ) {
			$viewsString = isset( $_COOKIE['sgb_post_view'] ) ? $_COOKIE['sgb_post_view'] : '';
			if ( ! $viewsString ) {
				return array();
			}
			$views = explode( ',', $viewsString );
			if ( $order === 'DESC' ) {
				$views = array_reverse( $views );
			}
			$query = array(
				'post_type'   => $post_type,
				'post_status' => 'publish',
				'post__in'    => $views,
				'numberposts' => $number_of_items,
			);
		} elseif ( $order_by === 'favorite' ) {
			$favoritesString = isset( $_COOKIE['sgb_post_favorite'] ) ? $_COOKIE['sgb_post_favorite'] : '';
			if ( ! $favoritesString ) {
				return array();
			}
			$favorites = explode( ',', $favoritesString );
			if ( $order === 'DESC' ) {
				$favorites = array_reverse( $favorites );
			}
			$query = array(
				'post_type'   => $post_type,
				'post_status' => 'publish',
				'post__in'    => $favorites,
				'numberposts' => $number_of_items,
			);
		} else {
			if ( ! $pickups ) {
				return array();
			}
			$query = array(
				'post_type'   => $post_type,
				'post_status' => 'publish',
				'post__in'    => $pickups,
				'numberposts' => count( $pickups ),
			);
		}
		$posts = get_posts( $query );
		if ( $manual_pickup ) {
			// ここでピックアップ順にpostsをソート
			usort(
				$posts,
				function ( $a, $b ) use ( $pickups ) {
					$index_a = array_search( strval( $a->ID ), $pickups );
					$index_b = array_search( strval( $b->ID ), $pickups );
					return $index_a >= $index_b ? 1 : -1;
				}
			);
		} elseif ( $order_by === 'views' ) {
			// ここで閲覧数順にpostsをソート
			usort(
				$posts,
				function ( $a, $b ) use ( $views ) {
					$index_a = array_search( strval( $a->ID ), $views );
					$index_b = array_search( strval( $b->ID ), $views );
					return $index_a >= $index_b ? 1 : -1;
				}
			);
		} elseif ( $order_by === 'favorite' ) {
			// ここでお気に入り順にpostsをソート
			usort(
				$posts,
				function ( $a, $b ) use ( $favorites ) {
					$index_a = array_search( strval( $a->ID ), $favorites );
					$index_b = array_search( strval( $b->ID ), $favorites );
					return $index_a >= $index_b ? 1 : -1;
				}
			);
		}
		return $posts;
	}
}
