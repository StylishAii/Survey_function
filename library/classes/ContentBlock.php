<?php

namespace SANGO;

class ContentBlock {


	private $table_name = 'sgb_cb_click';
	private $is_lazy    = false;

	public function set_lazy_mode( $is_lazy ) {
		$this->is_lazy = $is_lazy;
	}

	public function is_lazy_mode() {
		return $this->is_lazy;
	}

	public function init() {
		$this->register_content_block();
		if ( is_user_logged_in() ) {
			$this->add_custom_column();
			add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
			add_action( 'save_post', array( $this, 'save_post' ) );
			$this->register_content_block_as_block_patterns();
		}
		$this->exclude_from_search();
		$this->register_shortcode();
		add_filter( 'sng_content_block', 'do_blocks', 9 );
		add_filter( 'sng_content_block', 'do_shortcode' );
		add_filter( 'sng_content_block', 'wptexturize' );
		add_filter( 'sng_content_block', 'convert_smilies', 20 );
		add_filter( 'sng_content_block', 'prepend_attachment' );
		add_filter( 'sng_content_block', 'wp_filter_content_tags' );
		add_filter( 'sng_content_block', 'wp_replace_insecure_home_url' );
		// @deprecated
		add_action(
			'widgets_init',
			function () {
				$dirName = __DIR__;
				require_once $dirName . '/ContentBlockWidget.php';
				register_widget( 'ContentBlockWidget' );
			}
		);
	}

	public function createDb() {
		global $wpdb;
		$table_name      = $wpdb->prefix . $this->table_name;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE IF NOT EXISTS $table_name(
      cb_click_id BIGINT(20) NOT NULL AUTO_INCREMENT,
      cb_id BIGINT(20) NOT NULL,
      cb_click_date DATETIME NOT NULL,
      cb_click_url VARCHAR(255),
      cb_click_label VARCHAR(255),
      PRIMARY KEY (cb_click_id)
    ) $charset_collate";
		dbDelta( $sql );
	}

	public function search( $option ) {
		global $wpdb;
		$table_name  = $wpdb->prefix . $this->table_name;
		$query       = '';
		$id          = isset( $option['id'] ) ? $option['id'] : null;
		$unit        = isset( $option['unit'] ) ? $option['unit'] : 'week';
		$url         = isset( $option['url'] ) ? $option['url'] : null;
		$label       = isset( $option['label'] ) ? $option['label'] : null;
		$offset      = isset( $option['offset'] ) ? $option['offset'] : 0;
		$startOffset = $offset - 1;
		$start       = '';
		$end         = '';
		if ( $unit === 'month' ) {
			$query .= "SELECT DATE(cb_click_date) AS unit, DATE(cb_click_date) as date, COUNT(*) AS count FROM $table_name";
			$start  = date( 'Y-m-01', strtotime( "$offset month" ) );
			$end    = date( 'Y-m-t', strtotime( "$offset month" ) );
		}
		if ( $id ) {
			$query .= " WHERE cb_id = $id";
			$query .= " AND cb_click_date BETWEEN '$start' AND '$end'";
		} else {
			$query .= " WHERE cb_click_date BETWEEN '$start' AND '$end'";
		}
		if ( $url ) {
			$query .= " AND cb_click_url LIKE '%$url%'";
		}
		if ( $label ) {
			$query .= " AND cb_click_label LIKE '%$label%'";
		}
		$query .= ' GROUP BY date ORDER BY date';
		$result = $wpdb->get_results( $query );
		$result = $this->format_search_result( $result, $start, $end );
		return $result;
	}

	private function format_search_result( $result, $start, $end ) {
		$result_array = array();
		$i            = 0;
		$max          = 30;
		$m            = date( 'm', strtotime( $start ) );
		while ( $i <= $max ) {
			$date     = date( 'Y-m-d', strtotime( "$i day", strtotime( $start ) ) );
			$currentM = date( 'm', strtotime( $date ) );
			if ( $currentM !== $m ) {
				break;
			}
			$index = array_search( $date, array_column( $result, 'unit' ) );
			if ( $index ) {
				$result_array[] = $result[ $index ];
			} else {
				$result_array[] = array(
					'unit'  => $date,
					'count' => 0,
					'date'  => $date,
				);
			}
			++$i;
		}
		return $result_array;
	}

