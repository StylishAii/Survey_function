<?php
/*
	このファイルはトップページのヘッダー下にアイキャッチ画像を表示させるためのものです。
 * カスタマイザーから画像やテキストを変更できます
 */
	// カスタマイザーでヘッダー画像（分割なし）を選択
if ( get_option( 'header_image_checkbox' ) && ! is_paged() ) :
	if ( get_option( 'only_show_headerimg' ) ) :
		// 画像のみ表示
		?>
	<div class="
		<?php
		if ( get_option( 'limit_header_width' ) ) {
			echo 'maximg center';
		} else {
			echo 'center';}
		?>
	">
		<?php
		$src = esc_url( get_option( 'original_image_upload' ) );
		?>
	<img src="<?php echo $src; ?>" <?php sng_echo_image_size( $src ); ?> />
	</div>
<?php else : // ボタン・テキストも表示する場合 ?>
	<div id="header-image" class="header-image 
	<?php
	if ( get_option( 'limit_header_width' ) ) {
		echo 'maximg';}
	?>
	" style="background-image: url(<?php echo esc_url( get_option( 'original_image_upload' ) ); ?>);">
	<div class="header-image__text">
		<?php if ( get_option( 'header_big_txt' ) ) : ?>
		<p class="header-image__headline dfont"><?php echo get_option( 'header_big_txt' ); ?></p>
		<?php endif; ?>
		<?php if ( get_option( 'header_sml_txt' ) ) : ?>
		<p class="header-image__descr"><?php echo get_option( 'header_sml_txt' ); ?></p>
		<?php endif; ?>
		<?php if ( get_option( 'header_btn_txt' ) ) : ?>
		<p class="header-image__btn"><a class="raised rippler rippler-default" href="<?php echo esc_url( get_option( 'header_btn_url' ) ); ?>" style="background: <?php echo get_theme_mod( 'header_btn_color', '#ff90a1' ); ?>;"><?php echo get_option( 'header_btn_txt' ); ?></a></p>
		<?php endif; ?>
	</div>
	</div>
	<?php
	endif; // END画像のみ表示するオプション
	endif; // END ヘッダー画像のカスタマイザー
?>
<?php
	// 2分割ヘッダー
if ( get_option( 'header_divide_checkbox' ) && ! is_paged() ) :
	?>
	<div id="divheader" class="divheader maximg" style="background: <?php echo get_theme_mod( 'divide_background_color', '#93d1f0' ); ?>;">
	<div class="divheader__img">
	<?php
		$src = esc_url( get_option( 'divheader_image_upload' ) );
	?>
		<img src="<?php echo $src; ?>" <?php sng_echo_image_size( $src ); ?> />
	</div>
	<div class="divheader__text">
		<?php if ( get_option( 'divheader_big_txt' ) ) : ?>
		<p class="divheader__headline" style="color: <?php echo get_theme_mod( 'divide_bigtxt_color', '#FFF' ); ?>;"><?php echo get_option( 'divheader_big_txt' ); ?></p>
		<?php endif; ?>
		<?php if ( get_option( 'divheader_sml_txt' ) ) : ?>
		<p class="divheader__descr" style="color: <?php echo get_theme_mod( 'divide_smltxt_color', '#FFF' ); ?>;"><?php echo get_option( 'divheader_sml_txt' ); ?></p>
		<?php endif; ?>
		<?php if ( get_option( 'divheader_btn_txt' ) ) : ?>
		<p class="divheader__btn"><a class="raised rippler rippler-default" href="<?php echo esc_url( get_option( 'divheader_btn_url' ) ); ?>" style="background: <?php echo get_theme_mod( 'divide_btn_color', '#009EF3' ); ?>;"><?php echo get_option( 'divheader_btn_txt' ); ?></a></p>
		<?php endif; ?>
	</div>
	</div>
<?php endif; ?>
