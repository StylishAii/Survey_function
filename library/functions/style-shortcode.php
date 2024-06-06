<?php
/**
 * このファイルではショートコードの登録を行います
 */

// ウィジェットでショートコードを有効に
add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'category_description', 'do_shortcode' );
add_filter( 'term_description', 'do_shortcode' );
add_filter( 'post_tag_description', 'do_shortcode' );

// 登録
add_shortcode( 'rate', 'sng_rate_box' ); // 評価ボックス
add_shortcode( 'value', 'sng_rate_inner' ); // 評価ボックスの中身
add_shortcode( 'kanren', 'sng_entry_link' ); // 横長の関連記事を出力
add_shortcode( 'card', 'sng_card_link' ); // カードタイプの関連記事を出力
add_shortcode( 'card2', 'sng_longcard_link' ); // カードタイプ（横長）の関連記事を出力
add_shortcode( 'catpost', 'sng_output_cards_by' ); // 特定のカテゴリーの記事を好きな数だけ出力
add_shortcode( 'tagpost', 'sng_output_cards_by_tag' ); // 特定のタグの記事を好きな数だけ出力
add_shortcode( 'sanko', 'sng_othersite_link' ); // 他サイトへのリンクを出力
add_shortcode( 'sen', 'sng_sen' ); // 線を引く
add_shortcode( 'tensen', 'sng_tensen' ); // 点線を引く
add_shortcode( 'memo', 'sng_memo_box' ); // 補足説明
add_shortcode( 'alert', 'sng_alert_box' ); // 注意書き
add_shortcode( 'codebox', 'sng_code_withtag' ); // コード用のBOX
add_shortcode( 'say', 'sng_say_what' ); // 会話形式の吹き出し
add_shortcode( 'cell', 'sng_table_cell' ); // 横並び表示の中身
add_shortcode( 'yoko2', 'sng_table_two' ); // 2列表示
add_shortcode( 'yoko3', 'sng_table_three' ); // 3列表示
add_shortcode( 'mobile', 'sng_only_mobile' ); // モバイルでのみ表示
add_shortcode( 'pc', 'sng_only_pc' ); // PCでのみ表示
add_shortcode( 'category', 'sng_only_cat' ); // 特定のカテゴリーでのみ表示
add_shortcode( 'onlytag', 'sng_only_tag' ); // 特定のタグでのみ表示
add_shortcode( 'center', 'sng_text_align_center' ); // 中身を中央寄せ
add_shortcode( 'box', 'sng_insert_box' ); // ボックスを挿入
add_shortcode( 'btn', 'sng_insert_btn' ); // ボタンを挿入
add_shortcode( 'list', 'sng_insert_list' ); // ul,ol,liを装飾
add_shortcode( 'texton', 'sng_text_on_image' ); // 画像の上に文字をのせる
add_shortcode( 'open', 'sng_insert_accordion' ); // アコーディオン
add_shortcode( 'timeline', 'sng_insert_timeline' ); // タイムライン全体を囲む
add_shortcode( 'tl', 'sng_insert_tl_parts' ); // タイムライン個々の要素
add_shortcode( 'youtube', 'responsive_youtube' ); // YouTubeをレスポンシブで挿入

/*********************
 * 評価ボックス
 *********************/
