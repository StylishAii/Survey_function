<?php

namespace SANGO;

use SangoBlocks\App as SangoBlocksApp;

class Import {

	public function init() {}

	public function import( $data, $options ) {
		$updateIfExist     = $options['updateIfExist'];
		$clearBeforeUpdate = isset( $options['clearBeforeUpdate'] ) ? $options['clearBeforeUpdate'] : false;
		$preset            = $options['preset'];
		$format            = $options['format'];
		$color             = $options['color'];
		$share             = $options['share'];
		$variation         = $options['variation'];
		$top               = $options['top'];
		$widget            = $options['widget'];
		$customizer        = $options['customizer'];
		$contentBlock      = $options['contentBlock'];
		$contentBlockMaps  = array();

		if ( isset( $data['preset'] ) && $preset ) {
			SangoBlocksApp::get( 'preset' )->import( $data['preset'], $updateIfExist );
		}
		if ( isset( $data['format'] ) && $format ) {
			SangoBlocksApp::get( 'format' )->import( $data['format'], $updateIfExist );
		}
		if ( isset( $data['color'] ) && $color ) {
			SangoBlocksApp::get( 'color' )->import( $data['color'], $updateIfExist );
		}
		if ( isset( $data['share'] ) && $share ) {
			SangoBlocksApp::get( 'share' )->import( $data['share'], $updateIfExist );
		}
		if ( isset( $data['variation'] ) && $variation ) {
			SangoBlocksApp::get( 'variation' )->import( $data['variation'], $updateIfExist );
		}
		if ( isset( $data['widget'] ) && $widget ) {
			App::get( 'widget' )->import( $data['widget'], $clearBeforeUpdate );
		}
		if ( isset( $data['contentBlock'] ) && $contentBlock ) {
			$contentBlockMaps = App::get( 'content-block' )->import( $data['contentBlock'] );
		}
		if ( isset( $data['customizer'] ) && $customizer ) {
			App::get( 'customizer' )->import( $data['customizer'], $contentBlockMaps );
		}
		if ( isset( $data['top'] ) && $top ) {
			$topPage = $data['top'];
			global $user_ID;

			$content = preg_replace( '/\\"/', '"', $topPage['post_content'] );
			$content = preg_replace( '/ "/', '"', $content );

			remove_filter( 'content_save_pre', 'wp_filter_post_kses' );
			$post_id = wp_insert_post(
				wp_slash(
					array(
						'post_date'     => date( 'Y-m-d H:i:s' ),
						'post_content'  => $content,
						'post_title'    => $topPage['post_title'],
						'post_name'     => $topPage['post_name'],
						'post_type'     => $topPage['post_type'],
						'post_author'   => $user_ID,
						'post_status'   => 'publish',
						'post_category' => array( 0 ),
					)
				)
			);
			update_option( 'page_on_front', $post_id );
			update_option( 'show_on_front', 'page' );
			if ( isset( $data['top_meta'] ) ) {
				foreach ( $data['top_meta'] as $key => $value ) {
					$result = update_post_meta( $post_id, $key, $value );
				}
			}
		}
	}
}
