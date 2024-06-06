<?php

use SANGO\App;

App::get( 'builder' )->addSection( '🧑‍💻 クリック計測', 'measure', array( 'priority' => 5 ) );

App::get( 'builder' )->addConfig(
	'measure',
	array(
		'name'        => 'graph',
		'value'       => '',
		'title'       => 'コンテンツブロックの計測結果',
		'type'        => 'graph',
		'description' => '',
	)
);
