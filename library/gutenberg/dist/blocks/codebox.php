<?php

function sng_render_highlight( $block_content, $block ) {
	if ( isset( $block['blockName'] ) && $block['blockName'] === 'sgb/codebox' ) {
		if ( isset( $block['attrs']['highlight'] ) && $block['attrs']['highlight'] ) {
			wp_enqueue_script(
				'sng-highlight', // Handle.
				'//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.2.0/highlight.min.js'
			);
		}
	}
	return $block_content;
}

add_filter( 'render_block', 'sng_render_highlight', 10, 2 );
