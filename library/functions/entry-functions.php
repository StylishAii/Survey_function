<?php

use SANGO\App;
use SangoBlocks\App as SangoBlocksApp;
/**
 * SANGOの投稿ページで使われる関数をまとめています。
 * - articleに含まれるクラス名を変更
 * - 1カラム設定用のクラス名を出力
 * - 記事下：おすすめ記事
 * - 記事下：CTA
 * - 記事下：フォローボックス
 * - この記事を書いた人
 * - ユーザープロフィールからSNSのURLを登録
 * - 関連記事
 * - 構造化データ
 * - コメント
 * -「前後の記事へ」用にタイトル文字数を制限
 * - シェアボタン
 * - excerpt（要約の末尾の「…」を変更）
 */

/*************************
 * articleに出力されるクラス名を変更
 **************************/
function no_hentry( $classes ) {
	// アイキャッチ画像なしクラスを出力
	global $post;
	if ( ! has_post_thumbnail( $post->ID ) && ( ! get_option( 'open_fab' ) || is_page() ) ) {
		$classes[] = 'nothumb';
	}
	// hentryを出力しない
	$classes = array_diff( $classes, array( 'hentry' ) );
	return $classes;
}
add_filter( 'post_class', 'no_hentry' );

/*********************
 * 1カラム設定のときに特定のクラス名を出力
 */
/**
 * 以下のどちらかの条件で1カラム設定
 * 1) カスタマイザーで「モバイルでサイドバーを表示しない」にチェック
 * 2) 投稿/固定ページで1カラム設定にチェック
 * どちらかに当てはまれば、one-columnのクラス名を出力
 */
if ( ! function_exists( 'column_class' ) ) {
	function column_class() {
		global $post;
		if (
		( wp_is_mobile() && get_option( 'no_sidebar_mobile' ) ) ||
		get_post_meta( $post->ID, 'one_column_options', true ) ||
		get_option( 'no_sidebar' )
		) {
			echo ' class="one-column"';
		}
	}
}

/*********************
 * 記事下に表示するおすすめの記事
 *（カスタマイザーから4つまで登録可能）
 */
if ( ! function_exists( 'sng_recommended_posts' ) ) {
	function sng_recommended_posts() {
		if ( get_option( 'enable_recommend' ) ) {
			if ( get_option( 'recommend_title' ) ) {
				echo '<h3 class="h-undeline related_title">' . get_option( 'recommend_title' ) . '</h3>';
			}
			// タイトル（未入力なら非表示）
			echo '<div class="recommended">';
			global $post;
			$i = 0;
			while ( $i < 4 ) {
				++$i;
				$url_option_name   = 'recid' . $i; // カスタマイザーに入力されたURLを取得するための名前
				$id                = esc_attr( get_option( $url_option_name ) ); // 記事のID
				$url               = get_permalink( $id ); // 記事のURL
				$title_option_name = 'rectitle' . $i; // カスタマイザーに入力されたタイトルを取得するための名前
				$title             = ( get_option( $title_option_name ) ) ? get_option( $title_option_name ) : get_the_title( $id ); // 記事のタイトルを取得：カスタマイザーで未入力の場合、デフォルトのタイトルを取得
				if ( $id && ( $id != $post->ID ) ) {
					$src = featured_image_src( 'thumb-160', $id );
					?>
		<a href="<?php echo esc_attr( $url ); ?>">
			<figure>
			<img width="160" height="160" src="<?php echo $src; ?>" <?php sng_lazy_attr(); ?>  />
			</figure>
			<div><?php echo esc_attr( $title ); ?></div>
		</a>
					<?php
				}
			} // endwhile
			echo '</div>';
		} // endif
	} // end function
}

/**************************
 * 記事下CTA
 */
