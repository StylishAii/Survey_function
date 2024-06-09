<?php
use SANGO\App;

$should_show_footer = App::get('layout')->should_render_footer();
if ($should_show_footer) {
  App::get('layout')->render_footer();
}
do_action('sng_before_footer');
?>
</div> <!-- id="container" -->
<?php footer_nav_menu(); // モバイルフッターメニュー ?>
<?php go_top_btn(); // トップへ戻るボタン ?>
<?php wp_footer(); ?>
</body>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/prefCity.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/companyModal.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/endpoint.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/app.js"></script>

</html>