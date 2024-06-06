<?php
/**
 * REST API
 */

use SangoBlocks\App;
use Embed\Embed;

App::get( 'rest' )->register(
	array(
		'path'       => 'ogp',
		'methods'    => 'GET',
		'only_login' => true,
		'callback'   => function ( $req ) {
			include_once ABSPATH . 'wp-includes/media.php';
			$params = $req->get_params();
			$url = $params['url'];
			$info = Embed::create( $url );
			$providers = $info->getProviders();
			$opengraph = $providers['opengraph'];
			$width = 0;
			$height = 0;
			$image_url = '';
			if ( isset( $info->image ) ) {
				try {
					$image = $info->image;
					$file   = pathinfo( $image );
					$filename = md5( $image );
					$upload = wp_upload_dir();
					$ext    = empty( $file['extension'] ) ? '' : $file['extension'];
					$ext = preg_replace( '/\?(.*?)=(.*?)$/', '', $ext );
					$dest = $upload['basedir'] . '/sng/' . "$filename.$ext";
					$image_url = $upload['baseurl'] . '/sng/' . "$filename.$ext";
					$editor = wp_get_image_editor( $image );
					$editor->resize( 600, 600, false ); // false => クロップせずに最大600pxにリサイズ
					$editor->save( $dest );
					$size = $editor->get_size();
					$width = $size['width'];
					$height = $size['height'];
				} catch ( Exception $e ) {
					// 画像の加工に失敗した場合は、そのままの画像を表示する
					$image_url = $info->image;
					$size = getimagesize( $image_url );
					$width = $size[0];
					$height = $size[1];
				}
			}

			$meta = array(
				'title'              => $info->title,
				'description'        => $info->description,
				'imageUrl'           => $image_url,
				'siteName'           => $opengraph->getProviderName(),
				'imageNaturalWidth'  => $width,
				'imageNaturalHeight' => $height,
			);
			return $meta;
		},
	)
);