if ( ! function_exists( 'insert_cta' ) ) {
	function insert_cta() {
		if ( ! get_option( 'enable_cta' ) ) {
			return;
		}
		$exclude_cat = explode( ',', get_option( 'no_cta_cat' ) ); // CTAを表示しないカテゴリー
		if ( in_category( $exclude_cat ) ) {
			return;
		}
		?>
	<div class="cta" style="background: <?php echo get_theme_mod( 'cta_background_color', '#b4e0fa' ); ?>;">
		<?php if ( get_option( 'cta_big_txt' ) ) : ?>
		<h3 style="color: <?php echo get_theme_mod( 'cta_bigtxt_color', '#333' ); ?>;">
			<?php echo get_option( 'cta_big_txt' ); ?>
		</h3>
			<?php
	endif;
		if ( get_option( 'cta_image_media_upload' ) ) {
			$media_id   = get_option( 'cta_image_media_upload' );
			$media_url  = esc_url_raw( wp_get_attachment_url( $media_id ) );
			$image_data = wp_get_attachment_metadata( $media_id );
			$width      = '';
			$height     = '';
			if ( $image_data ) {
				$width  = $image_data['width'];
				$height = $image_data['height'];
			}
			?>
		<p class="cta-img">
			<img src="<?php echo $media_url; ?>" <?php sng_lazy_attr(); ?> width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
		</p>
			<?php
		} elseif ( get_option( 'cta_image_upload' ) ) {
			$url = esc_url( get_option( 'cta_image_upload' ) );
			?>
		<p class="cta-img">
		<img src="<?php echo $url; ?>" <?php sng_lazy_attr(); ?> <?php sng_echo_image_size( $url ); ?> />
		</p>
			<?php
		}
		if ( get_option( 'cta_sml_txt' ) ) :
			?>
		<p class="cta-descr" style="color: <?php echo get_theme_mod( 'cta_smltxt_color', '#333' ); ?>;"><?php echo get_option( 'cta_sml_txt' ); ?></p>
			<?php
	endif;
		if ( get_option( 'cta_btn_txt' ) ) :
			?>
		<p class="cta-btn"><a class="raised" href="<?php echo esc_url( get_option( 'cta_btn_url' ) ); ?>" style="background: <?php echo get_theme_mod( 'cta_btn_color', '#ffb36b' ); ?>;"><?php echo get_option( 'cta_btn_txt' ); ?></a></p>
		<?php endif; ?>
	</div>
		<?php
	}
}
/*********************
 * フォローボックス（この記事が気に入ったらいいね）
 */
