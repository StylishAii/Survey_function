<?php

use SANGO\App;

App::get( 'customizer_builder' )->addSection(
	'✨ デザイン・レイアウト',
	'desing_layout_setting',
	array(
		'priority' => 52,
	)
);
App::get( 'customizer_builder' )->addSection(
	'全体レイアウト',
	'all_layout',
	array(
		'priority' => 1,
		'parent'   => 'desing_layout_setting',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'all_layout',
	array(
		'name'         => 'sng_layout_squared',
		'title'        => '記事コンテンツやサイドメニューコンテンツの角丸を停止',
		'type'         => 'checkbox',
		'updateMethod' => 'theme_mod',
	)
);

App::get( 'customizer_builder' )->addConfig(
	'all_layout',
	array(
		'name'         => 'sng_parts_squared',
		'title'        => '記事内の著者情報や目次などのパーツの角丸を停止',
		'type'         => 'checkbox',
		'updateMethod' => 'theme_mod',
	)
);

App::get( 'customizer_builder' )->addConfig(
	'all_layout',
	array(
		'name'         => 'sng_posts_squared',
		'title'        => '記事一覧の角丸を停止',
		'type'         => 'checkbox',
		'updateMethod' => 'theme_mod',
	)
);

App::get( 'customizer_builder' )->addSection(
	'記事一覧レイアウト',
	'card_layout',
	array(
		'priority' => 2,
		'parent'   => 'desing_layout_setting',
	)
);

App::get( 'customizer_builder' )->addConfig(
	'card_layout',
	array(
		'name'         => 'sidelong_layout',
		'updateMethod' => 'option',
		'title'        => '【PC】トップページの記事一覧カードを横長にする',
		'type'         => 'checkbox',
	)
);
// 【モバイルトップページ】記事一覧のカードを横長にする
App::get( 'customizer_builder' )->addConfig(
	'card_layout',
	array(
		'name'         => 'mb_sidelong_layout',
		'updateMethod' => 'option',
		'title'        => '【モバイル】トップページの記事一覧カードを横長にする',
		'description'  => '<small>モバイル＝スマホ/タブレットでの表示</small>',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'card_layout',
	array(
		'name'         => 'mb_2column_layout',
		'updateMethod' => 'option',
		'title'        => '【モバイル】トップページの記事一覧カードを2カラム表示にする',
		'description'  => '<small>横長カードでない場合のみ有効</small>',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'card_layout',
	array(
		'name'         => 'archive_sidelong_layout',
		'updateMethod' => 'option',
		'title'        => '【PC】カテゴリー/アーカイブページの記事一覧カードを横長にする',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'card_layout',
	array(
		'name'         => 'mb_archive_sidelong_layout',
		'updateMethod' => 'option',
		'title'        => '【モバイル】カテゴリー/アーカイブページの記事一覧カードを横長にする',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'card_layout',
	array(
		'name'         => 'show_alternate_title',
		'updateMethod' => 'option',
		'title'        => '【共通】別名タイトルを表示する',
		'description'  => '<small>記事に別名タイトルが設定されている場合は別名タイトルを使用します。</small>',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'card_layout',
	array(
		'name'         => 'new_mark_date',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'title'        => '何日前の記事までNEWマークをつけるか',
		'description'  => '<small>例えば「2」にすると、2日前以降に公開された記事に一覧ページでNEWがつきます。デフォルトは「3」。表示しない場合は0にします。</small>',
		'type'         => 'number',
		'default'      => 3,
	)
);

App::get( 'customizer_builder' )->addSection(
	'記事コンテンツ',
	'sng_entry',
	array(
		'priority' => 3,
		'parent'   => 'desing_layout_setting',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_entry',
	array(
		'name'         => 'no_eyecatch',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'title'        => '投稿のタイトル下にアイキャッチ画像を表示しない',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_entry',
	array(
		'name'         => 'no_eyecatch_on_page',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'title'        => '固定ページのタイトル下にアイキャッチ画像を表示しない',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_entry',
	array(
		'name'         => 'remove_pubdate',
		'updateMethod' => 'option',
		'title'        => '日付を非表示にする',
		'transport'    => 'postMessage',
		'description'  => '<small>記事一覧上/投稿ページ上の日付を非表示にします。特に理由がない限りチェックをつける必要はありません。</small>',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_entry',
	array(
		'name'         => 'show_only_mod_date',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'title'        => '更新された投稿では更新日のみを表示する',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_entry',
	array(
		'name'         => 'sng_scroll_margin_top',
		'title'        => 'ページ内リンクスクロール位置',
		'transport'    => 'postMessage',
		'description'  => '<small>ページ内リンクをクリックした際のスクロール位置のオフセットを指定をします。ヘッダーが固定されたページのアンカーリンクがヘッダー下に隠れてしまう場合に有効です。</small>',
		'type'         => 'number',
		'default'      => '0',
		'updateMethod' => 'theme_mod',
	)
);

App::get( 'customizer_builder' )->addSection(
	'フォントサイズ',
	'font_size_setting',
	array(
		'priority' => 4,
		'parent'   => 'desing_layout_setting',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'font_size_setting',
	array(
		'name'         => 'mb_font_size',
		'updateMethod' => 'option',
		'default'      => '100',
		'title'        => 'スマホでのフォントサイズ',
		'transport'    => 'postMessage',
		'description'  => '<small>幅481px以下のブラウザでのフォントサイズを指定します。デフォルトは「100」です。レイアウト崩れを防ぐため、一部の文字サイズは変わりません（記事一覧のカード内などは固定）。</small>',
		'type'         => 'number',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'font_size_setting',
	array(
		'name'         => 'tb_font_size',
		'updateMethod' => 'option',
		'default'      => '107',
		'title'        => 'タブレットでのフォントサイズ',
		'description'  => '<small>幅482〜1029pxでのフォントサイズを指定します。デフォルト値は「107」です。</small>',
		'type'         => 'number',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'font_size_setting',
	array(
		'name'         => 'pc_font_size',
		'updateMethod' => 'option',
		'default'      => '107',
		'title'        => 'PCでのフォントサイズ',
		'description'  => '<small>幅1030px〜のフォントサイズを指定します。デフォルト値は「107」です。</small>',
		'type'         => 'number',
	)
);
App::get( 'customizer_builder' )->addSection(
	'フォント種類',
	'font_family_setting',
	array(
		'priority' => 5,
		'parent'   => 'desing_layout_setting',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'font_family_setting',
	array(
		'name'        => 'sng_font_family',
		'title'       => 'フォント種類',
		'description' => '<small>デフォルト以外のフォントを選ぶと読み込み速度が低下するのでご注意ください。</small>',
		'type'        => 'radio',
		'default'     => '',
		'choices'     => array(
			''               => 'デフォルト',
			'notosansjp'     => 'Noto Sans JP',
			'mplusrounded1c' => 'M PLUS Rounded 1c',
		),
	)
);

App::get( 'customizer_builder' )->addSection(
	'サイドバー',
	'sng_sidebar_widget',
	array(
		'priority' => 6,
		'parent'   => 'desing_layout_setting',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_sidebar_widget',
	array(
		'name'         => 'no_sidebar_mobile',
		'updateMethod' => 'option',
		'title'        => 'スマホ/タブレットではサイドバーを非表示にする',
		'transport'    => 'postMessage',
		'description'  => '<small>投稿/固定ページでサイドバーが非表示になります。</small>',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_sidebar_widget',
	array(
		'name'         => 'no_sidebar',
		'updateMethod' => 'option',
		'title'        => 'サイドバーを常に非表示にする',
		'transport'    => 'postMessage',
		'description'  => '<small>投稿/固定ページでサイドバーが非表示になります。</small>',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_sidebar_widget',
	array(
		'name'         => 'sng_sidebar_scroll_top',
		'title'        => '固定サイドバーの位置',
		'description'  => '<small>ヘッダーを固定している場合にスクロール時の固定サイドバーの表示位置を調整できます。</small>',
		'type'         => 'number',
		'default'      => 0,
		'updateMethod' => 'theme_mod',
	)
);

App::get( 'customizer_builder' )->addSection(
	'コンテンツブロック',
	'sng_content_block',
	array(
		'priority' => 7,
		'parent'   => 'desing_layout_setting',
	)
);

$block          = App::get( 'content-block' );
$content_blocks = $block->available_content_block_name_list();
if ( empty( $content_blocks ) ) {
	$content_blocks = array();
}

App::get( 'customizer_builder' )->addConfig(
	'sng_content_block',
	array(
		'name'         => 'sng_header_content_block',
		'title'        => 'ヘッダーのコンテンツブロック',
		'description'  => '<small>ヘッダーをコンテンツブロックで置き換えます</small>',
		'type'         => 'select',
		'updateMethod' => 'theme_mod',
		'choices'      => array_replace(
			$content_blocks,
			array(
				'' => '選択してください',
			)
		),
	)
);

App::get( 'customizer_builder' )->addConfig(
	'sng_content_block',
	array(
		'name'         => 'sng_footer_content_block',
		'title'        => 'フッターのコンテンツブロック',
		'description'  => '<small>フッターをコンテンツブロックで置き換えます</small>',
		'type'         => 'select',
		'updateMethod' => 'theme_mod',
		'choices'      => array_replace(
			$content_blocks,
			array(
				'' => '選択してください',
			)
		),
	)
);

App::get( 'customizer_builder' )->addConfig(
	'sng_content_block',
	array(
		'name'         => 'sng_notfound_content_block',
		'title'        => '404ページのコンテンツブロック',
		'description'  => '<small>404ページの内容をコンテンツブロックで置き換えます</small>',
		'type'         => 'select',
		'updateMethod' => 'theme_mod',
		'choices'      => array_replace(
			$content_blocks,
			array(
				'' => '選択してください',
			)
		),
	)
);

App::get( 'customizer_builder' )->addConfig(
	'sng_content_block',
	array(
		'name'         => 'sng_entry_footer_content_block',
		'title'        => '記事下のコンテンツブロック',
		'description'  => '<small>記事下の関連記事などをコンテンツブロックで置き換えます</small>',
		'type'         => 'select',
		'updateMethod' => 'theme_mod',
		'choices'      => array_replace(
			$content_blocks,
			array(
				'' => '選択してください',
			)
		),
	)
);
