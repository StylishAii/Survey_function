<?php
/**
 * このファイルではシェアボタンを出力するための関数をまとめています
 */
// シェアボタンをオフにする
if ( ! function_exists( 'sng_disable_share_button' ) ) {
	function sng_disable_share_button() {
		if ( get_option( 'sng_hide_share' ) ) {
			return true;
		}
		global $post;
		if ( ! $post ) {
			return false;
		}
		return get_post_meta( $post->ID, 'sng_disable_share', true );
	}
}


// シェア用のページタイトルを取得
if ( ! function_exists( 'sng_get_encoded_title_for_share' ) ) {
	function sng_get_encoded_title_for_share() {
		// トップ以外はタイトルに「｜サイト名」を含める
		$title = sng_get_page_title();
		if ( ! is_front_page() && ! is_home() ) {
			$title .= '｜' . get_bloginfo( 'name' );
		}
		return urlencode( $title );
	}
}
// ツイートURLを取得する
if ( ! function_exists( 'sng_get_tweet_url' ) ) {
	function sng_get_tweet_url( $url, $title ) {
		$via = ( get_option( 'include_tweet_via' ) ) ? '&via=' . get_option( 'include_tweet_via' ) : '';
		return 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title . $via;
	}
}
// FacebookシェアのURLを取得する
if ( ! function_exists( 'sng_get_fb_share_url' ) ) {
	function sng_get_fb_share_url( $url ) {
		return 'https://www.facebook.com/share.php?u=' . $url;
	}
}
// はてブのURLを取得する
if ( ! function_exists( 'sng_get_hatebu_url' ) ) {
	function sng_get_hatebu_url( $url, $title ) {
		return 'http://b.hatena.ne.jp/add?mode=confirm&url=' . $url . '&title=' . $title;
	}
}
// LINEでシェアのURLを取得する
if ( ! function_exists( 'sng_get_line_share_url' ) ) {
	function sng_get_line_share_url( $url, $title ) {
		return 'https://social-plugins.line.me/lineit/share?url=' . $url . '&text=' . $title;
	}
}

// ツイートリンクに属性を付与する
if ( ! function_exists( 'sng_add_tweet_link_attr' ) ) {
	function sng_add_tweet_link_attr() {
		$attrs = get_option( 'tweet_link_attr' );
		if ( ! $attrs ) {
			return;
		}
		echo ' ' . $attrs;
	}
}

// Facebookシェアリンクに属性を付与する
if ( ! function_exists( 'sng_add_fb_share_link_attr' ) ) {
	function sng_add_fb_share_link_attr() {
		$attrs = get_option( 'fb_share_link_attr' );
		if ( ! $attrs ) {
			return;
		}
		echo ' ' . $attrs;
	}
}

// はてブリンクに属性を付与する
if ( ! function_exists( 'sng_add_hatebu_link_attr' ) ) {
	function sng_add_hatebu_link_attr() {
		$attrs = get_option( 'hatebu_link_attr' );
		if ( ! $attrs ) {
			return;
		}
		echo ' ' . $attrs;
	}
}

// LINEでシェアリンクに属性を付与する
if ( ! function_exists( 'sng_add_line_share_link_attr' ) ) {
	function sng_add_line_share_link_attr() {
		$attrs = get_option( 'line_share_link_attr' );
		if ( ! $attrs ) {
			return;
		}
		echo ' ' . $attrs;
	}
}

if ( ! function_exists( 'sng_x_icon' ) ) {
	function sng_x_icon( $encoded_url, $encoded_title ) {
		// Xアイコン
		ob_start();
		?>
	<li class="tw sns-btn__item">
		<a href="<?php echo sng_get_tweet_url( $encoded_url, $encoded_title ); ?>" target="_blank" rel="nofollow noopener noreferrer" aria-label="Xでシェアする">
		<img alt="" src="<?php echo get_template_directory_uri() . '/library/images/x.svg'; ?>">
		<span class="share_txt">ポスト</span>
		</a>
		<?php
		if ( function_exists( 'scc_get_share_twitter' ) ) {
			echo '<span class="scc dfont">' . scc_get_share_twitter() . '</span>';
		}
		?>
	</li>
		<?php
		$x_icon = ob_get_clean();
		return $x_icon;
	}
}

