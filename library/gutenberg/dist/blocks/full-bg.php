<?php

use SangoBlocks\App;

function sng_render_full_bg( $block_content, $block ) {
	if ( isset( $block['blockName'] ) && $block['blockName'] === 'sgb/full-bg' ) {
		if ( isset( $block['attrs']['fixedBg'] ) && $block['attrs']['fixedBg'] === true ) {
			$js = <<<EOM
      const ua = navigator.userAgent;
      if ( ua.indexOf( 'iPhone' ) > 0 || ua.indexOf( 'iPad' ) > 0) {
        const bgs = document.querySelectorAll('.js-full-bg-fixed-ios');
        bgs.forEach((bg) => {
          bg.style.backgroundAttachment = 'scroll';
        });
      }
EOM;
			App::get( 'js' )->register( 'fixed-full-bg', $js, false );
			return str_replace( 'sgb-full-bg__cover', 'sgb-full-bg__cover js-full-bg-fixed-ios', $block_content );
		}
	}
	return $block_content;
}

add_filter( 'render_block', 'sng_render_full_bg', 10, 2 );
