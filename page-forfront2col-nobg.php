<?php
/**
* Template Name: トップページ用 サイドバー有（タイトル、背景色など出力無し）
* Template Post Type: page
*/
use SANGO\App;
get_header();
$status = App::get('status')->get_status();

?>
<?php if ( $status['is_top'] ) : ?>
  <?php get_template_part('parts/home/featured-header'); ?>
<?php endif; ?>
  <?php get_template_part('parts/home/top-header'); ?>
  <div id="content"<?php column_class();?>>
    <div id="inner-content" class="wrap">
      <main id="main">
        <?php
        sng_category_query();
        if (have_posts()) :
          while (have_posts()) :
            the_post(); ?>
            <article id="entry" <?php post_class(); ?>>
              <section class="entry-content entry-content--2cols">
                <?php
                  the_content();
                  wp_link_pages( array(
                    'before'      => '<div class="post-page-links dfont">',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                  ) );
                  sng_set_post_views(get_the_ID());
                ?>
                </section>
            </article>
          <?php endwhile; ?>
        <?php else : ?>
          <?php get_template_part('content', 'not-found'); ?>
        <?php endif; ?>
      </main>
      <?php get_sidebar(); ?>
    </div>
  </div>
<?php get_footer(); ?>
