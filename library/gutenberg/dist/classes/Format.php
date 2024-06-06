<?php

namespace SangoBlocks;

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

class Format {
	private $table_name = 'sgb_format';

	public function init() {}

	public function createDb() {
		global $wpdb;
		$table_name      = $wpdb->prefix . $this->table_name;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE IF NOT EXISTS $table_name(
      format_id BIGINT(20) NOT NULL AUTO_INCREMENT,
      format_name VARCHAR(255) NOT NULL,
      format_class_name VARCHAR(255),
      format_css LONGTEXT,
      format_link BOOLEAN,
      PRIMARY KEY (format_id)
    ) $charset_collate";
		dbDelta( $sql );
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
						'format_id'         => $item->format_id,
						'format_name'       => $item->format_name,
						'format_class_name' => $item->format_class_name,
						'format_css'        => $item->format_css,
						'format_link'       => isset( $item->format_link ) && $item->format_link === '1' ? true : false,
					);
				},
				$results
			);
		}
		return array();
	}

	public function remove( $id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->query(
			"DELETE FROM $table_name
      WHERE format_id = \"$id\"
    "
		);
	}

	public function create( $data ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;

		$wpdb->insert(
			$table_name,
			array(
				'format_name'       => $data['name'],
				'format_class_name' => $data['className'],
				'format_css'        => $data['css'],
				'format_link'       => $data['link'],
			)
		);
	}

	public function format_link_exist() {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$query      = <<< EOM
    SHOW COLUMNS from `$table_name` LIKE 'format_link';
EOM;
		$result     = $wpdb->query( $query );
		return $result === 0 ? false : true;
	}

	public function migrate_table() {
		if ( $this->format_link_exist() ) {
			return;
		}
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$query      = <<< EOM
    ALTER TABLE $table_name
    ADD COLUMN format_link BOOLEAN AFTER format_css;
EOM;
		$wpdb->query( $query );
	}

	public function update( $data ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;

		$wpdb->update(
			$table_name,
			array(
				'format_name'       => $data['name'],
				'format_class_name' => $data['className'],
				'format_css'        => $data['css'],
				'format_link'       => $data['link'],
			),
			array(
				'format_id' => $data['id'],
			)
		);
	}

	public function import( $data, $updateIfExist ) {
		$items = $this->get();
		foreach ( $data as $item ) {
			$name      = $item['format_name'];
			$found_key = array_search( $name, array_column( $items, 'format_name' ) );
			if ( $found_key === false ) {
				$this->create(
					array(
						'name'      => $item['format_name'],
						'className' => $item['format_class_name'],
						'css'       => $item['format_css'],
						'link'      => $item['format_link'],
					)
				);
			} elseif ( $updateIfExist ) {
				$id = $items[ $found_key ]['id'];
				$this->update(
					array(
						'id'        => $id,
						'name'      => $item['format_name'],
						'className' => $item['format_class_name'],
						'css'       => $item['format_css'],
						'link'      => $item['format_link'],
					)
				);
			}
		}
	}

	public function get_custom_format_css() {
		$custom_css = App::get( 'css' );
		$items      = $this->get();
		$css        = '';
		foreach ( $items as $item ) {
			$css .= $item['format_css'];
		}
		$css = $custom_css->minify_css( $css );
		return wp_strip_all_tags( $css );
	}
}
