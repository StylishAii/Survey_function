<?php
/**
 * 🖍ログインユーザーのみ
 * このファイルでは投稿ページやカテゴリー設定ページで用いられる
 * カスタムフィールド系の関数をまとめています。
 */

/*****************************
 * 投稿/固定ページのカスタムフィールド
 ******************************/
add_action( 'admin_menu', 'add_sngmeta_field' );
add_action( 'save_post', 'save_sngmeta_field' );

function add_sngmeta_field() {
	$sango_logo = sng_logo( 'sng-edit-logo' );
	// 作成
	// 投稿ページ
	add_meta_box( 'sng-meta-description', 'メタデスクリプション', 'sng_field_meta_description', 'post', 'normal' );
	add_meta_box( 'sng-meta-description', 'メタデスクリプション', 'sng_field_meta_description', 'page', 'normal' );
	add_meta_box( 'sng-title-tag', '【高度な設定】titleタグ', 'sng_field_title_tag', 'post', 'normal' );
	add_meta_box( 'sng-title-tag', '【高度な設定】titleタグ', 'sng_field_title_tag', 'page', 'normal' );
	add_meta_box( 'sng-canonical-url', 'Canonical URL', 'sng_field_canonical_url', 'post', 'normal' );
	add_meta_box( 'sng-canonical-url', 'Canonical URL', 'sng_field_canonical_url', 'page', 'normal' );
	add_meta_box( 'sng-side-setting', "{$sango_logo} SANGO設定", 'sng_field_side', 'post', 'side' );
	add_meta_box( 'sng-side-setting', "{$sango_logo} SANGO設定", 'sng_field_side', 'page', 'side' );
}

function sng_field_meta_description() {
	global $post;
	echo '<p class="howto">Google検索結果などに表示される記事の要約です（入力は必須ではありません）。100字以内に抑えるのが良いかと思います。</p><textarea name="sng_meta_description" cols="65" rows="4" onkeyup="document.getElementById(\'description_count\').innerText=this.value.length + \'字\'" style="max-width: 100%">' . get_post_meta( $post->ID, 'sng_meta_description', true ) . '</textarea><p><strong><span id="description_count" style="float: none;display: inline-block;border: none;box-shadow: none; background-color: var(--wp--preset--color--sango-pastel); padding: 5px 10px;">0字</span></strong></p>';
}

function sng_field_title_tag() {
	global $post;
	$result  = '<p class="howto">記事タイトルとは別のtitleタグを出力したい場合に入力します。空欄にすると記事タイトルがtitleタグに出力されます。</p>';
	$result .= '<textarea name="sng_title" cols="65" rows="1" style="max-width: 100%">' . get_post_meta( $post->ID, 'sng_title', true ) . '</textarea>';
	echo $result;
}

function sng_field_canonical_url() {
	global $post;
	$result  = '<p class="howto">カノニカルURLを指定します。基本的には空で構いません。</p>';
	$result .= '<textarea name="sng_canonical_url" cols="65" rows="1" style="max-width: 100%" placeholder="https://example.com/duplicate-page">' . get_post_meta( $post->ID, 'sng_canonical_url', true ) . '</textarea>';
	echo $result;
}

function sng_field_side() {
	sng_field_meta_robots();
	sng_field_ogp_type();
	sng_field_ogp_image();
	disable_ads();
	sng_field_disable_share();
	sng_field_one_column();
	sng_field_content_width();
	sng_field_no_header();
	sng_field_no_footer();
	sng_theme_field_meta_toc();
	sng_field_detail();
	sng_field_related();
	sng_field_js();
	sng_field_css();
	sng_field_html();
	do_action( 'sng_field_side_extra' );
	$css = <<< EOM
  .interface-complementary-area .sng-field-title,
  .sng-field-title {
    border-bottom: 2px solid var(--wp--preset--color--sango-main);
    font-size: 13px;
    margin-top: 30px !important;
    font-weight: bold;
  }
  .sng-edit-logo {
    width: 16px;
    height: 16px;
    vertical-align: middle;
  }
  #sng-side-setting .hndle {
    justify-content: flex-start;
  }
  #sng-side-setting .hndle svg {
    margin-right: 5px;
    width: 16px;
    height: 16px;
  }
EOM;
	echo '<style>' . $css . '</style>';
}

