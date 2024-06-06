<?php
/**
 * REST API
 */

namespace SANGO;

class Layout {
	function init() {}
	// wp_headの前に実行する
	function should_render_header() {
		$postId = get_the_ID();
		$status = App::get( 'status' )->get_status();
		if ( $status['is_category_top'] ) {
			$cat_fields = sng_get_cat_fields();
			$postId     = isset( $cat_fields['category_page'] ) ? $cat_fields['category_page'] : '';
		}
		$no_header = get_post_meta( $postId, 'sng_content_no_header', true );
		return ! $no_header;
	}

	function should_render_footer() {
		$postId    = get_the_ID();
		$no_footer = get_post_meta( $postId, 'sng_content_no_footer', true );
		return ! $no_footer;
	}

	function render_default_header() {
		?>
	<header class="header
		<?php
		if ( get_option( 'center_logo_checkbox' ) ) {
			echo ' header--center';}
		?>
	">
		<?php get_template_part( 'parts/header/nav-drawer' ); // headerナビドロワー（モバイル） ?>
		<?php get_template_part( 'parts/header/inner' ); // headerタグの中身 ?>
	</header>
		<?php
		get_template_part( 'parts/header/info-bar' );
	}

	function render_header() {
		$contentBlockId = get_theme_mod( 'sng_header_content_block', false );
		$html           = '';
		if ( $contentBlockId ) {
			$contentBlock = App::get( 'content-block' );
			$html         = $contentBlock->get_content_block( $contentBlockId, '', false );
		}
		?>
		<?php
		if ( $html ) {
			echo $html;
			return;
		}
		ob_start();
		$this->render_default_header();
		$html = ob_get_clean();
		echo apply_filters( 'sng_header', $html );
	}

	function render_default_footer() {
		?>
		<footer class="footer">
		<?php
		if ( is_active_sidebar( 'footer_left' ) ||
				is_active_sidebar( 'footer_cent' ) ||
				is_active_sidebar( 'footer_right' )
			) :
			?>
			<div id="inner-footer" class="inner-footer wrap">
			<div class="fblock first">
			<?php
			if ( is_active_sidebar( 'footer_left' ) ) {
				dynamic_sidebar( 'footer_left' );}
			?>
			</div>
			<div class="fblock">
			<?php
			if ( is_active_sidebar( 'footer_cent' ) ) {
				dynamic_sidebar( 'footer_cent' );}
			?>
			</div>
			<div class="fblock last">
			<?php
			if ( is_active_sidebar( 'footer_right' ) ) {
				dynamic_sidebar( 'footer_right' );}
			?>
			</div>
			</div>
		<?php endif; ?>
		<div id="footer-menu">
			<div>
			<a class="footer-menu__btn dfont" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php fa_tag( 'home', 'home', false ); ?> HOME</a>
			</div>
			<nav>
			<?php
			wp_nav_menu(
				array(
					'container'       => 'div',
					'container_class' => 'footer-links cf',
					'menu'            => 'フッターリンクメニュー',
					'menu_class'      => 'nav footer-nav cf',
					'theme_location'  => 'footer-links',
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'depth'           => 0,
					'fallback_cb'     => 'sng_footer_links_fallback',
				)
			);
			?>
				<?php
				// プライバシーポリシー
				if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link();
				}
				?>
			</nav>
			<p class="copyright dfont">
			&copy; <?php echo date( 'Y' ); ?>
			<?php
			if ( get_option( 'rights_reserved' ) ) {
				echo get_option( 'rights_reserved' );
			} else {
				bloginfo( 'name' );
			}
			?>
			All rights reserved.
			</p>
		</div>
		</footer>
		<?php
	}

	function render_footer() {
		$contentBlockId = get_theme_mod( 'sng_footer_content_block', false );
		if ( $contentBlockId ) {
			$contentBlock = App::get( 'content-block' );
			$html         = $contentBlock->get_content_block( $contentBlockId );
			echo $html;
			return;
		}
		ob_start();
		$this->render_default_footer();
		$html = ob_get_clean();
		echo apply_filters( 'sng_footer', $html );
	}
}
