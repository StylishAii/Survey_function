<?php

use SANGO\App;
use SangoBlocks\App as SangoBlocksApp;

App::get( 'builder' )->addSection( '🗂️ データ管理', 'export', array( 'priority' => 9 ) );

App::get( 'builder' )->addConfig(
	'export',
	array(
		'name'        => 'export_title0',
		'value'       => '',
		'title'       => 'マイグレーション',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'export',
	array(
		'name'  => 'sng_export',
		'title' => 'データのマイグレーション',
		'type'  => 'migrate',
	)
);

App::get( 'builder' )->addConfig(
	'export',
	array(
		'name'        => 'export_title1',
		'value'       => '',
		'title'       => 'テーマのダウングレード',
		'type'        => 'title',
		'description' => '',
	)
);


App::get( 'builder' )->addConfig(
	'export',
	array(
		'name'        => 'sng_export',
		'title'       => 'テーマのダウングレード（β）',
		'type'        => 'rollback',
		'description' => 'SANGOのアップデートによって不具合が生じ、緊急でバージョンを戻したい場合などにご利用ください。β版のため、実行前にテーマのバックアップをとっておくことをお勧めします。',
	)
);

App::get( 'builder' )->addConfig(
	'export',
	array(
		'name'        => 'export_title2',
		'value'       => '',
		'title'       => 'データのエクスポート',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'export',
	array(
		'name'  => 'sng_export',
		'title' => 'データのエクスポート',
		'type'  => 'export',
	)
);

App::get( 'builder' )->addConfig(
	'export',
	array(
		'name'        => 'export_title3',
		'value'       => '',
		'title'       => 'データのインポート',
		'type'        => 'title',
		'description' => '',
	)
);

App::get( 'builder' )->addConfig(
	'export',
	array(
		'name'  => 'sng_import',
		'title' => 'データのインポート',
		'type'  => 'import',
	)
);
