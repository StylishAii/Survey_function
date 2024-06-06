<?php


if ( ! function_exists( 'sng_normal_link' ) ) {
	function sng_normal_link( $atts ) {
		$output = '';
		$ids    = isset( $atts['id'] ) ? explode( ',', $atts['id'] ) : null;
		if ( ! $ids ) {
			return '';
		}
		$target             = isset( $atts['target'] ) ? ' target="_blank"' : '';
		$is_date            = isset( $atts['is_date'] ) && $atts['is_date'];
		$is_alternate_title = isset( $atts['is_alternate_title'] ) && $atts['is_alternate_title'];

		foreach ( $ids as $eachid ) {
			list($url, $title, $img, $date) = sng_get_entry_link_data( $eachid, 'thumb-520', $is_date );
			if ( $is_alternate_title ) {
				$title = get_post_meta( $eachid, 'sng_alternate_title', true ) ?: $title;
			}
			if ( $url && $title ) {
				$output .= <<<EOF
<p>
<a href="{$url}"{$target}>
  {$title}
</a>
</p>
EOF;
			} // endif
		} // end foreach
		return $output;
	}
}

register_block_type(
	'sgb/kanren',
	array(
		'editor_script'   => 'sgb',
		'attributes'      => array(
			'id'                 => array(
				'type'    => 'number',
				'default' => -1,
			),
			'target'             => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'showDate'           => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'showAlternateTitle' => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'type'               => array(
				'type'    => 'string',
				'default' => 'sng_entry_link',
			),
			'css'                => array(
				'type'    => 'string',
				'default' => '',
			),
			'js'                 => array(
				'type'    => 'string',
				'default' => '',
			),
			'scopedCSS'          => array(
				'type'    => 'string',
				'default' => '',
			),
			'adminCSS'           => array(
				'type'    => 'string',
				'default' => '',
			),
			'disableCSSAlert'    => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'customControls'     => array(
				'type'    => 'array',
				'default' => array(),
			),
			'blockId'            => array(
				'type'    => 'string',
				'default' => '',
			),
			'sharedId'           => array(
				'type'    => 'string',
				'default' => '',
			),
			'link'               => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'spaceBottom'        => array(
				'type'    => 'number',
				'default' => 0,
			),
			'mobileSpaceBottom'  => array(
				'type'    => 'number',
				'default' => 0,
			),
			'spaceBottomType'    => array(
				'type'    => 'string',
				'default' => 'em',
			),
		),
		'render_callback' => function ( $attributes ) {
			$show_date      = $attributes['showDate'];
			$id = $attributes['id'];
			$target = $attributes['target'];
			$type = $attributes['type'];
			$link = $attributes['link'];
			$alternate_title = $attributes['showAlternateTitle'];

			if ( ! $id ) {
				return '';
			}

			$option = array(
				'is_date'            => $show_date,
				'is_alternate_title' => $alternate_title,
				'id'                 => $id,
			);

			if ( $target ) {
				$option = array_merge( $option, array( 'target' => true ) );
			}

			if ( $link ) {
				return sng_normal_link( $option );
			}

			if ( $type === 'sng_card_link' ) {
				return sng_card_link( $option );
			}

			if ( $type === 'sng_longcard_link' ) {
				return sng_longcard_link( $option );
			}
			return sng_entry_link( $option );
		},
	)
);
