<?php

use SANGO\App;

$html           = '';
$contentBlockId = get_theme_mod( 'sng_entry_footer_content_block', false );

if ( $contentBlockId ) {
	$contentBlock = App::get( 'content-block' );
	$html         = $contentBlock->get_content_block( $contentBlockId, '', false );
}
?>

<footer class="article-footer">
	<aside>
	<div class="footer-contents">
		<?php
		if ( $html ) {
			echo $html;
		} else {
			?>
			<?php insert_social_buttons(); // シェアボタン ?>
			<?php insert_like_box(); // フォローボックス ?>
		<div class="footer-meta dfont">
			<?php if ( get_the_category_list() ) : // カテゴリー一覧を出力 ?>
			<p class="footer-meta_title">CATEGORY :</p>
				<?php echo get_the_category_list(); ?>
			<?php endif; ?>
			<?php if ( get_the_tags() ) : // タグ一覧を出力 ?>
			<div class="meta-tag">
				<p class="footer-meta_title">TAGS :</p>
				<?php the_tags( '<ul><li>', '</li><li>', '</li></ul>' ); ?>
			</div>
			<?php endif; ?>
		</div>
			<?php insert_cta(); // CTA ?>
			<?php sng_recommended_posts(); // おすすめ記事 ?>
			<?php
			if ( ! get_post_meta( $post->ID, 'disable_ads', true ) && is_active_sidebar( 'ads_footer' ) ) {
				dynamic_sidebar( 'ads_footer' ); // 関連記事広告
			}
			?>
			<?php
			if ( ! get_option( 'no_related_posts' ) ) {
				output_sng_related_posts(); // 関連記事
			}
		}
		?>
	</div>
	<?php insert_author_info(); // この記事を書いた人 ?>
	</aside>
</footer>