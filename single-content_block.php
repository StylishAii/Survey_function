<?php

use SANGO\App;

$content_block = App::get('content-block');
  /* コンテンツブロックのプレビューページ */
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <?php do_action('sng_set_status'); ?>
    <?php wp_head(); ?>
    <style>
    .sng-cb {
      position: relative;
    }
    :root {
      --wp--custom--wrap--max-width: 700px;
    }
    .toc {
      display: none;
    }
    .entry-content {
      max-width: 1300px;
      padding: 0 15px;
    }
    .page-forfront .alignfull {
      width: 100vw;
      margin-left: calc(50% - 50vw + var(--sgb-scroll-bar-width, 0) / 2);
      max-width: calc(100vw - var(--sgb-scroll-bar-width, 0)) !important;
    }
    @media screen and (max-width: 700px) {
      .sgb-full-bg__content {
        padding-right: 15px;
        padding-left: 15px;
        margin-right: 0;
        margin-left: 0 !important;
      }
    }
    </style>
  </head>
  <body <?php body_class(); ?>>
    <div class="page-forfront">
      <div class="entry-content">
        <div style="width: 100%;">
          <div style="margin-top: 2rem; padding: 1rem; font-size: 0.8em; color: rgba(0, 12, 30, 0.45); background: #f2f5f9;">
            <i class="fa fa-play-circle" style="color: #70b7ff"></i>
            コンテンツブロック「<?php the_title(); ?>」のプレビュー
          </div>
        </div>
      </div>
      <?php echo $content_block->get_content_block( get_the_ID(), 'entry-content' ); ?>
    </div>
    <?php wp_footer(); ?>
  </body>
</html>
