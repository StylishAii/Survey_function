<?php
/**
 * このファイルではウィジェットについての設定をしています。
 * 最新記事のウィジェットにアイキャッチ画像を追加
 * カテゴリー/アーカイブウィジェトtなどに表示される「記事数」の出力スタイル変更
 * 人気記事ウィジェットの設定（アクセスカウント＆ウィジェット出力のための関数）
 */
use SANGO\App;
/*********************
 * 最新記事ウィジェットにアイキャッチ画像を追加
 *********************/
class My_Recent_Posts_Widget extends WP_Widget_Recent_Posts {
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		$title  = ( ! empty( $instance['title'] ) ) ? $instance['title'] : 'Recent Posts';
		$title  = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$getposts  = new WP_Query(
			apply_filters(
				'widget_posts_args',
				array(
					'posts_per_page'      => $number,
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
				)
			)
		);
		if ( $getposts->have_posts() ) {
			echo $args['before_widget'];
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			?>
	<ul class="my-widget">
			<?php
			while ( $getposts->have_posts() ) :
				$getposts->the_post();
				?>
		<li>
		<a href="<?php the_permalink(); ?>">
				<?php if ( has_post_thumbnail() ) : ?>
			<figure class="my-widget__img">
				<img width="160" height="160" src="<?php the_post_thumbnail_url( 'thumb-160' ); ?>" alt="<?php the_title(); ?>" <?php sng_lazy_attr(); ?>>
			</figure>
			<?php elseif ( get_option( 'show_default_thumb_on_widget_posts' ) ) : ?>
			<figure class="my-widget__img">
				<img width="160" height="160" src="<?php echo featured_image_src( 'thumb-160' ); ?>" <?php sng_lazy_attr(); ?>>
			</figure>
			<?php endif; ?>
			<div class="my-widget__text"><?php the_title(); ?>
				<?php if ( $show_date ) : ?>
			<span class="post-date dfont"><?php the_time( get_option( 'date_format' ) ); ?></span>
			<?php endif; ?></div>
		</a>
		</li>
	<?php endwhile; ?>
	</ul>
			<?php echo $args['after_widget']; ?>
			<?php
			wp_reset_postdata();
		}
	} // END public function widget
}

function sng_add_img_to_recent_posts() {
	unregister_widget( 'WP_Widget_Recent_Posts' );
	register_widget( 'My_Recent_Posts_Widget' );
}
add_action( 'widgets_init', 'sng_add_img_to_recent_posts' );
// END 最新記事一覧にアイキャッチ画像を追加

/*********************
 * サイドバーのカテゴリー/アーカイブの数の表示を変更
 *********************/
// カテゴリー
function optimize_entry_count( $default, $args ) {
	$replaced = preg_replace( '/<\/a> \(([0-9,]*)\)/', ' <span class="entry-count dfont">${1}</span></a>', $default );
	if ( $replaced ) {
		return $replaced;
	} else {
		return $default;
	}
}
add_filter( 'wp_list_categories', 'optimize_entry_count', 10, 2 );

// アーカイブ
function optimize_entry_count_archive( $default ) {
	$replaced = preg_replace( '/<\/a>&nbsp;\(([0-9,]*)\)/', ' <span class="entry-count">${1}</span></a>', $default );
	if ( $replaced ) {
		return $replaced;
	} else {
		return $default;
	}
}
add_filter( 'get_archives_link', 'optimize_entry_count_archive', 10, 2 );

/*******************************
 * 人気記事ウィジェット
 */
// single.phpの最下部でアクセス数のカウントを実行しています。
// アクセス数を取得する（PV数を出力したいときにはこの関数を使用）
if ( ! function_exists( 'sng_get_post_views' ) ) {
	function sng_get_post_views( $postID ) {
		$count_key = 'post_views_count';
		$num       = get_post_meta( $postID, $count_key, true );
		if ( $num == '' ) {
			delete_post_meta( $postID, $count_key );
			add_post_meta( $postID, $count_key, '0' );
			return '0';
		}
		return $num . '';
	}
}

