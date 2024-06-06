<?php
/******************************
 * カスタマイザーで登録されたスタイルの設定を反映
 ********************************/

if ( ! function_exists( 'sng_customizer_css' ) ) {
	function sng_customizer_css() {
		// 色
		$link_c            = get_theme_mod( 'link_color', '#4f96f6' );
		$header_bc         = get_theme_mod( 'header_bc', '#009EF3' );
		$header_c          = get_theme_mod( 'header_c', '#FFF' );
		$header_menu_c     = get_theme_mod( 'header_menu_c', '#FFF' );
		$wid_c             = get_theme_mod( 'wid_title_c', '#009EF3' );
		$wid_bc            = get_theme_mod( 'wid_title_bc', '#b4e0fa' );
		$footer_c          = get_theme_mod( 'sng_footer_c', '#3c3c3c' );
		$footer_bc         = get_theme_mod( 'sng_footer_bc', '#e0e4eb' );
		$footer_menu_bc    = get_theme_mod( 'sng_footer_menu_bc', $header_bc );
		$footer_menu_c     = get_theme_mod( 'sng_footer_menu_c', $header_menu_c );
		$body_bc           = get_theme_mod( 'background_color' );
		$margin_top        = get_theme_mod( 'sng_sidebar_scroll_top', 0 );
		$scroll_margin_top = get_theme_mod( 'sng_scroll_margin_top', 0 );

		if ( is_admin_bar_showing() ) {
			$margin_top        = $margin_top + 32;
			$scroll_margin_top = $scroll_margin_top + 32;
		}

		// トップへ戻るボタン
		$totop_bc = get_theme_mod( 'to_top_color', '#009EF3' );

		// お知らせ欄
		$info_text = get_theme_mod( 'header_info_c', '#FFF' );
		$info_bc1  = get_theme_mod( 'header_info_c1', '#738bff' );
		$info_bc2  = get_theme_mod( 'header_info_c2', '#85e3ec' );

		// モバイルフッター固定メニュー
		$footer_fixed_bc   = get_theme_mod( 'footer_fixed_bc', '#FFF' );
		$footer_fixed_c    = get_theme_mod( 'footer_fixed_c', '#a2a7ab' );
		$footer_fixed_actc = get_theme_mod( 'footer_fixed_actc', '#009EF3' );

		// フォントサイズ
		$font_size_sp = get_option( 'mb_font_size' ) ? get_option( 'mb_font_size' ) : '100';
		$font_size_tb = get_option( 'tb_font_size' ) ? get_option( 'tb_font_size' ) : '107';
		$font_size_pc = get_option( 'pc_font_size' ) ? get_option( 'pc_font_size' ) : '107';

		// フォント種類
		$font_family = 'var(--wp--preset--font-family--default)';
		if ( sng_is_selected_font( 'notosansjp' ) ) {
			$font_family = 'var(--wp--preset--font-family--notosans)';
		}
		if ( sng_is_selected_font( 'mplusrounded1c' ) ) {
			$font_family = 'var(--wp--preset--font-family--mplusrounded)';
		}

		// タブ色
		$tab_bc          = get_theme_mod( 'tab_background_color', '#FFF' );
		$tab_c           = get_theme_mod( 'tab_text_color', '#a7a7a7' );
		$tab_active_self = get_theme_mod( 'tab_active_self', false );
		$tab_active_bc1  = get_theme_mod( 'tab_active_color1', '#bdb9ff' );
		$tab_active_bc2  = get_theme_mod( 'tab_active_color2', '#67b8ff' );
		$theme_dir       = get_template_directory_uri();

		// ヘッダー
		$header_height = get_option( 'header_height' );

		$css = <<< EOM
    a {
      color: {$link_c};
    }
    .header,
    .drawer__title {
      background-color: {$header_bc};
    }
    #logo a {
      color: {$header_c};
    }
    .desktop-nav li a , 
    .mobile-nav li a,
    #drawer__open,
    .header-search__open,
    .drawer__title {
      color: {$header_menu_c};
    }
    .drawer__title__close span,
    .drawer__title__close span:before {
      background: {$header_menu_c};
    }
    .desktop-nav li:after {
      background: {$header_menu_c};
    }
    .mobile-nav .current-menu-item {
      border-bottom-color: {$header_menu_c};
    }
    .widgettitle,
    .sidebar .wp-block-group h2,
    .drawer .wp-block-group h2 {
      color: {$wid_c};
      background-color: {$wid_bc};
    }
    #footer-menu a,
    .copyright {
      color: {$footer_menu_c};
    }
    #footer-menu {
      background-color: {$footer_menu_bc};
    }
    .footer {
      background-color: {$footer_bc};
    }
    .footer,
    .footer a,
    .footer .widget ul li a {
      color: {$footer_c};
    }
    body {
      font-size: {$font_size_sp}%;
    }
    @media only screen and (min-width: 481px) {
      body { font-size: {$font_size_tb}%; }
    }
    @media only screen and (min-width: 1030px) {
      body { font-size: {$font_size_pc}%; }
    }
    .totop {
      background: {$totop_bc};
    }
    .header-info a {
      color: {$info_text};
      background: linear-gradient(95deg, {$info_bc1}, {$info_bc2});
    }
    .fixed-menu ul {
      background: {$footer_fixed_bc};
    }
    .fixed-menu a {
      color: {$footer_fixed_c};
    }
    .fixed-menu .current-menu-item a,
    .fixed-menu ul li a.active {
      color: {$footer_fixed_actc};
    }
    .post-tab {
      background: {$tab_bc};
    }
    .post-tab > div {
      color: {$tab_c};
    }
    body {
      --sgb-font-family: {$font_family};
    }
    #fixed_sidebar {
      top: {$margin_top}px;
    }
    :target {
      scroll-margin-top: {$scroll_margin_top}px;
    }
    .Threads:before {
      background-image: url("{$theme_dir}/library/images/threads.svg");
    }
    .profile-sns li .Threads:before {
      background-image: url("{$theme_dir}/library/images/threads-outline.svg")
    }
    .X:before {
      background-image: url("{$theme_dir}/library/images/x-circle.svg");
    }