function sng_field_meta_robots() {
	global $post;
	$exist_options   = get_post_meta( $post->ID, 'noindex_options', true );
	$noindex_options = $exist_options ? $exist_options : array();
	$data            = array( 'noindex', 'nofollow' );
	echo '<p class="sng-field-title" style="margin-top: 20px;"><img draggable="false" role="img" class="emoji" alt="🛠" src="https://s.w.org/images/core/emoji/13.1.0/svg/1f6e0.svg"> SEO設定</p>';
	foreach ( $data as $d ) {
		$check = ( in_array( $d, $noindex_options ) ) ? 'checked' : '';
		echo '<div style="margin-top: 10px;"><label><input type="checkbox" name="noindex_options[]" value="' . $d . '" ' . $check . '>' . $d . '</label></div>';
	}
}

function sng_field_ogp_type() {
	global $post;
	$default_value = get_option( 'x_post_share_type', 'summary_large_image' );
	$meta_value    = get_post_meta( $post->ID, 'sng_x_share_type', true );
	if ( ! $meta_value ) {
		$meta_value = $default_value;
	}
	$data = array(
		array(
			'label' => '大きな画像でシェア',
			'value' => 'summary_large_image',
		),
		array(
			'label' => '小さな画像でシェア',
			'value' => 'summary',
		),
	);
	echo '<p class="sng-field-title"><img draggable="false" role="img" class="emoji" alt="📸" src="https://s.w.org/images/core/emoji/13.1.0/svg/1f4f8.svg"> OGP設定</p>';
	echo '<div style="margin-top: 10px;"><label style="display: block;margin-bottom: 5px;">Xカードの種類</label><select name="sng_x_share_type">';
	foreach ( $data as $d ) {
		$value    = $d['value'];
		$label    = $d['label'];
		$selected = ( $meta_value === $value ) ? 'selected' : '';
		echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
	}
	echo '</select></div>';
}

function sng_field_ogp_image() {
	global $post;
	$meta_value  = get_post_meta( $post->ID, 'post_og_image', true );
	$ogp_preview = wp_get_attachment_image_src( $meta_value, 'full' );
	?>
	<div style="margin-top: 10px;">OGP画像</div>
		<p>設定していない場合はアイキャッチ画像が利用されます。</p>
		<div style="margin-bottom: 10px;">
		<button id="ogp_btn" class="button" type="button">画像をアップロード</button>
		<?php if ( $ogp_preview && $ogp_preview[0] ) { ?>
		<button id="ogp_remove_btn" class="button" type="button">画像を削除</button>
		<?php } else { ?>
		<button id="ogp_remove_btn" class="button" type="button" style="display: none">画像を削除</button>
		<?php } ?>
	</div>
	<?php if ( $ogp_preview && $ogp_preview[0] ) { ?>
		<img src="<?php echo $ogp_preview[0]; ?>" style="max-width: 100%; height: auto;" id="ogp_preview" />
	<?php } else { ?>
		<img style="display: none; max-width: 100%; height: auto;" id="ogp_preview" />
	<?php } ?>
	<input type="hidden" name="post_og_image" id="ogp" value="<?php echo $meta_value; ?>"/>
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
	<?php
}


function sng_field_one_column() {
	global $post;
	if ( $post->post_type !== 'post' ) {
		return;
	}
	$meta_value = get_post_meta( $post->ID, 'one_column_options', true );
	$data       = '1カラムで表示';
	$check      = ( $meta_value ) ? 'checked' : '';
	echo '<div style="margin-top: 10px;"><label><input type="checkbox" name="one_column_options" value="' . $data . '" ' . $check . '>' . $data . '</label></div>';
}

function disable_ads() {
	global $post;
	$meta_value = get_post_meta( $post->ID, 'disable_ads', true );
	$data       = '広告を非表示にする';
	$check      = ( $meta_value ) ? 'checked' : '';
	echo '<p class="sng-field-title"><img draggable="false" role="img" class="emoji" alt="🗞️" src="https://s.w.org/images/core/emoji/13.1.0/svg/1f5de.svg"> 広告設定</p>';
	echo '<div style="margin-top: 10px;"><label><input type="checkbox" name="disable_ads" value="' . $data . '" ' . $check . '>' . $data . '</label></div>';
}

function sng_field_disable_share() {
	global $post;
	$meta_value = get_post_meta( $post->ID, 'sng_disable_share', true );
	$data       = 'シェアボタンを非表示にする';
	$check      = ( $meta_value ) ? 'checked' : '';
	echo '<p class="sng-field-title"><img draggable="false" role="img" class="emoji" alt="🎨" src="https://s.w.org/images/core/emoji/13.1.0/svg/1f3a8.svg"> 装飾設定</p>';
	echo '<div style="margin-top: 10px;"><label><input type="checkbox" name="sng_disable_share" value="' . $data . '" ' . $check . '>' . $data . '</label></div>';
}