// アクセス数を保存する
if ( ! function_exists( 'sng_set_post_views' ) ) {
	function sng_set_post_views( $postID ) {
		if ( is_bot() ) {
			return;
		}
		if ( is_user_logged_in() ) {
			return;
		}
		add_action(
			'wp_footer',
			function () use ( $postID ) {
				$site_url = site_url();
				$url      = "{$site_url}/?rest_route=/sng/v1/page-count";
				$script   = <<< EOM
    sng.domReady(() => {
      fetch("{$url}",{
        method: 'POST',
        body: JSON.stringify({
          post_id: {$postID}
        }),
      })
    });
    EOM;
				App::get( 'js' )->register( 'post-views', $script );
			},
			999
		);
	}
}

if ( ! function_exists( 'sng_get_popular_posts' ) ) {
	function sng_get_popular_posts( $num = 6 ) {
		return get_posts(
			array(
				'post_type'   => 'any',
				'numberposts' => $num,
				'meta_key'    => 'post_views_count',
				'orderby'     => 'meta_value_num',
				'order'       => 'DESC',
			// 'exclude' => '' // ランキングから除外する投稿ID
			)
		);
	}
}

// 人気記事ウィジェット
class myPopularPosts extends WP_Widget {

	public function __construct() {
		parent::__construct( false, $name = '【SANGO】人気記事' );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title      = apply_filters( 'widget_title', $instance['title'] );
		$entry_num  = apply_filters( 'widget_body', $instance['count'] );
		$show_num   = apply_filters( 'widget_checkbox', $instance['show_num'] );
		$show_views = apply_filters( 'widget_checkbox', $instance['show_views'] );
		$posts      = sng_get_popular_posts( $entry_num );
		if ( ! $posts ) {
			return;
		}
		?>
	<div class="widget my_popular_posts">
		<?php
		if ( $title ) {
			echo $before_title . $title . $after_title;}
		?>
	<ul class="my-widget 
		<?php
		if ( $show_num ) {
			$i = 1;
			echo 'show_num'; }
		?>
	">
		<?php foreach ( $posts as $post ) : ?>
		<li>
			<?php
			if ( $show_num ) {
				if ( $i <= 3 ) {
					echo '<span class="rank dfont accent-bc">' . $i . '</span>';
				} else {
					echo '<span class="rank dfont">' . $i . '</span>';
				}
				++$i;
			}
			?>
		<a href="<?php echo get_permalink( $post->ID ); ?>">
			<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
			<figure class="my-widget__img">
				<img width="160" height="160" src="<?php echo get_the_post_thumbnail_url( $post->ID, 'thumb-160' ); ?>" alt="<?php echo $post->post_title; ?>" <?php sng_lazy_attr(); ?>>
			</figure>
			<?php elseif ( get_option( 'show_default_thumb_on_widget_posts' ) ) : ?>
			<figure class="my-widget__img">
				<img width="160" height="160" src="<?php echo featured_image_src( 'thumb-160', $post->ID ); ?>" <?php sng_lazy_attr(); ?>>
			</figure>
			<?php endif; ?>
			<div class="my-widget__text">
			<?php echo $post->post_title; ?>
			<?php
			if ( $show_views ) {
				echo '<span class="dfont views">' . get_post_meta( $post->ID, 'post_views_count', true ) . ' views</span>';}
			?>
			</div>
		</a>
		</li>
		<?php endforeach; ?>
		<?php wp_reset_postdata(); ?>
	</ul>
	</div>
		<?php
	} // END public function widget

