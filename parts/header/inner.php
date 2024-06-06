<div id="inner-header" class="wrap">
	<?php
	$status = \SANGO\App::get( 'status' )->get_status();
	// トップページのみタイトルをh1に
	$title_tag = $status['is_top'] ? 'h1' : 'div';
	$src       = esc_url( get_option( 'logo_image_upload' ) );
	$media_id  = get_option( 'logo_image_media_upload' );
	$width     = '';
	$height    = '';
	$media_url = '';
	if ( $media_id ) {
			$media_url  = esc_url_raw( wp_get_attachment_url( $media_id ) );
			$image_data = wp_get_attachment_metadata( $media_id );
		if ( $image_data ) {
			$width  = $image_data['width'];
			$height = $image_data['height'];
		}
	}
	?>
	<<?php echo $title_tag; ?> id="logo" class="header-logo h1 dfont">
	<a href="<?php echo home_url( '/' ); ?>" class="header-logo__link">
		<?php if ( get_option( 'logo_image_media_upload' ) ) : ?>
		<img src="<?php echo $media_url; ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="header-logo__img">
		<?php elseif ( get_option( 'logo_image_upload' ) ) : ?>
		<img src="<?php echo $src; ?>" alt="<?php bloginfo( 'name' ); ?>" <?php sng_echo_header_logo_size( $src ); ?> class="header-logo__img">
		<?php endif; ?>
		<?php
		if ( ! get_option( 'onlylogo_checkbox' ) ) {
			bloginfo( 'name' );}
		?>
	</a>
	</<?php echo $title_tag; ?>>
	<?php
	// header検索
	get_template_part( 'parts/header/search' );
	?>
	<?php
	// PC用ヘッダーナビ
	if ( has_nav_menu( 'desktop-nav' ) ) {
		echo '<nav class="desktop-nav clearfix">';
		wp_nav_menu(
			array(
				'container'      => false,
				'theme_location' => 'desktop-nav',
				'depth'          => 2,
				'fallback_cb'    => '',
			)
		);
		echo '</nav>';
	}
	// END PC用ヘッダーナビ
	?>
</div>
<?php
	// モバイル用ヘッダーナビ
if ( wp_is_mobile() && has_nav_menu( 'mobile-nav' ) ) {
	echo '<nav class="mobile-nav">';
	wp_nav_menu(
		array(
			'container'      => false,
			'theme_location' => 'mobile-nav',
			'depth'          => 1,
			'fallback_cb'    => '',
		)
	);
	echo '</nav>';
}
	// END モバイル用ヘッダーナビ
?>