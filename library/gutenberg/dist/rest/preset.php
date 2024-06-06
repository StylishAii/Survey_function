<?php
/**
 * REST API
 */

use SangoBlocks\App;

App::get( 'rest' )->register(
	array(
		'path'       => 'preset',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$name = $params['name'];
			return App::get( 'preset' )->get_all( $name );
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'preset',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$name = $params['name'];
			$data = $params['data'];
			App::get( 'preset' )->save_category( $name, $data );
			return array(
				'ok' => 'ok',
			);
		},
	)
);
