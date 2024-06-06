<?php
/**
 * REST API
 */

namespace SangoBlocks;

class Gallery {

	private $table_name = 'sgb_gallery';

	public function init() {}

	public function createDb() {
		global $wpdb;
		$table_name      = $wpdb->prefix . $this->table_name;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE IF NOT EXISTS $table_name(
      id BIGINT(20) NOT NULL AUTO_INCREMENT,
      thumbnail VARCHAR(255) NOT NULL,
      category VARCHAR(255),
      code LONGTEXT,
      PRIMARY KEY (id)
    ) $charset_collate";
		dbDelta( $sql );
	}

	public function removeAll() {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->query( "TRUNCATE TABLE $table_name" );
	}

	public function create( $data ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->insert(
			$table_name,
			array(
				'category'  => $data['category'],
				'thumbnail' => $data['thumbnail'],
				'code'      => $data['code'],
			)
		);
	}

	public function getKey() {
		$key = get_theme_mod( 'sangoland_apikey', '' );
		return $key;
	}

	public function setKey( $key ) {
		set_theme_mod( 'sangoland_apikey', $key );
	}

	public function get() {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$results    = $wpdb->get_results(
			"SELECT *
      FROM $table_name
    "
		);
		if ( $results ) {
			return array_map(
				function ( $item ) {
					return array(
						'category'  => $item->category,
						'thumbnail' => $item->thumbnail,
						'id'        => $item->id,
						'code'      => $item->code,
					);
				},
				$results
			);
		}
		return array();
	}
}