	public function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance['title']      = strip_tags( $new_instance['title'] );
		$instance['count']      = $new_instance['count'];
		$instance['show_num']   = $new_instance['show_num'];
		$instance['show_views'] = $new_instance['show_views'];
		return $instance;
	} // END public function update

	public function form( $instance ) {
		$title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$entry_num  = isset( $instance['count'] ) ? $instance['count'] : '';
		$show_num   = isset( $instance['show_num'] ) ? $instance['show_num'] : '';
		$show_views = isset( $instance['show_views'] ) ? $instance['show_views'] : '';
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">タイトル:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>">表示する記事数</label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="number" step="1" min="1" value="<?php echo $entry_num; ?>" size="3">
		</p>
		<p>
		<input id="<?php echo $this->get_field_id( 'show_num' ); ?>" name="<?php echo $this->get_field_name( 'show_num' ); ?>" type="checkbox" value="1" <?php checked( $show_num, 1 ); ?>/>
		<label for="<?php echo $this->get_field_id( 'show_num' ); ?>">順位を表示する</label>
		</p>
		<p>
		<input id="<?php echo $this->get_field_id( 'show_views' ); ?>" name="<?php echo $this->get_field_name( 'show_views' ); ?>" type="checkbox" value="1" <?php checked( $show_views, 1 ); ?>/>
		<label for="<?php echo $this->get_field_id( 'show_views' ); ?>">累計閲覧数を表示</label>
		</p>
		<?php
	} // END public function form
}
add_action(
	'widgets_init',
	function () {
		register_widget( 'myPopularPosts' );
	}
);
// END 人気記事ウィジェット

// 広告ウィジェット
class SANGO_AdWidget extends WP_Widget {
	public function __construct() {
		parent::__construct( false, $name = '【SANGO】広告' );
	}
	public function widget( $args, $instance ) {
		global $post;
		$ads             = isset( $instance['ads'] ) ? $instance['ads'] : '';
		$hide_ads_on_404 = isset( $instance['hide_ads_on_404'] ) ? esc_attr( $instance['hide_ads_on_404'] ) : '';
		$hide_ads_on_top = isset( $instance['hide_ads_on_top'] ) ? esc_attr( $instance['hide_ads_on_top'] ) : '';
		$hide_categories = isset( $instance['hide_categories'] ) ? $instance['hide_categories'] : array();
		$ads             = do_shortcode( $ads );
		$categories      = get_the_category();
		$cat             = get_query_var( 'cat' );
		$status          = App::get( 'status' )->get_status();

		// トップページ
		if ( $status['is_top'] && ! $status['is_paged'] ) {
			if ( $hide_ads_on_top ) {
				return;
			}
			// 404ページ
		} elseif ( is_404() ) {
			if ( $hide_ads_on_404 ) {
				return;
			}
			// カテゴリーページ
		} elseif ( $cat ) {
			$category = get_category( $cat );
			foreach ( $hide_categories as $hide_category ) {
				if ( isset( $category->cat_ID ) && $hide_category === strval( $category->cat_ID ) ) {
					return;
				}
			}
			// 投稿ページ
		} elseif ( $post ) {
			$show_ads = get_post_meta( $post->ID, 'disable_ads', true ) ? null : '1';
			if ( ! $show_ads ) {
				return;
			}
			$categories = get_the_category();
			foreach ( $categories as $category ) {
				foreach ( $hide_categories as $hide_category ) {
					if ( $hide_category === strval( $category->term_id ) ) {
						return;
					}
				}
			}
		}
		?>
	<div class="widget my_ads">
		<?php echo $ads; ?>
	</div>
		<?php
	}
	public function form( $instance ) {
		$ads             = isset( $instance['ads'] ) ? esc_attr( $instance['ads'] ) : '';
		$hide_ads_on_404 = isset( $instance['hide_ads_on_404'] ) ? esc_attr( $instance['hide_ads_on_404'] ) : '';
		$hide_ads_on_top = isset( $instance['hide_ads_on_top'] ) ? esc_attr( $instance['hide_ads_on_top'] ) : '';
		$hide_categories = isset( $instance['hide_categories'] ) ? $instance['hide_categories'] : array();
		$categories      = get_categories();
		?>
	<p>
		<input id="<?php echo $this->get_field_id( 'hide_ads_on_404' ); ?>" name="<?php echo $this->get_field_name( 'hide_ads_on_404' ); ?>" type="checkbox" value="1" <?php checked( $hide_ads_on_404, 1 ); ?>/>
		<label for="<?php echo $this->get_field_id( 'hide_ads_on_404' ); ?>">404ページで広告を隠す</label>
	</p>
	<p>
		<input id="<?php echo $this->get_field_id( 'hide_ads_on_top' ); ?>" name="<?php echo $this->get_field_name( 'hide_ads_on_top' ); ?>" type="checkbox" value="1" <?php checked( $hide_ads_on_top, 1 ); ?>/>
		<label for="<?php echo $this->get_field_id( 'hide_ads_on_top' ); ?>">トップページで広告を隠す</label>
	</p>
	<p><small>チェックの入っているカテゴリーのページでは広告を非表示にします。</small></p>
	<p>
		<?php
		foreach ( $categories as $category ) {
			$checked = '';
			foreach ( $hide_categories as $hide_category ) {
				if ( $hide_category === strval( $category->term_id ) ) {
					$checked = ' checked';
					break;
				}
			}
			?>
		<label style="display: inline-block; margin-right: 5px;">
			<input type="checkbox" value="<?php echo $category->term_id; ?>" name="<?php echo $this->get_field_name( 'hide_categories' ); ?>[]" <?php echo $checked; ?>/>
			<?php echo $category->name; ?>
		</label>
			<?php
		}
		?>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'ads' ); ?>">HTML</label>
		<textarea 
		class="widefat code content" 
		rows="16" 
		cols="20"
		id="<?php echo $this->get_field_id( 'ads' ); ?>" 
		name="<?php echo $this->get_field_name( 'ads' ); ?>" 
		type="text" 
		><?php echo $ads; ?></textarea>
	</p>
		<?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance                    = $old_instance;
		$instance['ads']             = $new_instance['ads'];
		$instance['hide_ads_on_404'] = $new_instance['hide_ads_on_404'];
		$instance['hide_ads_on_top'] = $new_instance['hide_ads_on_top'];
		$instance['hide_categories'] = $new_instance['hide_categories'];
		return $instance;
	}
}

