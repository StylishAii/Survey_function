<?php
/**
 * REST API
 */

use SANGO\App;

App::get( 'rest' )->register(
	array(
		'path'       => 'field',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$name = $params['name'];
			$label = $params['label'];
			$type = $params['type'];
			$choices = $params['choices'];
			$id = isset( $params['id'] ) ? $params['id'] : '';
			$css = $params['css'];
			if ( $id ) {
				App::get( 'field' )->update(
					array(
						'id'      => $id,
						'name'    => $name,
						'label'   => $label,
						'type'    => $type,
						'choices' => $choices,
					)
				);
			} else {
				App::get( 'field' )->create(
					array(
						'name'    => $name,
						'label'   => $label,
						'type'    => $type,
						'choices' => $choices,
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
		'path'       => 'field',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			return App::get( 'field' )->get();
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'field',
		'methods'    => 'DELETE',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$id = $params['id'];
			App::get( 'field' )->remove( $id );
			return array(
				'ok' => 'ok',
			);
		},
	)
);
