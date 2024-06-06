<?php

use SANGO\App;

App::get( 'builder' )->addSection( '⚙️ 詳細設定', 'advanced', array( 'priority' => 4 ) );

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'detail_title0',
		'value'       => '',
		'title'       => 'コード挿入',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'insert_tag_tohead',
		'value'       => get_option( 'insert_tag_tohead', '' ),
		'title'       => 'headタグ内にコードを挿入',
		'type'        => 'textarea',
		'description' => 'head内に挿入したいタグがある場合はこちらに入力します。全ページのhead内にそのまま挿入されることにご注意ください。',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'         => 'insert_tag_to_end',
		'value'        => get_theme_mod( 'insert_tag_to_end', '' ),
		'title'        => 'body閉じタグ直前にコードを挿入',
		'type'         => 'textarea',
		'updateMethod' => 'theme_mod',
		'description'  => 'body閉じタグ直前に挿入したいタグがある場合はこちらに入力します。全ページのbody閉じタグ直前にそのまま挿入されることにご注意ください。',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'detail_title1',
		'value'       => '',
		'title'       => 'FontAwesome',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'use_fontawesome4',
		'value'       => get_option( 'use_fontawesome4', '' ),
		'title'       => 'FontAwesome4.7を使用する',
		'type'        => 'checkbox',
		'description' => 'すでにFontAwesome4のアイコンを使用しており、コードを最新のものに書き換えることができない場合はチェックを入れてください。',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'         => 'fontawesome_read_method',
		'value'        => get_theme_mod( 'fontawesome_read_method', 'all' ),
		'title'        => 'FontAwesomeの読み込み方法',
		'type'         => 'select',
		'updateMethod' => 'theme_mod',
		'choices'      => array(
			'all'     => '全て',
			'limited' => 'SANGOで利用されている最低限のフォントを読み込む',
			'local'   => '子テーマの/library/css/fa-sango.cssを読み込む',
		),
		'description'  => 'FontAwesomeの読み込み方法を指定します。子テーマのCSSをご利用される場合はSANGOテーマの/library/css/fa-sango.cssを複製して編集すると便利です。',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'fontawesome5_ver_num',
		'value'       => get_option( 'fontawesome5_ver_num', '' ),
		'title'       => 'FontAwesomeのバージョン',
		'type'        => 'text',
		'placeholder' => '6.1.1',
		'description' => '使用するFontAwesomeのバージョン番号<br><small>「6.1.1」のように、数字と「.」だけで指定します。空欄の場合バージョン6.1.1が使用されます。「FontAwesome4.7を使用する」にチェックが入っている場合は入力しても無視されます。',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'detail_title2',
		'value'       => '',
		'title'       => 'CSS, JavaScript',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'enable_scroll_hint_js',
		'value'       => get_option( 'enable_scroll_hint_js', '' ),
		'title'       => 'ScrollHintを読み込む',
		'type'        => 'checkbox',
		'description' => 'スクロールヒントという横スクロールを促すためのJSライブラリを読み込ます。パフォーマンスを改善したい場合はチェックを外してください。投稿ごとの設定でチェックをしていただく方がお勧めです。',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'enable_smartphoto_js',
		'value'       => get_option( 'enable_smartphoto_js', '' ),
		'title'       => 'SmartPhotoを読み込む',
		'type'        => 'checkbox',
		'description' => 'SmartPhotoという写真を拡大するためのJavaScriptライブラリを読み込ます。パフォーマンスを改善したい場合はチェックを外してください。',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'smartphoto_js_no_thumbnail',
		'value'       => get_option( 'smartphoto_js_no_thumbnail', '' ),
		'title'       => 'SmartPhotoで他の写真候補を表示しない',
		'type'        => 'checkbox',
		'description' => '写真拡大時に他の写真候補を表示しない場合はチェックを入れてください。',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'detail_title2',
		'value'       => '',
		'title'       => 'テーマのアップデート方法',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'sng_update_method_include_major_version',
		'value'       => get_option( 'sng_update_method_include_major_version', '' ),
		'title'       => 'テーマアップデート時にメジャーアップデートを含める',
		'type'        => 'checkbox',
		'description' => 'SANGOテーマのアップデート時に破壊的変更があるアップデートを含めます。2.0 → 3.0など',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'detail_title3',
		'value'       => '',
		'title'       => '管理メニュー設定',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'sng_hide_sango_land_link',
		'value'       => get_option( 'sng_hide_sango_land_link', '' ),
		'title'       => 'SANGO Landへのリンクを隠す',
		'type'        => 'checkbox',
		'description' => '管理メニューから「SANGO Land」へのリンクを除外したい場合はチェックを入れてください',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'sng_show_reusable_block_menu',
		'value'       => get_option( 'sng_show_reusable_block_menu', '' ),
		'title'       => '再利用ブロックのリンクを表示する',
		'type'        => 'checkbox',
		'description' => '管理メニューに再利用ブロックのリンクを表示します。',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'detail_title4',
		'value'       => '',
		'title'       => '管理用投稿一覧ページ設定',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'sng_hide_posts_featured_image',
		'value'       => get_option( 'sng_hide_posts_featured_image', '' ),
		'title'       => 'サムネイル画像を隠す',
		'type'        => 'checkbox',
		'description' => '管理用投稿一覧ページにてサムネイル画像を非表示にします',
	)
);

App::get( 'builder' )->addConfig(
	'advanced',
	array(
		'name'        => 'sng_hide_posts_pv',
		'value'       => get_option( 'sng_hide_posts_pv', '' ),
		'title'       => 'PV数を隠す',
		'type'        => 'checkbox',
		'description' => '管理用投稿一覧ページにてPV数をを非表示にします',
	)
);
