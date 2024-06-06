<?php
use SANGO\App;
/*********************
 * SANGOのオリジナル機能
 */
App::get( 'customizer_builder' )->addSection(
	'💻 SANGOオリジナル機能',
	'sango_original_addon',
	array(
		'priority' => 53,
	)
);
// タブ
App::get( 'customizer_builder' )->addSection(
	'記事一覧タブ切替（トップページ）',
	'sng_tab',
	array(
		'priority' => 1,
		'parent'   => 'sango_original_addon',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'         => 'activate_tab',
		'updateMethod' => 'option',
		'title'        => 'トップページの記事一覧でタブ切り替えを有効にする',
		'description'  => '<small>指定したカテゴリーの記事一覧をタブで表示できるようになります。<strong>タブの数が偶数個（2つか4つ）になるように</strong>設定してください。タイトルを入力したタブが有効になります。</small>',
		'type'         => 'checkbox',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'         => 'tab1name',
		'updateMethod' => 'option',
		'title'        => 'タブ1（新着記事）のタイトル',
		'transport'    => 'postMessage',
		'description'  => '<small>ここに入力したテキストがタブのラベル（名前）として表示されます。1番目のタブには新着記事一覧が表示されます。</small>',
		'type'         => 'text',
		'sanitize'     => false,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'         => 'tab2name',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'title'        => 'タブ2のタイトル',
		'type'         => 'text',
		'sanitize'     => false,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'        => 'tab2cat_or_tag',
		'title'       => '- タブ2の記事一覧の取得方法',
		'default'     => 'cat_chosen',
		'description' => '<small>特定のカテゴリーに属する記事一覧を表示するか、特定のタグを持つ記事一覧を表示するか選ぶことができます。</small>',
		'type'        => 'radio',
		'choices'     => array(
			'cat_chosen' => 'カテゴリーIDで指定',
			'tag_chosen' => 'タグIDで指定',
		),
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'         => 'tab2id',
		'title'        => '- タブ2のID',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'type'         => 'text',
		'input_attrs'  => array( 'placeholder' => 'カテゴリーIDかタグIDを半角数字で入力' ),
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'         => 'tab2link',
		'updateMethod' => 'option',
		'title'        => '- タブ2の「もっと見る」のリンク先URL',
		'description'  => '<small>空欄のままにすれば非表示になります。</small>',
		'type'         => 'url',
	)
);

App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'         => 'tab3name',
		'updateMethod' => 'option',
		'title'        => 'タブ3のタイトル',
		'transport'    => 'postMessage',
		'type'         => 'text',
		'sanitize'     => false,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'    => 'tab3cat_or_tag',
		'title'   => '- タブ3の記事一覧の取得方法',
		'type'    => 'radio',
		'default' => 'cat_chosen',
		'choices' => array(
			'cat_chosen' => 'カテゴリーIDで指定',
			'tag_chosen' => 'タグIDで指定',
		),
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'         => 'tab3id',
		'updateMethod' => 'option',
		'title'        => '- タブ3のID',
		'transport'    => 'postMessage',
		'type'         => 'text',
		'input_attrs'  => array( 'placeholder' => 'カテゴリーIDかタグIDを半角数字で入力' ),
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'         => 'tab3link',
		'updateMethod' => 'option',
		'title'        => '- タブ3の「もっと見る」のリンク先URL',
		'type'         => 'url',
	)
);


App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'         => 'tab4name',
		'updateMethod' => 'option',
		'title'        => 'タブ4のタイトル',
		'transport'    => 'postMessage',
		'type'         => 'text',
		'sanitize'     => false,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'    => 'tab4cat_or_tag',
		'title'   => '- タブ4の記事一覧の取得方法',
		'type'    => 'radio',
		'default' => 'cat_chosen',
		'choices' => array(
			'cat_chosen' => 'カテゴリーIDで指定',
			'tag_chosen' => 'タグIDで指定',
		),
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'         => 'tab4id',
		'updateMethod' => 'option',
		'title'        => '- タブ4のID',
		'transport'    => 'postMessage',
		'type'         => 'text',
		'input_attrs'  => array( 'placeholder' => 'カテゴリーIDかタグIDを半角数字で入力' ),
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'         => 'tab4link',
		'updateMethod' => 'option',
		'title'        => '- タブ4の「もっと見る」のリンク先URL',
		'type'         => 'url',
	)
);

