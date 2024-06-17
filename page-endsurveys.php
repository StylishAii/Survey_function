<?php get_header(); ?>
<div id="content" <?php column_class(); ?>>
    <div id="inner-content" class="wrap cf" style="justify-content: center;">
        <main id="main">
            <?php if (have_posts()):
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $scenic_args = array(
                    'post_type' => 'endsurveys',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'paged' => $paged
                );
                $scenic = new WP_Query($scenic_args);
                if ($scenic->have_posts()):
                    while ($scenic->have_posts()):
                        $scenic->the_post();
                        ?>
                        <article id="entry" <?php post_class(); ?>>

                            <div class="entry-content">
                                <section class="card">
                                    <section class="form step11 js-step" step="11">
                                        <section class="form-body">
                                            <h3 class="heading-result">
                                                <?php $completedtitle = get_field('completedtitle'); echo $completedtitle;?>
                                                <!-- 無料転職サポートへのお申し込み ありがとうございました！ -->
                                            </h3>
                                            <p class="result-description">
                                                <?php $completedcontent = get_field('completedcontent'); echo $completedcontent;?>
                                                <!-- この後、転職コンサルタントの携帯番号よりお電話を差し上げます。
                                                お電話ではご希望の転職時期や条件、興味のある求人をお伺いいたします。
                                                転職の相談だけでも結構です。決して無理に転職を勧めることは致しませんのでご安心ください。 -->
                                                <br />
                                            </p>
                                        </section>
                                    </section>
                                </section>
                            </div>
                        </article>
                    </main>
                </div>
            </div>

            <?php
                    endwhile;
                else:
                    echo '<p style="font-size: 16px">投稿がありません。</p>';
                endif;
                wp_reset_postdata();
            endif;
            ?>

<?php get_footer(); ?>