<?php

use SANGO\App;

register_block_type(
	'sgb/header',
	array(
		'editor_script'   => 'sgb',
		'attributes'      => array(
			'className'         => array(
				'type'    => 'string',
				'default' => '',
			),
			'hasShadow'         => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'headerBgColor'     => array(
				'type'    => 'string',
				'default' => '#009EF3',
			),
			'headerColor'       => array(
				'type'    => 'string',
				'default' => '#fff',
			),
			'headerTitleColor'  => array(
				'type'    => 'string',
				'default' => '#fff',
			),
			'headerStyle'       => array(
				'type'    => 'string',
				'default' => 'left',
			),
			'isFixed'           => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'hasDrawer'         => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'hasSearch'         => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'hasTitle'          => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'hasLogo'           => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'hasMobileSearch'   => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'hasMobileNavi'     => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'css'               => array(
				'type'    => 'string',
				'default' => '',
			),
			'js'                => array(
				'type'    => 'string',
				'default' => '',
			),
			'scopedCSS'         => array(
				'type'    => 'string',
				'default' => '',
			),
			'adminCSS'          => array(
				'type'    => 'string',
				'default' => '',
			),
			'disableCSSAlert'   => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'customControls'    => array(
				'type'    => 'array',
				'default' => array(),
			),
			'blockId'           => array(
				'type'    => 'string',
				'default' => '',
			),
			'sharedId'          => array(
				'type'    => 'string',
				'default' => '',
			),
			'spaceBottom'       => array(
				'type'    => 'number',
				'default' => 0,
			),
			'mobileSpaceBottom' => array(
				'type'    => 'number',
				'default' => 0,
			),
			'spaceBottomType'   => array(
				'type'    => 'string',
				'default' => 'em',
			),
			'align'             => array(
				'type'    => 'string',
				'default' => 'full',
			),
		),
		'render_callback' => function ( $attributes, $content ) {
			if ( is_admin() ) {
				return;
			}
			$status = App::get( 'status' )->get_status();
			$className = 'sgb-header';
			$style = 'style="';
			$hasShadow = $attributes['hasShadow'];
			$isFixed = $attributes['isFixed'];
			$headerBgColor = $attributes['headerBgColor'];
			$headerColor = $attributes['headerColor'];
			$headerTitleColor = $attributes['headerTitleColor'];
			$headerStyle = $attributes['headerStyle'];
			$hasDrawer = $attributes['hasDrawer'];
			$hasSearch = $attributes['hasSearch'];
			$hasTitle = $attributes['hasTitle'];
			$hasLogo = $attributes['hasLogo'];
			$hasMobileNavi = $attributes['hasMobileNavi'];
			$hasMobileSearch = $attributes['hasMobileSearch'];
			$appendClassName = $attributes['className'];
			$titleTag = $status['is_top'] ? 'h1' : 'div';
			$innerClassName = 'sgb-header__inner';
			// "sgb-header__inner--default": headerStyle === "left",
			// "sgb-header__inner--center": headerStyle === "center",
			if ( $headerStyle === 'left' ) {
				$innerClassName .= ' sgb-header__inner--default';
			} elseif ( $headerStyle === 'center' ) {
				$innerClassName .= ' sgb-header__inner--center';
			}
			if ( ! $hasShadow ) {
				$className .= ' sgb-header--no-shadow';
			}
			if ( $isFixed ) {
				$className .= ' sgb-header--sticky';
			}

			if ( $hasSearch ) {
				$className .= ' sgb-header--has-search';
			}

			if ( $hasMobileSearch ) {
				$className .= ' sgb-header--has-mobile-search';
			}

			if ( $hasTitle ) {
				$className .= ' sgb-header--has-title';
			}

			if ( $hasLogo ) {
				$className .= ' sgb-header--has-logo';
			}

			if ( $appendClassName ) {
				$className .= ' ' . $appendClassName;
			}

			if ( $headerBgColor ) {
				$style .= 'background-color: ' . $headerBgColor . ';';
			}
			if ( $headerColor ) {
				$style .= 'color: ' . $headerColor . ';';
				$style .= '--sgb--header--nav-color: ' . $headerColor . ';';
			}
			if ( $headerTitleColor ) {
				$style .= '--sgb--header--title-color: ' . $headerTitleColor . ';';
			}

			$style .= '"';
			$nav_drawer = '';
			$search = '';
			$search_btn = '';

			if ( $hasDrawer ) {
				ob_start();
				get_template_part( 'parts/header/nav-drawer' );
				$nav_drawer = ob_get_clean();
			}

			ob_start();
			get_template_part( 'parts/header/search' );
			$search = ob_get_clean();

			$html = "
      <header class=\"$className\" $style>
        $nav_drawer
        $search
        <div class=\"$innerClassName\">
          $content
        </div>
      </header>
    ";

			$html = str_replace( '<h1', "<$titleTag", $html );
			$html = str_replace( '</h1', "</$titleTag", $html );

			if ( ! $hasTitle ) {
				$doc = new \DOMDocument();
				@$doc->loadHTML( '<?xml encoding="UTF-8">' . $html );
				$xpath = new \DomXPath( $doc );
				$logos = @$xpath->query( "//p[contains(@class, 'sgb-site-title')]" );
				foreach ( $logos as $logo ) {
					@$logo->parentNode->removeChild( $logo );
				}
				$html = @$doc->saveHTML();
				$html = str_replace( '<?xml encoding="UTF-8">', '', $html );
				$html = str_replace( '<html><body>', '', $html );
				$html = str_replace( '</body></html>', '', $html );
				$html = str_replace( '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">', '', $html );
			}

			if ( ! $hasLogo ) {
				$doc = new \DOMDocument();
				@$doc->loadHTML( '<?xml encoding="UTF-8">' . $html );
				$xpath = new \DomXPath( $doc );
				$logos = @$xpath->query( "//div[contains(@class, 'wp-block-site-logo')]" );
				foreach ( $logos as $logo ) {
					@$logo->parentNode->removeChild( $logo );
				}
				$html = @$doc->saveHTML();
				$html = str_replace( '<?xml encoding="UTF-8">', '', $html );
				$html = str_replace( '<html><body>', '', $html );
				$html = str_replace( '</body></html>', '', $html );
				$html = str_replace( '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">', '', $html );
			}

			if ( ! $hasMobileNavi ) {
				$doc = new \DOMDocument();
				@$doc->loadHTML( '<?xml encoding="UTF-8">' . $html );
				$xpath = new \DomXPath( $doc );
				$navis = @$xpath->query( "//div[contains(@class, 'sgb-header__mobile-nav')]" );
				foreach ( $navis as $navi ) {
					@$navi->parentNode->removeChild( $navi );
				}
				$html = @$doc->saveHTML();
				$html = str_replace( '<?xml encoding="UTF-8">', '', $html );
				$html = str_replace( '<html><body>', '', $html );
				$html = str_replace( '</body></html>', '', $html );
				$html = str_replace( '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">', '', $html );
			}

			return $html;
		},
	)
);
