<?php
use SANGO\App;
/*********************
 * 色の設定項目を追加
*/
// デフォルトをオーバーライド
App::get( 'customizer_builder' )->addSection(
	'🎨 色',
	'colors',
	array(
		'priority' => 2,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'        => 'main_color',
		'title'       => 'メインカラー',
		'type'        => 'color',
		'default'     => '#009EF3',
		'description' => '<small>テーマの大部分に使用される色です。背景が白でも目立つ色にしましょう。設定色の詳しい意味は<a href="https://saruwakakun.com/sango/custom-color" target="_blank">色変更の方法</a>で解説しています。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'        => 'pastel_color',
		'title'       => '薄めの下地色',
		'type'        => 'color',
		'default'     => '#b4e0fa',
		'description' => '<small>一部の背景に使われます。メインカラーと合う薄めの色を選びましょう。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'        => 'accent_color',
		'title'       => 'アクセントカラー',
		'type'        => 'color',
		'default'     => '#ffb36b',
		'description' => '<small>テーマのごく一部に使われます。メインカラーと並べたときに目立つ色を選びましょう。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'        => 'link_color',
		'title'       => 'リンク色',
		'type'        => 'color',
		'default'     => '#4f96f6',
		'description' => '<small>記事内などのリンクに使用される色です。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'        => 'header_bc',
		'title'       => 'ヘッダー背景色',
		'type'        => 'color',
		'default'     => '#009EF3',
		'description' => '<small>ヘッダーの塗りつぶし色です。この色はページ最下部のフッターにも使われます。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'    => 'header_c',
		'title'   => 'ヘッダータイトル色',
		'type'    => 'color',
		'default' => '#FFF',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'        => 'header_menu_c',
		'title'       => 'ヘッダーメニュー文字色',
		'type'        => 'color',
		'default'     => '#FFF',
		'description' => '<small>この色はフッターメニューの文字にも使われます。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'        => 'wid_title_c',
		'title'       => 'ウィジェットのタイトル色',
		'type'        => 'color',
		'default'     => '#009EF3',
		'description' => '<small>サイドバーなどのウィジェットのタイトル色に使われます。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'        => 'wid_title_bc',
		'title'       => 'ウィジェットタイトルの背景色',
		'type'        => 'color',
		'default'     => '#b4e0fa',
		'description' => '<small>サイドバーなどのウィジェットタイトルの背景色に使われます。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'        => 'sng_footer_bc',
		'title'       => 'フッターウィジェットの背景色',
		'type'        => 'color',
		'default'     => '#e0e4eb',
		'description' => '<small>フッターウィジェットを追加したときに使われる背景色です。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'    => 'sng_footer_c',
		'title'   => 'フッターウィジェットの文字色',
		'type'    => 'color',
		'default' => '#3c3c3c',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'        => 'sng_footer_menu_c',
		'title'       => 'フッターコピーライト部分の文字色',
		'type'        => 'color',
		'default'     => '#fff',
		'description' => '<small>フッターウィジェットを追加したときに使われる背景色です。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'        => 'sng_footer_menu_bc',
		'title'       => 'フッターコピーライト部分の背景色',
		'type'        => 'color',
		'default'     => '#009EF3',
		'description' => '<small>フッターウィジェットを追加したときに使われる背景色です。</small>',
	)
);

App::get( 'customizer_builder' )->addConfig(
	'colors',
	array(
		'name'        => 'sng_status_bar_bc',
		'title'       => 'ステータスバーの色',
		'type'        => 'color',
		'default'     => '#009EF3',
		'description' => '<small>iOSやAndroidのステータスバーの色を変更します。何も設定されていない場合はメインカラーが適用されます。</small>',
	)
);
