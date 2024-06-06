<?php get_header(); ?>
	<div id="content">
	<div id="inner-content" class="wrap">
		<main id="main" role="main">
		<?php
			$cat_fields  = sng_get_cat_fields();
			$hide_header = $cat_fields['category_hide_header'];
			$hide_posts  = $cat_fields['category_hide_posts'];
			do_action( 'sng_before_main_content' );
		if ( ! is_category() || $hide_header !== 'true' ) {
			get_template_part( 'parts/archive/archive-header' ); // ヘッダー
		}
		if ( is_category() && is_active_sidebar( 'category_top' ) && ! is_paged() ) {
			?>
			<div class="category-content-top">
			<?php
				dynamic_sidebar( 'category_top' ); // カテゴリー記事上ウィジェット
			?>
			</div>
			<?php
		}

		if ( ! is_category() || $hide_posts !== 'true' ) {
			get_template_part( 'parts/post-grid' ); // 記事一覧
		}
		?>
		</main>
		<?php get_sidebar(); ?>
	</div>
	</div>
<?php get_footer(); ?>