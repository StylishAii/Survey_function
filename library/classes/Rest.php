<?php
/**
 * REST API
 */

namespace SANGO;

class Rest {

	private $rest_queue = array();
	private $endpoint   = 'sng/v1';
	private $dir        = '';

	public function init() {
		add_action( 'rest_api_init', array( $this, 'rest_api_init' ) );
	}

	public function rest_api_init() {
		App::requireDir( get_template_directory() . '/library/functions/rest' );
		foreach ( $this->rest_queue as $queue ) {
			if ( isset( $queue['only_login'] ) && $queue['only_login'] && ! is_user_logged_in() ) {
				continue;
			}
			register_rest_route(
				$this->endpoint,
				$queue['path'],
				array(
					'methods'             => $queue['methods'],
					'callback'            => $queue['callback'],
					'permission_callback' => '__return_true',
				)
			);
		}
	}

	public function register( $params ) {
		$this->rest_queue[] = $params;
	}
}
