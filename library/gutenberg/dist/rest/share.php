<?php
/**
 * REST API
 */

use SangoBlocks\App;

App::get( 'rest' )->register(
	array(
		'path'       => 'share',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$from = $params['from'];
			return App::get( 'share' )->get_category( $from );
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'share',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = json_decode( $req->get_body() );
			$data = App::get( 'share' )->save(
				$params->id,
				array(
					'title'     => $params->title,
					'from'      => $params->from,
					'js'        => $params->js,
					'css'       => $params->css,
					'adminCSS'  => $params->adminCSS,
					'scopedCSS' => $params->scopedCSS,
					'controls'  => $params->controls,
				)
			);
			App::get( 'share' )->generate_cache();

			return $data;
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'share',
		'methods'    => 'PUT',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = json_decode( $req->get_body() );
			$data = App::get( 'share' )->update(
				$params->id,
				array(
					'title'     => $params->title,
					'from'      => $params->from,
					'js'        => $params->js,
					'css'       => $params->css,
					'scopedCSS' => $params->scopedCSS,
					'controls'  => $params->controls,
				)
			);
			App::get( 'share' )->generate_cache();
			return $data;
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'share',
		'methods'    => 'DELETE',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$data = App::get( 'share' )->remove( $params['id'] );
			App::get( 'share' )->generate_cache();
			return $data;
		},
	)
);