// ボックス全体
function sng_rate_box( $atts, $content = null ) {
	$title   = isset( $atts['title'] ) ? '<div class="rate-title has-fa-before dfont main-c-b">' . esc_attr( $atts['title'] ) . '</div>' : '';
	$content = do_shortcode( shortcode_unautop( $content ) );
	if ( $content ) {
		return $title . '<div class="rate-box">' . $content . '</div>';
	}
}
// 行
function sng_rate_inner( $atts, $content = null ) {
	if ( isset( $atts[0] ) ) {
		$value = ( $atts[0] );
		$s     = '<i class="fa fa-star"></i>';
		$h     = get_option( 'use_fontawesome4' ) ? '<i class="fa fa-star-half-o"></i>' : '<i class="fas fa-star-half-alt"></i>';
		$n     = get_option( 'use_fontawesome4' ) ? '<i class="fa fa-star-o"></i>' : '<i class="fas fa-star rate-star-empty"></i>';
		if ( $value == '5' || $value == '5.0' ) {
			$star = $s . $s . $s . $s . $s . ' (5.0)';
		} elseif ( $value == '4.5' ) {
			$star = $s . $s . $s . $s . $h . ' (4.5)';
		} elseif ( $value == '4' || $value == '4.0' ) {
			$star = $s . $s . $s . $s . $n . ' (4.0)';
		} elseif ( $value == '3.5' ) {
			$star = $s . $s . $s . $h . $n . ' (3.5)';
		} elseif ( $value == '3' || $value == '3.0' ) {
			$star = $s . $s . $s . $n . $n . ' (3.0)';
		} elseif ( $value == '2.5' ) {
			$star = $s . $s . $h . $n . $n . ' (2.5)';
		} elseif ( $value == '2' || $value == '2.0' ) {
			$star = $s . $s . $n . $n . $n . ' (2.0)';
		} elseif ( $value == '1.5' ) {
			$star = $s . $h . $n . $n . $n . ' (1.5)';
		} else {
			$star = $s . $n . $n . $n . $n . ' (1.0)';
		}
		$endl = ( isset( $atts[1] ) ) ? ' end-rate' : '';
		if ( $content ) {
			return '<div class="rateline' . $endl . '"><div class="rate-thing">' . $content . '</div><div class="rate-star dfont">' . $star . '</div></div>';
		}
	}
}

/*********************
 * 関連記事リンクで使用する情報を取得する
 */
if ( ! function_exists( 'sng_get_entry_link_data' ) ) {
	function sng_get_entry_link_data( $id, $thumb_size, $is_date, $show_alternate_title = false ) {

		$url   = esc_url( get_permalink( $id ) );
		$src   = featured_image_src( $thumb_size, $id );
		$size  = $thumb_size === 'thumb-160' ? array( 160, 160 ) : array( 520, 300 );
		$title = esc_attr( get_the_title( $id ) );
		if ( $show_alternate_title ) {
			$title = get_post_meta( $id, 'sng_alternate_title', true ) ?: $title;
		}

		if ( get_the_post_thumbnail( $id ) ) {
			$img = get_the_post_thumbnail( $id, $thumb_size );
		} else {
			$img = '<img src="' . $src . '" alt="' . $title . '" width="' . $size[0] . '" height="' . $size[1] . '" >';
		}

		$date = $is_date ? sng_get_single_date( $id, 'sng-link-time dfont' ) : null;
		return array( $url, $title, $img, $date );
	}
}

/*********************
 * 関連記事リンク（シンプル）
 */
if ( ! function_exists( 'sng_entry_link' ) ) {
	function sng_entry_link( $atts ) {
		$output = '';
		$ids    = isset( $atts['id'] ) ? explode( ',', $atts['id'] ) : null;
		if ( ! $ids ) {
			return '';
		}
		$target             = isset( $atts['target'] ) ? ' target="_blank"' : '';
		$is_date            = isset( $atts['is_date'] ) && $atts['is_date'];
		$is_alternate_title = isset( $atts['is_alternate_title'] ) && $atts['is_alternate_title'];

		foreach ( $ids as $eachid ) {
			list($url, $title, $img, $date) = sng_get_entry_link_data( $eachid, 'thumb-160', $is_date );
			if ( $is_alternate_title ) {
				$title = get_post_meta( $eachid, 'sng_alternate_title', true ) ?: $title;
			}
			if ( $url && $title ) {
				ob_start();
				?>
		<a class="linkto table" href="<?php echo $url; ?>"<?php echo $target; ?>>
			<span class="tbcell tbimg"><?php echo $img; ?></span>
			<span class="tbcell tbtext">
				<?php echo $date; ?>
				<?php echo $title; ?>
				<?php do_action( 'sng_entry_link_after_title', $eachid ); ?>
			</span>
		</a>
				<?php
				$output .= ob_get_clean();
			}
		} // endforeach
		$output = preg_replace( '/\s+/', ' ', trim( $output ) );
		return $output;
	}
}// END get_entry_link