if ( ! function_exists( 'insert_like_box' ) ) {
	function insert_like_box() {
		if ( ! get_option( 'enable_like_box' ) ) {
			return;
		}

		$user_tw          = ( get_option( 'like_box_twitter' ) ) ? esc_attr( get_option( 'like_box_twitter' ) ) : null;
		$url_fb           = ( get_option( 'like_box_fb' ) ) ? esc_url( get_option( 'like_box_fb' ) ) : null;
		$url_fdly         = ( get_option( 'like_box_feedly' ) ) ? esc_url( get_option( 'like_box_feedly' ) ) : null;
		$url_insta        = ( get_option( 'like_box_insta' ) ) ? esc_url( get_option( 'like_box_insta' ) ) : null;
		$url_youtube      = ( get_option( 'like_box_youtube' ) ) ? esc_url( get_option( 'like_box_youtube' ) ) : null;
		$line_id          = ( get_option( 'like_box_line_friend_id' ) ) ? esc_attr( get_option( 'like_box_line_friend_id' ) ) : null;
		$title            = ( get_option( 'like_box_title' ) ) ? '<p class="dfont">' . get_option( 'like_box_title' ) . '</p>' : '';
		$follow_box_title = get_option( 'like_box_subtitle', 'この記事が気に入ったらフォローしよう' );

		?>
	<div class="like_box">
	<div class="like_inside">
		<div class="like_img">
		<?php
			$url = featured_image_src( 'thumb-520' );
		?>
		<img src="<?php echo $url; ?>" <?php sng_lazy_attr(); ?> width="520" height="300" alt="下のソーシャルリンクからフォロー">
		<?php echo $title; ?>
		</div>
		<div class="like_content">
		<p><?php echo $follow_box_title; ?></p>
		<?php if ( $user_tw ) : ?>
			<div><a href="https://twitter.com/<?php echo $user_tw; ?>" class="twitter-follow-button" data-show-count="<?php echo get_option( 'follower_count' ) ? 'true' : 'false'; ?>" data-lang="ja" data-show-screen-name="false" rel="nofollow">フォローする</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></div>
		<?php endif; ?>
		<?php if ( $line_id ) : ?>
			<div class="like-line-friend">
			<div class="line-it-button" data-lang="ja" data-type="friend" data-lineid="<?php echo $line_id; ?>" data-count="<?php echo get_option( 'like_box_line_show_follower_count' ) ? 'true' : 'false'; ?>" style="display: none;"></div>
			<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
			</div>
		<?php endif; ?>
		<?php if ( $url_fdly ) : ?>
			<div><a href="<?php echo $url_fdly; ?>" target="blank" rel="nofollow"><img src="<?php echo get_template_directory_uri() . '/library/images/feedly.png'; ?>" alt="follow me on feedly" width="66" height="20" <?php sng_lazy_attr(); ?>></a></div>
		<?php endif; ?>
		<?php if ( $url_fb ) : ?>
			<div><div class="fb-like" data-href="<?php echo $url_fb; ?>" data-layout="box_count" data-action="like" data-share="false"></div></div>
			<?php fb_like_js(); ?>
		<?php endif; ?>
		<?php if ( $url_insta ) : ?>
			<div><a class="like_insta" href="<?php echo $url_insta; ?>" target="blank" rel="nofollow"><?php fa_tag( 'instagram', 'instagram', true ); ?> <span>フォローする</span></a></div>
		<?php endif; ?>
		<?php if ( $url_youtube ) : ?>
			<div><a class="like_youtube" href="<?php echo $url_youtube; ?>" target="blank" rel="nofollow"><?php fa_tag( 'youtube', 'youtube', true ); ?> <span>YouTube</span></a></div>
		<?php endif; ?>
		</div>
	</div>
	</div>
		<?php
	} // end function
}

// facebookいいねボタン用のjs。カスタマイザーで登録済みの場合のみ出力
function fb_like_js() {
	echo <<< EOM
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    const js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
EOM;
}

/*********************
 * この記事を書いた人
 */

if ( ! function_exists( 'sng_author_info_by_id' ) ) {
	function sng_author_info_by_id( $id, $author_label = 'この記事を書いた人' ) {
		$socials      = array(
			'Twitter'   => esc_attr( get_the_author_meta( 'twitter', $id ) ),
			'Facebook'  => esc_url( get_the_author_meta( 'facebook', $id ) ),
			'Instagram' => esc_url( get_the_author_meta( 'instagram', $id ) ),
			'Feedly'    => esc_url( get_the_author_meta( 'feedly', $id ) ),
			'LINE'      => esc_url( get_the_author_meta( 'line', $id ) ),
			'YouTube'   => esc_url( get_the_author_meta( 'youtube', $id ) ),
			'Threads'   => esc_url( get_the_author_meta( 'threads', $id ) ),
			'Website'   => esc_url( get_the_author_meta( 'url', $id ) ),
		);
		$iconimg      = get_avatar( get_the_author_meta( 'ID', $id ), 100 );
		$display_name = esc_attr( get_the_author_meta( 'display_name', $id ) );
		$author_url   = esc_url( get_author_posts_url( get_the_author_meta( 'ID', $id ) ) );
		$title        = esc_attr( get_the_author_meta( 'yourtitle', $id ) );
		$description  = get_the_author_meta( 'user_description', $id );
		$html         = sng_author_info(
			array(
				'socials'      => $socials,
				'author_label' => $author_label,
				'icon'         => $iconimg,
				'display_name' => $display_name,
				'author_url'   => $author_url,
				'title'        => $title,
				'description'  => $description,
			)
		);
		return $html;
	}
}

