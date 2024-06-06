<?php

use SANGO\App;

App::get( 'builder' )->addSection( '🗞️ 広告設定', 'ad', array( 'priority' => 2 ) );

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'        => 'ad_title0',
		'value'       => '',
		'title'       => 'Google Adsense',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'         => 'google_ad_code',
		'value'        => get_theme_mod( 'google_ad_code', '' ),
		'title'        => 'scriptタグ',
		'type'         => 'textarea',
		'updateMethod' => 'theme_mod',
		'description'  => 'Google AdSenseで取得したコードのscriptタグはこちらに入力してください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'         => 'ad_title1',
		'value'        => '',
		'title'        => 'インフィード広告',
		'type'         => 'title',
		'updateMethod' => 'theme_mod',
		'description'  => '',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'         => 'enable_ad_infeed',
		'value'        => get_theme_mod( 'enable_ad_infeed', '' ),
		'title'        => 'インフィード広告を有効化する',
		'type'         => 'checkbox',
		'updateMethod' => 'theme_mod',
		'description'  => '記事一覧でインフィード広告を表示する場合はチェックしてください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'         => 'enable_ad_infeed_for_related',
		'value'        => get_theme_mod( 'enable_ad_infeed_for_related', '' ),
		'title'        => '関連記事にインフィード広告を表示',
		'type'         => 'checkbox',
		'updateMethod' => 'theme_mod',
		'description'  => '関連記事でインフィード広告を表示する場合はチェックしてください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'         => 'ad_infeed',
		'value'        => get_theme_mod( 'ad_infeed', '' ),
		'title'        => 'インフィード広告（カードタイプ用）',
		'type'         => 'textarea',
		'updateMethod' => 'theme_mod',
		'description'  => 'インフィード広告用のコードを入力してください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'         => 'ad_infeed2',
		'value'        => get_theme_mod( 'ad_infeed2', '' ),
		'title'        => 'インフィード広告（横長タイプ用）',
		'type'         => 'textarea',
		'updateMethod' => 'theme_mod',
		'description'  => 'インフィード広告用のコードを入力してください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'         => 'ad_infeed3',
		'value'        => get_theme_mod( 'ad_infeed3', '' ),
		'title'        => 'インフィード広告（横長大タイプ用）',
		'type'         => 'textarea',
		'updateMethod' => 'theme_mod',
		'description'  => 'インフィード広告用のコードを入力してください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'         => 'ad_infeed4',
		'value'        => get_theme_mod( 'ad_infeed4', '' ),
		'title'        => 'インフィード広告（関連記事一覧用）',
		'type'         => 'textarea',
		'updateMethod' => 'theme_mod',
		'description'  => 'インフィード広告用のコードを入力してください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'         => 'ad_infeed5',
		'value'        => get_theme_mod( 'ad_infeed5', '' ),
		'title'        => 'インフィード広告（記事スライダー用）',
		'type'         => 'textarea',
		'updateMethod' => 'theme_mod',
		'description'  => 'インフィード広告用のコードを入力してください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'         => 'ad_infeed_pos1',
		'value'        => get_theme_mod( 'ad_infeed_pos1', '' ),
		'title'        => 'インフィード広告の表示位置1',
		'type'         => 'text',
		'updateMethod' => 'theme_mod',
		'description'  => '隣同士にインフィード広告を設置することはできません',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'         => 'ad_infeed_pos2',
		'value'        => get_theme_mod( 'ad_infeed_pos2', '' ),
		'title'        => 'インフィード広告の表示位置2',
		'type'         => 'text',
		'updateMethod' => 'theme_mod',
		'description'  => '隣同士にインフィード広告を設置することはできません',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'         => 'ad_infeed_pos3',
		'value'        => get_theme_mod( 'ad_infeed_pos3', '' ),
		'title'        => 'インフィード広告の表示位置3',
		'type'         => 'text',
		'updateMethod' => 'theme_mod',
		'description'  => '隣同士にインフィード広告を設置することはできません',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'         => 'ad_title2',
		'value'        => '',
		'title'        => '記事内広告',
		'type'         => 'title',
		'updateMethod' => 'theme_mod',
		'description'  => '',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'        => 'show_ad_at_1st_pos',
		'value'       => get_option( 'show_ad_at_1st_pos', true ),
		'title'       => '1つ目のh2上',
		'type'        => 'checkbox',
		'description' => '記事内の1つ目のh2上に「記事中広告ウィジェット」を表示する場合はチェックしてください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'        => 'show_ad_at_2nd_pos',
		'value'       => get_option( 'show_ad_at_2nd_pos', false ),
		'title'       => '2つ目のh2上',
		'type'        => 'checkbox',
		'description' => '記事内の2つ目のh2上に「記事中広告ウィジェット」を表示する場合はチェックしてください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'        => 'show_ad_at_3rd_pos',
		'value'       => get_option( 'show_ad_at_3rd_pos', false ),
		'title'       => '3つ目のh2上',
		'type'        => 'checkbox',
		'description' => '記事内の3つ目のh2上に「記事中広告ウィジェット」を表示する場合はチェックしてください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'        => 'show_ad_at_4th_pos',
		'value'       => get_option( 'show_ad_at_4th_pos', false ),
		'title'       => '4つ目のh2上',
		'type'        => 'checkbox',
		'description' => '記事内の4つ目のh2上に「記事中広告ウィジェット」を表示する場合はチェックしてください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'        => 'show_ad_at_5th_pos',
		'value'       => get_option( 'show_ad_at_5th_pos', false ),
		'title'       => '5つ目のh2上',
		'type'        => 'checkbox',
		'description' => '記事内の5つ目のh2上に「記事中広告ウィジェット」を表示する場合はチェックしてください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'        => 'show_ad_at_odd_pos',
		'value'       => get_option( 'show_ad_at_odd_pos', false ),
		'title'       => '奇数番目のh2上',
		'type'        => 'checkbox',
		'description' => '記事内の奇数番目のh2上に「記事中広告ウィジェット」を表示する場合はチェックしてください。',
	)
);

App::get( 'builder' )->addConfig(
	'ad',
	array(
		'name'        => 'show_ad_at_even_pos',
		'value'       => get_option( 'show_ad_at_even_pos', false ),
		'title'       => '偶数番目のh2上',
		'type'        => 'checkbox',
		'description' => '記事内の偶数番目のh2上に「記事中広告ウィジェット」を表示する場合はチェックしてください。',
	)
);
