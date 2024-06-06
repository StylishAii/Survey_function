<?php

use SangoBlocks\App;

$root_path = App::getRootPluginUrl();
$image_dir = $root_path . '/images';

register_block_type(
	'sgb/footer',
	array(
		'editor_script'   => 'sgb',
		'attributes'      => array(
			'className'          => array(
				'type'    => 'string',
				'default' => '',
			),
			'bgColor'            => array(
				'type'    => 'string',
				'default' => '#e0e4eb',
			),
			'contentWidth'       => array(
				'type'    => 'number',
				'default' => 1180,
			),
			'showCopyright'      => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'showRichFooter'     => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'copyrightBgColor'   => array(
				'type'    => 'string',
				'default' => '',
			),
			'copyrightTextColor' => array(
				'type'    => 'string',
				'default' => '',
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
			'sharedId'           => array(
				'type'    => 'string',
				'default' => '',
			),
			'blockId'            => array(
				'type'    => 'string',
				'default' => '',
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
			'align'              => array(
				'type'    => 'string',
				'default' => 'full',
			),
		),
		'render_callback' => function ( $attributes, $content ) {
			$bg_color = $attributes['bgColor'];
			$content_width = $attributes['contentWidth'];
			$show_copyright = $attributes['showCopyright'];
			$show_rich_footer = $attributes['showRichFooter'];
			$copyright_bg_color = $attributes['copyrightBgColor'];
			$copyright_text_color = $attributes['copyrightTextColor'];
			$appendClassName = $attributes['className'];
			$className = 'sgb-footer';
			$align = $attributes['align'];
			$html = '';
			$style = '';

			if ( $appendClassName ) {
				$className .= " {$appendClassName}";
			}

			if ( $align ) {
				$className .= " align{$align}";
			}

			if ( $copyright_bg_color ) {
				$style .= "background-color: {$copyright_bg_color};";
			}
			if ( $copyright_text_color ) {
				$style .= "--sgb-footer-copyright-text-color: {$copyright_text_color};";
			}

			if ( ! is_admin() && ! defined( 'REST_REQUEST' ) && $show_rich_footer ) {
				$html = "
        <footer class=\"{$className}\" style=\"background-color: {$bg_color};\">
          <div class=\"sgb-footer__content\" id=\"inner-footer\">
            {$content}
          </div>
          __replace_here__
        </footer>
      ";
			}

			if ( ! $show_copyright ) {
				$html = str_replace( '__replace_here__', '', $html );
				return $html;
			}

			ob_start();
			?>
	<div class="sgb-footer__menu align<?php echo $align; ?>" style="<?php echo $style; ?>">
		<div>
		<a class="sgb-footer__menu-btn dfont" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php fa_tag( 'home', 'home', false ); ?> HOME</a>
		</div>
		<nav>
			<?php
			wp_nav_menu(
				array(
					'container'       => 'div',
					'container_class' => 'sgb-footer__links',
					'menu'            => 'フッターリンクメニュー',
					'menu_class'      => 'nav sgb-footer__nav',
					'theme_location'  => 'footer-links',
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'depth'           => 0,
					'fallback_cb'     => 'sng_footer_links_fallback',
				)
			);
			?>
			<?php
			// プライバシーポリシー
			if ( function_exists( 'the_privacy_policy_link' ) ) {
				the_privacy_policy_link();
			}
			?>
		</nav>
		<p class="sgb-footer__copyright dfont">
		&copy; <?php echo date( 'Y' ); ?>
			<?php
			if ( get_option( 'rights_reserved' ) ) {
				echo get_option( 'rights_reserved' );
			} else {
				bloginfo( 'name' );
			}
			?>
		All rights reserved.
		</p>
	</div>
			<?php

			$copyright_html = ob_get_clean();

			if ( $html ) {
				$html = str_replace( '__replace_here__', $copyright_html, $html );
			} else {
				$html = $copyright_html;
			}

			return $html;
		},
	)
);
