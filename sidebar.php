<?php if(sng_is_sidebar_shown() || is_active_fixed_sidebar()): ?>
  <div id="sidebar1" class="sidebar" role="complementary">
    <aside class="insidesp">
      <?php if( sng_is_sidebar_shown() ) : ?>
        <div id="notfix" class="normal-sidebar">
          <?php dynamic_sidebar( 'sidebar1' ); ?>
        </div>
      <?php endif; ?>
      <?php if( is_active_fixed_sidebar() ) : // 追尾のサイドバー ?>
        <div id="fixed_sidebar" class="fixed-sidebar">
          <?php dynamic_sidebar( 'fixed_sidebar' ); ?>
        </div>
      <?php endif;?>
    </aside>
  </div>
<?php endif; ?>