<?php

use SANGO\App;

App::get( 'rest' )->register(
	array(
		'path'     => 'page-count',
		'methods'  => 'POST',
		'callback' => function ( $req ) {
			$params = json_decode( $req->get_body() );
			$id = $params->post_id;
			$count_key = 'post_views_count';
			$num = get_post_meta( $id, $count_key, true );
			if ( $num == '' ) {
				$num = 0;
				delete_post_meta( $id, $count_key );
				add_post_meta( $id, $count_key, '0' );
			} else {
				$num++;
				update_post_meta( $id, $count_key, $num );
			}
			return array(
				'count' => $num,
			);
		},
	)
);
