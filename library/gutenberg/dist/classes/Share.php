<?php

namespace SangoBlocks;

class Share {
	private $table_name = 'sgb_share';

	function init() {}
	public function createDb() {
		global $wpdb;
		$table_name      = $wpdb->prefix . $this->table_name;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE IF NOT EXISTS $table_name(
      share_id VARCHAR(30) NOT NULL,
      share_title VARCHAR(30) NOT NULL,
      share_from VARCHAR(30) NOT NULL,
      share_css LONGTEXT,
      share_admin_css LONGTEXT,
      share_scoped_css LONGTEXT,
      share_js LONGTEXT,
      share_order INT DEFAULT 0,
      PRIMARY KEY (share_id)
    ) $charset_collate";
		dbDelta( $sql );
	}

	public function remove( $id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->query(
			"DELETE FROM $table_name
      WHERE share_id = \"$id\"
    "
		);
		return array(
			'id' => $id,
		);
	}

	public function save( $id, $data ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->query(
			"DELETE FROM $table_name
      WHERE share_id = \"$id\"
    "
		);
		$wpdb->insert(
			$table_name,
			array(
				'share_id'         => $id,
				'share_title'      => $data['title'],
				'share_js'         => $data['js'],
				'share_css'        => $data['css'],
				'share_admin_css'  => $data['adminCSS'],
				'share_scoped_css' => $data['scopedCSS'],
				'share_from'       => $data['from'],
			)
		);
		return array(
			'id' => $id,
		);
	}

	public function generate_cache() {
		$items = $this->get_all();
		$css   = '';
		$js    = '';
		foreach ( $items as $item ) {
			$id = $item['id'];
			if ( $item['css'] ) {
				$css .= $item['scopedCSS'];
			}
			if ( $item['js'] ) {
				$code = $item['js'];
				$js  .= "sgb.domReady(() => {
          const blocks = document.querySelectorAll('.sgb-shared-$id');
          blocks.forEach((block) => {
            const controls = {};
            const controlStr = block.dataset.control;
            if (controlStr) {
              const parsedControls = JSON.parse(controlStr);
              Object.keys(parsedControls).forEach((key) => {
                controls[key] = parsedControls[key];
              });
            }
            console.log(controls);
            $code
          });
        });";
			}
		}
		if ( $css ) {
			set_transient( 'sgb-shared-css', $css );
		}
		if ( $js ) {
			set_transient( 'sgb-shared-js', $js );
		}
	}

	public function get_all() {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$results    = $wpdb->get_results(
			"SELECT *
      FROM $table_name
    "
		);
		if ( $results ) {
			$data = array_map(
				function ( $item ) {
					return array(
						'id'        => $item->share_id,
						'title'     => $item->share_title,
						'from'      => $item->share_from,
						'js'        => $item->share_js,
						'css'       => $item->share_css,
						'adminCSS'  => $item->share_admin_css,
						'scopedCSS' => $item->share_scoped_css,
					);
				},
				$results
			);
			return $data;
		}
		return array();
	}

	public function get_category( $from ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$results    = $wpdb->get_results(
			"SELECT *
      FROM $table_name
      WHERE share_from = \"$from\"
    "
		);
		if ( $results ) {
			$data = array_map(
				function ( $item ) {
					return array(
						'id'        => $item->share_id,
						'title'     => $item->share_title,
						'from'      => $item->share_from,
						'js'        => $item->share_js,
						'css'       => $item->share_css,
						'adminCSS'  => $item->share_admin_css,
						'scopedCSS' => $item->share_scoped_css,
					);
				},
				$results
			);
			return $data;
		}
		return array();
	}


	public function import( $data, $updateIfExist ) {
		$items = $this->get_all();
		foreach ( $data as $item ) {
			$id        = $item['id'];
			$found_key = array_search( $id, array_column( $items, 'id' ) );
			if ( ! $found_key || $updateIfExist ) {
				$this->save( $id, $item );
			}
		}
	}
}
