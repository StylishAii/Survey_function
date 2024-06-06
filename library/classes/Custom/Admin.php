<?php

namespace SANGO\Custom;

use SANGO\App;

class Admin extends Custom {

	public function init() {
		$this->register_build_dir( '/library/functions/custom/admin' );
		add_action( 'admin_print_styles', array( $this, 'admin_custom_assets' ) );
		add_action( 'admin_menu', array( $this, 'admin_settings' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'manage_custom_column' ), 10, 2 );
		add_action( 'manage_pages_custom_column', array( $this, 'manage_custom_column' ), 10, 2 );
		add_action( 'admin_head-edit.php', array( $this, 'admin_head_edit' ), 100 );
		add_filter( 'manage_posts_columns', array( $this, 'manage_columns' ) );
		add_filter( 'manage_pages_columns', array( $this, 'manage_columns' ) );
	}

	public function update_option( $option_name ) {
		if ( ! isset( $_POST[ $option_name ] ) ) {
			return false;
		}
		$builder = App::get( 'builder' );
		$method  = $builder->getOptionUpdateMethod( $option_name );

		if ( $method === 'option' ) {
			return update_option( $option_name, stripslashes( $_POST[ $option_name ] ) );
		}
		return set_theme_mod( $option_name, stripslashes( $_POST[ $option_name ] ) );
	}

	// 配列で指定したテーマオプションを更新する
	public function update_options( $option_names ) {
		$total_result = true;
		foreach ( $option_names as $name ) {
			$result       = $this->update_option( $name );
			$total_result = ( $result && $total_result );
		}
		return $total_result;
	}

	public function print_custom_page() {
		// ユーザーが必要な権限を持つか確認
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'Permission error.' ) );
		}
		$page = isset( $_GET['page'] ) ? $_GET['page'] : '';
		if ( ! preg_match( '/sng_admin_settings/', $page ) ) {
			return;
		}
		wp_enqueue_script( 'sng-admin-script', get_template_directory_uri() . '/library/js/admin.build.js', false, false, true );
		$builder = App::get( 'builder' );
		$builder->setImage( get_template_directory_uri() . '/library/images' );
		$this->build();
		wp_localize_script( 'sng-admin-script', 'sangoConfig', $builder->build() );
		// オプションをビルド
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$options = $builder->getUpdateOptions();
			$this->update_options( $options );
			App::get( 'cache' )->clear_all();
		}
		?>
		<div id="sango-admin"></div>
		<?php
	}

	public function admin_custom_assets() {
		$page = isset( $_GET['page'] ) ? $_GET['page'] : '';
		// SANGO Xの管理画面でのみ読み込み
		if ( ! preg_match( '/sng_admin_settings/', $page ) ) {
			return;
		}

		// 画像アップロードができるようにするため
		wp_enqueue_media();
		wp_enqueue_style( 'sng-fontawesome', 'https://use.fontawesome.com/releases/v5.11.2/css/all.css' );
		wp_enqueue_style( 'sng-admin-font', 'https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,700&display=swap' );
		wp_enqueue_style( 'sng-admin-style', get_template_directory_uri() . '/library/css/admin.css' );
		wp_enqueue_script( 'wp-edit-post' );
	}

	public function admin_settings() {
		add_menu_page( 'SANGO 設定', 'SANGO 設定', 'manage_options', 'sng_admin_settings', array( $this, 'print_custom_page' ), get_template_directory_uri() . '/library/images/logo-sidebar.png', 20 );
		if ( ! get_option( 'sng_hide_sango_land_link' ) ) {
			add_menu_page( 'SANGO Land', 'SANGO Land', 'read', 'https://sangoland.app', '', get_template_directory_uri() . '/library/images/sango-land-logo.png', 21 );
		}
		if ( get_option( 'sng_show_reusable_block_menu' ) ) {
			add_menu_page( '再利用ブロック', '再利用ブロック', 'edit_posts', 'edit.php?post_type=wp_block', '', 'dashicons-controls-repeat', 22 );
		}
	}

	public function manage_columns( $columns ) {
		$hide_featured = get_option( 'sng_hide_posts_featured_image' );
		$hide_pv       = get_option( 'sng_hide_posts_pv' );
		if ( ! is_array( $columns ) ) {
			$columns = array();
		}
		$new_columns = array();
		// パターンがあるコンテンツブロックは除外
		$cb_category = isset( $columns['taxonomy-content_block_category'] ) ? $columns['taxonomy-content_block_category'] : false;

		foreach ( $columns as $key => $value ) {
			if ( $key == 'title' && ! $hide_featured && ! $cb_category ) {
				$new_columns['sng-featured-image'] = '画像';
			}
			$new_columns[ $key ] = $value;
		}
		if ( ! $hide_pv ) {
			$new_columns['pv'] = 'PV数';
		}
		return $new_columns;
	}

	public function manage_custom_column( $column, $post_id ) {
		if ( $column == 'sng-featured-image' ) {
			if ( has_post_thumbnail( $post_id ) ) {
				echo get_the_post_thumbnail( $post_id, 'thumbnail' );
			} else {
				echo '<div class="sng-featured-image-none"></div>';
			}
		} elseif ( $column == 'pv' ) {
			$count_key = 'post_views_count';
			$num       = get_post_meta( $post_id, $count_key, true );
			echo $num;
		}
	}

	public function admin_head_edit() {
		$style = <<< EOM
        .fixed .column-sng-featured-image {
            width: 60px;
        }
        .sng-featured-image img,
        .sng-featured-image div {
            width: 48px;
            height: 48px;
        }
        .sng-featured-image-none {
            border: #cccccc dashed 1px;
        }
        .wp-list-table tr:not(.inline-edit-row):not(.no-items) td.column-sng-featured-image::before {
            content: "";
        }
        .wp-list-table tr:not(.inline-edit-row):not(.no-items) td.column-sng-featured-image {
            display: table-cell !important;
        }
        .wp-list-table tr:not(.inline-edit-row):not(.no-items) td.hidden {
            display: none !important;
        }
        EOM;

		echo '<style>' . $style . '</style>';
	}
}
