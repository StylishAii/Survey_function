<?php

namespace SANGO;

class Migrate {
	public function init() {
		$version_key     = 'sng_version';
		$version         = \get_option( $version_key );
		$current_version = wp_get_theme( get_template() )->get( 'Version' );
		if ( ! $version ) {
			\update_option( $version_key, $current_version );
		}
		if ( $version !== $current_version ) {
			\update_option( $version_key, $current_version );
			// 更新時にWordPress本体のグローバルスタイルキャッシュを強制削除
			$transient_name = 'global_styles_' . get_stylesheet();
			delete_transient( $transient_name );
			do_action( 'sng_version_updated' );
		}
		if ( ! $version || version_compare( $version, '3.0.0', '<' ) ) {
			$cache = App::get( 'cache' );
			$cache->createDb();
		}

		if ( ! $version || version_compare( $version, '3.7.0', '<' ) ) {
			$field = App::get( 'field' );
			$field->createDb();
		}
	}
}
