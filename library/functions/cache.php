<?php

use SANGO\App;

function sng_is_localhost() {
	if ( ! isset( $_SERVER['HTTP_HOST'] ) ) {
		return false;
	}
	if ( strpos( $_SERVER['HTTP_HOST'], 'localhost' ) !== false ) {
		return true;
	}
	return false;
}

function sng_is_secure_protocol() {
	if ( sng_is_localhost() ) {
		return true;
	}
	if (
	isset( $_SERVER['HTTPS'] ) &&
	( $_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1 ) ||
	isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) &&
	$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
	) {
		return true;
	}
	return false;
}

function sng_get_cache_key() {
	$is_mobile = wp_is_mobile();
	$device    = $is_mobile ? 'mobile' : 'desktop';
	$key       = 'url-cache/device' . "/$device" . '/' . 'url' . $_SERVER['REQUEST_URI'];
	return $key;
}

function sng_can_cache( $contents ) {
	global $errors;
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return false;
	}
	if ( ! sng_is_secure_protocol() ) {
		return false;
	}
	if ( is_user_logged_in() ) {
		return false;
	}
	if ( isset( $errors ) && ! empty( $errors ) ) {
		return false;
	}
	if ( is_404() ) {
		return false;
	}
	if ( wp_doing_ajax() ) {
		return false;
	}
	return strlen( $contents ) > 0;
}

function sng_save_cache( $contents ) {
	global $errors;
	if ( ! get_option( 'sng_enable_cache' ) ) {
		return false;
	}
	if ( strpos( $_SERVER['REQUEST_URI'], '.txt' ) !== false ) {
		return false;
	}

	if ( ! sng_can_cache( $contents ) ) {
		return false;
	} else {
		$key = sng_get_cache_key();
		if ( ! App::get( 'cache' )->get( $key ) ) {
			if ( get_option( 'sng_enable_minify_html' ) ) {
				$search   = array(
					'/\>[^\S ]+/s',
					'/[^\S ]+\</s',
					'/(\s)+/s',
				);
				$replace  = array(
					'>',
					'<',
					'\\1',
				);
				$contents = preg_replace( $search, $replace, $contents );
			}
			App::get( 'cache' )->set( $key, $contents );
		}
	}
}

function sng_clear_cache() {
	App::get( 'cache' )->clear_all();
}

function sng_retrive_cache() {
	if ( ! get_option( 'sng_enable_cache' ) ) {
		return;
	}
	if ( ! sng_is_secure_protocol() ) {
		return;
	}
	$no_cache_pages_string = get_option( 'sng_nocache_pages', '' );
	$no_cache_pages        = explode( "\n", $no_cache_pages_string );
	foreach ( $no_cache_pages as $page ) {
		if ( $page && strpos( $_SERVER['REQUEST_URI'], $page ) !== false ) {
			return;
		}
	}
	global $errors;
	$key = sng_get_cache_key();
	if ( is_user_logged_in() ) {
		return;
	}
	$contents = App::get( 'cache' )->get( $key );
	if ( $contents ) {
		echo $contents;
		exit( 0 );
	}
}

function sng_cache_clear_url_check() {
	if ( ! is_user_logged_in() ) {
		return;
	}
	if ( isset( $_GET['sng_cache_clear'] ) ) {
		sng_clear_cache();
		wp_redirect( home_url() );
		exit( 0 );
	}
}

add_action( 'save_post', 'sng_clear_cache' );
add_action( 'customize_save', 'sng_clear_cache' );
add_action( 'upgrader_process_complete', 'sng_clear_cache', 10, 2 );
add_action( 'sng_version_updated', 'sng_clear_cache' );

// TODO そのコメントの記事のキャッシュだけ削除したい
add_action( 'edit_comment', 'sng_clear_cache' );