/*********************
 * 関連記事リンク（カードタイプ）
 */
if ( ! function_exists( 'sng_card_link' ) ) {
	function sng_card_link( $atts ) {
		$output = '';
		$html   = '';
		$ids    = isset( $atts['id'] ) ? explode( ',', $atts['id'] ) : null;
		if ( ! $ids ) {
			return '';
		}
		$target             = isset( $atts['target'] ) ? ' target="_blank"' : '';
		$is_date            = isset( $atts['is_date'] ) && $atts['is_date'];
		$is_category        = isset( $atts['is_category'] ) && $atts['is_category'];
		$is_new             = isset( $atts['is_new'] ) && $atts['is_new'];
		$is_alternate_title = isset( $atts['is_alternate_title'] ) && $atts['is_alternate_title'];

		foreach ( $ids as $eachid ) {
			list($url, $title, $img, $date) = sng_get_entry_link_data( $eachid, 'thumb-520', $is_date );
			if ( $is_alternate_title ) {
				$title = get_post_meta( $eachid, 'sng_alternate_title', true ) ?: $title;
			}
			$cat = get_the_category( $eachid );
			if ( $url && $title ) {
				ob_start();
				?>
			<div class="c_linkto_wrap">
			<a class="c_linkto" href="<?php echo $url; ?>"<?php echo $target; ?>>
				<span class="c_linkto_img_wrap"><?php echo $img; ?></span>
				<div class="c_linkto_text">
				<?php echo $title; ?>
				<?php echo $date; ?>
				<?php do_action( 'sng_card_link_after_title', $eachid ); ?>
				</div>
			</a>
				<?php
				// カテゴリーを出力
				if ( $is_category ) {
					output_catogry_link( $cat );
				}

				if ( $is_new ) {
					newmark( $eachid );
				}
				?>
			</div>
				<?php
				$html    = ob_get_clean();
				$output .= apply_filters( 'sng_card_link', $html, $eachid );
			} // endif
		} // end foreach
		return $output;
	}
}// END sng_card_link

/*********************
 * 関連記事リンク（横長カードタイプ）
 */
if ( ! function_exists( 'sng_longcard_link' ) ) {
	function sng_longcard_link( $atts ) {
		$output = '';
		$html   = '';
		$ids    = isset( $atts['id'] ) ? explode( ',', $atts['id'] ) : null;
		if ( ! $ids ) {
			return '';
		}
		$target             = isset( $atts['target'] ) ? ' target="_blank"' : '';
		$is_date            = isset( $atts['is_date'] ) ? $atts['is_date'] : true;
		$is_alternate_title = isset( $atts['is_alternate_title'] ) && $atts['is_alternate_title'];
		$is_category        = isset( $atts['is_category'] ) && $atts['is_category'];
		$is_new             = isset( $atts['is_new'] ) && $atts['is_new'];

		foreach ( $ids as $eachid ) {
			list($url, $title, $img, $date) = sng_get_entry_link_data( $eachid, 'thumb-520', true );
			$cat                            = get_the_category( $eachid );
			if ( ! $is_date ) {
				$date = '';
			}
			if ( $is_alternate_title ) {
				$title = get_post_meta( $eachid, 'sng_alternate_title', true ) ?: $title;
			}
			if ( $url && $title ) {
				ob_start();
				?>
		<div class="c_linkto_long">
			<a class="c_linkto longc_linkto" href="<?php echo $url; ?>"<?php echo $target; ?>>
			<span class="longc_img"><?php echo $img; ?></span>
			<div class="longc_content c_linkto_text">
				<?php echo $date; ?>
				<span class="longc_title"><?php echo $title; ?></span>
				<?php do_action( 'sng_longcard_link_after_title', $eachid ); ?>
			</div>
			</a>
				<?php
				// カテゴリーを出力
				if ( $is_category ) {
					output_catogry_link( $cat );
				}

				if ( $is_new ) {
					newmark( $eachid );
				}
				?>
		</div>
				<?php
				$html    = ob_get_clean();
				$output .= apply_filters( 'sng_longcard_link', $html, $eachid );
			} // endif
		} // end foreach
		return $output;
	}
}// END sng_longcard_link

