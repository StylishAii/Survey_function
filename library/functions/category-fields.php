<?php
/*********************
 * 🖍ログインユーザーのみ
 * カテゴリーページへのフィールドの追加/リンクの出力
 *********************/

// カテゴリーページに「カスタムの入力欄」を表示
function sng_add_archive_title( $term ) {
	$termid             = $term->term_id;
	$taxonomy           = $term->taxonomy;
	$term_meta          = get_option( $taxonomy . '_' . $termid );
	$hide_posts         = isset( $term_meta['category_hide_posts'] ) ? esc_attr( $term_meta['category_hide_posts'] ) : '';
	$hide_posts_checked = $hide_posts ? ' checked' : '';
	$selected_page_id   = isset( $term_meta['category_page'] ) ? esc_attr( $term_meta['category_page'] ) : '';

	$hide_header         = isset( $term_meta['category_hide_header'] ) ? esc_attr( $term_meta['category_hide_header'] ) : '';
	$hide_header_checked = $hide_header ? ' checked' : '';

	$hide_infeed         = isset( $term_meta['category_hide_infeed'] ) ? esc_attr( $term_meta['category_hide_infeed'] ) : '';
	$hide_infeed_checked = $hide_infeed ? ' checked' : '';
	$pages               = get_posts(
		array(
			'numberposts' => -1,
			'post_type'   => 'page',
			'post_status' => 'publish',
		)
	);

	$ogp         = isset( $term_meta['category_og_image'] ) ? esc_attr( $term_meta['category_og_image'] ) : '';
	$ogp_preview = wp_get_attachment_image_src( $ogp, 'full' );

	?>
	<tr class="form-field">
	<th scope="row"><label for="term_meta[category_title]">ページタイトル</label></th>
	<td>
		<textarea name="term_meta[category_title]" id="term_meta[category_title]" rows="1" cols="50" class="large-text"><?php echo isset( $term_meta['category_title'] ) ? esc_attr( $term_meta['category_title'] ) : ''; ?></textarea>
		<p class="description">カテゴリーページのタイトルを入力します。空欄の場合、カテゴリー名がページタイトルとなります。</p>
	</td>
	</tr>
	<tr class="form-field">
	<th scope="row"><label for="term_meta[category_description]">メタデスクリプション</label></th>
	<td>
		<textarea name="term_meta[category_description]" id="term_meta[category_description]" rows="3" cols="50" class="large-text"><?php echo isset( $term_meta['category_description'] ) ? esc_attr( $term_meta['category_description'] ) : ''; ?></textarea>
		<p class="description">カテゴリーページのメタデスクリプションを入力します。検索結果にページの説明文として表示されることがあります。</p>
	</td>
	</tr>
	<tr class="form-field">
	<th scope="row"><label for="term_meta[category_og_image]">OGP画像</label></th>
	<td>
		<div style="margin-bottom: 10px;">
		<button id="ogp_btn" class="button" type="button">画像をアップロード</button>
		<?php if ( $ogp_preview && $ogp_preview[0] ) { ?>
			<button id="ogp_remove_btn" class="button" type="button">画像を削除</button>
		<?php } else { ?>
			<button id="ogp_remove_btn" class="button" type="button" style="display: none">画像を削除</button>
		<?php } ?>
		</div>
		<?php if ( $ogp_preview && $ogp_preview[0] ) { ?>
		<img src="<?php echo $ogp_preview[0]; ?>" style="max-width: 400px; height: auto;" id="ogp_preview" />
		<?php } else { ?>
		<img style="display: none; max-width: 400px; height: auto;" id="ogp_preview" />
		<?php } ?>
		<input type="hidden" name="term_meta[category_og_image]" id="ogp" value="<?php echo $ogp; ?>"/>
	</td>
	</tr>
	<script>
	jQuery(function() {
		const uploader = window.wp.media({
		title: 'Choose Image',
		button: {
			text: 'Choose Image'
		},
		multiple: false
		});
		const removeButton = document.querySelector("#ogp_remove_btn");
		uploader.on('select', function() {
		const selections = uploader.state().get('selection');
		const selection = selections.single();
		const preview = document.querySelector("#ogp_preview");
		preview.style.display = 'block';
		preview.setAttribute('src', selection.attributes.url);
		const input = document.querySelector('#ogp');
		input.value = selection.attributes.id;
		removeButton.style.display = 'inline-block';
		});
		const button = document.querySelector("#ogp_btn");
		removeButton.addEventListener('click', function() {
		if (!confirm('画像を削除します。よろしいですか？')) {
			return;
		}
		const preview = document.querySelector("#ogp_preview");
		const input = document.querySelector('#ogp');
		preview.style.display = 'none';
		removeButton.style.display = 'none';
		input.value = '';
		});
		button.addEventListener('click', function() {
		uploader.open();
		})
	})
	</script>
	<tr class="form-field">
	<th scope="row"><label for="term_meta[category_page]">固定ページ</label></th>
	<td>
		<select name="term_meta[category_page]" id="term_meta[category_page]">
		<option value="">固定ページを使用しない</option>
		<?php
		foreach ( $pages as $page ) {
			?>
			<option value="<?php echo $page->ID; ?>" 
										<?php
										if ( intval( $page->ID ) === intval( $selected_page_id ) ) {
											echo ' selected'; }
										?>
			><?php echo $page->post_title; ?></option>
			<?php
		}
		?>
		</select>
		<p class="description">固定ページを選択するとこのカテゴリーのトップページでは選択された固定ページを表示します</p>
	</td>
	</tr>
	<tr class="form-field">
	<th scope="row"><label for="term_meta[category_hide_header]">アーカイブヘッダーを非表示</label></th>
	<td>
		<label class="description">
		<input type="checkbox" <?php echo $hide_header_checked; ?> value="true" name="term_meta[category_hide_header]" id="term_meta[category_hide_header]" />
		このカテゴリーページではアーカイブヘッダーを非表示にします。
		</label>
	</td>
	</tr>
	<tr class="form-field">
	<th scope="row"><label for="term_meta[category_hide_posts]">記事一覧を非表示</label></th>
	<td>
		<label class="description">
		<input type="checkbox" <?php echo $hide_posts_checked; ?> value="true" name="term_meta[category_hide_posts]" id="term_meta[category_hide_posts]" />
		このカテゴリーページでは記事一覧を非表示にします。
		</label>
	</td>
	</tr>
	<tr class="form-field">
	<th scope="row"><label for="term_meta[category_hide_infeed]">インフィード広告を非表示</label></th>
	<td>
		<label class="description">
		<input type="checkbox" <?php echo $hide_infeed_checked; ?> value="true" name="term_meta[category_hide_infeed]" id="term_meta[category_hide_infeed]" />
		カスタマイザーでインフィード広告を有効にしている場合、このカテゴリーではインフィード広告を非表示にします。
		</label>
	</td>
	</tr>
	<?php
}
add_action( 'category_edit_form_fields', 'sng_add_archive_title' );

// オリジナルタイトルを保存
function sng_save_archive_title( $term_id ) {
	global $taxonomy;
	if ( isset( $_POST['term_meta'] ) ) {
		$term_meta                         = get_option( $taxonomy . '_' . $term_id );
		$term_keys                         = array_keys( $_POST['term_meta'] );
		$term_meta['category_hide_posts']  = '';
		$term_meta['category_hide_header'] = '';
		$term_meta['category_hide_infeed'] = '';
		$term_meta['category_og_image']    = '';
		foreach ( $term_keys as $key ) {
			if ( isset( $_POST['term_meta'][ $key ] ) ) {
				$term_meta[ $key ] = stripslashes_deep( $_POST['term_meta'][ $key ] );
			}
		}
		update_option( $taxonomy . '_' . $term_id, $term_meta );
	}
}
add_action( 'edited_term', 'sng_save_archive_title' ); // 値を保存

// アーカイブの説明欄でHTMLタグを使えるように
remove_filter( 'pre_term_description', 'wp_filter_kses' );
