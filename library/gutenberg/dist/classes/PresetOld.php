<?php

namespace SangoBlocks;

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

class PresetOld {
	private $table_name = 'sgb_preset';

	public function init() {}

	public function createDb() {
		global $wpdb;
		$table_name      = $wpdb->prefix . $this->table_name;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE IF NOT EXISTS $table_name(
      preset_name VARCHAR(30) NOT NULL,
      preset_data LONGTEXT,
      PRIMARY KEY (preset_name)
    ) $charset_collate";
		dbDelta( $sql );
	}

	public function get( $name ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$results    = $wpdb->get_results(
			"SELECT preset_data
      FROM $table_name
      WHERE preset_name = \"$name\"
    "
		);
		if ( $results && isset( $results[0] ) ) {
			$preset_data = $results[0]->preset_data;
			return json_decode( $preset_data );
		}
		return array();
	}

	public function get_all() {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$results    = $wpdb->get_results(
			"SELECT preset_data, preset_name
      FROM $table_name
    "
		);
		return array_map(
			function ( $item ) {
				$data = json_decode( $item->preset_data );
				$name = $item->preset_name;

				return array(
					'preset_name' => $name,
					'preset_data' => $data,
				);
			},
			$results
		);
	}

	public function save( $name, $data ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->query(
			"DELETE FROM $table_name
      WHERE preset_name = \"$name\"
    "
		);
		$wpdb->insert(
			$table_name,
			array(
				'preset_name' => $name,
				'preset_data' => json_encode( $data ),
			)
		);
	}
}
