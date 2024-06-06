<?php

namespace SangoBlocks;

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

class Preset {
	private $table_name = 'sgb_preset2';

	public function init() {}

	public function createDb() {
		global $wpdb;
		$table_name      = $wpdb->prefix . $this->table_name;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE IF NOT EXISTS $table_name(
      preset_id VARCHAR(30) NOT NULL,
      preset_title VARCHAR(30) NOT NULL,
      preset_from VARCHAR(30) NOT NULL,
      preset_attributes LONGTEXT,
      preset_inner_blocks LONGTEXT,
      preset_order INT DEFAULT 0,
      PRIMARY KEY (preset_id)
    ) $charset_collate";
		dbDelta( $sql );
	}

	public function has_table() {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$query      = "SHOW TABLES LIKE '$table_name'";
		$result     = $wpdb->get_results( $query );
		if ( count( $result ) > 0 ) {
			return true;
		}
		return false;
	}

	public function migrate() {
		if ( $this->has_table() && count( $this->get_all() ) > 0 ) {
			return;
		}
		$items = App::get( 'preset_old' )->get_all();
		$this->createDb();
		foreach ( $items as $category ) {
			$from = $category['preset_name'];
			$data = $category['preset_data'];
			foreach ( $data as $i => $item ) {
				$this->save(
					$item->id,
					array(
						'title'        => $item->name,
						'from'         => $from,
						'attributes'   => isset( $item->attributes ) ? $item->attributes : '',
						'inner_blocks' => isset( $item->innerHTML ) ? $item->innerHTML : '',
						'order'        => $i,
					)
				);
			}
		}
	}

	public function migrate2() {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$query      = "SHOW COLUMNS FROM $table_name LIKE 'preset_order'";
		$result     = $wpdb->get_results( $query );
		if ( count( $result ) > 0 ) {
			return;
		}
		$query = <<< EOM
    ALTER TABLE $table_name
    ADD COLUMN preset_order INT DEFAULT 0 AFTER preset_inner_blocks;
EOM;
		$wpdb->query( $query );
	}

	public function get_all( $category = null ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$query      = "SELECT *
      FROM $table_name
    ";
		if ( $category ) {
			$query .= "WHERE preset_from = \"$category\"";
		}
		$query  .= ' ORDER BY preset_order ASC';
		$results = $wpdb->get_results( $query );
		if ( $results ) {
			$data = array_map(
				function ( $item ) {
					return array(
						'id'           => $item->preset_id,
						'title'        => $item->preset_title,
						'from'         => $item->preset_from,
						'attributes'   => json_decode( $item->preset_attributes ),
						'inner_blocks' => $item->preset_inner_blocks,
					);
				},
				$results
			);
			return $data;
		}
		return array();
	}

	public function save( $id, $data ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->query(
			"DELETE FROM $table_name
      WHERE preset_id = \"$id\"
    "
		);
		$wpdb->insert(
			$table_name,
			array(
				'preset_id'           => $id,
				'preset_title'        => $data['title'],
				'preset_from'         => $data['from'],
				'preset_attributes'   => json_encode( $data['attributes'] ),
				'preset_inner_blocks' => $data['inner_blocks'],
				'preset_order'        => isset( $data['order'] ) ? $data['order'] : 0,
			)
		);
	}

	public function save_category( $category, $data ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->query(
			"DELETE FROM $table_name
      WHERE preset_from = \"$category\"
    "
		);
		foreach ( $data as $index => $item ) {
			$this->save(
				$item['id'],
				array(
					'id'           => $item['id'],
					'from'         => $category,
					'title'        => $item['title'],
					'attributes'   => $item['attributes'],
					'inner_blocks' => $item['inner_blocks'],
					'order'        => $index,
				)
			);
		}
	}

	public function remove( $id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->query(
			"DELETE FROM $table_name
      WHERE preset_id = \"$id\"
    "
		);
	}

	public function import( $data, $updateIfExist ) {
		$items = $this->get_all();
		foreach ( $data as $item ) {
			$title     = $item['title'];
			$found_key = array_search( $title, array_column( $items, 'title' ) );
			if ( $found_key === false ) {
				$id = uniqid( 'sgb-preset-' );
				$this->save( $id, $item );
			} elseif ( $updateIfExist ) {
				$id = $items[ $found_key ]['id'];
				$this->remove( $id );
				$this->save( $id, $item );
			}
		}
	}
}
