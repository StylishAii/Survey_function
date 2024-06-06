<?php

namespace SANGO;

require_once ABSPATH . 'wp-admin/includes/upgrade.php';


class Cache {

	private $table_name = 'sng_cache';

	public function init() {
	}

	public function createDb() {
		global $wpdb;
		$table_name      = $wpdb->prefix . $this->table_name;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE IF NOT EXISTS $table_name(
      cache_id BIGINT(20) NOT NULL AUTO_INCREMENT,
      cache_key VARCHAR(255) NOT NULL,
      cache_body LONGTEXT,
      PRIMARY KEY (cache_id)
    ) $charset_collate";
		dbDelta( $sql );
	}

	public function set( $key, $contents ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->query(
			"DELETE FROM $table_name WHERE cache_key = '$key'"
		);
		$wpdb->insert(
			$table_name,
			array(
				'cache_key'  => $key,
				'cache_body' => $contents,
			)
		);
	}

	public function get( $key ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$is_mobile  = wp_is_mobile();
		$sql        = $wpdb->prepare( "SELECT cache_body FROM $table_name WHERE cache_key = %s", $key );
		$result     = $wpdb->get_var( $sql );
		return $result;
	}

	public function clear_all() {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->query( "DELETE FROM $table_name" );
	}
}