add_action(
	'widgets_init',
	function () {
		register_widget( 'SANGO_AdWidget' );
	}
);

// プロフィールウィジェット
class SANGO_ProfileWidget extends WP_Widget {

	public function __construct() {
		parent::__construct( false, $name = '【SANGO】プロフィール' );
	}
	public function widget( $args, $instance ) {
		$profile_user  = isset( $instance['profile_user'] ) ? esc_attr( $instance['profile_user'] ) : '';
		$profile_nl2br = isset( $instance['profile_nl2br'] ) ? esc_attr( $instance['profile_nl2br'] ) : '';
		$user          = get_user_by( 'id', $profile_user );
		if ( ! $user ) {
			return;
		}
		$avatar      = get_avatar_url( $profile_user );
		$description = get_user_meta( $profile_user, 'description', true );
		$profile_bg  = get_user_meta( $profile_user, 'profile_bg', true );
		$background  = array();
		if ( $profile_nl2br ) {
			$description = nl2br( $description );
		}
		if ( $profile_bg ) {
			$background = wp_get_attachment_image_src( $profile_bg, 'full' );
		}
		if ( ! $background ) {
			$template_image_path_base = get_template_directory_uri() . '/library/images/';
			$background               = array( $template_image_path_base . 'default.jpg', 924, 572 );
		}

		$socials = array(
			'X'                 => esc_attr( get_user_meta( $profile_user, 'twitter', true ) ),
			'fab fa-facebook-f' => esc_url( get_user_meta( $profile_user, 'facebook', true ) ),
			'fab fa-instagram'  => esc_url( get_user_meta( $profile_user, 'instagram', true ) ),
			'fa fa-rss'         => esc_url( get_user_meta( $profile_user, 'feedly', true ) ),
			'fab fa-line'       => esc_url( get_user_meta( $profile_user, 'line', true ) ),
			'fab fa-youtube'    => esc_url( get_user_meta( $profile_user, 'youtube', true ) ),
		);

		?>
	<div class="widget">
		<?php
		sng_show_profile(
			array(
				'background'   => $background,
				'avatar'       => $avatar,
				'display_name' => $user->display_name,
				'description'  => $description,
				'socials'      => $socials,
			)
		);
		?>
	</div>
		<?php
	}
	public function form( $instance ) {
		$profile_user  = isset( $instance['profile_user'] ) ? esc_attr( $instance['profile_user'] ) : '';
		$profile_nl2br = isset( $instance['profile_nl2br'] ) ? esc_attr( $instance['profile_nl2br'] ) : '';
		?>
	<p>
		<select name="<?php echo $this->get_field_name( 'profile_user' ); ?>">
		<option>表示するユーザーを選択</option>
		<?php
		$users = get_users();
		foreach ( $users as $user ) {
			?>
			<option value="<?php echo $user->ID; ?>" <?php selected( $profile_user, $user->ID ); ?>><?php echo $user->display_name; ?></option>
			<?php
		}
		?>
		</select>
	</p>
	<p>
		<input id="<?php echo $this->get_field_id( 'profile_nl2br' ); ?>" name="<?php echo $this->get_field_name( 'profile_nl2br' ); ?>" type="checkbox" value="1" <?php checked( $profile_nl2br, 1 ); ?>/>
		<label for="<?php echo $this->get_field_id( 'profile_nl2br' ); ?>">プロフィール欄の改行を表示画面に反映する</label>
	</p>
		<?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance                  = $old_instance;
		$instance['profile_user']  = $new_instance['profile_user'];
		$instance['profile_nl2br'] = $new_instance['profile_nl2br'];
		return $instance;
	}
}

