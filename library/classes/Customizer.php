<?php

namespace SANGO;

class Customizer {


	function init() {
	}

	function import( $data, $contentBlockMaps ) {
		$settings = $data;
		foreach ( $settings as $item ) {
			$updateMethod = $item['updateMethod'];
			$value        = $item['value'] ? $item['value'] : $item['default'];
			$name         = $item['name'];
			if ( $updateMethod === 'option' ) {
				update_option( $name, $value );
			} elseif ( $updateMethod === 'theme_mod' ) {
				if ( strpos( $name, 'content_block' ) === false ) {
					set_theme_mod( $name, $value );
				} elseif ( isset( $contentBlockMaps[ $value ] ) ) {
					$convertedValue = $contentBlockMaps[ $value ];
					set_theme_mod( $name, $convertedValue );
				}
			} elseif ( $updateMethod === 'custom_css' ) {
				wp_update_custom_css_post( $value );
			}
		}
	}

	function export() {
		$settings = App::get( 'customizer_custom' )->get_settings();
		return $settings;
	}
}
