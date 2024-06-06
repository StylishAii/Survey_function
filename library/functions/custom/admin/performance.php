<?php

use SANGO\App;


App::get( 'builder' )->addSection( '🚀 高速化', 'performance', array( 'priority' => 1 ) );

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'performance_title0',
		'value'       => '',
		'title'       => 'キャッシュ設定',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'sng_enable_cache',
		'value'       => get_option( 'sng_enable_cache', '' ),
		'title'       => '一度読み込んだページをキャッシュする（β機能）',
		'type'        => 'checkbox',
		'description' => 'ログインしていないユーザーにはキャッシュコンテンツを返します。投稿やカスタマイザー、ウィジェットを保存したタイミングでキャッシュクリアされます。',
	)
);
App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'sng_enable_minify_html',
		'value'       => get_option( 'sng_enable_minify_html', '' ),
		'title'       => ' HTMLを圧縮してキャッシュする',
		'type'        => 'checkbox',
		'description' => 'キャッシュが有効な際にHTMLを圧縮してキャッシュします。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'sng_nocache_pages',
		'value'       => get_option( 'sng_nocache_pages', '' ),
		'title'       => 'キャッシュしないページ',
		'type'        => 'textarea',
		'placeholder' => '例）/contact',
		'description' => 'キャッシュしないページを改行区切りで入力してください。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'performance_title1',
		'value'       => '',
		'title'       => 'インライン設定',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'sng_css_inline',
		'value'       => get_option( 'sng_css_inline', '' ),
		'title'       => ' SANGOテーマのCSSをインラインで読み込む',
		'type'        => 'checkbox',
		'description' => 'キャッシュ機能を利用しつつCSSファイルをHTML内に直接展開することでパフォーマンスが向上します。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'sng_js_inline',
		'value'       => get_option( 'sng_js_inline', '' ),
		'title'       => ' SANGOテーマのJavaScriptをインラインで読み込む',
		'type'        => 'checkbox',
		'description' => 'キャッシュ機能を利用しつつJavaScriptファイルをHTML内に直接展開することでパフォーマンスが向上します。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'performance_title2',
		'value'       => '',
		'title'       => 'アセットの読み込み設定',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'read_minified_css',
		'value'       => get_option( 'read_minified_css', '' ),
		'title'       => '圧縮されたCSSを読み込む',
		'type'        => 'checkbox',
		'description' => '圧縮されたSANGOテーマに関わるCSSを読み込みます。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'sng_disable_old_css',
		'value'       => get_option( 'sng_disable_old_css', '' ),
		'title'       => ' SANGOテーマの2系以前のCSSを読み込まない',
		'type'        => 'checkbox',
		'description' => 'SANGO 3.0以上で必要のないCSSの読み込みを停止します。クラシックエディターで書かれた記事がある場合は停止すると記事の内容が崩れる場合があります。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'sng_minify_custom_css',
		'value'       => get_option( 'sng_minify_custom_css', '' ),
		'title'       => ' カスタムCSSを圧縮する',
		'type'        => 'checkbox',
		'description' => 'ブロックごとに設定したカスタムCSSを圧縮することで高速化につながります。ただし、CSSの記述に誤りがあるとうまく表示がされなくなる場合があります。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'sng_disable_footer_custom_css',
		'value'       => get_option( 'sng_disable_footer_custom_css', '' ),
		'title'       => ' カスタムCSSのfooter出力を停止する',
		'type'        => 'checkbox',
		'description' => 'キャッシュプラグイン対策でカスタムCSSはhead内とfooter付近両方に出力されています。もし不要な場合はfooter付近の方のCSS出力をチェックをつけて停止してください。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'sng_disable_jquery',
		'value'       => get_option( 'sng_disable_jquery', '' ),
		'title'       => 'jQueryを読み込まない',
		'type'        => 'checkbox',
		'description' => 'jQueryを読み込まないことで、ページロードスピードが向上します。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'disable_emoji_js',
		'value'       => get_option( 'disable_emoji_js', '' ),
		'title'       => '絵文字用のJSを読み込まない',
		'type'        => 'checkbox',
		'description' => 'WordPressの初期設定では絵文字を使用するためのJavascriptが読み込まれます。サイト内で絵文字を使わない場合にはチェックを入れましょう。',
	)
);


App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'no_google_font',
		'value'       => get_option( 'no_google_font', '' ),
		'title'       => 'Googleフォントを読み込まない',
		'type'        => 'checkbox',
		'description' => 'Googleフォントを読み込まないことで、ページロードスピードが向上します。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'performance_title3',
		'value'       => '',
		'title'       => '遅延読み込み及び先読み設定',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'        => 'use_loading_lazy',
		'value'       => get_option( 'use_loading_lazy', '' ),
		'title'       => 'メインコンテンツ外の画像の遅延読み込み',
		'type'        => 'checkbox',
		'description' => '追加された画像を遅延読み込みするための機能です。チェックをいれるとウィジェットや記事下内の画像が遅延読み込みされます。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'         => 'sng_lazy_contents',
		'value'        => get_theme_mod( 'sng_lazy_contents', '' ),
		'title'        => '記事内のiframeやscriptの遅延読み込み',
		'type'         => 'checkbox',
		'updateMethod' => 'theme_mod',
		'description'  => '記事内のiframeやscriptが画面内に表示されたタイミングで遅延読み込みします。TwitterやYouTubeなどの埋め込みを記事内で使用している場合に有効です。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'         => 'sng_flying_pages',
		'value'        => get_theme_mod( 'sng_flying_pages', '' ),
		'title'        => 'リンク先情報のプリフェッチ',
		'type'         => 'checkbox',
		'updateMethod' => 'theme_mod',
		'description'  => 'ユーザーがクリックする前にリンク先の情報を事前にプリフェッチしたい場合にチェックを入れてください。ページ遷移時の体感が早くなります。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'         => 'sng_async_scripts',
		'value'        => get_theme_mod( 'sng_async_scripts', '' ),
		'title'        => 'スクリプトの遅延読み込み',
		'type'         => 'textarea',
		'updateMethod' => 'theme_mod',
		'placeholder'  => 'https://example.com/script.js',
		'description'  => '改行区切りで遅延させたいスクリプトを設定してください。キーワードと部分一致したスクリプトを遅延読み込みできます。',
	)
);

App::get( 'builder' )->addConfig(
	'performance',
	array(
		'name'         => 'sng_dns_prefetch',
		'value'        => get_theme_mod( 'sng_dns_prefetch', '' ),
		'title'        => 'DNSプリフェッチ',
		'type'         => 'textarea',
		'updateMethod' => 'theme_mod',
		'placeholder'  => '//cdnjs.cloudflare.com',
		'description'  => '改行区切りで各ページでアクセスされる可能性の高いドメイン名を事前に入力しましょう。実際にアクセスされた際のコンテンツ読み込みにかかわる時間の短縮を図ります。',
	)
);
