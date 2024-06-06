<section class="entry-content">
	<?php
	if ( is_active_sidebar( 'contents_below_title' ) ) {
			dynamic_sidebar( 'contents_below_title' );
	}
	$show_ads = ( get_post_meta( $post->ID, 'disable_ads', true ) ) ? null : '1';
	// タイトル下広告（ウィジェットで設定）
	if ( wp_is_mobile() && is_active_sidebar( 'ads_below_title_mb' ) && $show_ads ) {
			dynamic_sidebar( 'ads_below_title_mb' );
	} elseif ( ! wp_is_mobile() && is_active_sidebar( 'ads_below_title_pc' ) && $show_ads ) {
			dynamic_sidebar( 'ads_below_title_pc' );
	}
	// 記事の中身
	the_content();
	// 分割ページのページネイション
	wp_link_pages(
		array(
			'before'      => '<div class="post-page-links dfont">',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
		)
	);
	// 記事下広告（ウィジェットで設定）
	if ( wp_is_mobile() && is_active_sidebar( 'ads_below_contents_mb' ) && $show_ads ) {
		dynamic_sidebar( 'ads_below_contents_mb' );
	} elseif ( ! wp_is_mobile() && is_active_sidebar( 'ads_below_contents_pc' ) && $show_ads ) {
		dynamic_sidebar( 'ads_below_contents_pc' );
	}
	?>
</section>