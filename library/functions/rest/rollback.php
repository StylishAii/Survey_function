<?php
/**
 * REST API
 */

use SANGO\App;

App::get( 'rest' )->register(
	array(
		'path'       => 'rollback',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params   = $req->get_params();
			$rollback = App::get( 'rollback' );
			return $rollback->rollback( $params['version'] );
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'rollback/versions',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params   = $req->get_params();
			$rollback = App::get( 'rollback' );
			return $rollback->get_versions();
		},
	)
);
