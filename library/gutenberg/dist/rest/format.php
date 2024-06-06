<?php
/**
 * REST API
 */

use SangoBlocks\App;

App::get( 'rest' )->register(
	array(
		'path'       => 'format',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$name = $params['name'];
			$className = $params['className'];
			$id = isset( $params['id'] ) ? $params['id'] : '';
			$css = $params['css'];
			$link = $params['link'];
			if ( $id ) {
				App::get( 'format' )->update(
					array(
						'id'        => $id,
						'name'      => $name,
						'className' => $className,
						'css'       => $css,
						'link'      => $link,
					)
				);
			} else {
				App::get( 'format' )->create(
					array(
						'name'      => $name,
						'className' => $className,
						'css'       => $css,
						'link'      => $link,
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
		'path'       => 'format',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			return App::get( 'format' )->get();
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'format',
		'methods'    => 'DELETE',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$id = $params['id'];
			App::get( 'format' )->remove( $id );
			return array(
				'ok' => 'ok',
			);
		},
	)
);