if ( ! function_exists( 'sng_fb_icon' ) ) {
	function sng_fb_icon( $encoded_url, $encoded_title ) {
		// facebookアイコン
		ob_start();
		?>
	<li class="fb sns-btn__item">
		<a href="<?php echo sng_get_fb_share_url( $encoded_url ); ?>" target="_blank" rel="nofollow noopener noreferrer" aria-label="Facebookでシェアする">
		<?php fa_tag( 'facebook', 'facebook', true ); ?>
		<span class="share_txt">シェア</span>
		</a>
		<?php
		if ( function_exists( 'scc_get_share_facebook' ) ) {
			echo '<span class="scc dfont">' . scc_get_share_facebook() . '</span>';
		}
		?>
	</li>
		<?php
		$fb_icon = ob_get_clean();
		return $fb_icon;
	}
}

if ( ! function_exists( 'sng_hatebu_icon' ) ) {
	function sng_hatebu_icon( $encoded_url, $encoded_title ) {
		// はてなアイコン
		ob_start();
		?>
	<li class="hatebu sns-btn__item">
		<a href="<?php echo sng_get_hatebu_url( $encoded_url, $encoded_title ); ?>" target="_blank" rel="nofollow noopener noreferrer" aria-label="はてブでブックマークする">
		<i class="fa fa-hatebu" aria-hidden="true"></i>
		<span class="share_txt">はてブ</span>
		</a>
		<?php
		if ( function_exists( 'scc_get_share_hatebu' ) ) {
			echo '<span class="scc dfont">' . scc_get_share_hatebu() . '</span>';
		}
		?>
	</li>
		<?php
		$hatebu_icon = ob_get_clean();
		return $hatebu_icon;
	}
}

if ( ! function_exists( 'sng_line_icon' ) ) {
	function sng_line_icon( $encoded_url, $encoded_title ) {
		// LINEアイコン
		ob_start();
		?>
	<li class="line sns-btn__item">
		<a href="<?php echo sng_get_line_share_url( $encoded_url, $encoded_title ); ?>" target="_blank" rel="nofollow noopener noreferrer" aria-label="LINEでシェアする">
		<?php if ( get_option( 'use_fontawesome4' ) ) : ?>
			<img src="<?php echo get_template_directory_uri() . '/library/images/line.svg'; ?>">
		<?php else : ?>
			<i class="fab fa-line" aria-hidden="true"></i>
		<?php endif; ?>
		<span class="share_txt share_txt_line dfont">LINE</span>
		</a>
	</li>
		<?php
		$line_icon = ob_get_clean();
		return $line_icon;
	}
}

if ( ! function_exists( 'insert_social_buttons' ) ) {
	function insert_social_buttons( $type = null ) {
		if ( sng_disable_share_button() ) {
			return;
		}
		/**
		* $type = fabだとfab用のシェアボタンを出力
		* $type = belowtitleだとタイトル下用のシェアボタンを出力
		* fabだとタイトルの出力無し
		* カスタマイザーで「シェアボタンのデザインを変える」にチェックをつけると、sns-difというクラス名を出力。CSSでデザイン指定
		* ホームでも使えるように
		*/
		$encoded_url   = urlencode( sng_get_current_url() );
		$encoded_title = sng_get_encoded_title_for_share();

		$x_icon      = sng_x_icon( $encoded_url, $encoded_title );
		$fb_icon     = sng_fb_icon( $encoded_url, $encoded_title );
		$hatebu_icon = sng_hatebu_icon( $encoded_url, $encoded_title );
		$line_icon   = sng_line_icon( $encoded_url, $encoded_title );

		?>
	<div class="sns-btn
		<?php
		if ( get_option( 'another_social' ) || $type == 'fab' ) {
			echo ' sns-dif'; }
		?>
	">
		<?php
		if ( $type == null ) {
			echo '<span class="sns-btn__title dfont">SHARE</span>';}
		?>
		<ul>
		<?php echo apply_filters( 'sng_social_x', $x_icon ); ?>
		<?php echo apply_filters( 'sng_social_fb', $fb_icon ); ?>
		<?php echo apply_filters( 'sng_social_hatebu', $hatebu_icon ); ?>
		<?php echo apply_filters( 'sng_social_line', $line_icon ); ?>
		</ul>
	</div>
		<?php
		// END シェアボタン
	}
}