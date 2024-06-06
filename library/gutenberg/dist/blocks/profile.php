<?php

use SangoBlocks\App;

$root_path = App::getRootPluginUrl();
$image_dir = $root_path . '/images';

register_block_type(
	'sgb/profile',
	array(
		'editor_script'   => 'sgb',
		'attributes'      => array(
			'id'                      => array(
				'type'    => 'number',
				'default' => -1,
			),
			'nl2br'                   => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'type'                    => array(
				'type'    => 'string',
				'default' => 'sng_entry_link',
			),
			'showSocials'             => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'useProfileSettings'      => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'profileUserName'         => array(
				'type'    => 'string',
				'default' => '',
			),
			'profileBackground'       => array(
				'type'    => 'string',
				'default' => $image_dir . '/default.jpg',
			),
			'profileBackgroundWidth'  => array(
				'type'    => 'number',
				'default' => 924,
			),
			'profileBackgroundHeight' => array(
				'type'    => 'number',
				'default' => 572,
			),
			'profileImg'              => array(
				'type'    => 'string',
				'default' => $image_dir . '/avatar.png',
			),
			'profileImgWidth'         => array(
				'type'    => 'number',
				'default' => 150,
			),
			'profileImgHeight'        => array(
				'type'    => 'number',
				'default' => 150,
			),
			'css'                     => array(
				'type'    => 'string',
				'default' => '',
			),
			'js'                      => array(
				'type'    => 'string',
				'default' => '',
			),
			'scopedCSS'               => array(
				'type'    => 'string',
				'default' => '',
			),
			'customControls'          => array(
				'type'    => 'array',
				'default' => array(),
			),
			'sharedId'                => array(
				'type'    => 'string',
				'default' => '',
			),
			'adminCSS'                => array(
				'type'    => 'string',
				'default' => '',
			),
			'disableCSSAlert'         => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'blockId'                 => array(
				'type'    => 'string',
				'default' => '',
			),
			'spaceBottom'             => array(
				'type'    => 'number',
				'default' => 0,
			),
			'mobileSpaceBottom'       => array(
				'type'    => 'number',
				'default' => 0,
			),
			'spaceBottomType'         => array(
				'type'    => 'string',
				'default' => 'em',
			),
			'bgColor'                 => array(
				'type'    => 'string',
				'default' => '',
			),
		),
		'render_callback' => function ( $attributes, $content ) {
			$id = $attributes['id'];
			$useProfileSettings = $attributes['useProfileSettings'];

			if ( ! function_exists( 'sng_show_profile' ) ) {
				return '';
			}

			if ( $useProfileSettings ) {
				return App::get( 'profile' )->render_user_by_id( $id, $attributes );
			}

			return App::get( 'profile' )->render_user_by_manual( $attributes, $content );
		},
	)
);