if ( ! function_exists( 'sng_author_info' ) ) {
	function sng_author_info( $author ) {
		$socials      = $author['socials'];
		$author_label = $author['author_label'];
		$icon         = $author['icon'];
		$display_name = $author['display_name'];
		$author_url   = $author['author_url'];
		$title        = $author['title'];
		$description  = $author['description'];
		ob_start();
		?>
	<div class="author-info__inner">
	<div class="tb">
		<div class="tb-left">
		<div class="author_label">
		<span><?php echo $author_label; ?></span>
		</div>
		<div class="author_img">
		<?php
		if ( $icon ) {
			echo $icon;
		}
		?>
		</div>
		<dl class="aut">
			<dt>
			<a class="dfont" href="<?php echo $author_url; ?>">
				<span><?php echo $display_name; // 名前 ?></span>
			</a>
			</dt>
			<dd><?php echo $title; ?></dd>
		</dl>
		</div>
		<div class="tb-right">
		<p><?php echo $description; ?></p>
		<div class="follow_btn dfont">
			<?php
			foreach ( $socials as $name => $url ) {
				if ( $url ) {
					?>
				<a class="<?php echo $name; ?>" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="nofollow noopener noreferrer"><?php echo esc_attr( $name ); ?></a>
					<?php
				}
			}
			?>
		</div>
		</div>
	</div>
	</div>
		<?php
		$content = ob_get_clean();
		return $content;
	}
}
if ( ! function_exists( 'insert_author_info' ) ) {
	function insert_author_info() {
		$author_label        = apply_filters( 'sng_author_label', 'この記事を書いた人' );
		$author_descr        = get_the_author_meta( 'description' );
		$should_show_profile = get_the_author_meta( 'should_show_profile' );
		// プロフィール情報が空欄のときは表示しない
		if ( empty( $author_descr ) && empty( $should_show_profile ) ) {
			return;
		}

		$socials      = array(
			'X'         => esc_attr( get_the_author_meta( 'twitter' ) ),
			'Facebook'  => esc_url( get_the_author_meta( 'facebook' ) ),
			'Instagram' => esc_url( get_the_author_meta( 'instagram' ) ),
			'Feedly'    => esc_url( get_the_author_meta( 'feedly' ) ),
			'LINE'      => esc_url( get_the_author_meta( 'line' ) ),
			'YouTube'   => esc_url( get_the_author_meta( 'youtube' ) ),
			'Threads'   => esc_url( get_the_author_meta( 'threads' ) ),
			'Website'   => esc_url( get_the_author_meta( 'url' ) ),
		);
		$iconimg      = get_avatar( get_the_author_meta( 'ID' ), 100 );
		$display_name = esc_attr( get_the_author_meta( 'display_name' ) );
		$author_url   = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
		$title        = esc_attr( get_the_author_meta( 'yourtitle' ) );
		$description  = get_the_author_meta( 'user_description' );
		$params       = array(
			'socials'      => $socials,
			'author_label' => $author_label,
			'icon'         => $iconimg,
			'display_name' => $display_name,
			'author_url'   => $author_url,
			'title'        => $title,
			'description'  => $description,
		);

		$content = sng_author_info( $params );
		$html    = apply_filters( 'sng_author_info', $content, $params );
		?>
		<div class="author-info pastel-bc">
		<?php echo $html; ?>
		</div>
		<?php
	}
}

/*********************
 * ユーザー管理画面からfacebookやTwitterを登録
 *********************/
function add_user_contactmethods( $user_contactmethods ) {
	return array(
		'yourtitle' => '肩書き（入力するとプロフィールに表示）',
		'twitter'   => 'TwitterのURL',
		'facebook'  => 'FacebookのURL',
		'instagram' => 'InstagramのURL',
		'feedly'    => 'FeedlyのURL',
		'youtube'   => 'YouTubeのURL',
		'line'      => 'LINEのURL',
		'threads'   => 'ThreadsのURL',
	);
}
add_filter( 'user_contactmethods', 'add_user_contactmethods' );


