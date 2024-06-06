<?php

namespace SANGO;

class App {

	private static $singleton;
	private $instances = array();
	private $dirName   = '';
	private $url       = '';

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
		return $singleton->instances[ $name ];
	}

	public static function getUrl( $path ) {
		$theme_ver = wp_get_theme( 'sango-theme' )->Version;
		$args      = array(
			'version' => $theme_ver,
		);
		if ( is_user_logged_in() ) {
			$args['wexal'] = 'purge';
		}
		$script_url = get_template_directory_uri() . '/' . $path;

		return add_query_arg( $args, $script_url );
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

	public static function run() {
		self::hook( 'init' );
	}

	public static function hook( $hookName ) {
		$singleton = self::singleton();
		$instances = $singleton->instances;
		foreach ( $instances as $instance ) {
			// if ($instance->$hookName) {
			$instance->$hookName();
			// }
		}
	}
}
