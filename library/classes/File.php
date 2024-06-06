<?php

namespace SANGO;

class File {
	public function init() {}

	public function get_file_url( $file ) {
		return get_template_directory_uri() . '/' . $file;
	}

	public function get_file_path( $file ) {
		return get_template_directory() . '/' . $file;
	}

	public function get_file_content( $file ) {
		$file_url = $this->get_file_path( $file );
		if ( file_exists( $file_url ) ) {
			return file_get_contents( $this->get_file_path( $file ) );
		}
		return '';
	}
}
