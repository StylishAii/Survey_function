<?php // 検索結果のテンプレート
  get_header(); 
?>
  <div id="content">
    <div id="inner-content" class="wrap cf">
      <main id="main" role="main">
        <h1 class="search-title"><?php fa_tag("search","search",false) ?>「<?php echo esc_attr(get_search_query()); ?>」の検索結果</h1>
        <?php get_template_part('parts/post-grid');//記事一覧?>
      </main>
      <?php get_sidebar(); ?>
    </div>
  </div>
<?php get_footer(); ?>