function sng_field_related() {
	global $post;
	$meta_value = get_post_meta( $post->ID, 'sng_related_posts', true );

	echo '<p class="sng-field-title"><img draggable="false" role="img" class="emoji" alt="📑" src="https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/svg/1f4c3.svg"> 関連記事設定</p>';
	echo '<div id="sng-related"></div>';
	echo '<input type="hidden" name="sng_related_posts" value="' . $meta_value . '">';
}

function sng_field_detail() {
	global $post;
	// sng_alternate_title
	$meta_value = get_post_meta( $post->ID, 'sng_alternate_title', true );
	echo '<p class="sng-field-title"><img draggable="false" role="img" class="emoji" alt="🗺️" src="https://cdn.jsdelivr.net/gh/twitter/twemoji@latest/assets/svg/1f5fa.svg"> 詳細設定</p>';
	echo '<div style="margin-top: 10px;">記事一覧ブロックにてタイトルを別名で出力したい場合に設定</div>';
	echo '<div style="margin-top: 10px;"><input type="text" name="sng_alternate_title" value="' . $meta_value . '" placeholder="別名タイトルを入力"></div>';
}

function sng_is_edit_page( $new_edit = null ) {
	global $pagenow;
	// make sure we are on the backend
	if ( ! is_admin() ) {
		return false;
	}

	if ( $new_edit == 'edit' ) {
		return in_array( $pagenow, array( 'post.php' ) );
	} elseif ( $new_edit == 'new' ) { // check for new post page
		return in_array( $pagenow, array( 'post-new.php' ) );
	} else { // check for either new or edit
		return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
	}
}

function sng_field_content_width() {
	global $post;
	if ( $post->post_type !== 'page' ) {
		return;
	}
	$meta_value = get_post_meta( $post->ID, 'sng_content_width', true );
	echo '<div style="margin-top: 10px;"><span style="font-weight: bold;">トップページ用 1カラム</span>のテンプレートにのみ有効な設定</div>';
	echo '<div style="margin-top: 10px;"><label>コンテンツ最大幅</label><input type="text" name="sng_content_width" value="' . $meta_value . '">px</div>';

	$meta_value = get_post_meta( $post->ID, 'sng_content_padding_zero', true );
	if ( sng_is_edit_page( 'new' ) ) {
		$meta_value = true;
	}
	$data  = 'コンテンツ上下の余白をなくす';
	$check = ( $meta_value ) ? 'checked' : '';
	echo '<div style="margin-top: 10px;"><label><input type="checkbox" name="sng_content_padding_zero" value="' . $data . '" ' . $check . '>コンテンツ上下の余白をなくす</label></div>';
}

function sng_field_no_header() {
	global $post;
	if ( $post->post_type !== 'page' ) {
		return;
	}

	$meta_value = get_post_meta( $post->ID, 'sng_content_no_header', true );
	$check      = ( $meta_value ) ? 'checked' : '';
	echo '<div style="margin-top: 10px;"><label><input type="checkbox" name="sng_content_no_header" value="on" ' . $check . '>ヘッダーを非表示</label></div>';
}

function sng_field_no_footer() {
	global $post;
	if ( $post->post_type !== 'page' ) {
		return;
	}

	$meta_value = get_post_meta( $post->ID, 'sng_content_no_footer', true );
	$check      = ( $meta_value ) ? 'checked' : '';
	echo '<div style="margin-top: 10px;"><label><input type="checkbox" name="sng_content_no_footer" value="on" ' . $check . '>フッターを非表示</label></div>';
}

function sng_field_js() {
	global $post;
	$meta_value = get_post_meta( $post->ID, 'sng_enable_post_smartphoto_js', true );
	$check      = ( $meta_value ) ? 'checked' : '';
	echo '<p class="sng-field-title">JavaScript設定</p>';
	echo '<div>カスタマイザーで設定がONの場合はそれぞれチェック不要</div>';
	echo '<div style="margin-top: 10px;"><label><input type="checkbox" name="sng_enable_post_smartphoto_js" value="true" ' . $check . '>写真を拡大するJavaScriptを利用</label></div>';

	$meta_value = get_post_meta( $post->ID, 'sng_enable_post_scrollhint_js', true );
	$check      = ( $meta_value ) ? 'checked' : '';
	echo '<div style="margin-top: 10px;"><label><input type="checkbox" name="sng_enable_post_scrollhint_js" value="true" ' . $check . '>テーブルのスクロールを促すJavaScriptを利用</label></div>';

	$meta_value = get_post_meta( $post->ID, 'sng_post_js', true );
	echo '<div style="margin-top: 10px;"><div>JavaScript（この記事にのみ反映されます）</div><textarea name="sng_post_js" rows="10" style="width: 100%;">' . $meta_value . '</textarea></div>';
}

