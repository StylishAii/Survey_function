<?php

namespace SANGO;

use WP_Customize_Image_Control;
use WP_Customize_Media_Control;
use WP_Customize_Color_Control;

class CustomizerBuilder extends Builder {
	public function textfield( $setting_id, $option ) {
		$sanitizer         = App::get( 'sanitize' );
		$updateMethod      = $option['updateMethod'];
		$sanitize          = isset( $option['sanitize'] ) ? $option['sanitize'] : true;
		$sanitize_callback = $sanitize ? 'wp_filter_nohtml_kses' : array( $sanitizer, 'dangerously_skip_sanitize' );
		$default_setting   = array(
			'type'              => $updateMethod,
			'sanitize_callback' => $sanitize_callback,
			'transport'         => $option['transport'],
		);
		if ( isset( $option['default'] ) ) {
			$default_setting['default'] = $option['default'];
		}
		$this->attr->add_setting(
			$setting_id,
			$default_setting
		);
		$this->attr->add_control(
			$setting_id,
			array(
				'settings'    => $setting_id,
				'label'       => $option['label'],
				'section'     => $option['section'],
				'type'        => 'text',
				'description' => $option['description'],
				'input_attrs' => $option['input_attrs'],
			)
		);
	}
	/**
	 * テキストエリア
	 */
	public function textarea( $setting_id, $option ) {
		$sanitizer         = App::get( 'sanitize' );
		$updateMethod      = $option['updateMethod'];
		$sanitize          = isset( $option['sanitize'] ) ? $option['sanitize'] : true;
		$sanitize_callback = $sanitize ? 'wp_kses_post' : array( $sanitizer, 'dangerously_skip_sanitize' );
		$default_setting   = array(
			'type'              => $updateMethod,
			'transport'         => $option['transport'],
			'sanitize_callback' => $sanitize_callback,
		);
		if ( isset( $option['default'] ) ) {
			$default_setting['default'] = $option['default'];
		}
		$this->attr->add_setting(
			$setting_id,
			$default_setting,
		);
		$this->attr->add_control(
			$setting_id,
			array(
				'settings'    => $setting_id,
				'label'       => $option['label'],
				'section'     => $option['section'],
				'type'        => 'textarea',
				'description' => $option['description'],
			)
		);
	}

	/**
	 * URL
	 */
	public function url( $setting_id, $option ) {
		$updateMethod    = $option['updateMethod'];
		$default_setting = array(
			'type'              => $updateMethod,
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => $option['transport'],
		);
		if ( isset( $option['default'] ) ) {
			$default_setting['default'] = $option['default'];
		}
		$this->attr->add_setting(
			$setting_id,
			$default_setting
		);
		$this->attr->add_control(
			$setting_id,
			array(
				'settings'    => $setting_id,
				'label'       => $option['label'],
				'section'     => $option['section'],
				'type'        => 'text',
				'description' => $option['description'],
			)
		);
	}
	/**
	 * チェックボックス
	 */
	public function checkbox( $setting_id, $option ) {
		$sanitize        = App::get( 'sanitize' );
		$updateMethod    = $option['updateMethod'];
		$default_setting = array(
			'type'              => $updateMethod,
			'sanitize_callback' => array( $sanitize, 'checkbox' ),
			'transport'         => $option['transport'],
		);
		$this->attr->add_setting(
			$setting_id,
			$default_setting,
		);
		$this->attr->add_control(
			$setting_id,
			array(
				'settings'    => $setting_id,
				'label'       => $option['label'],
				'section'     => $option['section'],
				'type'        => 'checkbox',
				'description' => $option['description'],
			)
		);
	}

	/**
	 * スイッチ
	 */
	public function switch( $setting_id, $option ) {
		$sanitize        = App::get( 'sanitize' );
		$updateMethod    = $option['updateMethod'];
		$default_setting = array(
			'type'              => $updateMethod,
			'sanitize_callback' => array( $sanitize, 'dangerously_skip_sanitize' ),
			'transport'         => $option['transport'],
		);
		if ( isset( $option['default'] ) ) {
			$default_setting['default'] = $option['default'];
		}
		$this->attr->add_setting(
			$setting_id,
			$default_setting
		);
		$this->attr->add_control(
			$setting_id,
			array(
				'settings'    => $setting_id,
				'label'       => $option['label'],
				'section'     => $option['section'],
				'type'        => 'radio',
				'description' => $option['description'],
				'choices'     => $option['choices'],
			)
		);
	}

