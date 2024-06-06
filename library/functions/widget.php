<?php

function sng_register_sidebars() {
	// メインのサイドバー
	register_sidebar(
		array(
			'id'            => 'sidebar1',
			'name'          => 'サイドバー',
			'description'   => 'メインのサイドバーです。スマホで見たときにはページ下に配置されます。',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widgettitle has-fa-before">',
			'after_title'   => '</h4>',
		)
	);

	// 追尾サイドバー
	register_sidebar(
		array(
			'id'            => 'fixed_sidebar',
			'name'          => '追尾サイドバー（PCのみ）',
			'description'   => 'この中に入れたウィジェットは記事ページのサイドバーで固定されます',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widgettitle has-fa-before">',
			'after_title'   => '</h4>',
		)
	);

	// ナビドロワー（ハンバーガーメニュー）
	register_sidebar(
		array(
			'id'            => 'nav_drawer',
			'name'          => 'スマホ用ナビドロワー（ハンバーガーメニュー）',
			'description'   => 'ハンバーガーメニューで表示されるナビドロワーです',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widgettitle has-fa-before">',
			'after_title'   => '</h4>',
		)
	);

	// フッターウィジェット左
	register_sidebar(
		array(
			'id'            => 'footer_left',
			'name'          => 'フッターウィジェット左',
			'description'   => '画面が小さくなるとフッターウィジェットは縦に並びます。',
			'before_widget' => '<div class="ft_widget widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="ft_title">',
			'after_title'   => '</h4>',
		)
	);

	// 目次用ウィジェット
	register_sidebar(
		array(
			'id'            => 'toc_in_contents',
			'name'          => '記事内目次用エリア',
			'description'   => 'はじめのh2見出しの前に表示されます',
			'before_widget' => '<div class="toc">',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="ads-title">',
			'after_title'   => '</p>',
		)
	);

	// フッターウィジェット中
	register_sidebar(
		array(
			'id'            => 'footer_cent',
			'name'          => 'フッターウィジェット中',
			'description'   => '画面が小さくなるとフッターウィジェットは縦に並びます。',
			'before_widget' => '<div class="ft_widget widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="ft_title">',
			'after_title'   => '</h4>',
		)
	);

	// フッターウィジェット右
	register_sidebar(
		array(
			'id'            => 'footer_right',
			'name'          => 'フッターウィジェット右',
			'description'   => '画面が小さくなるとフッターウィジェットは縦に並びます。',
			'before_widget' => '<div class="ft_widget widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="ft_title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'id'            => 'home_header',
			'name'          => 'トップページヘッダー下',
			'description'   => 'トップページのヘッダー下のスペースに表示されます(モバイル/PC共通)。',
			'before_widget' => '<div class="home_header">',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="strong center">',
			'after_title'   => '</p>',
		)
	);

	// トップページ上
	register_sidebar(
		array(
			'id'            => 'home_top',
			'name'          => 'トップページ記事一覧上',
			'description'   => 'トップページの記事一覧上のスペースに表示されます(モバイル/PC共通)。',
			'before_widget' => '<div class="home_top">',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="strong center">',
			'after_title'   => '</p>',
		)
	);

	// トップページ下
	register_sidebar(
		array(
			'id'            => 'home_bottom',
			'name'          => 'トップページ記事一覧下',
			'description'   => 'トップページの記事一覧下のスペースに表示されます(モバイル/PC共通)。',
			'before_widget' => '<div class="home_bottom">',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="strong center">',
			'after_title'   => '</p>',
		)
	);

	// 記事タイトル下広告（モバイル）
	register_sidebar(
		array(
			'id'            => 'ads_below_title_mb',
			'name'          => '記事タイトル下広告（モバイル）',
			'description'   => 'スマホ・タブレットで見たときに記事のタイトル下に表示されます。',
			'before_widget' => '<div class="sponsored">',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="ads-title dfont">',
			'after_title'   => '</p>',
		)
	);

	// 記事タイトル下広告（PC）
	register_sidebar(
		array(
			'id'            => 'ads_below_title_pc',
			'name'          => '記事タイトル下広告（PC）',
			'description'   => 'PCで見たときに記事のタイトル下に表示されます。',
			'before_widget' => '<div class="sponsored">',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="ads-title dfont">',
			'after_title'   => '</p>',
		)
	);

	// 記事タイトル下共通
	register_sidebar(
		array(
			'id'            => 'contents_below_title',
			'name'          => '記事タイトル下（共通）',
			'description'   => 'PCとモバイル共通で記事のタイトル下に表示されます。',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<p>',
			'after_title'   => '</p>',
		)
	);

	// カテゴリー記事上
	register_sidebar(
		array(
			'id'            => 'category_top',
			'name'          => 'カテゴリートップページ記事一覧上',
			'description'   => 'カテゴリートップページの記事一覧上に表示されます。',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="widgettitle has-fa-before">',
			'after_title'   => '</p>',
		)
	);

	// 記事中広告
	register_sidebar(
		array(
			'id'            => 'ads_in_contents',
			'name'          => '記事中広告',
			'description'   => 'はじめのh2見出しの前に表示されます',
			'before_widget' => '<div class="sponsored">',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="ads-title dfont">',
			'after_title'   => '</p>',
		)
	);

	// アドセンス 記事下広告（モバイル）
	register_sidebar(
		array(
			'id'            => 'ads_below_contents_mb',
			'name'          => '記事コンテンツ後広告（モバイル）',
			'description'   => 'スマホ・タブレットで見たときに記事の記事コンテンツの下（シェアボタン前）に表示されます。',
			'before_widget' => '<div class="sponsored">',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="ads-title dfont">',
			'after_title'   => '</p>',
		)
	);

	// アドセンス 記事下広告（PC）
	register_sidebar(
		array(
			'id'            => 'ads_below_contents_pc',
			'name'          => '記事コンテンツ後広告（PC）',
			'description'   => 'PCで見たときに記事の記事コンテンツの下（シェアボタン前）に表示されます。',
			'before_widget' => '<div class="sponsored">',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="ads-title dfont">',
			'after_title'   => '</p>',
		)
	);

	// アドセンス関連記事型広告
	register_sidebar(
		array(
			'id'            => 'ads_footer',
			'name'          => 'アドセンス関連記事型広告',
			'description'   => '記事下に表示されます。アドセンスの関連記事型広告向けです。コードを貼り付けてご利用ください。',
			'before_widget' => '<div id="related_ads" class="related_ads">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="h-undeline related_title">',
			'after_title'   => '</h3>',
		)
	);
}

add_action( 'widgets_init', 'sng_register_sidebars' );