function sng_field_css() {
	global $post;
	$meta_value = get_post_meta( $post->ID, 'sng_post_css', true );
	echo '<p class="sng-field-title">CSS設定</p>';
	echo '<div style="margin-top: 10px;"><div>CSS（この記事にのみ反映されます）</div><textarea name="sng_post_css" rows="10" style="width: 100%;">' . $meta_value . '</textarea></div>';
}

function sng_field_html() {
	global $post;
	$meta_value = get_post_meta( $post->ID, 'sng_post_html', true );
	echo '<p class="sng-field-title">HTML設定</p>';
	echo '<div style="margin-top: 10px;"><div>HTML（この記事にのみ反映されます）</div><textarea name="sng_post_html" rows="10" style="width: 100%;">' . $meta_value . '</textarea></div>';
}


function sng_theme_field_meta_toc() {
	global $post;
	echo '<p class="sng-field-title" style="margin-top: 20px;"><img draggable="false" role="img" class="emoji" alt="🛠" src="https://s.w.org/images/core/emoji/13.1.0/svg/1f6e0.svg"> 目次設定</p>';
	$meta_value = get_post_meta( $post->ID, 'sng_toc_hide', true );
	$check      = ( $meta_value ) ? 'checked' : '';
	$label      = 'この記事では目次を隠す';
	echo '<div><label><input type="checkbox" name="sng_toc_hide" value="on" ' . $check . '>' . $label . '</label></div>';
}

function sng_update_custom_text_fields( $post_id, $field_name ) {
	if ( ! is_user_logged_in() ) {
		return;
	}
	( isset( $_POST[ $field_name ] ) ) ? update_post_meta( $post_id, $field_name, $_POST[ $field_name ] ) : '';
}

function sng_update_custom_option_fields( $post_id, $field_name ) {
	if ( ! is_user_logged_in() ) {
		return;
	}
	if ( isset( $_POST[ $field_name ] ) ) {
		$value = $_POST[ $field_name ];
	} else {
		$value = '';
	}
	update_post_meta( $post_id, $field_name, $value );
}

// 値を保存
function save_sngmeta_field( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// クイックポストの時は何もしない
	if ( isset( $_POST['action'] ) && $_POST['action'] == 'inline-save' ) {
		return $post_id;
	}

	// Ajaxなどの時は何もしない
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return $post_id;
	}

	// $_POSTデータが何もない場合は何もしない
	if ( count( $_POST ) == 0 ) {
		return $post_id;
	}

	sng_update_custom_text_fields( $post_id, 'sng_meta_description' );
	sng_update_custom_text_fields( $post_id, 'sng_title' );
	sng_update_custom_text_fields( $post_id, 'sng_canonical_url' );
	sng_update_custom_text_fields( $post_id, 'sng_alternate_title' );
	sng_update_custom_text_fields( $post_id, 'sng_post_js' );
	sng_update_custom_text_fields( $post_id, 'sng_post_css' );
	sng_update_custom_text_fields( $post_id, 'sng_post_html' );
	sng_update_custom_text_fields( $post_id, 'sng_content_width' );
	sng_update_custom_text_fields( $post_id, 'sng_related_posts' );
	sng_update_custom_text_fields( $post_id, 'sng_x_share_type' );
	sng_update_custom_text_fields( $post_id, 'post_og_image' );

	sng_update_custom_option_fields( $post_id, 'noindex_options' );
	sng_update_custom_option_fields( $post_id, 'one_column_options' );
	sng_update_custom_option_fields( $post_id, 'disable_ads' );
	sng_update_custom_option_fields( $post_id, 'sng_disable_share' );
	sng_update_custom_option_fields( $post_id, 'sng_content_padding_zero' );
	sng_update_custom_option_fields( $post_id, 'sng_content_no_header' );
	sng_update_custom_option_fields( $post_id, 'sng_content_no_footer' );
	sng_update_custom_option_fields( $post_id, 'sng_enable_post_smartphoto_js' );
	sng_update_custom_option_fields( $post_id, 'sng_enable_post_scrollhint_js' );

	do_action( 'sng_update_custom_fields', $post_id );
}
