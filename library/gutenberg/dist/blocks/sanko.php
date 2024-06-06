<?php

function sng_sanko_render( $block_content, $block ) {
	$replaced = str_replace( 'class="sgb-e-link__img"', 'class="sgb-e-link__img" alt=""', $block_content );
	return $replaced;
}

add_filter( 'render_block_sgb/sanko', 'sng_sanko_render', 10, 2 );
