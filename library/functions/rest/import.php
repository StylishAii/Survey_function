<?php
/**
 * REST API
 */

use SANGO\App;

App::get( 'rest' )->register(
	array(
		'path'       => 'import',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params  = $req->get_params();
			$files   = $req->get_file_params();
			$file    = $files['file'];
			$content = file_get_contents( $file['tmp_name'] );
			return App::get( 'import' )->import(
				json_decode( $content, true ),
				json_decode( $params['options'], true )
			);
		},
	)
);
