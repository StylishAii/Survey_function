<?php // 記事タイトルまわりのテンプレート ?>
<header class="article-header entry-header">
	<?php
	breadcrumb(); // パンくず
	?>
	<?php do_action( 'sng_before_title' ); ?>
	<h1 class="entry-title single-title"><?php the_title(); // タイトル ?></h1>
	<?php do_action( 'sng_after_title' ); ?>
	<div class="entry-meta vcard">
	<?php
	if ( get_option( 'show_only_mod_date' ) ) {
		echo sng_get_single_date( null, 'entry-time' );
	} else {
		echo sng_get_date( null, 'entry-time' );
		echo sng_get_modified_date( null, 'entry-time' );
	}
	?>
	</div>
	<?php if ( has_post_thumbnail() && ! get_option( 'no_eyecatch' ) ) : // アイキャッチ画像 ?>
	<p class="post-thumbnail"><?php the_post_thumbnail( 'thumb-940' ); ?></p>
	<?php endif; ?>
	<?php
	// FABボタン
	if ( ! get_option( 'no_fab' ) && ! sng_disable_share_button() ) :
		?>
	<input type="checkbox" id="fab">
	<label class="fab-btn extended-fab main-c" for="fab"><?php fa_tag( 'share-alt', 'share-alt', false ); ?></label>
	<label class="fab__close-cover" for="fab"></label>
		<?php // FABの中身 ?>
	<div id="fab__contents">
		<div class="fab__contents-main dfont">
		<label class="fab__contents__close" for="fab"><span></span></label>
		<p class="fab__contents_title">SHARE</p>
		<?php if ( has_post_thumbnail() ) : // サムネイルあり ?>
			<div class="fab__contents_img" style="background-image: url(<?php echo featured_image_src( 'thumb-520' ); ?>);">
			</div>
		<?php endif; ?>
		<?php insert_social_buttons( 'fab' ); ?>
		</div>
	</div>
	<?php endif; // END FABボタン ?>
	<?php
	if ( get_option( 'open_fab' ) ) {
		insert_social_buttons( 'belowtitle' );} // 通常のボタン
	?>
</header>
