<?php

use SANGO\App;

function sng_to_async_scripts( $tag, $handle, $src ) {
	$scirpt_text = get_theme_mod( 'sng_async_scripts', '' );
	$scripts     = explode( "\n", $scirpt_text );
	foreach ( $scripts as $script ) {
		if ( $script && strpos( $src, $script ) !== false ) {
			return str_replace( ' src', ' async src', $tag );
		}
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'sng_to_async_scripts', 10, 3 );

// 記事内のiframe及びscriptをフィルターする
add_filter( 'the_content', 'sng_lazyload_target_filter_content' );
function sng_lazyload_target_filter_content( $content ) {
	if ( ! get_theme_mod( 'sng_lazy_contents', '' ) ) {
		return $content;
	}
	$content = preg_replace_callback( '/(<\s*iframe[^>]+)(src\s*=\s*"[^"]+")([^>]+>)/i', 'preg_iframe_lazyload', $content );
	$content = preg_replace_callback( '/(<\s*script[^>]+)(src\s*=\s*"[^"]+")([^>]+>)<\/script>/i', 'preg_script_lazyload', $content );
	return $content;
}
function preg_iframe_lazyload( $matches ) {
	$result = $matches[1] . 'data-src' . substr( $matches[2], 3 ) . $matches[3];
	return $result;
}

function preg_script_lazyload( $matches ) {
	$result = $matches[1] . 'data-src' . substr( $matches[2], 3 ) . $matches[3] . '</div>';
	$result = str_replace( '<script', '<div data-type="script"', $result );
	return $result;
}

add_action( 'wp_footer', 'sng_lazyload_scripts', 100 );
if ( ! function_exists( 'sng_lazyload_scripts' ) ) {
	function sng_lazyload_scripts() {
		if ( ! get_theme_mod( 'sng_lazy_contents', '' ) ) {
			return;
		}
		$script = <<< EOM
    const elements = document.querySelectorAll('.entry-content [data-type="script"], .entry-content iframe');
    const io = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          const element = entry.target;
          if (element.classList.contains('executed')) {
            return;
          }
          const type = element.getAttribute('data-type');
          if (type === 'script') {
            const script = document.createElement('script');
            script.src = element.getAttribute('data-src');
            script.async = true;
            element.parentNode.replaceChild(script, element);
          } else {
            if (element.getAttribute('data-src')) {
              element.src = element.getAttribute('data-src');
            }
          }
          element.classList.add('executed');
        }
      });
    });
    elements.forEach((element) => {
      io.observe(element);
    });
    EOM;
		App::get( 'js' )->register( 'lazy_load', $script );
	}
}