if ( ! function_exists( 'sng_longcard_link_half' ) ) {
	function sng_longcard_link_half( $atts ) {
		$output = '';
		$ids    = isset( $atts['id'] ) ? explode( ',', $atts['id'] ) : null;
		if ( ! $ids ) {
			return '';
		}
		$target             = isset( $atts['target'] ) ? ' target="_blank"' : '';
		$is_date            = isset( $atts['is_date'] ) ? $atts['is_date'] : true;
		$is_category        = isset( $atts['is_category'] ) && $atts['is_category'];
		$is_new             = isset( $atts['is_new'] ) && $atts['is_new'];
		$is_alternate_title = isset( $atts['is_alternate_title'] ) && $atts['is_alternate_title'];

		foreach ( $ids as $eachid ) {
			list($url, $title, $img, $date) = sng_get_entry_link_data( $eachid, 'thumb-160', true );
			$cat                            = get_the_category( $eachid );
			if ( $is_alternate_title ) {
				$title = get_post_meta( $eachid, 'sng_alternate_title', true ) ?: $title;
			}
			if ( ! $is_date ) {
				$date = '';
			}
			if ( $url && $title ) {
				ob_start();
				?>
<article class="sidelong__article">
<a class="sidelong__link" href="<?php echo $url; ?>" <?php echo $target; ?>>
	<div class="sidelong__img">
				<?php echo $img; ?>
	</div>
	<div class="sidelong__article-info">
				<?php echo $date; ?>
	<p class="sidelong__title"><?php echo $title; ?></p>
				<?php do_action( 'sng_longcard_link_half_after_title', $eachid ); ?>
	</div>
</a>
				<?php
				// カテゴリーを出力
				if ( $is_category ) {
						output_catogry_link( $cat );
				}

				if ( $is_new ) {
						newmark( $eachid );
				}
				?>
</article>
				<?php
				$html    = ob_get_clean();
				$output .= apply_filters( 'sng_longcard_link_half', $html, $eachid );
			}
		}
		return $output;
	}
}

/*********************
 * 特定のカテゴリーの記事を好きな数だけ出力
 */
// 必要なデータを取得する関数
if ( ! function_exists( 'sng_get_cat_tag_post_data' ) ) {
	function sng_get_cat_tag_post_data( $atts ) {
		$num     = isset( $atts['num'] ) ? esc_attr( $atts['num'] ) : '4'; // 出力数。入力なしなら4
		$orderby = isset( $atts['orderby'] ) ? $atts['orderby'] : 'date'; // 日付順かランダムか
		$order   = isset( $atts['order'] ) ? ( $atts['order'] ) : 'DESC'; // 降順or昇順
		$type    = 'kanren'; // カードのタイプ
		if ( isset( $atts['type'] ) ) {
			if ( $atts['type'] == 'card' ) {
				$type = 'card';
			} elseif ( $atts['type'] == 'card2' ) {
				$type = 'card2';
			} elseif ( $atts['type'] == 'card3' ) {
				$type = 'card3';
			}
		}
		$is_date = isset( $atts['is_date'] );
		return array( $num, $orderby, $order, $type, $is_date );
	}
}

