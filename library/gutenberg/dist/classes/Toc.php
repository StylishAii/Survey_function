<?php
/**
 * REST API
 */

namespace SangoBlocks;

use Masterminds\HTML5;
use RuntimeException;
use TOC\HtmlHelper;
use TOC\TocGenerator;
use TOC\MarkupFixer;
use DOMDocument;

class Toc {

	use HtmlHelper;

	private $htmlParser;

	public function __construct( $htmlParser = null ) {
		$this->htmlParser = new HTML5();
	}

	public function init() {}

	public function fix_content_with_paginated( $markup ) {
		$markups      = explode( '<!--nextpage-->', $markup );
		$current_page = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) - 1 : 0;
		$html         = '';
		foreach ( $markups as $page => $markup ) {
			if ( $current_page !== $page ) {
				$html .= $this->fix_content( $markup, $page + 1 );
			} else {
				$html .= $this->fix_content( $markup );
			}
		}
		return $html;
	}

	public function fix_content( $markup, $page = 0 ) {
		$topLevel = 1;
		$depth    = 6;
		global $post;
		$link = '';
		if ( $post ) {
			$link = rtrim( get_permalink( $post->ID ), '/' ) . '/';
		}
		if ( ! $this->isFullHtmlDocument( $markup ) ) {
			$partialID = uniqid( 'toc_generator_' );
			$markup    = sprintf( "<body id='%s'>%s</body>", $partialID, $markup );
		}

		$domDocument                     = $this->htmlParser->loadHTML( $markup );
		$domDocument->preserveWhiteSpace = true;

		foreach ( $this->traverseHeaderTags( $domDocument, $topLevel, $depth ) as $i => $node ) {
			$attr = $node->getAttribute( 'id' );
			if ( $attr ) {
				if ( $page !== 0 ) {
					if ( $page >= 2 ) {
						$attr = $link . $page . '/#' . $attr;
					} else {
						$attr = $link . '#' . $attr;
					}
				}
				$node->setAttribute( 'id', $attr );
				continue;
			}
			$id = 'i-' . $i;
			if ( $page !== 0 ) {
				if ( $page >= 2 ) {
					$id = $link . $page . '/#' . $id;
				} else {
					$id = $link . '#' . $id;
				}
			}
			$node->setAttribute( 'id', $id );
		}

		return $this->htmlParser->saveHTML( ( isset( $partialID ) ) ? $domDocument->getElementById( $partialID )->childNodes : $domDocument );
	}

	public function extract_headings( $heading_tag, $html ) {
		$doc = new DOMDocument();
		if ( ! $html ) {
			return false;
		}
		@$doc->loadHTML( $html );
		$list = $doc->getElementsByTagName( $heading_tag );
		return count( $list ) ? true : false;
	}

	public function should_show( $post, $options ) {
		$show_on_page         = $options['showOnPage'];
		$show_on_post         = $options['showOnPost'];
		$show_on_top          = $options['showOnTop'];
		$show_on_category_top = $options['showOnCategoryTop'];
		$status               = \SANGO\App::get( 'status' )->get_status();
		if ( is_admin() ) {
			return false;
		}
		if ( ! $post ) {
			return false;
		}

		if ( ! $post->post_content ) {
			return false;
		}

		$field_hide = get_post_meta( $post->ID, 'sng_toc_hide', true );

		if ( $status['is_admin'] ) {
			return false;
		}

		if ( ! $show_on_category_top ) {
			if ( $status['is_category_top'] ) {
				return false;
			}
		}

		if ( ! $show_on_top ) {
			if ( $status['is_top'] && ! $status['is_paged'] ) {
				return false;
			}
		}

		if ( ! $show_on_post ) {
			if ( $post->post_type === 'post' ) {
				return false;
			}
		}

		if ( ! $show_on_page ) {
			if ( $post->post_type === 'page' ) {
				return false;
			}
		}

		if ( $field_hide ) {
			return false;
		}

		// post_typeが存在しないページでは表示しない
		if ( ! $post->post_type ) {
			return false;
		}

		return true;
	}

	public function build( $post, $options ) {
		$list_style = $options['listStyle'];
		$list_type  = $options['listType'];
		if ( ! $this->should_show( $post, $options ) ) {
			return '';
		}
		// コンテンツブロックの場合はプレビュー用にモックを表示
		if ( $post && $post->post_type === 'content_block' ) {
			$tag  = $list_style === 'main' ? $list_type : 'ul';
			$list = $this->build_mock_list( $tag, $options );
			if ( $list_style === 'main' ) {
				$html = $this->build_main_toc( $list, $options );
			} else {
				$html = $this->build_sub_toc( $list, $options );
			}
			return $html;
		}

		// カスタムCSSの登録を阻止
		App::get( 'css' )->set_enabled( false );
		$content = apply_filters( 'sng_content_block', $post->post_content );
		App::get( 'css' )->set_enabled( true );

		$list = $this->build_list( $content, $options );

		if ( ! $list ) {
			return '';
		}

		$this->register_css( $options );

		if ( $list_style === 'main' ) {
			return $this->build_main_toc( $list, $options );
		}

		return $this->build_sub_toc( $list, $options );
	}

	public function build_main_toc( $list_html, $options ) {
		$has_toc_button        = $options['hasGoToTocButton'];
		$has_toc_mobile_button = $options['hasGoToTocMobileButton'];
		$smooth_scroll         = $options['smoothScroll'] ? 'js-smooth-scroll' : '';
		$main_list_class       = $options['noBullets'] ? 'sgb-toc--no-bullets' : 'sgb-toc--bullets';
		$toggle_label          = $options['toggleLabel'];
		$toggle_close_label    = $options['toggleCloseLabel'];
		$toggle_open           = $options['isToggleOpen'];
		$has_toggle            = $options['hasToggle'];
		$has_dialog            = $options['hasDialog'];
		$title                 = $options['title'];
		$dialogTitle           = $options['dialogTitle'];
		$first_toggle_label    = $toggle_open ? $toggle_close_label : $toggle_label;
		$toc_button            = '';
		$toc_button_attr       = '';
		$toggle                = $has_toggle ? "<span class=\"toc_toggle js-toc-toggle\" data-open-toggle=\"$toggle_label\" data-close-toggle=\"$toggle_close_label\">$first_toggle_label</span>" : '';
		if ( $has_dialog ) {
			$toc_button_attr = ' data-open-dialog="true"';
		}
		if ( wp_is_mobile() && $has_toc_mobile_button ) {
			$toc_button = "<a href=\"#\" class=\"sgb-toc-button js-toc-button\" rel=\"nofollow\"$toc_button_attr><i class=\"fa fa-list\"></i><span class=\"sgb-toc-button__text\">目次へ</span></a>";
		} elseif ( ! wp_is_mobile() && $has_toc_button ) {
			$toc_button = "<a href=\"#\" class=\"sgb-toc-button js-toc-button\" rel=\"nofollow\"$toc_button_attr><i class=\"fa fa-list\"></i><span class=\"sgb-toc-button__text\">目次へ</span></a>";
		}

		$html = <<<EOF
    <div id="toc_container" class="$main_list_class $smooth_scroll" data-dialog-title="$dialogTitle">
      <p class="toc_title">$title $toggle</p>
      $list_html
      $toc_button
    </div>
EOF;
		return $html;
	}

	public function build_sub_toc( $list_html, $options ) {
		$highlight_menu   = $options['highlightMenu'] ? 'js-highlight-menu' : '';
		$heading_count    = $options['headingCounts'];
		$heading_icon     = $options['headingIcon'];
		$heading_center   = $options['headingCenter'];
		$heading_color    = $options['headingColor'];
		$heading_bg_color = $options['headingBgColor'];
		$smooth_scroll    = $options['smoothScroll'] ? 'js-smooth-scroll' : '';
		$title            = $options['title'];
		$icon             = $heading_icon ? "<i class=\"$heading_icon\"></i>" : '';
		$heading_class    = $heading_center ? 'sgb-toc-menu__title sgb-toc-menu__title--center' : 'sgb-toc-menu__title';
		$heading_style    = '';
		$menu_class       = 'sgb-toc-menu';

		if ( $smooth_scroll ) {
			$menu_class .= ' ' . $smooth_scroll;
		}

		if ( $highlight_menu ) {
			$menu_class .= ' ' . $highlight_menu;
		}

		if ( $heading_bg_color || $heading_color ) {
			$heading_style = ' style="';
			if ( $heading_bg_color ) {
				$heading_style .= "background-color: $heading_bg_color;";
			}
			if ( $heading_color ) {
				$heading_style .= "color: $heading_color;";
			}
			$heading_style .= '"';
		}
		$html = <<<EOF
    <div class="$menu_class">
      <p class="$heading_class"$heading_style>{$icon}{$title}</p>
      $list_html
    </div>
EOF;
		return $html;
	}

	public function build_list_class( $list_style, $options ) {
		$list_class  = '';
		$toggle_open = $options['isToggleOpen'];
		$has_toggle  = $options['hasToggle'];

		if ( $list_style === 'main' ) {
			$list_class = $has_toggle ? 'toc_list js-toc-list' : 'toc_list';
			if ( ! $toggle_open && $has_toggle ) {
				$list_class .= ' toc_list-close';
			}
			return $list_class;
		}
		return 'toc_widget_list no_bullets';
	}

	public function register_css( $options ) {
		$color                         = get_theme_mod( 'main_color', '#009EF3' );
		$id                            = $options['blockId'];
		$list_style                    = $options['listStyle'];
		$has_toc_button                = $options['hasGoToTocButton'];
		$toc_button_pos                = $options['goToTocButtonPos'];
		$toc_button_pos_x              = $options['goToTocButtonPosX'];
		$toc_button_pos_y              = $options['goToTocButtonPosY'];
		$has_toc_mobile_button         = $options['hasGoToTocMobileButton'];
		$toc_button_pos                = $options['goToTocButtonPos'];
		$toc_reverse_button_pos        = $toc_button_pos === 'left' ? 'right' : 'left';
		$toc_mobile_button_pos         = $options['goToTocMobileButtonPos'];
		$toc_mobile_button_pos_x       = $options['goToTocMobileButtonPosX'];
		$toc_mobile_button_pos_y       = $options['goToTocMobileButtonPosY'];
		$toc_reverse_mobile_button_pos = $toc_mobile_button_pos === 'left' ? 'right' : 'left';

		if ( $list_style !== 'main' ) {
			return;
		}

		$css = <<<EOM
    .sgb-toc-button {
      background-color: $color;
EOM;
		if ( $has_toc_button && ! wp_is_mobile() ) {
			$css .= <<<EOM
      $toc_button_pos: {$toc_button_pos_x}px;
      $toc_reverse_button_pos: auto;
      bottom: {$toc_button_pos_y}px;
EOM;
		}
		if ( $has_toc_mobile_button && wp_is_mobile() ) {
			$css .= <<<EOM
      $toc_mobile_button_pos: {$toc_mobile_button_pos_x}px;
      $toc_reverse_mobile_button_pos: auto;
      bottom: {$toc_mobile_button_pos_y}px;
EOM;
		}
		$css .= '}';
		App::get( 'css' )->register( 'toc-' . $id, $css );
	}

	public function build_list( $content, $options ) {
		$tocGenerator        = new TocGenerator();
		$list_style          = $options['listStyle'];
		$list_type           = $options['listType'];
		$heading_count       = $options['headingCounts'];
		$heading_level       = $options['headingLevel'];
		$heading_first_level = 0;
		$content             = $this->fix_content_with_paginated( $content );

		$list_class = $this->build_list_class( $list_style, $options );

		if ( $this->extract_headings( 'h1', $content ) ) {
			$heading_first_level = 1;
		} elseif ( $this->extract_headings( 'h2', $content ) ) {
			$heading_first_level = 2;
		} elseif ( $this->extract_headings( 'h3', $content ) ) {
			$heading_first_level = 3;
		} elseif ( $this->extract_headings( 'h4', $content ) ) {
			$heading_first_level = 4;
		} elseif ( $this->extract_headings( 'h5', $content ) ) {
			$heading_first_level = 5;
		}
		if ( ! $heading_first_level ) {
			return '';
		}

		$list = $tocGenerator->getHtmlMenu( $content, $heading_first_level, $heading_level );
		if ( $list_type === 'ol' && $list_style === 'main' ) {
			$list = preg_replace( '/<ul/', '<ol', $list );
			$list = preg_replace( '/<\/ul/', '</ol', $list );
		}
		$list = preg_replace( '/<ul>/', "<ul class=\"$list_class\">", $list );
		$list = preg_replace( '/<ol>/', "<ol class=\"$list_class\">", $list );
		$list = str_replace( '<a href="#http://', '<a class="js-no-scroll js-no-highlight" href="http://', $list );
		$list = str_replace( '<a href="#https://', '<a class="js-no-scroll js-no-highlight" href="https://', $list );
		$list = preg_replace( '/\n/', '', $list );

		$counts = array();
		preg_match_all( '/<li/', $list, $counts );

		// 見出しの数が少ない場合は表示しない
		if ( isset( $counts[0] ) && count( $counts[0] ) < $heading_count ) {
			return '';
		}

		return $list;
	}

	public function build_mock_list( $list_style, $options ) {
		$list_class = $this->build_list_class( $list_style, $options );

		$html = <<<EOF
    <$list_style class="$list_class">
      <li>
        <a href="#">目次 1</a>
        <$list_style>
          <li>
            <a href="#">目次 1-1</a>
          </li>
          <li>
            <a href="#">目次 1-2</a>
          </li>
        </$list_style>
      </li>
      <li>
        目次 2
        <$list_style>
          <li>
            <a href="#">目次 2-1</a>
          </li>
          <li>
            <a href="#">目次 2-2</a>
          </li>
        </$list_style>
      </li>
      <li>
        目次 3
        <$list_style>
          <li>
            <a href="#">目次 3-1</a>
          </li>
          <li>
            <a href="#">目次 3-2</a>
          </li>
        </$list_style>
      </li>
    </$list_style>
EOF;
		return $html;
	}
}
