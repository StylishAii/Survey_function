<?php

use SangoBlocks\App;

if ( get_option( 'not_use_sgb_toc' ) ) {
	return;
}

register_block_type(
	'sgb/toc',
	array(
		'editor_script'   => 'sgb',
		'attributes'      => array(
			'css'                     => array(
				'type'    => 'string',
				'default' => '',
			),
			'js'                      => array(
				'type'    => 'string',
				'default' => '',
			),
			'scopedCSS'               => array(
				'type'    => 'string',
				'default' => '',
			),
			'adminCSS'                => array(
				'type'    => 'string',
				'default' => '',
			),
			'disableCSSAlert'         => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'customControls'          => array(
				'type'    => 'array',
				'default' => array(),
			),
			'sharedId'                => array(
				'type'    => 'string',
				'default' => '',
			),
			'title'                   => array(
				'type'    => 'string',
				'default' => '目次',
			),
			'toggleLabel'             => array(
				'type'    => 'string',
				'default' => '表示',
			),
			'toggleCloseLabel'        => array(
				'type'    => 'string',
				'default' => '非表示',
			),
			'hasToggle'               => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'hasDialog'               => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'isToggleOpen'            => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'showOnPage'              => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'showOnPost'              => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'showOnTop'               => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'showOnCategoryTop'       => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'smoothScroll'            => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'headingCounts'           => array(
				'type'    => 'number',
				'default' => 1,
			),
			'headingLevel'            => array(
				'type'    => 'number',
				'default' => 2,
			),
			'listType'                => array(
				'type'    => 'string',
				'default' => 'ul',
			),
			'listStyle'               => array(
				'type'    => 'string',
				'default' => 'main', // main, side
			),
			'noBullets'               => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'headingIcon'             => array(
				'type'    => 'string',
				'default' => '',
			),
			'headingCenter'           => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'headingBgColor'          => array(
				'type'    => 'string',
				'default' => '',
			),
			'headingColor'            => array(
				'type'    => 'string',
				'default' => '',
			),
			'highlightMenu'           => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'hasGoToTocButton'        => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'hasGoToTocMobileButton'  => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'goToTocButtonPos'        => array(
				'type'    => 'string',
				'default' => 'left',
			),
			'goToTocButtonPosX'       => array(
				'type'    => 'number',
				'default' => 18,
			),
			'goToTocButtonPosY'       => array(
				'type'    => 'number',
				'default' => 20,
			),
			'goToTocMobileButtonPos'  => array(
				'type'    => 'string',
				'default' => 'left',
			),
			'goToTocMobileButtonPosX' => array(
				'type'    => 'number',
				'default' => 10,
			),
			'goToTocMobileButtonPosY' => array(
				'type'    => 'number',
				'default' => 15,
			),
			'blockId'                 => array(
				'type'    => 'string',
				'default' => '',
			),
			'spaceBottom'             => array(
				'type'    => 'number',
				'default' => 0,
			),
			'mobileSpaceBottom'       => array(
				'type'    => 'number',
				'default' => 0,
			),
			'spaceBottomType'         => array(
				'type'    => 'string',
				'default' => 'em',
			),
			'dialogTitle'             => array(
				'type'    => 'string',
				'default' => 'Table of Contents',
			),
		),
		'render_callback' => function ( $attributes ) {
			global $post;
			$toc = App::get( 'toc' );
			return $toc->build( $post, $attributes );
		},
	)
);
/*****************************
 * 投稿/固定ページのカスタムフィールド
 */
add_action( 'admin_menu', 'add_sng_meta_toc_field' );
add_action( 'save_post', 'save_sng_meta_toc_field' );

function add_sng_meta_toc_field() {
	$theme   = wp_get_theme( get_template() );
	$version = $theme->get( 'Version' );
	if ( version_compare( $version, '3.0', '<' ) ) {
		add_meta_box( 'sng-toc-hide', '目次', 'sng_field_meta_toc', 'post', 'side' );
		add_meta_box( 'sng-toc-hide', '目次', 'sng_field_meta_toc', 'page', 'side' );
	}
}

function sng_field_meta_toc() {
	global $post;
	$meta_value = get_post_meta( $post->ID, 'sng_toc_hide', true );
	$check      = ( $meta_value ) ? 'checked' : '';
	$label      = 'この記事では目次を隠す';
	echo '<div><label><input type="checkbox" name="sng_toc_hide" value="on" ' . $check . '>' . $label . '</label></div>';
}

function save_sng_meta_toc_field( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	// クイックポストの時は何もしない
	if ( isset( $_POST['action'] ) && $_POST['action'] == 'inline-save' ) {
		return $post_id;
	}
	if ( function_exists( 'sng_update_custom_option_fields' ) ) {
		sng_update_custom_option_fields( $post_id, 'sng_toc_hide' );
	}
}

// 目次のhrefと見出しのidを一致させるためのコード
function sng_toc_fixer( $content ) {
	if ( is_admin() || get_option( 'not_use_sgb_toc' ) ) {
		return $content;
	}
	$toc  = App::get( 'toc' );
	$html = apply_filters( 'sng_content_block', $content );

	try {
		$html = $toc->fix_content( $html );
	} catch ( Throwable $error ) {
		return $html;
	}
	return $html;
}

// lazy-loadなどのフィルターと衝突する場合があるため、他のフィルターよりも早く実行する
add_filter( 'the_content', 'sng_toc_fixer', 1 );
