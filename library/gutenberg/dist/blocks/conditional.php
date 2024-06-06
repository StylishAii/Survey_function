<?php

use SANGO\App;
use SangoBlocks\App as SangoBlocksApp;

function sng_conditional_render( $block_content, $block ) {
	if ( is_admin() ) {
		return $block_content;
	}
	return SangoBlocksApp::get( 'conditional' )->hide_or_show_content( $block_content, $block );
}

add_filter( 'render_block_sgb/conditional', 'sng_conditional_render', 10, 2 );
