<div id="archive_header" class="archive-header">
	<?php breadcrumb(); ?>
	<?php if ( is_author() ) : // ヘッダータイトル 著者ページの場合 ?>
	<p class="author_page_img">
		<?php
		// 著者画像
		$iconimg = get_avatar( get_the_author_meta( 'ID' ), 125 );
		if ( $iconimg ) {
			echo $iconimg;
		}
		?>
	</p>
	<h1 class="dfont">
		<?php echo esc_attr( get_the_author_meta( 'display_name', $author ) ); ?> <?php fa_tag( 'check-circle', 'check-circle', false ); ?>
	</h1>
	<?php else : // 著者ページ以外 ?>
	<h1>
		<?php
		if ( output_archive_title() ) {
			echo output_archive_title();
		} else {
			$title         = '「' . get_the_archive_title() . '」の記事一覧';
			$archive_title = apply_filters( 'sng_archive_title', $title );
			echo $archive_title;
		}
		?>
	</h1>
	<?php endif; ?>
	<?php
	if ( is_category() && ! get_the_archive_description() ) {
		// 説明文が入力されているときには子カテゴリを表示しない
		output_categories_list();
	}
	if ( ! is_paged() ) {
		// 説明文（2ページ目以降には非表示）
		the_archive_description( '<div class="taxonomy-description entry-content">', '</div>' );
	}
	?>
</div>