App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'    => 'tab_background_color',
		'title'   => 'タブの背景色',
		'type'    => 'color',
		'default' => '#FFF',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'    => 'tab_text_color',
		'title'   => 'タブの文字色',
		'type'    => 'color',
		'default' => '#a7a7a7',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'        => 'tab_active_self',
		'title'       => 'アクティブタブの背景色',
		'type'        => 'checkbox',
		'description' => '<small>デフォルトで選択中のタブの背景色はメインカラーになりますが、もし自身で設定したい場合はチェックを入れてください。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'        => 'tab_active_color1',
		'type'        => 'color',
		'description' => '<small>現在選択中のタブの背景色です。2色を異なる色で設定すると、グラデーションになります。文字色は白です。</small>',
		'default'     => '#bdb9ff',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'    => 'tab_active_color2',
		'type'    => 'color',
		'default' => '#67b8ff',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'         => 'tab_cat_num',
		'updateMethod' => 'option',
		'type'         => 'number',
		'transport'    => 'postMessage',
		'description'  => '<small>新着記事(タブ1)の表示数は「設定」⇒「表示設定」で指定された値が反映されます。</small>',
		'title'        => 'タブ2〜4の表示記事数',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_tab',
	array(
		'name'         => 'tab_posts_show_random',
		'updateMethod' => 'option',
		'type'         => 'checkbox',
		'description'  => '<small>チェックを入れるとタブ2〜4の記事が新着順ではなくランダムに表示されます。</small>',
		'title'        => '記事をランダムに表示する',
	)
);

