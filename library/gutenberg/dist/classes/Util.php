<?php
/**
 * REST API
 */

namespace SangoBlocks;

class Util {
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
}
