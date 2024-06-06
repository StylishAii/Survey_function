<?php

namespace SangoBlocks;

class App {

	private static $singleton;
	private $instances = array();
	private $dirName   = '';
	private $url       = '';
	private $is_plugin = false;

	public static function getUrl( $url ) {
		$theme_ver = wp_get_theme( 'sango-theme' )->Version;
		$args      = array(
			'version' => $theme_ver,
		);
		if ( is_user_logged_in() ) {
			$args['wexal'] = 'purge';
		}
		$script_url = get_template_directory_uri() . '/library/gutenberg/dist/' . $url;
		return add_query_arg( $args, $script_url );
	}

	public static function getDirUrl( $url ) {
		return get_template_directory_uri() . '/library/gutenberg/dist/' . $url . '/';
	}

	public static function register( $name, $class ) {
		$singleton                     = self::singleton();
		$singleton->instances[ $name ] = new $class();
	}

	public static function singleton() {
		if ( ! isset( self::$singleton ) ) {
			self::$singleton = new App();
		}
		return self::$singleton;
	}

	public static function get( $name ) {
		$singleton = self::singleton();
		if ( ! isset( $singleton->instances[ $name ] ) ) {
			return null;
		}
		return $singleton->instances[ $name ];
	}

	public static function requireDir( $dirName ) {
		if ( ! is_dir( $dirName ) ) {
			return;
		}
		foreach ( scandir( $dirName ) as $filename ) {
			$path     = $dirName . '/' . $filename;
			$pathInfo = pathinfo( $path );
			if ( is_file( $path ) && $pathInfo['extension'] === 'php' ) {
				include_once $path;
			}
		}
	}

	public static function setRootPluginDir( $dirName ) {
		$singleton          = self::singleton();
		$singleton->dirName = $dirName;
	}

	public static function getRootPluginDir() {
		$singleton = self::singleton();
		return $singleton->dirName;
	}

	public static function getRootPluginUrl() {
		$singleton = self::singleton();
		return $singleton->url;
	}

	public static function setRootPluginUrl( $url ) {
		$singleton      = self::singleton();
		$singleton->url = $url;
	}

	public static function rootPluginDir() {
		$singleton = self::singleton();
		return $singleton->dirName;
	}

	public static function rootPluginUrl() {
		$singleton = self::singleton();
		return $singleton->url;
	}

	public static function run() {
		self::hook( 'init' );
	}

	public static function hook( $hookName ) {
		$singleton = self::singleton();
		$instances = $singleton->instances;
		foreach ( $instances as $instance ) {
			$instance->$hookName();
		}
	}
}
