<?php

namespace SangoBlocks;

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

class Variation {
	private $table_name = 'sgb_variation';

	public function init() {}

	public function createDb() {
		global $wpdb;
		$table_name      = $wpdb->prefix . $this->table_name;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE IF NOT EXISTS $table_name(
      variation_id VARCHAR(30) NOT NULL,
      variation_title VARCHAR(30) NOT NULL,
      variation_icon VARCHAR(30),
      variation_from VARCHAR(30) NOT NULL,
      variation_keywords LONGTEXT,
      variation_attributes LONGTEXT,
      variation_inner_blocks LONGTEXT,
      variation_default INT DEFAULT 0,
      variation_order INT DEFAULT 0,
      PRIMARY KEY (variation_id)
    ) $charset_collate";
		dbDelta( $sql );
	}

	public function migrate2() {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$query      = "SHOW COLUMNS FROM $table_name LIKE 'variation_default'";
		$result     = $wpdb->get_results( $query );
		if ( count( $result ) > 0 ) {
			return;
		}
		$query = <<< EOM
    ALTER TABLE $table_name
    ADD COLUMN variation_default INT DEFAULT 0 AFTER variation_inner_blocks;
EOM;
		$wpdb->query( $query );
	}

	public function migrate3() {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$query      = "SHOW COLUMNS FROM $table_name LIKE 'variation_order'";
		$result     = $wpdb->get_results( $query );
		if ( count( $result ) > 0 ) {
			return;
		}
		$query = <<< EOM
    ALTER TABLE $table_name
    ADD COLUMN variation_order INT DEFAULT 0 AFTER variation_default;
EOM;
		$wpdb->query( $query );
	}

	public function get( $id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$results    = $wpdb->get_results(
			"SELECT *
      FROM $table_name
      WHERE variation_id = \"$id\"
    "
		);
		if ( $results && isset( $results[0] ) ) {
			$variation = $results[0];
			return json_decode(
				array(
					'id'           => $variation->variation_id,
					'title'        => $variation->variation_title,
					'icon'         => $variation->variation_icon,
					'from'         => $variation->variation_from,
					'keywords'     => $variation->variation_keywords,
					'attributes'   => $variation->variation_attributes,
					'inner_blocks' => $variation->variation_inner_blocks,
					'default'      => $variation->variation_default,
					'order'        => $variation->variation_order,
				)
			);
		}
		return array();
	}

	public function get_category_variation( $cateogry ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$results    = $wpdb->get_results(
			"SELECT *
      FROM $table_name
      WHERE variation_from = \"$cateogry\"
    "
		);
		if ( $results ) {
			$data = array_map(
				function ( $item ) {
					return array(
						'id'           => $item->variation_id,
						'title'        => $item->variation_title,
						'icon'         => $item->variation_icon,
						'from'         => $item->variation_from,
						'keywords'     => explode( ',', $item->variation_keywords ),
						'attributes'   => json_decode( $item->variation_attributes ),
						'inner_blocks' => $item->variation_inner_blocks,
						'default'      => $item->variation_default,
						'order'        => $item->variation_order,
					);
				},
				$results
			);
			return $data;
		}
		return array();
	}

	public function get_all() {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$results    = $wpdb->get_results(
			"SELECT *
      FROM $table_name
      ORDER BY variation_order ASC
    "
		);
		if ( $results ) {
			$data = array_map(
				function ( $item ) {
					return array(
						'id'           => $item->variation_id,
						'title'        => $item->variation_title,
						'icon'         => $item->variation_icon,
						'from'         => $item->variation_from,
						'keywords'     => explode( ',', $item->variation_keywords ),
						'attributes'   => json_decode( $item->variation_attributes ),
						'inner_blocks' => $item->variation_inner_blocks,
						'default'      => $item->variation_default ?? '0',
						'order'        => $item->variation_order,
					);
				},
				$results
			);
			return $data;
		}
		return array();
	}

	public function remove( $id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->query(
			"DELETE FROM $table_name
      WHERE variation_id = \"$id\"
    "
		);
		return array(
			'result' => 'OK',
		);
	}

	public function save( $id, $data ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->query(
			"DELETE FROM $table_name
      WHERE variation_id = \"$id\"
    "
		);
		$wpdb->insert(
			$table_name,
			array(
				'variation_id'           => $id,
				'variation_title'        => $data['title'],
				'variation_icon'         => $data['icon'],
				'variation_from'         => $data['from'],
				'variation_keywords'     => $data['keywords'],
				'variation_attributes'   => $data['attributes'],
				'variation_inner_blocks' => $data['inner_blocks'],
				'variation_default'      => intval( $data['default'] ),
				'variation_order'        => isset( $data['order'] ) ? $data['order'] : 0,
			)
		);
	}

	public function save_order( $items ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		foreach ( $items as $index => $item ) {
			$wpdb->update(
				$table_name,
				array(
					'variation_order' => $index,
				),
				array(
					'variation_id' => $item['id'],
				)
			);
		}
	}

	public function import( $data, $updateIfExist ) {
		$items = $this->get_all();
		foreach ( $data as $item ) {
			$id       = $item['id'];
			$title    = $item['title'];
			$found_id = array_search( $id, array_column( $items, 'id' ) );
			if ( $found_key === false ) {
				$this->save(
					$id,
					array(
						'title'        => $item['title'],
						'icon'         => $item['icon'],
						'from'         => $item['from'],
						'keywords'     => implode( $item['keywords'], ',' ),
						'attributes'   => json_encode( $item['attributes'] ),
						'inner_blocks' => $item['inner_blocks'],
						'default'      => isset( $item['default'] ) ? $item['default'] : 0,
						'order'        => isset( $item['order'] ) ? $item['order'] : 0,
					)
				);
			} elseif ( $updateIfExist ) {
				$this->remove( $id );
				$this->save(
					$id,
					array(
						'title'        => $item['title'],
						'icon'         => $item['icon'],
						'from'         => $item['from'],
						'keywords'     => implode( $item['keywords'], ',' ),
						'attributes'   => json_encode( $item['attributes'] ),
						'inner_blocks' => $item['inner_blocks'],
						'default'      => isset( $item['default'] ) ? $item['default'] : 0,
						'order'        => isset( $item['order'] ) ? $item['order'] : 0,
					)
				);
			}
		}
	}
}