// 記事の配列からリンク一覧のHTMLを生成する関数
if ( ! function_exists( 'sng_get_cat_tag_post_output' ) ) {
	function sng_get_cat_tag_post_output(
		$array_posts,
		$type,
		$is_date,
		$infeed = false,
		$column = 2,
		$columnMobile = 1,
		$showCategory = false,
		$showNewLabel = false,
		$showAltenateTitle = false
	) {
		if ( ! $array_posts ) {
			return '';
		}
		$ad           = get_theme_mod( 'ad_infeed' );
		$ad2          = get_theme_mod( 'ad_infeed2' );
		$ad3          = get_theme_mod( 'ad_infeed3' );
		$ad4          = get_theme_mod( 'ad_infeed4' );
		$ad_pos1      = get_theme_mod( 'ad_infeed_pos1', -1 );
		$ad_pos2      = get_theme_mod( 'ad_infeed_pos2', -1 );
		$ad_pos3      = get_theme_mod( 'ad_infeed_pos3', -1 );
		$ad_enabled   = get_theme_mod( 'enable_ad_infeed', false ) && $infeed;
		$ad_pos_array = $ad_enabled ? array( $ad_pos1, $ad_pos2, $ad_pos3 ) : array();

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
						)
					);
				}
				break;
			case 'card3':
				$shown_count = 0;
				$class_name  = 'sidelong sidelong--shade';
				if ( $column ) {
					$class_name .= "sidelong--column-{$column}";
				}
				if ( $columnMobile ) {
					$class_name .= " sidelong--column-mobile-{$columnMobile}";
				}
				foreach ( $array_posts as $i => $post ) {
					if ( $ad2 && is_numeric( array_search( $i + 1 + $shown_count, $ad_pos_array ) ) ) {
						++$shown_count;
						$output .= "<div class=\"sidelong__article\">$ad2</div>";
					}
					$output .= sng_longcard_link_half(
						array(
							'id'                 => $post->ID,
							'is_alternate_title' => $showAltenateTitle,
						)
					);
				}
				$output = '<div class="' . $class_name . '">' . $output . '</div>';
				break;
			// sng_sidelong_card
			default:
				foreach ( $array_posts as $post ) {
					$output .= sng_entry_link(
						array(
							'id'                 => $post->ID,
							'is_date'            => $is_date,
							'is_alternate_title' => $showAltenateTitle,
						)
					);
				}
		}
		return $output;
	}
}


function sng_output_cards_by( $atts ) {

	list($num, $orderby, $order, $type, $is_date) = sng_get_cat_tag_post_data( $atts );

	// どのカテゴリーの記事を出力するか（複数指定を配列に）
	$catid = isset( $atts['catid'] ) ? explode( ',', $atts['catid'] ) : null;

	// 除外するカテゴリー（オプション）
	$notin = isset( $atts['notin'] ) ? explode( ',', $atts['notin'] ) : null;

	// 子カテゴリを含める（オプション）
	if ( $catid && isset( $atts['include_children'] ) ) {
		foreach ( $catid as $parent_id ) {
			$child_ids = get_term_children( $parent_id, 'category' );
			$catid     = array_merge( $catid, $child_ids );
		}
	}

	if ( $catid ) {
		$array_posts = get_posts(
			array(
				'category__in' => $catid,
				'numberposts'  => $num,
				'orderby'      => $orderby,
				'order'        => $order,
				'post_type'    => 'any',
			)
		);
	} else {
		$array_posts = get_posts(
			array(
				'category__not_in' => $notin,
				'numberposts'      => $num,
				'orderby'          => $orderby,
				'order'            => $order,
			)
		);
	}

	return sng_get_cat_tag_post_output( $array_posts, $type, $is_date );
}

/*********************
 * 特定のタグの記事を好きな数だけ出力
 *********************/
function sng_output_cards_by_tag( $atts ) {
	list($num, $orderby, $order, $type, $is_date) = sng_get_cat_tag_post_data( $atts );

	// どのタグの記事を出力するか（複数指定を配列に）
	$tagid = isset( $atts['id'] ) ? explode( ',', $atts['id'] ) : null;
	if ( ! $tagid ) {
		return '';
	}

	$array_posts = get_posts(
		array(
			'tag__in'     => $tagid,
			'numberposts' => $num,
			'orderby'     => $orderby,
			'exclude'     => get_the_ID(),
			'order'       => $order,
			'post_type'   => 'any',
		)
	);

	return sng_get_cat_tag_post_output( $array_posts, $type, $is_date );
}