EOM;
		if ( $tab_active_self === true ) {
			if ( $tab_active_bc1 !== $tab_active_bc2 ) {
				$css .= <<< EOM
      .post-tab > div.tab-active {
        background: linear-gradient(95deg, {$tab_active_bc1}, {$tab_active_bc2});
      }
EOM;
			} else {
				$css .= <<< EOM
      .post-tab > div.tab-active {
        background: {$tab_active_bc1};
      }
EOM;
			}
		}

		// 背景色が白の場合は見やすさのための調整
		if ( strpos( $body_bc, 'ffffff' ) !== false ) {
			$css .= <<< EOM
    .post,
    .sidebar .widget,
    .archive-header {
      border: solid 1px rgba(0,0,0,.08);
    }
    .one-column .post {
      border: none;
    }
    .sidebar .widget .widget {
      border: none;
    }
    .sidebar .widget_search input {
      border: solid 1px #ececec;
    }
    .sidelong__article {
      border: solid 1px #ececec;
    }
EOM;
		}

		if ( $body_bc ) {
			$css .= '.body_bc { background-color: ' . $body_bc . ';}';
		}

		if ( $header_height && ! get_option( 'center_logo_checkbox' ) ) {
			$css .= <<< EOM
      @media only screen and (min-width: 769px) {
        #logo {
          height: {$header_height}px;
          line-height: {$header_height}px;
        }
        #logo img {
          height: {$header_height}px;
        }
        .desktop-nav li a {
          height: {$header_height}px;
          line-height: {$header_height}px;
        }
      }
EOM;
		}

		echo '<style>' . sng_minify_css( $css ) . '</style>';
	}
}
add_action( 'wp_head', 'sng_customizer_css', 101 );
