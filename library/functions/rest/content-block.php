<?php
/**
 * REST API
 */

use SANGO\App;

App::get( 'rest' )->register(
	array(
		'path'     => 'cb/click',
		'methods'  => 'POST',
		'callback' => function ( $req ) {
			$body = $req->get_body();
			$params = json_decode( $body, true );
			$post_id = $params['postId'];
			$meta = array(
				'url'   => $params['url'],
				'label' => $params['label'],
			);
			return App::get( 'content-block' )->count_click( $post_id, $meta );
		},
	)
);
															

App::get( 'rest' )->register(
	array(
		'path'     => 'cb/register',
		'methods'  => 'POST',
		'callback' => function ( $req ) {

			$body = $req->get_body();

			$params = json_decode( $body, true );

			$client = Google_Spreadsheet::getClient('credintial.json');
			// Get the sheet instance by sheets_id and sheet name
			$sheet = $client->file('12QHL2HNwzvVUbJahqJ4DciTGAy-DVY1724ZY3G-DNcQ')->sheet('シート1');
			// // Fetch data from remote (or cache)
			// Insert a new row
			$sheet->insert(array(
				'名前'   => $params['name'],
				'生年' => $params['birthYear'],
				'郵便番号' => $params['postalCode'],
				'県' => $params['prefecture'],
				'市' => $params['city'],
				'電話' => $params['tel'],
				'Eメール' => $params['email'],
				'番地' => $params['streetAddress'],
				'雇用の種類' => $params['employmentType'],
				'移転タイミング' => $params['relocationTiming'],
				'過去の職歴変更' => $params['pastJobChanges'],
				'現在のジョブステータス' => $params['currentJobStatus'],
				'フィーリング' => $params['feeling'],
				'資格' => $params['qualifications'],
				'持ち上げ操作' => $params['liftingOperations'],
				'好み' => $params['preferences'],
			));
			
			return true;

		},
	)
);


App::get( 'rest' )->register(
	array(
		'path'     => 'cb/pv',
		'methods'  => 'POST',
		'callback' => function ( $req ) {
			$body = $req->get_body();
			$params = json_decode( $body, true );
			$post_id = $params['postId'];
			return App::get( 'content-block' )->count_pv( $post_id );
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'     => 'cb/block',
		'methods'  => 'POST',
		'callback' => function ( $req ) {
			$body = $req->get_body();
			$params = json_decode( $body, true );
			$id = $params['id'];
			App::get( 'content-block' )->set_lazy_mode( true );
			$html = App::get( 'content-block' )->get_content_block( $id );
			$css = App::get( 'css' )->get_style( true );
			return array(
				'html' => $html,
				'css'  => $css,
			);
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'cb/meta',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$id = $params['id'];
			$meta = App::get( 'content-block' )->get_meta( $id );
			return $meta;
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'cb/search',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$id = $params['id'];
			$start = $params['start'];
			$end = $params['end'];

			return App::get( 'content-block' )->search(
				array(
					'id'     => $id,
					'unit'   => $params['unit'],
					'url'    => $params['url'],
					'label'  => $params['label'],
					'offset' => $params['offset'],
				)
			);
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'cb/reset',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$body = $req->get_body();
			$params = json_decode( $body, true );
			$id = $params['id'];

			return App::get( 'content-block' )->reset( $id );
		},
	)
);