/*********************
 * 他サイトへのリンクカード
 *********************/
function sng_othersite_link( $atts ) {
	$href   = isset( $atts['href'] ) ? esc_url( $atts['href'] ) : null;
	$title  = isset( $atts['title'] ) ? esc_attr( $atts['title'] ) : null;
	$site   = isset( $atts['site'] ) ? '<span>' . esc_attr( $atts['site'] ) . '</span>' : '';
	$target = isset( $atts['target'] ) ? 'target="_blank"' : '';
	$rel    = isset( $atts['rel'] ) ? ' rel="nofollow noopener noreferrer"' : ' rel="noopener noreferrer"';
	if ( $href && $title ) { // タイトルとURLがある場合のみ出力
		$output = <<<EOF
  <a class="reference table" href="{$href}" {$target}{$rel}>
    <span class="tbcell refttl">参考</span>
    <span class="tbcell refcite">{$title}{$site}</span>
  </a>
EOF;
		return $output;
	} else {
		return '<span class="red">参考記事のタイトルとURLを入力してください</span>';
	}
} // END sng_othersite_link

/*********************
 * 線・点線を出力
 *********************/
function sng_sen( $atts ) {
	return '<hr>'; }
function sng_tensen( $atts ) {
	return '<hr class="dotted">'; }

/*********************
 * 補足説明（メモ）
 *********************/
function sng_memo_box( $atts, $content = null ) {
	$title = isset( $atts['title'] ) ? '<div class="memo_ttl dfont"> ' . esc_attr( $atts['title'] ) . '</div>' : '';
	$class = isset( $atts['class'] ) ? esc_attr( $atts['class'] ) : null;
	if ( $content ) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		$output  = <<<EOF
<div class="memo {$class}">{$title}{$content}</div>
EOF;
		return $output;
	}
}

/*********************
 * 注意書き
 *********************/
function sng_alert_box( $atts, $content = null ) {
	$title = isset( $atts['title'] ) ? '<div class="memo_ttl dfont"> ' . esc_attr( $atts['title'] ) . '</div>' : '';
	if ( $content ) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		$output  = <<<EOF
<div class="memo alert">{$title}{$content}</div>
EOF;
		return $output;
	}
}

/*********************
 * タグ付きのソースコード枠
 *********************/
function sng_code_withtag( $atts, $content = null ) {
	$title = isset( $atts['title'] ) ? '<span><i class="fa fa-code"></i> ' . esc_attr( $atts['title'] ) . '</span>' : '';
	if ( $content ) {
		$output = <<<EOF
  <div class="pre_tag">{$title}{$content}</div>
EOF;
		return $output;
	}
}
/*********************
 * 会話ふきだし
 *********************/
function sng_say_what( $atts, $content = null ) {
	$img  = ( isset( $atts['img'] ) ) ? esc_url( $atts['img'] ) : esc_url( get_option( 'say_image_upload' ) );
	$name = ( isset( $atts['name'] ) ) ? esc_attr( $atts['name'] ) : esc_attr( get_option( 'say_name' ) );
	if ( isset( $atts['from'] ) ) {
		$from = ( $atts['from'] == 'right' ) ? 'right' : 'left'; // 入力が無ければleftに
	} else {
		$from = 'left';
	}
	if ( $from == 'right' ) { // 右に吹き出し
		$output = <<<EOF
    <div class="say {$from}">
      <div class="chatting"><div class="sc">{$content}</div></div>
      <p class="faceicon"><img src="{$img}" width="110"><span>{$name}</span></p>
    </div>
EOF;
	} else { // 左に吹き出し
		$output = <<<EOF
    <div class="say {$from}">
      <p class="faceicon"><img src="{$img}" width="110"><span>{$name}</span></p>
      <div class="chatting"><div class="sc">{$content}</div></div>
    </div>
EOF;
	} // endif
	return $output;
}