/*********************
 * ユーザー管理画面にカスタムフィールドを登録
 *********************/
function sng_set_user_profile( $bool ) {
	global $profileuser;
	global $profile_user;
	$profile             = $profileuser ?? $profile_user;
	$profile_bg          = $profile->profile_bg;
	$profile_avatar      = $profile->profile_avatar;
	$should_show_profile = $profile->should_show_profile ? ' checked' : '';
	$profile_preview     = wp_get_attachment_image_src( $profile_bg, 'full' );
	$avatar_previews     = wp_get_attachment_image_src( $profile_avatar, 'full' );
	$avatar_preview      = get_avatar_url( $profile->ID );
	if ( $avatar_previews ) {
		$avatar_preview = $avatar_previews[0];
	}
	?>

	<tr>
	<th>プロフィール写真</th>
	<td>
		<div style="margin-bottom: 10px; display: flex; align-items: center; gap: 15px;">
		<?php if ( $avatar_preview ) { ?>
			<img src="<?php echo $avatar_preview; ?>" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;" id="profile_avatar_preview" />
		<?php } else { ?>
			<img style="display: none; width: 100px; height: 100px; border-radius: 50%; object-fit: cover;" id="profile_avatar_preview" />
		<?php } ?>
		<div>
		<button id="profile_avatar_btn" class="button" type="button">画像をアップロード</button>
		<?php if ( $avatar_preview ) { ?>
			<button id="profile_avatar_remove_btn" class="button" type="button">画像を削除</button>
		<?php } else { ?>
			<button id="profile_avatar_remove_btn" class="button" type="button" style="display: none">画像を削除</button>
		<?php } ?>
		</div>
		<input type="hidden" name="profile_avatar" id="profile_avatar" value="<?php echo $profile_avatar; ?>"/>
		</div>
		<p><small>プラグインを使わないでアバターを表示したい場合は、こちらにアバター画像をアップロードしてください。</small></p>
		<p><small>何も設定していない場合は<a href="https://ja.gravatar.com/" target="_blank">Gravatar</a>の画像が使われます。</small></p>
	</td>
	</tr>
	<tr>
	<th><label for="profile_bg">プロフィール背景画像</label></th>
	<td>
		<div style="margin-bottom: 10px;">
		<button id="profile_bg_btn" class="button" type="button">画像をアップロード</button>
		<?php if ( $profile_preview && $profile_preview[0] ) { ?>
			<button id="profile_bg_remove_btn" class="button" type="button">画像を削除</button>
		<?php } else { ?>
			<button id="profile_bg_remove_btn" class="button" type="button" style="display: none">画像を削除</button>
		<?php } ?>
		</div>
		<?php if ( $profile_preview && $profile_preview[0] ) { ?>
		<img src="<?php echo $profile_preview[0]; ?>" style="max-width: 400px; height: auto;" id="profile_bg_preview" />
		<?php } else { ?>
		<img style="display: none; max-width: 400px; height: auto;" id="profile_bg_preview" />
		<?php } ?>
		<input type="hidden" name="profile_bg" id="profile_bg" value="<?php echo $profile_bg; ?>"/>
	</td>
	</tr>
	<tr>
	<th>記事下にプロフィールを表示</th>
	<td>
		<input type="checkbox" name="should_show_profile" id="should_show_profile" value="on" <?php echo $should_show_profile; ?> />
		<label for="should_show_profile">プロフィール情報を設定していない場合でも記事下に著者情報を表示する</label>
	</td>
	</tr>
	<script>
	jQuery(function() {
		const uploader = window.wp.media({
		title: 'Choose Image',
		button: {
			text: 'Choose Image'
		},
		multiple: false
		});
		const removeButton = document.querySelector("#profile_bg_remove_btn");
		uploader.on('select', function() {
		const selections = uploader.state().get('selection');
		const selection = selections.single();
		const preview = document.querySelector("#profile_bg_preview");
		preview.style.display = 'block';
		preview.setAttribute('src', selection.attributes.url);
		const input = document.querySelector('#profile_bg');
		input.value = selection.attributes.id;
		removeButton.style.display = 'inline-block';
		});
		removeButton.addEventListener('click', function() {
		if (!confirm('画像を削除します。よろしいですか？')) {
			return;
		}
		const preview = document.querySelector("#profile_bg_preview");
		const input = document.querySelector('#profile_bg');
		preview.style.display = 'none';
		removeButton.style.display = 'none';
		input.value = '';
		});
		const button = document.querySelector("#profile_bg_btn");
		button.addEventListener('click', function() {
		uploader.open();
		});
	})
	jQuery(function() {
		const uploader = window.wp.media({
		title: 'Choose Image',
		button: {
			text: 'Choose Image'
		},
		multiple: false
		});
		const removeButton = document.querySelector("#profile_avatar_remove_btn");
		uploader.on('select', function() {
		const selections = uploader.state().get('selection');
		const selection = selections.single();
		const preview = document.querySelector("#profile_avatar_preview");
		preview.style.display = 'block';
		preview.setAttribute('src', selection.attributes.url);
		const input = document.querySelector('#profile_avatar');
		input.value = selection.attributes.id;
		removeButton.style.display = 'inline-block';
		});
		removeButton.addEventListener('click', function() {
		if (!confirm('画像を削除します。よろしいですか？')) {
			return;
		}
		const preview = document.querySelector("#profile_avatar_preview");
		const input = document.querySelector('#profile_avatar');
		preview.style.display = 'none';
		removeButton.style.display = 'none';
		input.value = '';
		});
		const button = document.querySelector("#profile_avatar_btn");
		button.addEventListener('click', function() {
		uploader.open();
		});
	})
	</script>
	<?php
	return $bool;
}
add_action( 'show_password_fields', 'sng_set_user_profile' );
function sng_update_user_profile( $user_id, $old_user_data ) {
	$updates = array( 'profile_bg', 'should_show_profile', 'profile_avatar' );
	foreach ( $updates as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			$value = $_POST[ $key ];
			update_user_meta( $user_id, $key, $value, $old_user_data->{$key} );
		} elseif ( $key === 'should_show_profile' ) {
			update_user_meta( $user_id, $key, '', $old_user_data->{$key} );
		}
	}
}
add_action( 'profile_update', 'sng_update_user_profile', 10, 2 );
function sng_load_media_files() {
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'sng_load_media_files' );

