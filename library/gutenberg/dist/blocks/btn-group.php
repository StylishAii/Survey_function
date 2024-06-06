<?php

use SangoBlocks\App;

function sng_build_btn_group_css( $id, $options ) {
	$css    = "#$id .wp-block-sgb-btn-group {";
	$layout = isset( $options['layout'] ) ? $options['layout'] : array(
		'orientation'    => 'horizontal',
		'justifyContent' => 'left',
	);
	if ( isset( $layout['orientation'] ) && $layout['orientation'] === 'vertical' ) {
		$css .= 'flex-direction: column;';
		if ( isset( $layout['justifyContent'] ) ) {
			if ( $layout['justifyContent'] === 'left' ) {
				$css .= 'align-items: flex-start;';
			} elseif ( $layout['justifyContent'] === 'center' ) {
				$css .= 'align-items: center;';
			} elseif ( $layout['justifyContent'] === 'right' ) {
				$css .= 'align-items: flex-end;';
			}
		}
	} else {
		$css .= 'flex-direction: row;';
		if ( isset( $layout['justifyContent'] ) ) {
			if ( $layout['justifyContent'] === 'left' ) {
				$css .= 'justify-content: flex-start;';
			} elseif ( $layout['justifyContent'] === 'center' ) {
				$css .= 'justify-content: center;';
			} elseif ( $layout['justifyContent'] === 'right' ) {
				$css .= 'justify-content: flex-end;';
			} elseif ( $layout['justifyContent'] === 'space-between' ) {
				$css .= 'justify-content: space-between;';
			}
		}
	}
	if ( isset( $options['style']['spacing']['blockGap'] ) ) {
		$gap  = $options['style']['spacing']['blockGap'];
		$css .= "gap: $gap;";
	}
	$css .= '}';
	return $css;
}

function sng_btn_group_render( $block_content, $block ) {
	if ( is_admin() ) {
		return $block_content;
	}
	$id = wp_unique_id( 'sgb-btn-group-id' );
	if ( ! isset( $block['attrs']['layout'] ) && ! isset( $block['attrs']['style']['spacing'] ) ) {
		return $block_content;
	}

	$css = sng_build_btn_group_css( $id, $block['attrs'] );

	App::get( 'css' )->register( $id, $css );
	return "<div id=\"$id\">$block_content</div>";
}

add_filter( 'render_block_sgb/btn-group', 'sng_btn_group_render', 10, 2 );