/*********************
 * テーブルのセル(後述の関数で利用)
 *********************/
function sng_table_cell( $atts, $content = null ) {
	$content = do_shortcode( shortcode_unautop( $content ) );
	if ( $content ) {
		return '<div class="cell">' . $content . '</div>';
	}
}

/*********************
 * 2列横並び
 *********************/
function sng_table_two( $atts, $content = null ) {
	$layout  = ( $atts && $atts[0] == 'responsive' ) ? 'tbrsp' : '';
	$content = do_shortcode( shortcode_unautop( $content ) );
	if ( $content ) {
		return '<div class="shtb2 ' . $layout . '">' . $content . '</div>';
	}
}

/*********************
 * 3列横並び
 *********************/
function sng_table_three( $atts, $content = null ) {
	$layout  = ( $atts && $atts[0] == 'responsive' ) ? 'tbrsp' : '';
	$content = do_shortcode( shortcode_unautop( $content ) );
	if ( $content ) {
		return '<div class="shtb3 ' . $layout . '">' . $content . '</div>';
	}
}

/*********************
 * モバイルでのみ表示
 *********************/
function sng_only_mobile( $atts, $content = null ) {
	if ( $content && wp_is_mobile() ) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		return $content;
	}
}

/*********************
 * PCでのみ表示
 *********************/
function sng_only_pc( $atts, $content = null ) {
	if ( $content && ! wp_is_mobile() ) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		return $content;
	}
}
/*********************
 * 特定のカテゴリーでのみ表示
 *********************/
function sng_only_cat( $atts, $content = null ) {
	$cat_id = ( isset( $atts['id'] ) ) ? $atts['id'] : null;
	$cat_id = explode( ',', $cat_id );
	if ( $content && in_category( $cat_id ) ) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		return $content;
	}
}
/*********************
 * 特定のタグでのみ表示
 *********************/
function sng_only_tag( $atts, $content = null ) {
	$tag_id = ( isset( $atts['id'] ) ) ? $atts['id'] : null;
	$tag_id = explode( ',', $tag_id );
	if ( $content && has_tag( $tag_id ) ) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		return $content;
	}
}

/*********************
 * 中身を中央寄せにするコード
 *********************/
function sng_text_align_center( $atts, $content = null ) {
	if ( $content ) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		return '<div class="center">' . $content . '</div>';
	}
}

/*********************
 * ボックスデザインのショートコード
 *********************/
function sng_insert_box( $atts, $content = null ) {
	if ( isset( $atts ) && $content ) {
		$class   = ( isset( $atts['class'] ) ) ? esc_attr( $atts['class'] ) : null;
		$title   = ( isset( $atts['title'] ) ) ? $atts['title'] : null;
		$content = do_shortcode( shortcode_unautop( $content ) );
		$output  = '';
		if ( ! $title && $class ) { // タイトルが無いとき
			$output = <<<EOF
  <div class="sng-box {$class}">{$content}</div>
EOF;
		} elseif ( $title && $class ) { // タイトルがあるとき
			$output = <<<EOF
  <div class="sng-box {$class}"><div class="box-title">{$title}</div><div class="box-content">{$content}</div></div>
EOF;
		}
		return $output;
	} // end if atts && content
}

/*********************
 * ボタンデザインのショートコード
 */

