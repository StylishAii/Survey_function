<?php
/**
 * REST API
 */

use SangoBlocks\App;

App::get( 'rest' )->register(
	array(
		'path'       => 'gallery',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function () {
			return App::get( 'gallery' )->get();
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'gallery',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$items = $params['items'];
			App::get( 'gallery' )->removeAll();
			foreach ( $items as $item ) {
				App::get( 'gallery' )->create(
					array(
						'category'  => isset( $item['categories'] ) ? implode( ',', $item['categories'] ) : $item['category'],
						'code'      => $item['code'],
						'thumbnail' => $item['image'],
					)
				);
			}
			return App::get( 'gallery' )->get();
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'gallery/key',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function () {
			return App::get( 'gallery' )->getKey();
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'gallery/key',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$key = $params['apiKey'];
			App::get( 'gallery' )->setKey( $key );
			return array( 'result' => 'ok' );
		},
	)
);
