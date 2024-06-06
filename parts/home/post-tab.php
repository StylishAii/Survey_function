<div class="post-tab-wrap">
<?php sng_tab_menu(); ?>
<?php if ( get_option( 'tab1name' ) ) : ?>
	<div class="post-tab__content tab1 tab-active">
	<?php get_template_part( 'parts/post-grid' ); // 新着記事一覧 ?>
	</div>
<?php endif; ?>
<?php
// tab2〜tab4を出力
	$i         = 2;
	$className = 'catpost-cards catpost-cards--column-2';
if ( get_option( 'mb_2column_layout' ) ) {
	$className .= ' catpost-cards--column-mobile-2';
}
	$className = apply_filters( 'sng_post_grid_class', $className );
while ( $i < 5 ) {
	$posts = sng_get_tab_posts( $i );
	if ( $posts ) :
		echo '<div class="' . sng_get_tab_class( $i ) . '">';
		if ( is_sidelong() ) {
			// (1)横長の場合
			echo '<div class="sidelong">';
		} else {
			// (2)通常のカード
			$content = "<div class=\"$className\">";
			echo $content;
		}
		foreach ( $posts as $post ) :
			setup_postdata( $post );
			/*カードの出力*/
			if ( is_sidelong() ) {
				// (1)横長の場合
				sng_sidelong_card();
			} else {
				// (2)通常のカード
				sng_normal_card();
			}
		endforeach;
		echo '</div>';
		sng_get_tab_link( $i );
		echo '</div>';
	endif;
	wp_reset_postdata();
	++$i;
}/*end while*/
?>
</div>