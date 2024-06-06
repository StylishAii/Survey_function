<?php

namespace SANGO;

class Widget {
	public function init() {}

	public function get_available_widgets() {
		global $wp_registered_widget_controls;
		$widget_controls   = $wp_registered_widget_controls;
		$available_widgets = array();

		foreach ( $widget_controls as $widget ) {
			if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[ $widget['id_base'] ] ) ) { // no dupes
				$available_widgets[ $widget['id_base'] ]['id_base'] = $widget['id_base'];
				$available_widgets[ $widget['id_base'] ]['name']    = $widget['name'];
			}
		}
		return $available_widgets;
	}

	public function export() {
		$available_widgets = $this->get_available_widgets();
		$widget_instances  = array();
		foreach ( $available_widgets as $widget_data ) {
			$instances = get_option( 'widget_' . $widget_data['id_base'] );
			if ( ! empty( $instances ) ) {
				foreach ( $instances as $instance_id => $instance_data ) {
					if ( is_numeric( $instance_id ) ) {
						$unique_instance_id                      = $widget_data['id_base'] . '-' . $instance_id;
						$widget_instances[ $unique_instance_id ] = $instance_data;
					}
				}
			}
		}

		$sidebars_widgets          = get_option( 'sidebars_widgets' );
		$sidebars_widget_instances = array();
		foreach ( $sidebars_widgets as $sidebar_id => $widget_ids ) {
			if ( 'wp_inactive_widgets' == $sidebar_id ) {
				continue;
			}
			if ( ! is_array( $widget_ids ) || empty( $widget_ids ) ) {
				continue;
			}
			foreach ( $widget_ids as $widget_id ) {
				if ( isset( $widget_instances[ $widget_id ] ) ) {
					$sidebars_widget_instances[ $sidebar_id ][ $widget_id ] = $widget_instances[ $widget_id ];
				}
			}
		}
		return $sidebars_widget_instances;
	}

	public function import( $data, $clearBeforeUpdate = false ) {
		global $wp_registered_sidebars;
		$available_widgets = $this->get_available_widgets();
		$widget_instances  = array();
		if ( $clearBeforeUpdate ) {
			update_option( 'sidebars_widgets', array() );
		}
		foreach ( $available_widgets as $widget_data ) {
			$widget_instances[ $widget_data['id_base'] ] = get_option( 'widget_' . $widget_data['id_base'] );
		}
		foreach ( $data as $sidebar_id => $widgets ) {
			if ( 'wp_inactive_widgets' == $sidebar_id ) {
				continue;
			}
			if ( isset( $wp_registered_sidebars[ $sidebar_id ] ) ) {
				$sidebar_available = true;
				$use_sidebar_id    = $sidebar_id;
			} else {
				$sidebar_available = false;
				$use_sidebar_id    = 'wp_inactive_widgets';
			}
			foreach ( $widgets as $widget_instance_id => $widget ) {
				$fail               = false;
				$id_base            = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
				$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );
				if ( ! $fail && ! isset( $available_widgets[ $id_base ] ) ) {
					$fail = true;
				}
				$widget = json_decode( json_encode( $widget ), true );
				if ( ! $fail && isset( $widget_instances[ $id_base ] ) ) {
					$sidebars_widgets = get_option( 'sidebars_widgets' );
					$sidebar_widgets  = isset( $sidebars_widgets[ $use_sidebar_id ] ) ? $sidebars_widgets[ $use_sidebar_id ] : array();

					$single_widget_instances = ! empty( $widget_instances[ $id_base ] ) ? $widget_instances[ $id_base ] : array();
					foreach ( $single_widget_instances as $check_id => $check_widget ) {
						if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {
								$fail = true;
								break;
						}
					}
				}
				if ( ! $fail ) {
					$single_widget_instances   = get_option( 'widget_' . $id_base );
					$single_widget_instances   = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 );
					$single_widget_instances[] = $widget;
					end( $single_widget_instances );
					$new_instance_id_number = key( $single_widget_instances );
					if ( '0' === strval( $new_instance_id_number ) ) {
						$new_instance_id_number                             = 1;
						$single_widget_instances[ $new_instance_id_number ] = $single_widget_instances[0];
						unset( $single_widget_instances[0] );
					}
					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
						$multiwidget = $single_widget_instances['_multiwidget'];
						unset( $single_widget_instances['_multiwidget'] );
						$single_widget_instances['_multiwidget'] = $multiwidget;
					}
					update_option( 'widget_' . $id_base, $single_widget_instances );
					$sidebars_widgets                      = get_option( 'sidebars_widgets' );
					$new_instance_id                       = $id_base . '-' . $new_instance_id_number;
					$sidebars_widgets[ $use_sidebar_id ][] = $new_instance_id;
					update_option( 'sidebars_widgets', $sidebars_widgets );
				}
			}
		}
	}
}