	public function notice() {
		$post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
		if ( ! preg_match( '/content_block/', $post_type ) ) {
			return;
		}
		$html = <<< EOM
<div class="notice" style="border:none; background-color: transparent; box-shadow: none; padding-left: 0;">
コンテンツブロックとはあらかじめサイトで使う部品を記事として登録しておく機能です。詳しくは<a href="https://saruwakakun.com/sango/sango-content-block" target="_blank" rel="noopener noreferrer">こちら</a>
</div>
EOM;
		echo $html;
	}

	// コンテンツブロックの登録
	public function register_content_block() {
		register_post_type(
			'content_block',
			array(
				'labels'        => array(
					'name'      => 'コンテンツブロック',
					'all_items' => 'ブロック一覧',
				),
				'description'   => 'コンテンツブロックとはあらかじめサイトで使う部品を記事として登録しておく機能です。',
				'taxonomies'    => array( 'content_block_category' ),
				'public'        => true,
				'has_archive'   => false,
				'show_in_rest'  => true,
				'menu_position' => 20,
				'map_meta_cap'  => true,
				'menu_icon'     => App::getUrl( 'library/images/content-block.png' ),
			)
		);

		add_action( 'admin_notices', array( $this, 'notice' ), 10 );
		register_taxonomy(
			'content_block_category',
			'content_block',
			array(
				'hierarchical'      => true,
				'query_var'         => true,
				'label'             => 'カテゴリー',
				'show_in_menu'      => true,
				'show_admin_column' => true,
				'singular_label'    => 'カテゴリー',
				'show_in_rest'      => true,
				// 'public' => true,
				'show_ui'           => true,
			)
		);
		add_action(
			'restrict_manage_posts',
			function ( $post_type ) {
				if ( 'content_block' === $post_type ) {
					$taxonomy = 'content_block_category';
					wp_dropdown_categories(
						array(
							'show_option_all' => 'すべてのカテゴリー',
							'orderby'         => 'name',
							'selected'        => get_query_var( $taxonomy ),
							'hide_empty'      => 0,
							'name'            => $taxonomy,
							'taxonomy'        => $taxonomy,
							'value_field'     => 'slug',
							'hierarchical'    => 1,
						)
					);
				}
			}
		);
	}

	public function add_admin_menu() {
		$sango_logo = sng_logo();
		add_meta_box( 'sng-content-block-setting', "{$sango_logo} SANGO設定", array( $this, 'add_custom_field' ), 'content_block', 'side' );
	}

	public function pv_field() {
		global $post;
		$meta_value = get_post_meta( $post->ID, 'sng_content_block_pv_count', true );
		$data       = '内部リンクのクリック率等を計測する';
		$check      = ( $meta_value ) ? 'checked' : '';
		echo '<p class="sng-field-title"><img draggable="false" role="img" class="emoji" alt="🔢" src="https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/svg/1f522.svg"> PV設定</p>';
		echo '<div style="margin-top: 10px;"><label><input type="checkbox" name="sng_content_block_pv_count" value="' . $data . '" ' . $check . '>' . $data . '</label></div>';
	}

	public function patterns_field() {
		global $post;
		$meta_value = get_post_meta( $post->ID, 'sng_content_block_disable_block_pattern', true );
		$data       = 'ブロックパターンとして登録しない';
		$check      = ( $meta_value ) ? 'checked' : '';
		echo '<p class="sng-field-title"><img draggable="false" role="img" class="emoji" alt="🧩" src="https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/svg/1f9e9.svg"> ブロックパターン設定</p>';
		echo '<div style="margin-top: 10px;"><label><input type="checkbox" name="sng_content_block_disable_block_pattern" value="' . $data . '" ' . $check . '>' . $data . '</label></div>';
	}

	public function add_custom_field() {
		$this->pv_field();
		$this->patterns_field();
		$css = <<< EOM
    .interface-complementary-area .sng-field-title,
    .sng-field-title {
      border-bottom: 2px solid #58a9ef;
      font-size: 13px;
      margin-top: 30px !important;
      font-weight: bold;
    }
    .sng-edit-logo {
      width: 16px;
      height: 16px;
      vertical-align: middle;
    }
    #sng-content-block-setting .hndle {
      justify-content: flex-start;
    }
    #sng-content-block-setting .hndle svg {
      margin-right: 5px;
      width: 16px;
      height: 16px;
    }
