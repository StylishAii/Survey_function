<?php

use SangoBlocks\App;

function sng_box_render( $block_content, $block ) {
	if ( is_admin() ) {
		return $block_content;
	}
	if ( isset( $block['blockName'] ) && $block['blockName'] === 'sgb/box' && SGB_DISABLE_OLD_CSS ) {
		$box          = App::get( 'box' );
		$css          = App::get( 'css' );
		$boxClassName = isset( $block['attrs']['boxClassName'] ) ? $block['attrs']['boxClassName'] : 'box6';
		$style        = $box->$boxClassName();
		$css->register( $boxClassName, $style );
	}
	return $block_content;
}

add_filter( 'render_block', 'sng_box_render', 10, 2 );