	/**
	 * ラジオ
	 */
	public function radio( $setting_id, $option ) {
		$sanitize     = App::get( 'sanitize' );
		$updateMethod = $option['updateMethod'];
		$this->attr->add_setting(
			$setting_id,
			array(
				'type'              => $updateMethod,
				'sanitize_callback' => array( $sanitize, 'radio' ),
				'transport'         => $option['transport'],
				'default'           => $option['default'],
			)
		);
		$this->attr->add_control(
			$setting_id,
			array(
				'settings'    => $setting_id,
				'label'       => $option['label'],
				'section'     => $option['section'],
				'type'        => 'radio',
				'description' => $option['description'],
				'choices'     => $option['choices'],
			)
		);
	}
	/**
	 * Select
	 */
	public function select( $setting_id, $option ) {
		$sanitize     = App::get( 'sanitize' );
		$updateMethod = $option['updateMethod'];
		$this->attr->add_setting(
			$setting_id,
			array(
				'type'              => $updateMethod,
				'transport'         => $option['transport'],
				'sanitize_callback' => array( $sanitize, 'select' ),
				'default'           => isset( $option['default'] ) ? $option['default'] : '',
			)
		);
		$this->attr->add_control(
			$setting_id,
			array(
				'settings'    => $setting_id,
				'label'       => $option['label'],
				'section'     => $option['section'],
				'type'        => 'select',
				'description' => $option['description'],
				'choices'     => $option['choices'],
			)
		);
	}
	/**
	 * 数値
	 */
	public function number( $setting_id, $option ) {
		$updateMethod    = $option['updateMethod'];
		$default_setting = array(
			'type'              => $updateMethod,
			'transport'         => $option['transport'],
			'sanitize_callback' => 'absint',
		);
		if ( isset( $option['default'] ) ) {
			$default_setting['default'] = $option['default'];
		}
		$this->attr->add_setting(
			$setting_id,
			$default_setting
		);
		$this->attr->add_control(
			$setting_id,
			array(
				'settings'    => $setting_id,
				'label'       => $option['label'],
				'section'     => $option['section'],
				'type'        => 'number',
				'description' => $option['description'],
			)
		);
	}
	/**
	 * カラーピッカー
	 */
	public function color( $setting_id, $option ) {
		$updateMethod    = $option['updateMethod'];
		$default_setting = array(
			'type'              => $updateMethod,
			'transport'         => $option['transport'],
			'sanitize_callback' => 'sanitize_hex_color',
		);
		if ( isset( $option['default'] ) ) {
			$default_setting['default'] = $option['default'];
		}
		$this->attr->add_setting(
			$setting_id,
			$default_setting
		);
		$this->attr->add_control(
			new WP_Customize_Color_Control(
				$this->attr,
				$setting_id,
				array(
					'settings'    => $setting_id,
					'label'       => $option['label'],
					'section'     => $option['section'],
					'description' => $option['description'],
				)
			)
		);
	}
	/**
	 * ファイルのアップロード
	 */
	public function file( $setting_id, $option ) {
		$updateMethod    = $option['updateMethod'];
		$sanitizer       = App::get( 'sanitize' );
		$default_setting = array(
			'type'              => $updateMethod,
			'transport'         => $option['transport'],
			'sanitize_callback' => array( $sanitizer, 'file' ),
		);
		if ( isset( $option['default'] ) ) {
			$default_setting['default'] = $option['default'];
		}
		$this->attr->add_setting(
			$setting_id,
			$default_setting
		);
	}

	public function image( $setting_id, $option ) {
		$updateMethod    = $option['updateMethod'];
		$sanitizer       = App::get( 'sanitize' );
		$default_setting = array(
			'type'              => $updateMethod,
			'sanitize_callback' => array( $sanitizer, 'file' ),
			'transport'         => $option['transport'],
		);
		if ( isset( $option['default'] ) ) {
			$default_setting['default'] = $option['default'];
		}
		$this->attr->add_setting(
			$setting_id,
			$default_setting
		);
		$this->attr->add_control(
			new WP_Customize_Image_Control(
				$this->attr,
				$setting_id,
				array(
					'settings'    => $setting_id,
					'label'       => $option['label'],
					'section'     => $option['section'],
					'description' => $option['description'],
				)
			)
		);
	}

	public function media( $setting_id, $option ) {
		$updateMethod    = $option['updateMethod'];
		$sanitizer       = App::get( 'sanitize' );
		$default_setting = array(
			'type'              => $updateMethod,
			'transport'         => $option['transport'],
			'sanitize_callback' => array( $sanitizer, 'dangerously_skip_sanitize' ),
		);
		if ( isset( $option['default'] ) ) {
			$default_setting['default'] = $option['default'];
		}
		$this->attr->add_setting(
			$setting_id,
			$default_setting
		);
		$this->attr->add_control(
			new WP_Customize_Media_Control(
				$this->attr,
				$setting_id,
				array(
					'settings'    => $setting_id,
					'label'       => $option['label'],
					'section'     => $option['section'],
					'description' => $option['description'],
				)
			)
		);
	}
}
