<?php

use SangoBlocks\App;

function sng_button_css( $block_content, $block ) {
	if ( isset( $block['blockName'] ) && $block['blockName'] === 'sgb/btn' && SGB_DISABLE_OLD_CSS ) {
		$css       = App::get( 'css' );
		$button    = App::get( 'button' );
		$className = isset( $block['attrs']['btnType'] ) ? $block['attrs']['btnType'] : '';

		if ( $className ) {
			$style = $button->$className();
			$css->register( $className, $style );
		}
	}
	return $block_content;
}

add_filter( 'render_block', 'sng_button_css', 10, 2 );
