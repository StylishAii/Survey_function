<?php
/**
 * REST API
 */

use SangoBlocks\App;

App::get( 'rest' )->register(
	array(
		'path'       => 'color',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$name = $params['name'];
			$code = $params['code'];
			$slug = $params['slug'];
			$id = isset( $params['id'] ) ? $params['id'] : '';
			$css = $params['css'];
			if ( $id ) {
				App::get( 'color' )->update(
					array(
						'id'   => $id,
						'name' => $name,
						'code' => $code,
						'slug' => $slug,
					)
				);
			} else {
				App::get( 'color' )->create(
					array(
						'name' => $name,
						'code' => $code,
						'slug' => $slug,
					)
				);
			}
			return array(
				'ok' => 'ok',
			);
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'color',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			return App::get( 'color' )->get();
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'color',
		'methods'    => 'DELETE',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$id = $params['id'];
			App::get( 'color' )->remove( $id );
			return array(
				'ok' => 'ok',
			);
		},
	)
);