/*************************
 * 関連記事
 */

// 親カテゴリーとその子カテゴリー（＝兄弟カテゴリー）を取得する関数
if ( ! function_exists( 'get_parent_and_siblings_cat_ids' ) ) {
	function get_parent_and_siblings_cat_ids( $category ) {
		$ids       = array();
		$parent_id = $category->category_parent; // 親カテゴリーを取得
		if ( ! $parent_id ) {
			return $category->cat_ID; // 親カテゴリがない場合はそのカテゴリだけ返す
		}

		$child_catids = get_term_children( $parent_id, 'category' );
		foreach ( $child_catids as $id ) {
			$ids[] .= $id; // 子のIDを配列に追加
		}
		$ids[] .= $parent_id; // 親のIDを配列に追加
		return $ids; // 自身 + 親 + 兄弟 のID
	}
}

// 関連記事データの取得
if ( ! function_exists( 'sng_get_related_posts_array' ) ) {
	function sng_get_related_posts_array() {
		global $post;
		$categories  = get_the_category();
		$related_str = get_post_meta( $post->ID, 'sng_related_posts', true );
		if ( $related_str ) {
			$related_ids = explode( ',', $related_str );
			$args        = array(
				'post_type'   => 'post',
				'post_status' => 'publish',
				'post__in'    => $related_ids,
				'numberposts' => count( $related_ids ),
			);
			$posts       = get_posts( $args );
			usort(
				$posts,
				function ( $a, $b ) use ( $related_ids ) {
					$index_a = array_search( strval( $a->ID ), $related_ids );
					$index_b = array_search( strval( $b->ID ), $related_ids );
					return $index_a >= $index_b ? 1 : -1;
				}
			);
			return $posts;
		}
		if ( ! $categories ) {
			return null;
		}

		$catid   = ( get_option( 'related_add_parent' ) ) ? get_parent_and_siblings_cat_ids( $categories[0] ) : $categories[0]->cat_ID;
		$num     = ( get_option( 'num_related_posts' ) ) ? esc_attr( get_option( 'num_related_posts' ) ) : 6;
		$orderby = ( get_theme_mod( 'related_posts_order' ) == 'date' ) ? 'date' : 'rand';

		$args = array(
			'category__in' => $catid,
			'exclude'      => $post->ID,
			'numberposts'  => $num,
			'orderby'      => $orderby,
		);

		$days_ago = get_option( 'related_posts_days_ago' );
		if ( $days_ago && $days_ago != '0' ) {
			$args['date_query'] = array(
				array(
					'after'     => date_i18n( 'Y-m-d 0:0:0', strtotime( "- $days_ago days" ) ),
					'inclusive' => true,
				),
			);
		}
		return get_posts( $args );
	}
}