if ( ! function_exists( 'sng_show_profile' ) ) {
	function sng_show_profile( $option ) {
		$background       = $option['background'];
		$avatar           = $option['avatar'];
		$display_name     = $option['display_name'];
		$description      = $option['description'];
		$socials          = $option['socials'];
		$description_wrap = isset( $option['description_wrap'] ) ? $option['description_wrap'] : 'p';

		?>
	<div class="my_profile">
		<div class="yourprofile">
		<div class="profile-background">
			<img src="<?php echo $background[0]; ?>" width="<?php echo $background[1]; ?>" height="<?php echo $background[2]; ?>" alt="プロフィール背景画像">
		</div>
		<div class="profile-img">
			<img src="<?php echo $avatar; ?>" width="80" height="80" alt="プロフィール画像">
		</div>
		<p class="yourname dfont"><?php echo $display_name; ?></p>
		</div>
		<div class="profile-content">
		<?php if ( $description ) { ?>
			<<?php echo $description_wrap; ?>><?php echo $description; ?></<?php echo $description_wrap; ?>>
		<?php } ?>
		</div>
		<ul class="profile-sns dfont">
		<?php
		foreach ( $socials as $name => $url ) {
			if ( $url ) {
				?>
			<li><a href="<?php echo $url; ?>" target="_blank" rel="nofollow noopener" ><i class="<?php echo $name; ?>"></i></a></li>
				<?php
			}
		}
		?>
		</ul>
	</div>
		<?php
	}
}

add_action(
	'widgets_init',
	function () {
		register_widget( 'SANGO_ProfileWidget' );
	}
);

// プロフィールウィジェット
class SANGO_BoxMenuWidget extends WP_Widget {
	public function __construct() {
		parent::__construct( false, $name = '【SANGO】ボックスメニュー' );
	}
	public function widget( $args, $instance ) {
		extract( $args );
		$data             = isset( $instance['items'] ) ? esc_attr( $instance['items'] ) : '{}';
		$data             = json_decode( html_entity_decode( $data ), true );
		$items            = isset( $data['items'] ) ? $data['items'] : array();
		$title            = isset( $data['title'] ) ? $data['title'] : '';
		$icon             = isset( $data['icon'] ) ? $data['icon'] : '';
		$background_color = isset( $data['backgroundColor'] ) ? $data['backgroundColor'] : '';
		$color            = isset( $data['color'] ) ? $data['color'] : '';
		$center           = isset( $data['center'] ) ? $data['center'] : '';
		?>
	
		<?php
		sng_show_box_menu(
			array(
				'items'           => $items,
				'title'           => $title,
				'icon'            => $icon,
				'backgroundColor' => $background_color,
				'color'           => $color,
				'center'          => $center,
			)
		);
	}
	public function form( $instance ) {
		wp_enqueue_style(
			'sng-fontawesome',
			sng_font_awesome_cdn_url(),
			array()
		);
		wp_enqueue_script( 'box-menu', get_template_directory_uri() . '/library/js/boxMenu.build.js' );
		$items = isset( $instance['items'] ) ? esc_attr( $instance['items'] ) : '';
		?>
	<div class="js-box-menu-wrap">
		<textarea class="js-box-menu" style="display: none;" id="<?php echo $this->get_field_id( 'items' ); ?>" name="<?php echo $this->get_field_name( 'items' ); ?>"><?php echo $items; ?></textarea>
		<div class="js-box-menu-render"></div>
	</div>
		<?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['items'] = $new_instance['items'];
		return $instance;
	}
}

