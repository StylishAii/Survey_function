<?php

namespace SANGO;

/**
 * カスタマイザーで使用するサニタイズ
 */

/**
 * textarea or inputのサニタイズ
 * 👉 'sanitize_callback' => 'wp_filter_nohtml_kses'
 *
 * URLのサニタイズ
 * 👉 'sanitize_callback' => 'esc_url_raw'
 *
 * 数値のサニタイズ
 * 👉 'sanitize_callback' => 'absint'
 *
 * 色（HEX）のサニタイズ
 * 👉 'sanitize_callback' => 'sanitize_hex_color'
 */
class Sanitize {

	public function init() {}
	public function checkbox( $input ) {
		return ( $input == true );
	}
	public function radio( $input, $setting ) {
		$input   = sanitize_key( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
	public function select( $input, $setting ) {
		$input   = sanitize_key( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
	public function file( $file, $setting ) {
		$mimes    = array(
			'jpg|jpeg' => 'image/jpeg',
			'gif'      => 'image/gif',
			'png'      => 'image/png',
			'svg'      => 'image/svg+xml',
		);
		$file_ext = wp_check_filetype( $file, $mimes );
		return ( $file_ext['ext'] ? $file : $setting->default );
	}
	public function dangerously_skip_sanitize( $input ) {
		return $input;
	}
}
