<?php

use SANGO\App;

function sng_admin_style() {
	?>
	<style>
	.menu-icon-content_block .wp-menu-name {
		font-size: 12px;
	}
	.menu-top a[href="https://sangoland.app"] img {
		width: 20px;
		height: auto;
	}
	.user-profile-picture {
		display: none;
	}
	</style>
	<script>
	document.addEventListener('DOMContentLoaded', () => {
	const a = document.querySelector('a[href^="https://sangoland.app"]');
	const site_url = "<?php echo site_url(); ?>";
	a.setAttribute('target', '_blank');
	const resetBtns = document.querySelectorAll('.js-cb-reset');
	resetBtns.forEach((resetBtn) => {
		resetBtn.addEventListener('click', async () => {
		if (!confirm('コンテンツブロックのPV、クリック率をリセットします。よろしいですか？')) {
			return;
		}
		const result = await fetch(`${site_url}/?rest_route=/sng/v1/cb/reset`, {
			method: 'POST',
			body: JSON.stringify({
			id: resetBtn.dataset.id,
			})
		});
		const label = document.querySelector(`.js-cb-label[data-id="${resetBtn.dataset.id}"]`)
		label.innerHTML = `<div>PV数: 0</div>
			<div>ボタンクリック数: 0</div>
			<div>ボタンクリック率: 0 %</div>
		`;
		});
	});
	});
	</script>
	<?php
}

function sng_admin_bar_menu_css() {
	if ( ! is_user_logged_in() ) {
		return;
	}
	$css = '.sng-edit-logo {
    width: 12px !important; 
    height: auto; 
    vertical-align: middle; 
    margin-right: 5px !important;
  }';
	echo '<style>' . $css . '</style>';
}

function sng_admin_bar_menu( $wp_admin_bar ) {
	if ( ! is_user_logged_in() ) {
		return;
	}
	$sango_logo = sng_logo( 'sng-edit-logo' );

	$status = App::get( 'status' )->get_status();

	if ( $status['is_category_top'] ) {
		$cat_fields    = sng_get_cat_fields();
		$category_page = isset( $cat_fields['category_page'] ) ? $cat_fields['category_page'] : '';
		$wp_admin_bar->add_menu(
			array(
				'id'    => 'edit-category-page',
				'title' => '固定ページを編集',
				'href'  => get_edit_post_link( $category_page ),
			)
		);
	}

	$wp_admin_bar->add_menu(
		array(
			'id'    => 'sng_admin_bar_menu',
			'title' => "$sango_logo SANGO",
			'href'  => '#',
		)
	);

	$wp_admin_bar->add_menu(
		array(
			'parent' => 'sng_admin_bar_menu',
			'id'     => 'sng_admin_bar_menu_sango_manual',
			'title'  => 'SANGO カスタマイズマニュアル',
			'meta'   => array( 'target' => '_blank' ),
			'href'   => 'https://saruwakakun.com/sango/all-menu',
		)
	);

	$wp_admin_bar->add_menu(
		array(
			'parent' => 'sng_admin_bar_menu',
			'id'     => 'sng_admin_bar_menu_sango_versions',
			'title'  => 'SANGO テーマ 更新情報',
			'meta'   => array( 'target' => '_blank' ),
			'href'   => 'https://saruwakakun.com/sango/update-info',
		)
	);

	$wp_admin_bar->add_menu(
		array(
			'parent' => 'sng_admin_bar_menu',
			'id'     => 'sng_admin_bar_menu_sango_land',
			'title'  => 'SANGO Land',
			'meta'   => array( 'target' => '_blank' ),
			'href'   => 'https://sangoland.app/',
		)
	);

	if ( get_option( 'sng_enable_cache' ) ) {
		$wp_admin_bar->add_menu(
			array(
				'parent' => 'sng_admin_bar_menu',
				'id'     => 'sng_admin_bar_menu_sango_cache_clear',
				'title'  => 'キャッシュ削除',
				'href'   => '?sng_cache_clear=true',
			)
		);
	}
}

if ( ! function_exists( 'sng_content_block_template' ) ) {
	function sng_content_block_template( $single ) {
		global $post;
		$dirName = __DIR__;
		if ( get_post_type( $post ) === 'content_block' ) {
			if ( file_exists( $dirName . '/single-content_block.php' ) ) {
				return $dirName . '/single-content_block.php';
			}
		}
		return $single;
	}
}

add_filter( 'single_template', 'sng_content_block_template' );

add_action( 'wp_head', 'sng_admin_bar_menu_css' );
add_action( 'admin_head', 'sng_admin_bar_menu_css' );
add_action( 'admin_print_styles', 'sng_admin_style' );
add_action( 'admin_bar_menu', 'sng_admin_bar_menu', 99 );
