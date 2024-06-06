<?php

use SangoBlocks\App;

function sng_heading_render( $block_content, $block ) {
	if ( is_admin() ) {
		return $block_content;
	}
	if ( isset( $block['blockName'] ) && $block['blockName'] === 'sgb/headings' && SGB_DISABLE_OLD_CSS ) {
		$heading      = App::get( 'heading' );
		$css          = App::get( 'css' );
		$headingClass = isset( $block['attrs']['headingStyle'] ) ? $block['attrs']['headingStyle'] : '';
		$headingClass = str_replace( 'hh ', '', $headingClass );
		if ( method_exists( $heading, $headingClass ) ) {
			$style = $heading->$headingClass();
			$css->register( $headingClass, $style );
		}
	}
	return $block_content;
}

add_filter( 'render_block', 'sng_heading_render', 10, 2 );
