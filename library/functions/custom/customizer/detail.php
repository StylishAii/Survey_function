<?php
use SANGO\App;
/*********************
 * 詳細設定
 */
App::get( 'customizer_builder' )->addSection(
	'⚙️ 詳細設定',
	'other_options',
	array(
		'priority' => 60,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'other_options',
	array(
		'name'         => 'no_header_search',
		'transport'    => 'postMessage',
		'updateMethod' => 'option',
		'title'        => 'モバイルのヘッダー検索ボタンを非表示にする',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'other_options',
	array(
		'name'         => 'disable_animation',
		'transport'    => 'postMessage',
		'updateMethod' => 'option',
		'title'        => 'アイテムを表示する際のアニメーションを無効にする',
		'description'  => '<small>出現時のアニメーションのみ無効にします。マウスオーバー時のアニメーションは対象外です。</small>',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'other_options',
	array(
		'name'         => 'never_wpautop',
		'transport'    => 'postMessage',
		'updateMethod' => 'option',
		'title'        => '【非推奨】自動整形をオフにする（Classic Editor）',
		'description'  => '<small>WordPressデフォルトの自動整形を無効化します。WordPressの更新に伴い問題が生じる可能性があるため利用を推奨しません。</small>',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'other_options',
	array(
		'name'        => 'say_image_upload',
		'title'       => '吹き出しショートコードのデフォルト設定',
		'description' => '<small>吹き出しのショートコードでimg="~"を指定しなかった場合に、こちらで登録した画像が使用されます。</small>',
		'type'        => 'image',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'other_options',
	array(
		'name'         => 'say_name',
		'transport'    => 'postMessage',
		'updateMethod' => 'option',
		// 'title' => '吹き出しショートコードのデフォルト設定',
		'description'  => 'デフォルトの吹き出しアイコン画像下の名前',
		'input_attrs'  => array( 'placeholder' => '表示しない場合は空欄に' ),
		'type'         => 'text',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'other_options',
	array(
		'name'         => 'sng_hide_share',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'title'        => '投稿ページのシェアボタンを常に非表示にする',
		'type'         => 'checkbox',
	)
);
