<?php
/**
 * 記事一覧表示は以下の2種類（カスタマイザーから設定）
 * 1）横長のタイプ
 * 2) 通常のカードタイプ
 */
if ( have_posts() ) {
	$ad           = get_theme_mod( 'ad_infeed' );
	$ad2          = get_theme_mod( 'ad_infeed2' );
	$cat_fields   = sng_get_cat_fields();
	$ad_pos1      = get_theme_mod( 'ad_infeed_pos1', -1 );
	$ad_pos2      = get_theme_mod( 'ad_infeed_pos2', -1 );
	$ad_pos3      = get_theme_mod( 'ad_infeed_pos3', -1 );
	$hide_infeed  = $cat_fields['category_hide_infeed'];
	$ad_enabled   = get_theme_mod( 'enable_ad_infeed', false ) && $hide_infeed !== 'true';
	$ad_pos_array = $ad_enabled ? array( $ad_pos1, $ad_pos2, $ad_pos3 ) : array();
	$className    = 'catpost-cards catpost-cards--column-2';
	if ( get_option( 'mb_2column_layout' ) ) {
		$className .= ' catpost-cards--column-mobile-2';
	}
	$className = apply_filters( 'sng_post_grid_class', $className );

	if ( is_sidelong() ) : // 1)横長
		?>
	<div class="sidelong">
		<?php
		$i           = 1;
		$shown_count = 0;
		while ( have_posts() ) :
			if ( $ad2 && is_numeric( array_search( $i + $shown_count, $ad_pos_array ) ) ) {
				++$shown_count;
				echo "<div class=\"sidelong__article\">$ad2</div>";
			}
			the_post();
			sng_sidelong_card();
			++$i;
			endwhile;
		?>
	</div>
		<?php
	else : // 2)カードタイプ
		?>
	<div class="<?php echo $className; ?>">
		<?php
		$i           = 1;
		$shown_count = 0;
		while ( have_posts() ) :
			if ( $ad && is_numeric( array_search( $i + $shown_count, $ad_pos_array ) ) ) {
				++$shown_count;
				echo "<div class=\"c_linkto\">$ad</div>";
			}
			the_post();
			sng_normal_card();
			++$i;
		endwhile;
		?>
	</div>
		<?php
	endif;
	sng_page_navi();
} else {
	// 記事なし
	get_template_part( 'content', 'not-found' );
}
wp_reset_query();
?>