// 関連記事の出力
if ( ! function_exists( 'output_sng_related_posts' ) ) {
	function output_sng_related_posts() {
		$related_posts = sng_get_related_posts_array();
		if ( ! $related_posts ) {
			return;
		}

		$design       = get_theme_mod( 'related_posts_type' ) ? esc_attr( get_theme_mod( 'related_posts_type' ) ) : 'type_a';
		$design      .= get_option( 'related_no_slider' ) || ( $design == 'type_c' ) ? ' no_slide' : ' slide';
		$shown_count  = 0;
		$ad_pos1      = get_theme_mod( 'ad_infeed_pos1', -1 );
		$ad_pos2      = get_theme_mod( 'ad_infeed_pos2', -1 );
		$ad_pos3      = get_theme_mod( 'ad_infeed_pos3', -1 );
		$ad           = get_theme_mod( 'ad_infeed5' );
		$ad_enabled   = get_theme_mod( 'enable_ad_infeed_for_related', false );
		$ad_pos_array = $ad_enabled ? array( $ad_pos1, $ad_pos2, $ad_pos3 ) : array();

		if ( get_option( 'related_post_title' ) ) {
			echo '<h3 class="h-undeline related_title">' . get_option( 'related_post_title' ) . '</h3>';
		}
		echo '<div class="related-posts ' . $design . '"><ul>';
		foreach ( $related_posts as $i => $related_post ) :
			$src   = featured_image_src( 'thumb-520', $related_post->ID );
			$title = $related_post->post_title;
			if ( $ad && is_numeric( array_search( $i + 1 + $shown_count, $ad_pos_array ) ) ) {
				?>
		<li><?php echo $ad; ?></li>
				<?php
				++$shown_count;
			}
			?>
	<li>
	<a href="<?php echo get_permalink( $related_post->ID ); ?>">
		<figure class="rlmg">
		<img src="<?php echo $src; ?>" width="520" height="300" alt="<?php echo $title; ?>" loading="lazy">
		</figure>
		<div class="rep">
		<p><?php echo $title; ?></p>
			<?php do_action( 'sng_related_posts_after_title', $related_post->ID ); ?>
		</div>
	</a>
	</li>
			<?php
		endforeach;
		wp_reset_postdata();
		echo '</ul></div>';
	} /* end related posts function */
}

/*********************
 * 構造化データ挿入
 */
