<?php
/**
 * REST API
 */

use SangoBlocks\App;

App::get( 'rest' )->register(
	array(
		'path'       => 'variation',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$id = $params['id'];
			return App::get( 'variation' )->get( $id );
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'variation',
		'methods'    => 'DELETE',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$id = $params['id'];
			return App::get( 'variation' )->remove( $id );
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'variation/category',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$from = $params['from'];
			return App::get( 'variation' )->get_category_variation( $from );
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'variation/all',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			return App::get( 'variation' )->get_all();
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'variation/order',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$body = $req->get_body();
			$params = json_decode( $body, true );
			$items = $params['items'];
			App::get( 'variation' )->save_order( $items );
			return array(
				'ok' => 'ok',
			);
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'variation',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$id = $params['id'];
			$data = array(
				'title'        => $params['title'],
				'keywords'     => $params['keywords'],
				'icon'         => $params['icon'],
				'attributes'   => json_encode( $params['attributes'] ),
				'inner_blocks' => $params['inner_blocks'],
				'from'         => $params['from'],
				'default'      => $params['default'],
				'order'        => $params['order'],
			);
			App::get( 'variation' )->save( $id, $data );
			return array(
				'ok' => 'ok',
			);
		},
	)
);
