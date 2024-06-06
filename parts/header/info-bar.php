<?php
	// ヘッダーお知らせ欄
if ( get_option( 'header_info_text' ) ) :
	?>
	<div class="header-info 
	<?php
	if ( get_option( 'enable_header_info_animation' ) ) {
		echo 'animated';}
	?>
	">
	<a href="<?php echo get_option( 'header_info_url' ); ?>">
	<?php echo get_option( 'header_info_text' ); ?>
	</a>
	</div>
	<?php
	endif;
?>