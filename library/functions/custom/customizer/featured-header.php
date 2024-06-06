<?php
use SANGO\App;
/*********************
 * ヘッダーアイキャッチ
 */
App::get( 'customizer_builder' )->addSection(
	'🏞 ヘッダーアイキャッチ',
	'panel_featured_header',
	array(
		'priority' => 55,
	)
);
// ヘッダーアイキャッチ
App::get( 'customizer_builder' )->addSection(
	'ヘッダーアイキャッチ画像',
	'header_image',
	array(
		'priority'  => 1,
		'transport' => 'postMessage',
		'parent'    => 'panel_featured_header',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_image',
	array(
		'name'         => 'header_image_checkbox',
		'updateMethod' => 'option',
		'title'        => 'ヘッダーアイキャッチ画像を表示',
		'description'  => '<small>トップページにのみ表示される巨大なアイキャッチ画像です。</small>',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_image',
	array(
		'name'         => 'original_image_upload',
		'updateMethod' => 'option',
		'title'        => '画像をアップロード',
		'type'         => 'image',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_image',
	array(
		'name'         => 'limit_header_width',
		'updateMethod' => 'option',
		'title'        => '画像の最大横幅に制限を設ける（推奨）',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_image',
	array(
		'name'         => 'only_show_headerimg',
		'updateMethod' => 'option',
		'title'        => '文字やボタンを表示しない（画像のみ表示）',
		'description'  => '<small>画像の縦横比が常に保たれるようになります。</small>',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_image',
	array(
		'name'         => 'header_big_txt',
		'updateMethod' => 'option',
		'title'        => '見出し',
		'description'  => '<small>画像上に表示されます。</small>',
		'type'         => 'text',
		'sanitize'     => false,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_image',
	array(
		'name'         => 'header_sml_txt',
		'updateMethod' => 'option',
		'title'        => '説明文',
		'description'  => '<small>画像上に表示される小さめのテキストです。</small>',
		'type'         => 'textarea',
		'sanitize'     => false,
	)
);

App::get( 'customizer_builder' )->addConfig(
	'header_image',
	array(
		'name'         => 'header_btn_txt',
		'updateMethod' => 'option',
		'title'        => 'ボタンテキスト（挿入する場合）',
		'description'  => '<small>ボタンを挿入する場合に入力します。</small>',
		'type'         => 'text',
		'sanitize'     => false,
	)
);

App::get( 'customizer_builder' )->addConfig(
	'header_image',
	array(
		'name'         => 'header_btn_url',
		'updateMethod' => 'option',
		'title'        => 'ボタンURL',
		'type'         => 'url',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_image',
	array(
		'name'    => 'header_btn_color',
		'title'   => 'ボタン色',
		'default' => '#ff90a1',
		'type'    => 'color',
	)
);


// 2分割ヘッダーアイキャッチ
App::get( 'customizer_builder' )->addSection(
	'2分割ヘッダーアイキャッチ画像',
	'header_divide_image',
	array(
		'priority'  => 2,
		'transport' => 'postMessage',
		'parent'    => 'panel_featured_header',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_divide_image',
	array(
		'name'         => 'header_divide_checkbox',
		'updateMethod' => 'option',
		'title'        => '2分割ヘッダーアイキャッチを表示',
		'description'  => '<small>左側に画像、右側にテキストが表示されるヘッダーアイキャッチです（スマホだと縦に並びます）。トップページにのみ表示されます。</small>',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_divide_image',
	array(
		'name'         => 'divheader_image_upload',
		'updateMethod' => 'option',
		'title'        => '画像をアップロード',
		'type'         => 'image',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_divide_image',
	array(
		'name'         => 'divheader_big_txt',
		'updateMethod' => 'option',
		'title'        => '見出し',
		'type'         => 'text',
		'sanitize'     => false,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_divide_image',
	array(
		'name'         => 'divheader_sml_txt',
		'updateMethod' => 'option',
		'title'        => '説明文',
		'type'         => 'textarea',
		'sanitize'     => false,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_divide_image',
	array(
		'name'         => 'divheader_btn_txt',
		'updateMethod' => 'option',
		'title'        => 'ボタンテキスト（挿入する場合）',
		'type'         => 'text',
		'sanitize'     => false,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_divide_image',
	array(
		'name'         => 'divheader_btn_url',
		'updateMethod' => 'option',
		'title'        => 'ボタンURL',
		'type'         => 'url',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_divide_image',
	array(
		'name'    => 'divide_background_color',
		'title'   => 'テキスト部分の背景色',
		'type'    => 'color',
		'default' => '#93d1f0',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_divide_image',
	array(
		'name'    => 'divide_bigtxt_color',
		'title'   => '見出しカラー',
		'type'    => 'color',
		'default' => '#FFF',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_divide_image',
	array(
		'name'    => 'divide_smltxt_color',
		'title'   => '説明文カラー',
		'type'    => 'color',
		'default' => '#FFF',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_divide_image',
	array(
		'name'    => 'divide_btn_color',
		'title'   => 'ボタン色',
		'type'    => 'color',
		'default' => '#009EF3',
	)
);
