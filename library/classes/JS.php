<?php
/**
 * REST API
 */

namespace SANGO;

use JShrink\Minifier;

class JS {
	private $codes = array();

	public function init() {
		add_action( 'wp_footer', array( $this, 'print_codes' ), 9999 );
		$this->setup();
	}

	public function print_codes() {
		$final_js = '';
		$codes    = $this->codes;
		foreach ( $codes as $code ) {
			$final_js .= $this->minify_js( $code );
		}
		echo '<script>' . $final_js . '</script>';
	}

	public function register( $key, $code ) {
		$this->codes[ $key ] = $code;
	}

	public function setup() {
		$script                   = <<<EOT
    const sng = {};
    sng.domReady = (fn) => {
      document.addEventListener("DOMContentLoaded", fn);
      if (document.readyState === "interactive" || document.readyState === "complete" ) {
        fn();
      }
    };
    sng.fadeIn = (el, display = "block") => {
      if (el.classList.contains(display)) {
        return;
      }
      el.classList.add(display);
      function fadeInAnimationEnd () {
        el.removeEventListener('transitionend', fadeInAnimationEnd);
      };
      el.addEventListener('transitionend', fadeInAnimationEnd);
      requestAnimationFrame(() => {
        el.classList.add('active');
      });
    };
    sng.fadeOut = (el, display = "block") => {
      if (!el.classList.contains('active')) {
       return;
      }
      el.classList.remove('active');
      function fadeOutAnimationEnd () {
        el.classList.remove(display);
        el.removeEventListener('transitionend', fadeOutAnimationEnd);
      };
      el.addEventListener('transitionend', fadeOutAnimationEnd);
    };
    sng.offsetTop = (el) => {
      const rect = el.getBoundingClientRect();
      const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      const top = rect.top + scrollTop;
      return top
    };
    sng.wrapElement = (el, wrapper) => {
      el.parentNode.insertBefore(wrapper, el);
      wrapper.appendChild(el);
    };
    sng.scrollTop = () => {
      return window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    };
EOT;
		$this->codes['dom_ready'] = $script;
	}

	public function minify_js( $js ) {
		return Minifier::minify( $js );
	}
}
