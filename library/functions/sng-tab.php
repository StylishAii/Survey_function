<?php
/**
 * このファイルでは記事一覧タブを出力するための関数をまとめています
 */
if ( ! function_exists( 'sng_tab_menu' ) ) {
	function sng_tab_menu() {
		$tab1name = get_option( 'tab1name' );
		$tab2name = get_option( 'tab2name' );
		$tab3name = get_option( 'tab3name' );
		$tab4name = get_option( 'tab4name' );
		?>
<div class="post-tab cf">
		<?php if ( $tab1name ) : ?>
	<div class="tab1 tab-active">
			<?php echo $tab1name; ?>
	</div>
	<?php endif; ?>
		<?php if ( $tab2name ) : ?>
	<div class="tab2
			<?php
			if ( ! $tab1name ) {
				echo ' tab-active';}
			?>
	">
			<?php echo $tab2name; ?>
	</div>
	<?php endif; ?>
		<?php if ( $tab3name ) : ?>
	<div class="tab3"
			<?php
			if ( ! $tab1name ) {
				echo 'style="border-top:none;"';}
			?>
	>
			<?php echo $tab3name; ?>
	</div>
	<?php endif; ?>
		<?php if ( $tab4name ) : ?>
	<div class="tab4">
			<?php echo $tab4name; ?>
	</div>
	<?php endif; ?>
</div>
		<?php
	}
}

/*********************
 * 記事一覧タブの記事一覧を取得
 */
if ( ! function_exists( 'sng_get_tab_posts' ) ) {
	function sng_get_tab_posts( $tab_number ) {
		// タグorカテゴリーのID
		$taxonomy_id = get_option( "tab{$tab_number}id" );
		if ( ! $taxonomy_id ) {
			return null;
		}
		// 記事の表示数
		$post_num = get_option( 'tab_cat_num' );
		// タグで記事を取得するかどうか
		$is_tag = ( get_theme_mod( "tab{$tab_number}cat_or_tag" ) == 'tag_chosen' );
		// 並び順
		$orderby = get_option( 'tab_posts_show_random' ) ? 'rand' : 'date';
		if ( $is_tag ) {
			// タグIDで一覧を取得
			return get_posts(
				array(
					'posts_per_page' => $post_num,
					'tag__in'        => explode( ',', $taxonomy_id ),
					'orderby'        => $orderby,
				)
			);
		} else {
			// カテゴリーIDで一覧を取得
			return get_posts(
				array(
					'posts_per_page' => $post_num,
					'category'       => $taxonomy_id,
					'orderby'        => $orderby,
				)
			);
		}
	}
}

/*********************
 * タブごとのクラス名を取得
 */
if ( ! function_exists( 'sng_get_tab_class' ) ) {
	function sng_get_tab_class( $tab_number ) {
		$class = "post-tab__content tab{$tab_number}";
		// 新着記事を表示しないときは、タブ2をアクティブに
		if ( ( ! get_option( 'tab1name' ) ) && ( $tab_number == 2 ) ) {
			$class .= ' tab-active';
		}
		return $class;
	}
}

/*********************
 * 記事一覧タブのリンクを取得
 */
if ( ! function_exists( 'sng_get_tab_link' ) ) {
	function sng_get_tab_link( $tab_number ) {
		$tab_link = get_option( "tab{$tab_number}link" );
		if ( ! $tab_link ) {
			return null;
		}
		?>
	<div class="post-tab__more ct">
	<a class="raised main-bc strong" href="<?php echo $tab_link; ?>">
		<?php fa_tag( 'caret-right', 'caret-right', false ); ?>
		<span>もっと見る</span>
	</a>
	</div>
		<?php
	}
}

