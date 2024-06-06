<?php

namespace SANGO;

class Field {

	private $table_name = 'sng_field';

	public function init() {
		add_action( 'sng_field_side_extra', array( $this, 'renderSideFields' ) );
		add_action( 'sng_update_custom_fields', array( $this, 'saveFields' ), 10, 3 );
	}

	public function renderSideFields() {
		global $post;
		$fields = $this->get();
		if ( count( $fields ) >= 0 ) {
			echo '<p class="sng-field-title">カスタム設定</p>';
		}
		foreach ( $fields as $field ) {
			$meta_value = get_post_meta( $post->ID, $field->field_name, true );
			$this->renderField( $field, $meta_value );
		}
	}

	public function saveFields( $post_id ) {
		$fields = $this->get();
		foreach ( $fields as $field ) {
			$name = $field->field_name;
			if ( $field->field_type === 'checkbox' ) {
				sng_update_custom_option_fields( $post_id, $name );
			} else {
				sng_update_custom_text_fields( $post_id, $name );
			}
		}
	}

	public function renderField( $field, $value ) {
		$name    = $field->field_name;
		$label   = $field->field_label;
		$type    = $field->field_type;
		$choices = $field->field_choices;
		$value   = $value ? $value : '';
		if ( $type === 'text' ) {
			$this->renderText( $label, $name, $value );
		} elseif ( $type === 'select' ) {
			$this->renderSelect( $label, $name, $choices, $value );
		} elseif ( $type === 'textarea' ) {
			$this->renderTextarea( $label, $name, $value );
		} elseif ( $type === 'checkbox' ) {
			$this->renderCheckbox( $label, $name, $value );
		} elseif ( $type === 'radio' ) {
			$this->renderRadio( $label, $name, $choices, $value );
		}
	}

	private function renderText( $label, $name, $value ) {
		$value = "<input type='text' name='{$name}' value='{$value}' />";
		$value = "<div style='margin-top: 10px;'>{$value}</div>";
		echo "<div style='margin-top: 15px;'>{$label}</div>";
		echo $value;
	}

	private function renderTextarea( $label, $name, $value ) {
		$value = "<textarea name='{$name}'>{$value}</textarea>";
		$value = "<div style='margin-top: 10px;'>{$value}</div>";
		echo "<div style='margin-top: 15px;'>{$label}</div>";
		echo $value;
	}

	private function renderCheckbox( $label, $name, $value ) {
		$checked = $value ? ' checked' : '';
		$value   = "<input type='checkbox' name='{$name}' value='1'{$checked} />";
		$value   = "<label style='margin-top: 10px;'>{$value} {$label}</label>";
		echo "<div style='margin-top: 15px;'>{$value}</div>";
	}

	private function renderRadio( $label, $name, $choices, $value ) {
		echo "<div style='margin-top: 15px;'>{$label}</div>";
		foreach ( $choices as $choice ) {
			$checked = $choice->value === $value ? ' checked' : '';
			$value   = "<input type='radio' name='{$name}' value='{$choice->value}'{$checked} />";
			echo "<div style='margin-top: 10px;'>{$value}</div>";
		}
	}

	private function renderSelect( $label, $name, $choices, $value ) {
		echo "<div style='margin-top: 15px;'>{$label}</div>";
		echo "<select name='{$name}'>";
		foreach ( $choices as $choice ) {
			$selected = $choice->value === $value ? ' selected' : '';
			echo "<option value='{$choice->value}'{$selected}>{$choice->label}</option>";
		}
		echo '</select>';
	}

	public function createDb() {
		global $wpdb;
		$table_name      = $wpdb->prefix . $this->table_name;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE IF NOT EXISTS $table_name(
      field_id BIGINT(20) NOT NULL AUTO_INCREMENT,
      field_name VARCHAR(255) NOT NULL,
      field_label VARCHAR(255) NOT NULL,
      field_type VARCHAR(255) NOT NULL,
      field_choices LONGTEXT,
      PRIMARY KEY (field_id)
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
				function ( $result ) {
					$result->field_choices = json_decode( $result->field_choices );
					return $result;
				},
				$results
			);
		}
		return array();
	}

	public function get_by_name( $name ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		// get one record by name
		$result = $wpdb->get_row(
			"SELECT *
      FROM $table_name
      WHERE field_name = \"$name\"
    "
		);
		if ( $result ) {
			$result->field_choices = json_decode( $result->field_choices );
			return $result;
		}
		return null;
	}

	public function remove( $id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->query(
			"DELETE FROM $table_name
      WHERE field_id = \"$id\"
    "
		);
	}

	public function create( $data ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;

		$wpdb->insert(
			$table_name,
			array(
				'field_name'    => $data['name'],
				'field_label'   => $data['label'],
				'field_type'    => $data['type'],
				'field_choices' => isset( $data['choices'] ) ? json_encode( $data['choices'] ) : '',
			)
		);
	}

	public function update( $data ) {
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$wpdb->update(
			$table_name,
			array(
				'field_name'    => $data['name'],
				'field_label'   => $data['label'],
				'field_type'    => $data['type'],
				'field_choices' => isset( $data['choices'] ) ? json_encode( $data['choices'] ) : '',
			),
			array(
				'field_id' => $data['id'],
			)
		);
	}
}
