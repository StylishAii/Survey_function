<?php
/**
 * REST API
 */

namespace SangoBlocks;

use JShrink\Minifier;

class CustomJS {
	private $codes = array();

	public function init() {
		add_action( 'wp_footer', array( $this, 'print_codes' ), 9999 );
	}

	public function print_codes() {
		$shared_js = get_transient( 'sgb-shared-js' );
		if ( empty( $this->codes ) && ! $shared_js ) {
			return;
		}
		$final_js = $this->ready_js();
		$final_js = $this->minify_js( $final_js );
		$codes    = $this->codes;
		foreach ( $codes as $code ) {
			$final_js .= $this->minify_js( $code );
		}
		echo '<script>' . $final_js . $shared_js . '</script>';
	}

	public function createControl( $controls ) {
		$first_code = '{';
		$jsControls = array_filter(
			$controls,
			function ( $control ) {
				$disabled = isset( $control['disableJS'] ) ? $control['disableJS'] : false;
				if ( $disabled ) {
					return false;
				}
				return true;
			}
		);
		foreach ( $jsControls as $key => $control ) {
			$type    = isset( $control['variableType'] ) ? $control['variableType'] : 'string';
			$varName = isset( $control['variableName'] ) ? $control['variableName'] : '';
			$value   = isset( $control['value'] ) ? $control['value'] : '';
			if ( $type === 'number' ) {
				$first_code .= "\"$varName\": $value";
			} elseif ( $type === 'boolean' ) {
				if ( empty( $value ) || $value === 0 ) {
					$value = 'false';
				} else {
					$value = 'true';
				}
				$first_code .= "\"$varName\": $value";
			} else {
				$first_code .= "\"$varName\": \"$value\"";
			}
			if ( $key !== array_key_last( $jsControls ) ) {
				$first_code .= ',';
			}
		}
		$first_code .= '}';

		return $first_code;
	}

	public function register( $key, $code, $scoped = true, $controls = array() ) {
		$first_code = $scoped ? "const block = document.querySelector(\"#$key\");
if (!block) return;" : '';
		if ( count( $controls ) > 0 ) {
			$first_code .= 'const controls = ' . $this->createControl( $controls ) . ';';
		}
		$script              = <<<EOT
    sgb.domReady(function() {
      $first_code
      $code
    });
EOT;
		$this->codes[ $key ] = $script;
	}

	public function ready_js() {
		$script = <<<EOT
    const sgb = {};
    sgb.domReady = (fn) => {
      document.addEventListener("DOMContentLoaded", fn);
      if (document.readyState === "interactive" || document.readyState === "complete" ) {
        fn();
      }
    };
EOT;
		return $script;
	}

	public function minify_js( $js ) {
		return Minifier::minify( $js );
	}
}
