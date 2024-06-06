<?php

use SangoBlocks\App;

function sng_list_css( $block_content, $block ) {
	if ( isset( $block['blockName'] ) && $block['blockName'] === 'sgb/list' ) {
		$css  = App::get( 'css' );
		$list = App::get( 'list' );
		if ( SGB_DISABLE_OLD_CSS ) {
			$className     = isset( $block['attrs']['borderStyleClassName'] ) ? $block['attrs']['borderStyleClassName'] : '';
			$listClassName = $list->get_list_func_name( $className );
			if ( $listClassName ) {
				$style = $list->$listClassName();
				$css->register( $listClassName, $style );
			}
		}

		if ( isset( $block['attrs']['iconColor'] ) ) {
			$iconColor = $block['attrs']['iconColor'];
			$listId    = wp_unique_id( 'sgb-list-id-' );
			$css       = <<<EOM
            #$listId li:before {
              color: {$iconColor};
            }
            #$listId .ol-circle li:before {
              color: #FFF;
              background-color: {$iconColor};
            }
EOM;
			App::get( 'css' )->register( $listId, $css );
			return "<div id=\"{$listId}\">$block_content</div>";
		}
	}
	return $block_content;
}

add_filter( 'render_block', 'sng_list_css', 10, 2 );