if ( ! function_exists( 'sng_show_box_menu' ) ) {
	function sng_show_box_menu( $option ) {
		$items            = $option['items'];
		$icon             = $option['icon'];
		$title            = $option['title'];
		$background_color = $option['backgroundColor'];
		$color            = $option['color'];
		$center           = $option['center'];
		?>
	<div class="widget">
		<?php if ( $title ) { ?>
		<div class="widget-menu__title main-c pastel-bc strong
			<?php
			if ( $center ) :
				echo ' ct';
endif;
			?>
		" style="background-color: <?php echo $background_color; ?>; color: <?php echo $color; ?>">
			<?php if ( $icon ) { ?>
			<i class="<?php echo $icon; ?>"></i>
				<?php
			}
			?>
			<?php echo $title; ?>
		</div>
		<?php } ?>
		<ul class="widget-menu dfont cf">
		<?php
		foreach ( $items as $item ) {
			$openNew   = $item['openNew'];
			$attr      = $openNew ? ' target="_blank" noopener noreferrer' : '';
			$url       = isset( $item['url'] ) ? $item['url'] : '';
			$icon      = isset( $item['icon'] ) ? $item['icon'] : '';
			$iconColor = isset( $item['iconColor'] ) ? $item['iconColor'] : '';
			$title     = isset( $item['title'] ) ? $item['title'] : '';
			?>
			<li>
			<a href="<?php echo $url; ?>"<?php echo $attr; ?>>
				<i class="<?php echo $icon; ?>" style="color: <?php echo $iconColor; ?>"></i>
				<?php echo $title; ?>
			</a>
			</li>
			<?php
		}
		?>
		</ul>
	</div>
		<?php
	}
}

add_action(
	'widgets_init',
	function () {
		register_widget( 'SANGO_BoxMenuWidget' );
	}
);

// アクセスがBOTかどうか判断する関数
if ( ! function_exists( 'is_bot' ) ) {
	function is_bot() {
		if ( ! isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			return false;
		}
		$ua   = $_SERVER['HTTP_USER_AGENT'];
		$bots = array(
			'Googlebot',
			'Yahoo! Slurp',
			'Mediapartners-Google',
			'msnbot',
			'bingbot',
			'MJ12bot',
			'Ezooms',
			'pirst; MSIE 8.0;',
			'Google Web Preview',
			'ia_archiver',
			'Sogou web spider',
			'Googlebot-Mobile',
			'AhrefsBot',
			'YandexBot',
			'Purebot',
			'Baiduspider',
			'UnwindFetchor',
			'TweetmemeBot',
			'MetaURI',
			'PaperLiBot',
			'Showyoubot',
			'JS-Kit',
			'PostRank',
			'Crowsnest',
			'PycURL',
			'bitlybot',
			'Hatena',
			'facebookexternalhit',
			'NINJA bot',
			'YahooCacheSystem',
			'GPTBot',
		);
		foreach ( $bots as $bot ) {
			if ( stripos( $ua, $bot ) !== false ) {
				return true;}
		}
		return false;
	}
}

if ( ! function_exists( 'sng_remove_widgets_block_editor' ) ) {
	function sng_remove_widgets_block_editor() {
		if ( get_option( 'sng_use_legacy_widget' ) ) {
			remove_theme_support( 'widgets-block-editor' );
		}
	}
}

add_action( 'after_setup_theme', 'sng_remove_widgets_block_editor' );
