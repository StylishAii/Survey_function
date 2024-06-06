<?php
/**
 * コメントテンプレート
 * コメントがオフのときは読み込まない
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments">
	<?php if ( have_comments() ) : ?>
	<h3 id="comments-title" class="h2 dfont"><?php comments_number( 'コメントはありません', '<span>1</span> COMMENT', '<span>%</span> COMMENTS' ); ?></h3>

	<section class="commentlist">
		<?php
		wp_list_comments(
			array(
				'style'             => 'div',
				'short_ping'        => true,
				'avatar_size'       => 40,
				'callback'          => 'sng_comments',
				'type'              => 'all',
				'reply_text'        => '返信する',
				'page'              => '',
				'per_page'          => '',
				'reverse_top_level' => null,
				'reverse_children'  => '',
			)
		);
		?>
	</section>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="navigation comment-navigation" role="navigation">
		<div class="comment-nav-prev"><?php previous_comments_link( '<i class="fa fa-chevron-left"></i> 過去のコメントを表示' ); ?></div>
		<div class="comment-nav-next"><?php next_comments_link( '新しいコメントを表示 <i class="fa fa-chevron-right"></i> ' ); ?></div>
		</nav>
	<?php endif; ?>
		<?php if ( ! comments_open() ) : ?>
		<p class="no-comments"><?php echo '現在コメントは受け付けておりません。'; ?></p>
	<?php endif; ?>
	<?php endif; ?>
	<?php comment_form(); ?>
</div>