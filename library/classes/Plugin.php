<?php

namespace SANGO;

require_once ABSPATH . 'wp-admin/includes/plugin.php';
require_once ABSPATH . 'wp-admin/includes/plugin-install.php'; // for plugins_api..
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/misc.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

class Plugin {

	public function init() {}

	public function get_plugins() {
		$plugins = get_plugins();
		if ( empty( $plugins ) ) {
			return array();
		}
		foreach ( $plugins as $file => $data ) {
			if ( false !== strpos( $file, '/' ) ) {
				$slugs[] = substr( $file, 0, strpos( $file, '/' ) );
			} else {
				$slugs[] = sanitize_title( $data['Name'] );
			}
		}
		return $slugs;
	}

	public function activate_plugin( $slug ) {
		if ( $this->is_plugin_active( $slug ) ) {
			return;
		}
		$pluginName = $this->get_plugin_name_from_slug( $slug );
		activate_plugin( $pluginName );
	}

	public function deactivate_plugin( $slug ) {
		if ( ! $this->is_plugin_active( $slug ) ) {
			return;
		}
		$pluginName = $this->get_plugin_name_from_slug( $slug );
		deactivate_plugins( $pluginName );
	}

	public function is_plugin_active( $slug ) {
		return is_plugin_active( $this->get_plugin_name_from_slug( $slug ) );
	}

	public function get_plugin_name_from_slug( $slug ) {
		$plugins = get_plugins();
		foreach ( $plugins as $file => $data ) {
			if ( false !== strpos( $file, '/' ) ) {
				if ( $slug === substr( $file, 0, strpos( $file, '/' ) ) ) {
					return $file;
				}
			} elseif ( $slug === sanitize_title( $data['Name'] ) ) {
					return $file;
			}
		}
	}

	public function is_plugin_installed( $slug ) {
		$plugins = $this->get_plugins();
		foreach ( $plugins as $plugin ) {
			if ( $plugin === $slug ) {
				return true;
			}
		}
		return false;
	}

	public function uninstall_plugin( $slug ) {
		if ( ! $this->is_plugin_installed( $slug ) ) {
			return;
		}
		$pluginName = $this->get_plugin_name_from_slug( $slug );
		delete_plugins( array( $pluginName ) );
	}

	public function install_plugin( $plugin ) {
		if ( $this->is_plugin_installed( $plugin ) ) {
			return;
		}
		$api      = plugins_api(
			'plugin_information',
			array(
				'slug'   => $plugin,
				'fields' => array(
					'short_description' => false,
					'sections'          => false,
					'requires'          => false,
					'rating'            => false,
					'ratings'           => false,
					'downloaded'        => false,
					'last_updated'      => false,
					'added'             => false,
					'tags'              => false,
					'compatibility'     => false,
					'homepage'          => false,
					'donate_link'       => false,
				),
			)
		);
		$upgrader = new \Plugin_Upgrader( new \Plugin_Installer_Skin( compact( 'title', 'url', 'nonce', 'plugin', 'api' ) ) );
		$upgrader->install( $api->download_link );
	}
}
