<?php
/*
* Template Name: 投稿ID/カテゴリーIDチェック用
* Template Post Type: page
** このファイルは、サイト内のカテゴリーIDと投稿IDを一覧で出力するページです。
** 関連記事のショートコードを使う際に便利なのではないかと思います。
** 固定ページ作成時にパーマリンクを「allpostsid」とするとこのファイルが読み込まれます。
** 下書きなどに保存し、プレビューで見て使うのが良いのではないでしょうか。
** 詳細：https://saruwakakun.com/sango/all-ids
*/
?>
<!doctype html>
<html lang="ja">
  <head>
    <meta name='robots' content='noindex,nofollow' />
    <style>
      a {
        text-decoration: none;
        color: gray;
      }
    </style>
  </head>
  <body>
    <h1>カテゴリーIDと投稿ID一覧</h1>
    <p>「Ctrl」+「F」の検索ショートカットを使って、記事タイトル名で探すと楽だと思います（Macなら⌘ + F）。</p>
    <?php
      $categories = get_categories();
      foreach($categories as $category) :
    ?>
    <h2>
      「<a href="<?php echo get_category_link( $category->term_id ); ?>"><?php echo $category->cat_name; ?></a>」のカテゴリーIDは「<?php echo $category->term_id; ?>」
    </h2>
      <ul>
        <?php query_posts('cat='.$category->cat_ID.'&posts_per_page=500'); ?>
        <?php if (have_posts()) : ?>
          <?php while (have_posts()) : the_post(); ?>
            <li>
              「<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>」の投稿IDは「<span style="color:skyblue"><?php echo get_the_ID(); ?></span>」
            </li>
          <?php endwhile; ?>
        <?php endif; ?>
      </ul>
    <?php endforeach; ?>
  </body>
</html>
