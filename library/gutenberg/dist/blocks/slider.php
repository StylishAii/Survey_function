<?php

function sng_slider_render( $block_content, $block ) {
	if ( isset( $block['blockName'] ) && $block['blockName'] === 'sgb/slider' ) {
		wp_enqueue_style( 'slick-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css' );
		wp_enqueue_style( 'slick-theme-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script(
			'sng-slick', // Handle.
			'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js'
		);
	}
	return $block_content;
}

add_filter( 'render_block', 'sng_slider_render', 10, 2 );