EOM;
		echo '<style>' . $css . '</style>';
	}

	public function count_click( $id, $meta ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$count_key  = 'content_block_click_count';
		$num        = get_post_meta( $id, $count_key, true );
		$wpdb->insert(
			$table_name,
			array(
				'cb_id'          => $id,
				'cb_click_label' => $meta['label'],
				'cb_click_url'   => $meta['url'],
				'cb_click_date'  => date( 'Y-m-d H:i:s' ),
			)
		);
		if ( $num == '' ) {
			$num = 1;
			delete_post_meta( $id, $count_key );
			add_post_meta( $id, $count_key, '1' );
		} else {
			++$num;
			update_post_meta( $id, $count_key, $num );
		}
		return array(
			'count' => $num,
		);
	}

	public function count_pv( $id ) {
		$count_key = 'content_block_pv_count';
		$num       = get_post_meta( $id, $count_key, true );
		if ( $num == '' ) {
			$num = 1;
			delete_post_meta( $id, $count_key );
			add_post_meta( $id, $count_key, '1' );
		} else {
			++$num;
			update_post_meta( $id, $count_key, $num );
		}
		return array(
			'count' => $num,
		);
	}

	public function reset( $id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		update_post_meta( $id, 'content_block_pv_count', 0 );
		update_post_meta( $id, 'content_block_click_count', 0 );
		$wpdb->delete(
			$table_name,
			array(
				'cb_id' => $id,
			)
		);
	}

	public function save_post( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		// クイックポストの時は何もしない
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'inline-save' ) {
			return $post_id;
		}
		if ( function_exists( 'sng_update_custom_option_fields' ) ) {
			sng_update_custom_option_fields( $post_id, 'sng_content_block_pv_count' );
			sng_update_custom_option_fields( $post_id, 'sng_content_block_disable_block_pattern' );
		}
	}

	public function add_custom_column() {
		add_filter(
			'manage_content_block_posts_columns',
			function ( $columns ) {
				return array_merge(
					$columns,
					array(
						'patterns' => __( 'ブロックパターン', 'block pattern' ),
						'pv'       => __( '計測', 'measure' ),
						'reset'    => __( '計測データのリセット', 'reset' ),
					)
				);
			}
		);

		add_action(
			'manage_content_block_posts_custom_column',
			function ( $column_key, $post_id ) {
				if ( $column_key == 'pv' ) {
					$pv               = get_post_meta( $post_id, 'content_block_pv_count', true );
					$clicked          = get_post_meta( $post_id, 'content_block_click_count', true );
					$ratio            = $clicked ? round( $clicked / $pv * 100, 2 ) : 0;
					$analyticsEnabled = get_post_meta( $post_id, 'sng_content_block_pv_count', true );

					if ( ! $pv ) {
						$pv = 0;
					}

					if ( ! $clicked ) {
						$clicked = 0;
					}

					if ( strlen( $analyticsEnabled ) ) {
						?>
				<div class='js-cb-label' data-id="<?php echo $post_id; ?>">
				<div>PV数: <?php echo $pv; ?></div>
				<div>ボタンクリック数: <?php echo $clicked; ?></div>
				<div>ボタンクリック率: <?php echo $ratio; ?>%</div>
			</div>
						<?php
					} else {
						echo '無効';
					}
				} elseif ( $column_key == 'patterns' ) {
							$patterns = get_post_meta( $post_id, 'content-block-disable-patterns', true );
					if ( ! strlen( $patterns ) ) {
						echo '有効';
					} else {
						echo '無効';
					}
				} elseif ( $column_key == 'reset' ) {
					?>
			<button class="button js-cb-reset" type="button" data-id="<?php echo $post_id; ?>">リセット</button>
					<?php
				}
			},
			10,
			2
		);
	}

	public function exclude_from_search() {
		global $wp_post_types;
		if ( post_type_exists( 'content_block' ) ) {
			$wp_post_types['content_block']->exclude_from_search = true;
		}
	}

	// 利用可能なコンテンツブロックを取得
	public function available_content_blocks() {
		return get_posts(
			array(
				'numberposts' => -1,
				'post_type'   => 'content_block',
				'post_status' => 'publish',
			)
		);
	}

	// 利用可能なコンテンツブロックの(id => 名前)の一覧をオブジェクトの配列で出力
	// 例
	// [ '25' => '自己紹介', '10' => '記事下用' ]
	public function available_content_block_name_list() {
		$posts = $this->available_content_blocks();
		if ( ! $posts ) {
			return null;
		}

		$blocks = array();
		foreach ( $posts as $post ) {
			$blocks[ $post->ID ] = $post->post_title;
		}
		return $blocks;
	}

	public function import( $data ) {
		global $user_ID;
		remove_filter( 'content_save_pre', 'wp_filter_post_kses' );
		$imported_maps = array();

		foreach ( $data as $item ) {
			$content                  = preg_replace( '/\\"/', '"', $item['post_content'] );
			$content                  = preg_replace( '/ "/', '"', $content );
			$post_id                  = wp_insert_post(
				wp_slash(
					array(
						'post_date'     => date( 'Y-m-d H:i:s' ),
						'post_content'  => $content,
						'post_title'    => $item['post_title'],
						'post_name'     => $item['post_name'],
						'post_type'     => $item['post_type'],
						'post_author'   => $user_ID,
						'post_status'   => 'publish',
						'post_category' => array( 0 ),
					)
				)
			);
			$old_id                   = $item['ID'];
			$imported_maps[ $old_id ] = $post_id;
		}
		return $imported_maps;
	}

	public function register_content_block_as_block_patterns() {
		$availableBlocks = $this->available_content_blocks();
		if ( ! function_exists( 'register_block_pattern_category' ) ) {
			return;
		}
		register_block_pattern_category(
			'sgb/content-block',
			array( 'label' => 'SANGO コンテンツブロック' )
		);

		foreach ( $availableBlocks as $block ) {
			$content = $block->post_content;
			$title   = $block->post_title;
			$id      = $block->ID;
			$disable = get_post_meta( $block->ID, 'sng_content_block_disable_block_pattern', true );
			if ( strlen( $disable ) > 0 ) {
				return;
			}
			register_block_pattern(
				'sgb/' . $id,
				array(
					'title'      => $title,
					'categories' => array( 'sgb/content-block' ),
					'content'    => $content,
				)
			);
		}
	}

	public function register_shortcode() {
		add_shortcode( 'content_block', array( $this, 'get_shortcode_content_block' ) );
	}

	public function get_shortcode_content_block( $atts ) {
		$class = isset( $atts['class'] ) ? $atts['class'] : '';
		if ( ! isset( $atts['id'] ) ) {
			return '';
		}
		return $this->get_content_block( $atts['id'], $class );
	}

	public function get_meta( $post_id ) {
		$pv               = get_post_meta( $post_id, 'content_block_pv_count', true );
		$clicked          = get_post_meta( $post_id, 'content_block_click_count', true );
		$analyticsEnabled = get_post_meta( $post_id, 'sng_content_block_pv_count', true );
		$ratio            = $clicked ? round( $clicked / $pv * 100, 2 ) : 0;
		$edit_url         = "post.php?post=$post_id&action=edit";

		return array(
			'pv'               => $pv,
			'clicked'          => $clicked,
			'ratio'            => $ratio,
			'editUrl'          => $edit_url,
			'analyticsEnabled' => $analyticsEnabled,
		);
	}

	public function get_content_block( $id, $class = '', $wrap = true ) {
		if ( is_admin() ) {
			return '';
		}

		if ( ! $id ) {
			return;
		}
		$the_post = get_post( $id );
		// コンテンツブロックが見つからない場合
		if ( ! $the_post ) {
			return '';
		}

		if ( $the_post->post_type !== 'content_block' ) {
			return '';
		}
		// コンテンツブロックが非公開の場合は、ログインユーザーのみ閲覧可
		if ( ! ( 'publish' === $the_post->post_status || is_user_logged_in() ) ) {
			return '';
		}
		// phpcs:ignore

		$admin_html = '';

		$edit_url = get_edit_post_link( $id );

		$pv_count = get_post_meta( $id, 'sng_content_block_pv_count', true );

		$class_name = 'sgb-content-block post-' . $id;

		if ( $pv_count && ! is_user_logged_in() ) {
			$class_name .= ' js-sgb-content-block';
		}

		if ( $class ) {
			$class_name .= ' ' . $class;
		}

		if ( is_user_logged_in() ) {
			$admin_html  = "<a class=\"sgb-content-block__admin-link\" href=\"$edit_url\" target=\"_blank\">このブロックを編集</a>";
			$class_name .= ' sgb-content-block--admin';
		}

		$content = apply_filters( 'sng_content_block', $the_post->post_content );

		if ( ! $wrap ) {
			return $content;
		}

		return '<div class="' . $class_name . '" data-id="' . $id . '">' .
		$admin_html .
		$content .
		'</div>';
	}
}
