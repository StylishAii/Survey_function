<?php
/**
 * REST API
 */

use SANGO\App;

App::get( 'rest' )->register(
	array(
		'path'       => 'environment',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			return array(
				'version'      => phpversion(),
				'wpVersion'    => get_bloginfo( 'version' ),
				'sangoVersion' => wp_get_theme( 'sango-theme' )->Version,
			);
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'license',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => 'sng_license',
	)
);
