<?php

namespace SangoBlocks;

class FontAwesome {

	private $fontawesome5_ver;

	public function init() {
		$this->fontawesome5_ver = get_option( 'fontawesome5_ver_num' ) ? preg_replace( '/( |　)/', '', get_option( 'fontawesome5_ver_num' ) ) : '6.1.1';
	}

	public function get_fontawesome_cdn() {
		$fontawesome5_ver = $this->fontawesome5_ver;
		return 'https://use.fontawesome.com/releases/v' . $fontawesome5_ver . '/css/all.css';
	}
}
