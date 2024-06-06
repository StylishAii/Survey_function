<?php
use SangoBlocks\App;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Layout Shift対策
// カスタムCSSのheadへの出力
// xmlの場合は無視
$is_xml = false;
if ( isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], '.xml' ) !== false ) {
	$is_xml = true;
}
if ( ! $is_xml ) {
	ob_start();
	add_action(
		'shutdown',
		function () {
			$final = ob_get_clean();
			$style = App::get( 'css' )->get_custom_css_style();
			if ( $style ) {
				$final = str_replace( '</head>', "$style\n</head>", $final );
			}
			if ( function_exists( 'sng_save_cache' ) ) {
				sng_save_cache( $final ); // SANGO 3.0より
			}
			echo $final;
		},
		0
	);
}
