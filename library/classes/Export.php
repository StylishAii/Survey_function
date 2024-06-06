<?php

namespace SANGO;

use SangoBlocks\App as SangoBlocksApp;

class Export {

	public function init() {}

	public function export( $options ) {
		$results = array();
		if ( $options['preset'] ) {
			$results['preset'] = SangoBlocksApp::get( 'preset' )->get_all();
		}
		if ( $options['format'] ) {
			$results['format'] = SangoBlocksApp::get( 'format' )->get();
		}
		if ( $options['color'] ) {
			$results['color'] = SangoBlocksApp::get( 'color' )->get();
		}
		if ( $options['variation'] ) {
			$results['variation'] = SangoBlocksApp::get( 'variation' )->get_all();
		}
		if ( $options['top'] ) {
			$front_id = get_option( 'page_on_front' );
			if ( $front_id ) {
				$post           = get_post( $front_id );
				$results['top'] = $post;
				$metas          = get_post_meta( $front_id );
				$top_meta       = array();
				foreach ( $metas as $key => $meta ) {
					$top_meta[ $key ] = $meta[0];
				}
				$results['top_meta'] = $top_meta;
			}
		}
		if ( $options['widget'] ) {
			$results['widget'] = App::get( 'widget' )->export();
		}
		if ( $options['contentBlock'] ) {
			$results['contentBlock'] = App::get( 'content-block' )->available_content_blocks();
		}
		if ( $options['customizer'] ) {
			$results['customizer'] = App::get( 'customizer' )->export();
		}
		if ( $options['share'] ) {
			$results['share'] = SangoBlocksApp::get( 'share' )->get_all();
		}
		return $results;
	}
}
