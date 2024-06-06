<?php
/**
 * REST API
 */

use SANGO\App;

App::get( 'rest' )->register(
	array(
		'path'       => 'activate-plugin',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$plugin = App::get( 'plugin' );
			return $plugin->activate_plugin( $params['name'] );
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'deactivate-plugin',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$plugin = App::get( 'plugin' );
			return $plugin->deactivate_plugin( $params['name'] );
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'install-plugin',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$plugin = App::get( 'plugin' );
			return $plugin->install_plugin( $params['name'] );
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'uninstall-plugin',
		'methods'    => 'POST',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$plugin = App::get( 'plugin' );
			return $plugin->uninstall_plugin( $params['name'] );
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'plugin-installed',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$params = $req->get_params();
			$plugin = App::get( 'plugin' );
			return array(
				'installed' => $plugin->is_plugin_installed( $params['name'] ),
			);
		},
	)
);

App::get( 'rest' )->register(
	array(
		'path'       => 'plugin-active',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			$plugin = App::get( 'plugin' );
			$params = $req->get_params();
			return array(
				'active' => $plugin->is_plugin_active( $params['name'] ),
			);
		},
	)
);
