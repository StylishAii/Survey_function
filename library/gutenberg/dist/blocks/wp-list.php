<?php

function sng_core_list_render( $block_content, $block ) {
	$style = '';
	if ( isset( $block['attrs']['iconColor'] ) ) {
		$style .= '--sgb-list-icon-color: ' . $block['attrs']['iconColor'] . ';';
	}
	if ( isset( $block['attrs']['noBdr'] ) && $block['attrs']['noBdr'] ) {
		$style .= '--sgb-list-border-color: none;';
	} elseif ( isset( $block['attrs']['borderColor'] ) ) {
		$style .= '--sgb-list-border-color: ' . $block['attrs']['borderColor'] . ';';
	}
	if ( isset( $block['attrs']['shadow'] ) && $block['attrs']['shadow'] ) {
		$style .= '--sgb-list-box-shadow: var(--wp--custom--shadow--medium)';
	}
	if ( $style ) {
		$block_content = "<div style=\"$style\">$block_content</div>";
	}
	return $block_content;
}

add_filter( 'render_block_core/list', 'sng_core_list_render', 10, 2 );
