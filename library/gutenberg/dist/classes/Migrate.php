<?php

namespace SangoBlocks;

use SANGO\App as ThemeApp;

class Migrate {
	public function init() {
		$version_key     = 'sng_gutenberg_version';
		$version         = \get_option( $version_key );
		$current_version = SGB_VER_NUM;
		if ( ! $version ) {
			\update_option( $version_key, $current_version );
		}
		if ( $version !== $current_version ) {
			\update_option( $version_key, $current_version );
		}
		if ( ! $version || version_compare( $version, '1.56.0', '<' ) ) {
			$format = App::get( 'format' );
			$color  = App::get( 'color' );
			$preset = App::get( 'preset' );
			$format->createDb();
			$color->createDb();
			$preset->createDb();
			$format->migrate_table();
		}
		if ( ! $version || version_compare( $version, '1.59.0', '<' ) ) {
			$gallery = App::get( 'gallery' );
			$gallery->createDb();
		}
		if ( ! $version || version_compare( $version, '1.61.0', '<' ) ) {
			$content_block = ThemeApp::get( 'content-block' );
			$content_block->createDb();
		}
		if ( ! $version || version_compare( $version, '3.1.0', '<' ) ) {
			$variation = App::get( 'variation' );
			$variation->createDb();
		}
		if ( ! $version || version_compare( $version, '3.3.0', '<' ) ) {
			$preset = App::get( 'preset' );
			$preset->migrate();
		}
		if ( ! $version || version_compare( $version, '3.3.1', '<' ) ) {
			$preset = App::get( 'preset' );
			$preset->migrate2();
		}
		if ( ! $version || version_compare( $version, '3.4.3', '<' ) ) {
			$variation = App::get( 'variation' );
			$variation->migrate2();
		}
		if ( $version || version_compare( $version, '3.5.10', '<' ) ) {
			$variation = App::get( 'variation' );
			$variation->migrate3();
		}
		if ( $version || version_compare( $version, '3.5.13', '<' ) ) {
			$color = App::get( 'color' );
			$color->migrate();
		}
		if ( $version || version_compare( $version, '3.6.0', '<' ) ) {
			$share = App::get( 'share' );
			$share->createDb();
		}
	}
}
