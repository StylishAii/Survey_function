<?php

use SANGO\App;

function sng_ab_test_render( $block_content, $block ) {
	if ( $block['blockName'] !== 'sgb/ab' ) {
		return $block_content;
	}

	$inner_blocks = $block['innerBlocks'];
	$lazyLoad     = isset( $block['attrs']['lazyLoad'] ) ? $block['attrs']['lazyLoad'] : false;

	$delivery_rate = isset( $block['attrs']['deliveryRate'] ) ? $block['attrs']['deliveryRate'] : 50;
	$pattern_a     = isset( $inner_blocks[0]['innerBlocks'][0]['attrs']['contentBlockId'] ) ? $inner_blocks[0]['innerBlocks'][0]['attrs']['contentBlockId'] : -1;
	$pattern_b     = isset( $inner_blocks[1]['innerBlocks'][0]['attrs']['contentBlockId'] ) ? $inner_blocks[1]['innerBlocks'][0]['attrs']['contentBlockId'] : -1;
	$num           = rand( 1, 100 );

	if ( $lazyLoad ) {
		return "<div class=\"js-ab-test\" data-a-id=\"$pattern_a\" data-b-id=\"$pattern_b\" data-delivery-rate=\"$delivery_rate\"></div>";
	}

	if ( ! $pattern_a || ! $pattern_b ) {
		return $block_content;
	}

	if ( $num <= $delivery_rate ) {
		return App::get( 'content-block' )->get_content_block( $pattern_a );
	}

	return App::get( 'content-block' )->get_content_block( $pattern_b );
}

add_filter( 'render_block', 'sng_ab_test_render', 10, 2 );