if ( ! function_exists( 'insert_json_ld' ) ) {
	function insert_json_ld() {
		$src_info = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		if ( $src_info ) {
			$src    = $src_info[0];
			$width  = $src_info[1];
			$height = $src_info[2];
		} else { // アイキャッチ画像が無い場合はデフォルトの登録画像
			$src    = featured_image_src( 'thumb-520' );
			$width  = '520';
			$height = '300';
		}
		$page_url           = get_the_permalink();
		$headline           = esc_attr( get_the_title() );
		$date_published     = get_the_date( DATE_ISO8601 );
		$date_modified      = ( get_the_date() != get_the_modified_time() ) ? get_the_modified_date( DATE_ISO8601 ) : get_the_date( DATE_ISO8601 );
		$author_name        = get_the_author_meta( 'display_name' );
		$author_url         = get_the_author_meta( 'url' );
		$hide_article_ogp   = get_option( 'hide_article_ogp' );
		$publisher_name     = esc_attr( get_option( 'publisher_name' ) );
		$publisher_type     = esc_attr( get_option( 'publisher_type', 'Organization' ) );
		$publisher_logo_url = esc_url( get_option( 'publisher_img' ) );
		$custom_description = get_post_meta( get_the_ID(), 'sng_meta_description', true );
		SangoBlocksApp::get( 'css' )->set_enabled( false );
		$description = $custom_description ? esc_attr( $custom_description ) : esc_attr( get_the_excerpt() );
		SangoBlocksApp::get( 'css' )->set_enabled( true );
		$description = preg_replace( '/\n|\r|\r\n/', '', $description );

		if ( $hide_article_ogp ) {
			return;
		}

		$json = <<< EOM
    {
      "@context": "http://schema.org",
      "@type": "Article",
      "mainEntityOfPage":"{$page_url}",
      "headline": "{$headline}",
      "image": {
        "@type": "ImageObject",
        "url": "{$src}",
        "width": {$width},
        "height": {$height}
      },
      "datePublished": "{$date_published}",
      "dateModified": "{$date_modified}",
      "author": {
        "@type": "Person",
        "name": "{$author_name}",
        "url": "{$author_url}"
      },
      "publisher": {
        "@type": "{$publisher_type}",
        "name": "{$publisher_name}",
        "logo": {
          "@type": "ImageObject",
          "url": "{$publisher_logo_url}"
        }
      },
      "description": "{$description}"
    }
EOM;
		echo '<script type="application/ld+json">' . App::get( 'js' )->minify_js( $json ) . '</script>';
	}
}
/*************************
 * コメントレイアウト（comments.phpで呼び出し）
 */
if ( ! function_exists( 'sng_comments' ) ) {
	function sng_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
	<div id="comment-<?php comment_ID(); ?>" <?php comment_class( 'cf' ); ?>>
		<article  class="cf">
		<header class="comment-author vcard">
			<?php $bgauthemail = get_comment_author_email(); ?>
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( '<cite class="fn">%1$s</cite> %2$s', get_comment_author_link(), edit_comment_link( '(Edit)', '  ', '' ) ); ?>
			<time datetime="<?php echo comment_time( 'Y-m-j' ); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>" rel="nofollow"><?php comment_time( get_option( 'date_format' ) ); ?></a></time>
		</header>
			<?php if ( $comment->comment_approved == '0' ) : ?>
			<div class="alert alert-info">
			<p><?php echo 'あなたのコメントは現在承認待ちです。'; ?></p>
			</div>
		<?php endif; ?>
		<section class="comment_content cf">
			<?php comment_text(); ?>
		</section>
			<?php
			comment_reply_link(
				array_merge(
					$args,
					array(
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
					)
				)
			);
			?>
		</article>
		<?php
	} //END sng comments
}

/*********************
 * 文字数を制限しながらタイトルを出力
 * ⇒前の記事/次の記事へのリンクで使用
 *********************/
function lim_title( $id ) {
	$raw = esc_attr( get_the_title( $id ) );
	if ( mb_strlen( $raw, 'UTF-8' ) > 31 ) {
		$title = mb_substr( $raw, 0, 31, 'UTF-8' );
		echo $title . '…';
	} else {
		echo $raw;
	}
}

/*********************
 * excerptの…を変更
 *********************/
function sng_excerpt_more( $more ) {
	return ' ... ';
}
add_filter( 'excerpt_more', 'sng_excerpt_more' );