if ( ! function_exists( 'sng_insert_btn' ) ) {
	function sng_insert_btn( $atts, $content = null ) {
		if ( isset( $atts ) && $content ) {
			$href    = isset( $atts['href'] ) ? 'href="' . esc_url( $atts['href'] ) . '"' : null;
			$class   = isset( $atts['class'] ) ? esc_attr( $atts['class'] ) : null;
			$target  = ( isset( $atts['target'] ) && preg_match( '/_blank/', $atts['target'] ) ) ? ' target="_blank"' : null;
			$yoko    = ( isset( $atts['0'] ) && $atts['0'] == 'yoko' ) ? 'yoko' : null;
			$rel_val = isset( $atts['rel'] ) ? $atts['rel'] : '';

			// rel：target="_blank"の場合は必ずnoopener noreferrerを付与する
			if ( $target ) {
				if ( preg_match( '/nofollow/', $rel_val ) ) {
					$rel_val = 'nofollow noopener noreferrer';
				} else {
					$rel_val = 'noopener noreferrer';
				}
			}
			$rel = $rel_val ? ' rel="' . $rel_val . '"' : null;

			if ( $class ) {
				$output  = ( ! $yoko ) ? '<p>' : ''; // 横並びならpなし
				$output .= <<<EOF
  <a {$href} class="btn {$class}"{$target}{$rel}>{$content}</a>
EOF;
				if ( ! $yoko ) {
					$output .= '</p>'; } // 横並びならpなし
				return $output;
			} // end if class
		} // end if atts && content
	}
}

/*********************
 * ul ol liのショートコード
 *********************/
function sng_insert_list( $atts, $content = null ) {
	if ( $content ) {
		// ul内にpタグが入ってしまう場合に以下のコメントアウトを解除
		// $search = array('<p>','</p>');
		// $content = str_replace($search,'',$content);
		$class = ( isset( $atts['class'] ) ) ? esc_attr( $atts['class'] ) : null;
		$title = ( isset( $atts['title'] ) ) ? '<div class="list-title">' . esc_attr( $atts['title'] ) . '</div>' : null;
		return '<div class="' . $class . '">' . $title . $content . '</div>';
	} // endif content
}
/*********************
 * YouTubeをレスポンシブに
 */
if ( ! function_exists( 'responsive_youtube' ) ) {
	function responsive_youtube( $atts, $content = null ) {
		if ( $content ) {
			return '<div class="youtube">' . $content . '</div>';
		}
	}
}

/*********************
 * 画像の上に文字をのせる
 *********************/
function sng_text_on_image( $atts, $content = null ) {
	$src    = ( isset( $atts['img'] ) ) ? esc_url( $atts['img'] ) : null;
	$title  = ( isset( $atts['title'] ) ) ? esc_attr( $atts['title'] ) : '';
	$width  = ( isset( $atts['width'] ) ) ? esc_attr( $atts['width'] ) : '';
	$height = ( isset( $atts['height'] ) ) ? esc_attr( $atts['height'] ) : '';

	if ( $src ) {
		$output = <<<EOF
<div class="textimg"><p class="dfont">{$title}</p><img src="{$src}" width="{$width}" height="{$height}"></div>
EOF;
		return $output;
	}
}
/*********************
 * アコーディオン
 *********************/
function sng_insert_accordion( $atts, $content = null ) {
	$title   = isset( $atts['title'] ) ? $atts['title'] : null;
	$content = do_shortcode( shortcode_unautop( $content ) );
	$randid  = mt_rand( 1, 99999 );
	if ( $title ) {
		return '<div class="accordion main_c"><input type="checkbox" id="label' . $randid . '" class="accordion_input" /><label for="label' . $randid . '">' . $title . '</label><div class="accordion_content">' . $content . '</div></div>';
	} else {
		return '<span class="red">アコーディオンにtitleを入力してください</span>';
	}
}
/*********************
 * タイムライン
 *********************/
function sng_insert_timeline( $atts, $content = null ) {
	if ( $content ) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		$output  = '<div class="tl">' . $content . '</div>';
		return $output;
	}
}
function sng_insert_tl_parts( $atts, $content = null ) {
	$label = isset( $atts['label'] ) ? '<div class="tl_label">' . $atts['label'] . '</div>' : null;
	$title = isset( $atts['title'] ) ? '<div class="tl_title">' . $atts['title'] . '</div>' : null;
	if ( $content ) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		$content = '<div class="tl_main">' . $content . '</div>';
	}
	$marker = '<div class="tl_marker main-bdr main-bc"></div>';
	return '<div class="tl-content main-bdr">' . $label . $title . $content . $marker . '</div>';
}
