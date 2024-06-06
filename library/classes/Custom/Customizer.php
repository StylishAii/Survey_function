<?php

namespace SANGO\Custom;

use SANGO\App;

class Customizer extends Custom {

	public $dir = '';

	public function init() {
		$this->register_build_dir( '/library/functions/custom/customizer' );
		add_action( 'customize_register', array( $this, 'register_customizer' ) );
		$this->build();
	}

	public function register_customizer( $wp_customize ) {
		$this->sections( $wp_customize );
		$this->settings( $wp_customize );
	}

	public function sections( $wp_customize ) {
		$builder = App::get( 'customizer_builder' );
		$builder->setAttr( $wp_customize );
		$config = $builder->build();
		foreach ( $config['config'] as $section ) {
			$priority    = isset( $section['option']['priority'] ) ? $section['option']['priority'] : '';
			$description = isset( $section['option']['description'] ) ? $section['option']['description'] : '';
			if ( isset( $section['option']['parent'] ) ) {
				$wp_customize->add_section(
					$section['name'],
					array(
						'panel'       => $section['option']['parent'],
						'priority'    => $priority,
						'title'       => $section['title'],
						'description' => $description,
					)
				);
			} else {
				$find = false;
				foreach ( $config['config'] as $item ) {
					if ( isset( $item['option']['parent'] ) && $item['option']['parent'] === $section['name'] ) {
						$find = true;
						break;
					}
				}
				if ( $find ) {
					$wp_customize->add_panel(
						$section['name'],
						array(
							'priority'    => $priority,
							'title'       => $section['title'],
							'description' => $description,
						)
					);
				} else {
					$wp_customize->add_section(
						$section['name'],
						array(
							'priority'    => $priority,
							'title'       => $section['title'],
							'description' => $description,
						)
					);
				}
			}
		}
	}

	public function get_settings() {
		$builder  = App::get( 'customizer_builder' );
		$sections = $builder->build();
		$settings = array();
		$css      = wp_get_custom_css();
		$bg       = get_theme_mod( 'background_color' );
		foreach ( $sections['config'] as $section ) {
			foreach ( $section['config'] as $option ) {
				$name         = $option['name'];
				$description  = isset( $option['description'] ) ? $option['description'] : null;
				$updateMethod = isset( $option['updateMethod'] ) ? $option['updateMethod'] : 'theme_mod';
				$value        = $updateMethod === 'theme_mod' ? get_theme_mod( $name ) : get_option( $name );
				$type         = $option['type'];
				if ( $type === 'image' || $type === 'media' ) {
					continue;
				}
				$params = array(
					'name'         => $name,
					'value'        => $value,
					'type'         => $type,
					'updateMethod' => $updateMethod,
				);
				if ( isset( $option['default'] ) ) {
					$params['default'] = $option['default'];
				}
				$settings[] = $params;
			}
		}
		if ( $css ) {
			$settings[] = array(
				'name'         => 'custom_css',
				'updateMethod' => 'custom_css',
				'value'        => $css,
			);
		}
		if ( $bg ) {
			$settings[] = array(
				'name'         => 'background_color',
				'updateMethod' => 'theme_mod',
				'type'         => 'color',
				'value'        => $bg,
			);
		}
		return $settings;
	}

	public function settings( $wp_customize ) {
		$builder = App::get( 'customizer_builder' );
		$builder->setAttr( $wp_customize );
		$sections = $builder->build();
		foreach ( $sections['config'] as $section ) {
			foreach ( $section['config'] as $option ) {
				$description = isset( $option['description'] ) ? $option['description'] : null;

				$params = array(
					'settings'     => $option['name'],
					'label'        => isset( $option['title'] ) ? $option['title'] : '',
					'description'  => $description,
					'section'      => $section['name'],
					'updateMethod' => isset( $option['updateMethod'] ) ? $option['updateMethod'] : 'theme_mod',
					'sanitize'     => isset( $option['sanitize'] ) ? $option['sanitize'] : true,
					'choices'      => isset( $option['choices'] ) ? $option['choices'] : array(),
					'input_attrs'  => isset( $option['input_attrs'] ) ? $option['input_attrs'] : array(),
					'transport'    => isset( $option['transport'] ) ? $option['transport'] : 'refresh',
				);
				if ( isset( $option['default'] ) ) {
					$params['default'] = $option['default'];
				}
				$type = $option['type'];
				if ( $type === 'file' ) {
					$builder->file( $option['name'], $params );
				} elseif ( $type === 'color' ) {
					$builder->color( $option['name'], $params );
				} elseif ( $type === 'radio' ) {
					$builder->radio( $option['name'], $params );
				} elseif ( $type === 'number' ) {
					$builder->number( $option['name'], $params );
				} elseif ( $type === 'switch' ) {
					$builder->switch( $option['name'], $params );
				} elseif ( $type === 'select' ) {
					$builder->select( $option['name'], $params );
				} elseif ( $type === 'textarea' ) {
					$builder->textarea( $option['name'], $params );
				} elseif ( $type === 'url' ) {
					$builder->url( $option['name'], $params );
				} elseif ( $type === 'image' ) {
					$builder->image( $option['name'], $params );
				} elseif ( $type === 'media' ) {
					$builder->media( $option['name'], $params );
				} elseif ( $type === 'text' ) {
					$builder->textfield( $option['name'], $params );
				} elseif ( $type === 'checkbox' ) {
					$builder->checkbox( $option['name'], $params );
				}
			}
		}
	}
}
