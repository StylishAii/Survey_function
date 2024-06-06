<?php

namespace SANGO;

class Builder {

	protected $config  = array();
	protected $section = array();
	protected $imageDir;
	protected $attr;
	public function init() {
	}

	public function setAttr( $attr ) {
		$this->attr = $attr;
	}

	public function getAttr() {
		return $this->attr;
	}

	public function getProp( $name ) {
		if ( ! isset( $this->attr[ $name ] ) ) {
			return null;
		}
		return $this->attr[ $name ];
	}

	public function setImage( $dir ) {
		$this->imageDir = $dir;
	}

	public function addSection( $title, $name, $option = array() ) {
		$this->section[] = array(
			'title'  => $title,
			'name'   => $name,
			'option' => $option,
		);
	}

	public function addConfig( $type, $config ) {
		$this->config[] = array(
			'type'   => $type,
			'config' => $config,
		);
	}

	public function getConfigBySection( $name ) {
		$config = $this->config;
		$array  = array();
		foreach ( $config as $item ) {
			$childConf = $item['config'];
			if ( $item['type'] === $name ) {
				// var_dump($childConf);
				if ( isset( $childConf['choices'] ) ) {
					$coices = array();
					foreach ( $childConf['choices'] as $key => $value ) {
						$coices[] = array(
							'value' => $key,
							'label' => $value,
						);
					}
					$childConf['options'] = $coices;
				}
				$array[] = $childConf;
			}
		}
		// var_dump($array);
		return $array;
	}

	public function getConfig() {
		$section = $this->section;
		$array   = array();
		foreach ( $section as $item ) {
			$array[] = array(
				'title'  => $item['title'],
				'name'   => $item['name'],
				'option' => $item['option'],
				'saved'  => false,
				'config' => $this->getConfigBySection( $item['name'] ),
			);
		}
		usort(
			$array,
			function ( $a, $b ) {
				$priority_a = 0;
				$priority_b = 0;
				if ( isset( $a['option'] ) && isset( $a['option']['priority'] ) ) {
					$priority_a = $a['option']['priority'];
				}
				if ( isset( $b['option'] ) && isset( $b['option']['priority'] ) ) {
					$priority_b = $b['option']['priority'];
				}
				return $priority_a - $priority_b;
			}
		);
		return $array;
	}

	public function build() {
		return array(
			'imageDir'     => $this->imageDir,
			'siteUrl'      => site_url(),
			'version'      => wp_get_theme( get_template() )->get( 'Version' ),
			'contentBlock' => App::get( 'content-block' )->available_content_block_name_list(),
			'config'       => $this->getConfig(),
		);
	}

	public function getUpdateOptions() {
		$config = $this->config;
		$array  = array();
		foreach ( $config as $item ) {
			$array[] = $item['config']['name'];
		}
		return $array;
	}

	public function getOptionUpdateMethod( $name ) {
		$method = 'option';
		$config = $this->config;
		foreach ( $config as $item ) {
			if ( $item['config']['name'] === $name && isset( $item['config']['updateMethod'] ) ) {
				$method = $item['config']['updateMethod'];
			}
		}
		return $method;
	}
}