// モバイルフッター固定メニュー
App::get( 'customizer_builder' )->addSection(
	'モバイルフッター固定メニュー',
	'footer_fixed',
	array(
		'priority'    => 2,
		'parent'      => 'sango_original_addon',
		'description' => '<small>［外観］⇒［メニュー］で「モバイル用フッター固定メニュー」を作成・登録するとモバイル（スマホ・タブレット）で表示されるようになります。詳しい設定方法は<a href="https://saruwakakun.com/sango/mb_footer" target="_blank">カスタマイズガイド</a>で解説しています。<br>こちらでは、細かな設定を行うことができます。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'footer_fixed',
	array(
		'name'         => 'footer_fixed_share',
		'updateMethod' => 'option',
		'type'         => 'checkbox',
		'description'  => '<small>さらにシェアボタン用のメニューを追加する必要があります。詳しい設定はカスタマイズガイドをご覧ください。</small>',
		'title'        => 'シェアボタン機能を使用する',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'footer_fixed',
	array(
		'name'         => 'footer_fixed_follow',
		'updateMethod' => 'option',
		'type'         => 'checkbox',
		'description'  => '<small>さらにフォローボタン用のメニューを追加する必要があります。</small>',
		'title'        => 'フォローボタン機能を使用する',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'footer_fixed',
	array(
		'name'         => 'footer_fixed_scroll_upward',
		'updateMethod' => 'option',
		'type'         => 'checkbox',
		'description'  => '<small>モバイルフッター固定メニューを上方向にスクロールした時のみ表示します。</small>',
		'title'        => '上方向にスクロールした時だけメニューを表示する',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'footer_fixed',
	array(
		'name'    => 'footer_fixed_bc',
		'type'    => 'color',
		'title'   => 'メニューの背景色',
		'default' => '#FFF',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'footer_fixed',
	array(
		'name'    => 'footer_fixed_c',
		'type'    => 'color',
		'title'   => 'メニューの文字/アイコン色',
		'default' => '#a2a7ab',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'footer_fixed',
	array(
		'name'        => 'footer_fixed_actc',
		'type'        => 'color',
		'title'       => 'アクティブカラー',
		'description' => '<small>メニューがタップされたときなどの文字/アイコン色です。メインカラーと合わせるのがおすすめです。</small>',
		'default'     => '#009EF3',
	)
);
// ヘッダーお知らせ欄
App::get( 'customizer_builder' )->addSection(
	'ヘッダーお知らせ欄',
	'header_info',
	array(
		'priority' => 3,
		'parent'   => 'sango_original_addon',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_info',
	array(
		'name'         => 'header_info_text',
		'updateMethod' => 'option',
		'type'         => 'text',
		'title'        => 'お知らせ文',
		'sanitize'     => false,
		'description'  => '<small>入力すると表示されるようになります。FontAwesomeのアイコンも使用できます。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_info',
	array(
		'name'        => 'header_info_c1',
		'type'        => 'color',
		'default'     => '#738bff',
		'title'       => '背景色1',
		'description' => '<small>背景のグラデーションの片側の色です。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_info',
	array(
		'name'        => 'header_info_c2',
		'type'        => 'color',
		'default'     => '#85e3ec',
		'title'       => '背景色2',
		'description' => '<small>グラデーションのもう片側の色です。グラデーションにしない場合には、両方の色を合わせてください。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_info',
	array(
		'name'    => 'header_info_c',
		'type'    => 'color',
		'default' => '#FFF',
		'title'   => '文字色',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_info',
	array(
		'name'         => 'header_info_url',
		'updateMethod' => 'option',
		'type'         => 'url',
		'title'        => 'リンク先URL',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'header_info',
	array(
		'name'         => 'enable_header_info_animation',
		'updateMethod' => 'option',
		'type'         => 'checkbox',
		'title'        => '読み込み時のアニメーションを有効にする',
	)
);

// フォローボックス（記事下）
App::get( 'customizer_builder' )->addSection(
	'フォローボックス（記事下）',
	'show_like_box',
	array(
		'priority' => 4,
		'parent'   => 'sango_original_addon',
	)
);

App::get( 'customizer_builder' )->addConfig(
	'show_like_box',
	array(
		'name'         => 'enable_like_box',
		'updateMethod' => 'option',
		'type'         => 'checkbox',
		'title'        => 'フォローボックスを表示する',
		'description'  => '<small>「この記事を気に入ったらいいね」というようなボックスです。</small>',
	)
);

App::get( 'customizer_builder' )->addConfig(
	'show_like_box',
	array(
		'name'         => 'like_box_title',
		'updateMethod' => 'option',
		'type'         => 'text',
		'title'        => '画像上にのせるテキスト',
		'description'  => '<small>「この記事を気に入ったらいいね」というようなボックスです。</small>',
		'sanitize'     => false,
	)
);

App::get( 'customizer_builder' )->addConfig(
	'show_like_box',
	array(
		'name'         => 'like_box_subtitle',
		'updateMethod' => 'option',
		'type'         => 'text',
		'title'        => 'フォローボックスのサブタイトル',
		'default'      => 'この記事が気に入ったらフォローしよう',
		'description'  => '<small>SNSアカウント等でのフォローを促す文言などを入力してください。</small>',
		'sanitize'     => false,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_like_box',
	array(
		'name'         => 'like_box_twitter',
		'updateMethod' => 'option',
		'type'         => 'text',
		'title'        => 'Twitterのユーザー名',
		'description'  => '<small>@に続くユーザー名を入力してください（@は含めない）。名前が空欄の場合には表示されません。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_like_box',
	array(
		'name'         => 'follower_count',
		'updateMethod' => 'option',
		'type'         => 'checkbox',
		'title'        => 'Twitterのフォロワー数を表示',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_like_box',
	array(
		'name'         => 'like_box_fb',
		'updateMethod' => 'option',
		'type'         => 'text',
		'title'        => 'FacebookページのURL',
		'description'  => '<small>Facebookの仕様上、個人アカウントページには対応していません。空欄の場合には表示されません。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_like_box',
	array(
		'name'         => 'like_box_feedly',
		'updateMethod' => 'option',
		'type'         => 'text',
		'title'        => 'FeedlyのURL',
		'description'  => '<small>空欄の場合には表示されません。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_like_box',
	array(
		'name'         => 'like_box_insta',
		'updateMethod' => 'option',
		'type'         => 'text',
		'title'        => 'InstagramのURL',
		'description'  => '<small>InstagramのプロフィールページのURLを入力します。空欄の場合には表示されません。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_like_box',
	array(
		'name'         => 'like_box_youtube',
		'updateMethod' => 'option',
		'type'         => 'text',
		'title'        => 'YouTubeのURL',
		'description'  => '<small>YouTubeのチャンネルなどのURLを入力します。空欄の場合には表示されません。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_like_box',
	array(
		'name'         => 'like_box_line_friend_id',
		'updateMethod' => 'option',
		'type'         => 'text',
		'title'        => 'LINE ID',
		'description'  => '<small>LINE公式アカウントやLINE@アカウントのLINE IDを入力してください。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_like_box',
	array(
		'name'         => 'like_box_line_show_follower_count',
		'updateMethod' => 'option',
		'type'         => 'checkbox',
		'title'        => 'LINEボタン横にフォロワー数を表示する',
	)
);
// 関連記事（記事下）
App::get( 'customizer_builder' )->addSection(
	'関連記事（記事下）',
	'sng_related_posts',
	array(
		'priority' => 5,
		'parent'   => 'sango_original_addon',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_related_posts',
	array(
		'name'         => 'no_related_posts',
		'updateMethod' => 'option',
		'type'         => 'checkbox',
		'transport'    => 'postMessage',
		'title'        => '記事下に関連記事を表示しない',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_related_posts',
	array(
		'name'         => 'related_post_title',
		'updateMethod' => 'option',
		'type'         => 'text',
		'transport'    => 'postMessage',
		'title'        => '関連記事のタイトル',
		'sanitize'     => false,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_related_posts',
	array(
		'name'    => 'related_posts_type',
		'type'    => 'radio',
		'title'   => '関連記事のデザイン',
		'default' => 'type_a',
		'choices' => array(
			'type_a' => 'タイプA',
			'type_b' => 'タイプB（カード）',
			'type_c' => 'タイプC（横長）',
		),
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_related_posts',
	array(
		'name'         => 'related_no_slider',
		'updateMethod' => 'option',
		'type'         => 'checkbox',
		'transport'    => 'postMessage',
		'title'        => 'モバイル表示で関連記事をスライダー表示にしない',
		'description'  => '<small>スマホ/タブレット表示で関連記事を横スクロール表示にしない場合には、こちらにチェックを入れます。タイプCではチェックの有無に関わらず、スクロールなしになります。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_related_posts',
	array(
		'name'         => 'related_add_parent',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'type'         => 'checkbox',
		'title'        => '親カテゴリーに属する記事も含める',
		'description'  => '<small>スマホ/デフォルトでは同カテゴリーの記事のみが出力されます。こちらにチェックを入れると「親カテゴリー」と「親カテゴリーに含まれる子カテゴリー」の記事も合わせてランダムで出力するようになります。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_related_posts',
	array(
		'name'         => 'num_related_posts',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'type'         => 'number',
		'title'        => '関連記事の表示数',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_related_posts',
	array(
		'name'    => 'related_posts_order',
		'type'    => 'radio',
		'title'   => '関連記事の取得順',
		'default' => 'rand',
		'choices' => array(
			'rand' => 'ランダム',
			'date' => '新着順',
		),
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_related_posts',
	array(
		'name'         => 'related_posts_days_ago',
		'type'         => 'number',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'title'        => '○日前より後に公開された記事のみ表示',
		'description'  => '例えば「30」にすると、30日前以降に公開された記事のみ関連記事に含まれるようになります。「0」にすると、全期間の記事が取得されます。',
		'default'      => 0,
	)
);

// おすすめ記事（記事下）
App::get( 'customizer_builder' )->addSection(
	'おすすめ記事（記事下）',
	'recommended_posts',
	array(
		'priority' => 6,
		'parent'   => 'sango_original_addon',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'recommended_posts',
	array(
		'name'         => 'enable_recommend',
		'updateMethod' => 'option',
		'type'         => 'checkbox',
		'title'        => 'おすすめ記事を記事下に表示',
		'description'  => '<small>記事下に指定した投稿IDの記事を表示します。アイキャッチ画像が登録されている記事のみ指定することができます。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'recommended_posts',
	array(
		'name'         => 'recommend_title',
		'updateMethod' => 'option',
		'type'         => 'text',
		'title'        => '見出し',
		'transport'    => 'postMessage',
		'description'  => '<small>例：おすすめの記事</small>',
		'sanitize'     => false,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'recommended_posts',
	array(
		'name'         => 'recid1',
		'updateMethod' => 'option',
		'type'         => 'text',
		'title'        => 'おすすめ記事(1)のID',
		'transport'    => 'postMessage',
		'description'  => '<small>例:145</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'recommended_posts',
	array(
		'name'         => 'rectitle1',
		'updateMethod' => 'option',
		'type'         => 'text',
		'transport'    => 'postMessage',
		'title'        => 'ーおすすめ記事(1)のタイトル',
		'description'  => '<small>※空欄の場合、もともとのタイトルを表示します。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'recommended_posts',
	array(
		'name'         => 'recid2',
		'updateMethod' => 'option',
		'type'         => 'text',
		'transport'    => 'postMessage',
		'title'        => 'おすすめ記事(2)のID',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'recommended_posts',
	array(
		'name'         => 'rectitle2',
		'updateMethod' => 'option',
		'type'         => 'text',
		'title'        => 'ーおすすめ記事(2)のタイトル',
		'transport'    => 'postMessage',
		'description'  => '<small>※空欄の場合、もともとのタイトルを表示します。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'recommended_posts',
	array(
		'name'         => 'recid3',
		'updateMethod' => 'option',
		'type'         => 'text',
		'transport'    => 'postMessage',
		'title'        => 'おすすめ記事(3)のID',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'recommended_posts',
	array(
		'name'         => 'rectitle3',
		'updateMethod' => 'option',
		'type'         => 'text',
		'title'        => 'ーおすすめ記事(3)のタイトル',
		'transport'    => 'postMessage',
		'description'  => '<small>※空欄の場合、もともとのタイトルを表示します。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'recommended_posts',
	array(
		'name'         => 'recid4',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'type'         => 'text',
		'title'        => 'おすすめ記事(4)のID',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'recommended_posts',
	array(
		'name'         => 'rectitle4',
		'updateMethod' => 'option',
		'type'         => 'text',
		'transport'    => 'postMessage',
		'title'        => 'ーおすすめ記事(4)のタイトル',
		'description'  => '<small>※空欄の場合、もともとのタイトルを表示します。</small>',
	)
);

// CTA（記事下）
App::get( 'customizer_builder' )->addSection(
	'CTA（記事下）',
	'show_cta',
	array(
		'priority' => 7,
		'parent'   => 'sango_original_addon',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_cta',
	array(
		'name'         => 'enable_cta',
		'updateMethod' => 'option',
		'type'         => 'checkbox',
		'title'        => 'CTAを記事下に表示する',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_cta',
	array(
		'name'         => 'no_cta_cat',
		'type'         => 'text',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'title'        => 'CTAを表示しないカテゴリーのID（複数指定は半角カンマ,で区切る）',
		'input_attrs'  => array( 'placeholder' => '半角数字を入力' ),
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_cta',
	array(
		'name'         => 'cta_image_upload',
		'type'         => 'image',
		'updateMethod' => 'option',
		'title'        => 'CTA用の画像をアップロード',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_cta',
	array(
		'name'         => 'cta_image_media_upload',
		'updateMethod' => 'option',
		'type'         => 'media',
		'title'        => 'CTA用の画像をアップロード（メディア）',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_cta',
	array(
		'name'    => 'cta_background_color',
		'type'    => 'color',
		'default' => '#b4e0fa',
		'title'   => 'CTA全体の背景色',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_cta',
	array(
		'name'    => 'cta_bigtxt_color',
		'type'    => 'color',
		'default' => '#333',
		'title'   => '見出し色',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_cta',
	array(
		'name'    => 'cta_smltxt_color',
		'type'    => 'color',
		'default' => '#333',
		'title'   => '説明文の色',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_cta',
	array(
		'name'    => 'cta_btn_color',
		'type'    => 'color',
		'default' => '#ffb36b',
		'title'   => 'ボタン色',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_cta',
	array(
		'name'         => 'cta_big_txt',
		'type'         => 'text',
		'updateMethod' => 'option',
		'title'        => 'ボタン色',
		'sanitize'     => false,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_cta',
	array(
		'name'         => 'cta_sml_txt',
		'type'         => 'textarea',
		'updateMethod' => 'option',
		'title'        => '説明文',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_cta',
	array(
		'name'         => 'cta_btn_txt',
		'type'         => 'text',
		'updateMethod' => 'option',
		'title'        => 'ボタンテキスト',
		'sanitize'     => false,
	)
);
App::get( 'customizer_builder' )->addConfig(
	'show_cta',
	array(
		'name'         => 'cta_btn_url',
		'type'         => 'url',
		'updateMethod' => 'option',
		'title'        => 'ボタンURL',
	)
);

App::get( 'customizer_builder' )->addSection(
	'トップへ戻るボタン',
	'to_top',
	array(
		'priority' => 8,
		'parent'   => 'sango_original_addon',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'to_top',
	array(
		'name'         => 'show_to_top',
		'type'         => 'checkbox',
		'updateMethod' => 'option',
		'title'        => '【モバイル表示】トップへ戻るボタンを表示する',
		'description'  => '<small>記事ページ/固定ページにのみ表示されます。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'to_top',
	array(
		'name'         => 'pc_show_to_top',
		'updateMethod' => 'option',
		'type'         => 'checkbox',
		'title'        => '【PC表示】トップへ戻るボタンを表示する',
		'description'  => '<small>記事/固定ページにのみ表示されます。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'to_top',
	array(
		'name'        => 'to_top_color',
		'type'        => 'color',
		'title'       => 'ボタン色',
		'default'     => '#009EF3',
		'description' => '<small>ボタンは半透明になるため、濃い目の色を選びましょう。</small>',
	)
);

// シェアボタン設定
App::get( 'customizer_builder' )->addSection(
	'シェアボタンの設定',
	'sng_share_setting',
	array(
		'priority' => 9,
		'parent'   => 'sango_original_addon',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_share_setting',
	array(
		'name'         => 'another_social',
		'type'         => 'checkbox',
		'updateMethod' => 'option',
		'title'        => 'シェアボタン一覧を別デザインにする',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_share_setting',
	array(
		'name'         => 'no_fab',
		'type'         => 'checkbox',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'title'        => 'タイトル下の「SHARE」をオフにする',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_share_setting',
	array(
		'name'         => 'open_fab',
		'type'         => 'checkbox',
		'updateMethod' => 'option',
		'title'        => 'タイトル下にシェアボタンを並べて表示',
		'description'  => '<small>タイトル下にシェアボタンを並べて表示したいときにチェックを入れてください</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_share_setting',
	array(
		'name'         => 'include_tweet_via',
		'type'         => 'text',
		'updateMethod' => 'option',
		'transport'    => 'postMessage',
		'title'        => 'シェアボタンからのツイートに表示するアカウント名',
		'description'  => '<small>@を含めずに入力。表示しない場合は空欄のままにしてください。</small>',
	)
);
App::get( 'customizer_builder' )->addConfig(
	'sng_share_setting',
	array(
		'name'         => 'fb_app_id',
		'type'         => 'text',
		'updateMethod' => 'option',
		'title'        => 'Facebookのapp id',
		'transport'    => 'postMessage',
		'description'  => '<small>「fb:app_id」を設定したい方は入力してください。</small>',
		'input_attrs'  => array( 'placeholder' => '半角数字のみ' ),
	)
);
