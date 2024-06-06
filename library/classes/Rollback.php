<?php

namespace SANGO;

use Theme_Upgrader;

class Rollback extends Theme_Upgrader {
	public function init() {}
	public function get_versions() {
		$json     = file_get_contents( 'https://storage.googleapis.com/sango-theme-fd439535gasls/versions.json' );
		$versions = json_decode( $json );
		return $versions;
	}

	public function rollback( $version ) {
		$download_endpoint = 'https://storage.googleapis.com/sango-theme-fd439535gasls/';
		$url               = $download_endpoint . 'sango-theme.' . $version . '.zip';

		$this->run(
			array(
				'package'           => $url,
				'destination'       => get_theme_root(),
				'clear_destination' => true,
				'clear_working'     => true,
				'hook_extra'        => array(
					'theme'  => 'sango-theme',
					'type'   => 'theme',
					'action' => 'update',
				),
			)
		);

		if ( ! $this->result || is_wp_error( $this->result ) ) {
			return $this->result;
		}

		return array(
			'success' => true,
		);
	}
}
