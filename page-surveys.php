<?php get_header(); ?>
<div id="content" <?php column_class(); ?>>
    <div id="inner-content" class="wrap cf" style="justify-content: center;">
        <main id="main">
            <?php if (have_posts()):
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $scenic_args = array(
                    'post_type' => 'surveys',
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
                                    <section class="form step0 js-step" step="0">
                                        <section class="form-body">
                                            <h3 class="heading-3"><?php $step0_質問 = get_field('step0_質問');
                                            echo $step0_質問; ?></h3>
                                            <section class="step0-buttons">
                                                <button class="step0-button js-feel-btn js-guide-s0-1" value="<?php $step0_回答_1 = get_field('step0_回答_1');
                                                echo $step0_回答_1; ?>" step-to="1">
                                                    <?php $step0_回答_1 = get_field('step0_回答_1');
                                                    echo $step0_回答_1; ?>
                                                </button>
                                                <button class="step0-button js-feel-btn" value="<?php $step0_回答_2 = get_field('step0_回答_2');
                                                echo $step0_回答_2; ?>" step-to="1">
                                                    <?php $step0_回答_2 = get_field('step0_回答_2');
                                                    echo $step0_回答_2; ?>
                                                </button>
                                            </section>
                                        </section>
                                    </section>

                                    <section class="form step1 js-step hidden" step="1">
                                        <header class="form-stepper">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/step1.png" />
                                        </header>
                                        <section class="form-body">
                                            <h3 class="heading-3"><?php $step1_質問 = get_field('step1_質問');
                                            echo $step1_質問; ?></h3>
                                            <p class="heading-note">(複数選択可)</p>
                                            <section class="select-buttons mt-l js-guide-s1-1">
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_1 = get_field('step1_回答_1');
                                                echo $step1_回答_1; ?>">
                                                    <?php $step1_回答_1 = get_field('step1_回答_1');
                                                    echo $step1_回答_1; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_2 = get_field('step1_回答_2');
                                                echo $step1_回答_2; ?>">
                                                    <?php $step1_回答_2 = get_field('step1_回答_2');
                                                    echo $step1_回答_2; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_3 = get_field('step1_回答_3');
                                                echo $step1_回答_3; ?>">
                                                    <?php $step1_回答_3 = get_field('step1_回答_3');
                                                    echo $step1_回答_3; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_4 = get_field('step1_回答_4');
                                                echo $step1_回答_4; ?>">
                                                    <?php $step1_回答_4 = get_field('step1_回答_4');
                                                    echo $step1_回答_4; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_5 = get_field('step1_回答_5');
                                                echo $step1_回答_5; ?>">
                                                    <?php $step1_回答_5 = get_field('step1_回答_5');
                                                    echo $step1_回答_5; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_6 = get_field('step1_回答_6');
                                                echo $step1_回答_6; ?>">
                                                    <?php $step1_回答_6 = get_field('step1_回答_6');
                                                    echo $step1_回答_6; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_7 = get_field('step1_回答_7');
                                                echo $step1_回答_7; ?>">
                                                    <?php $step1_回答_7 = get_field('step1_回答_7');
                                                    echo $step1_回答_7; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_8 = get_field('step1_回答_8');
                                                echo $step1_回答_8; ?>">
                                                    <?php $step1_回答_8 = get_field('step1_回答_8');
                                                    echo $step1_回答_8; ?>
                                                </button>
                                            </section>
                                            <section class="step1-more-button-wrapper js-step1-more-button-wrapper">
                                                <button class="step1-more-button js-step1-more-button">
                                                    それ以外の資格 ▼
                                                </button>
                                            </section>
                                            <section class="select-buttons js-step1-additional-selectors hidden">

                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_9 = get_field('step1_回答_9');
                                                echo $step1_回答_9; ?>">
                                                    <?php $step1_回答_9 = get_field('step1_回答_9');
                                                    echo $step1_回答_9; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_10 = get_field('step1_回答_10');
                                                echo $step1_回答_10; ?>">
                                                    <?php $step1_回答_10 = get_field('step1_回答_10');
                                                    echo $step1_回答_10; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_11 = get_field('step1_回答_11');
                                                echo $step1_回答_11; ?>">
                                                    <?php $step1_回答_11 = get_field('step1_回答_11');
                                                    echo $step1_回答_11; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_12 = get_field('step1_回答_12');
                                                echo $step1_回答_12; ?>">
                                                    <?php $step1_回答_12 = get_field('step1_回答_12');
                                                    echo $step1_回答_12; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_13 = get_field('step1_回答_13');
                                                echo $step1_回答_13; ?>">
                                                    <?php $step1_回答_13 = get_field('step1_回答_13');
                                                    echo $step1_回答_13; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_14 = get_field('step1_回答_14');
                                                echo $step1_回答_14; ?>">
                                                    <?php $step1_回答_14 = get_field('step1_回答_14');
                                                    echo $step1_回答_14; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_15 = get_field('step1_回答_15');
                                                echo $step1_回答_15; ?>">
                                                    <?php $step1_回答_15 = get_field('step1_回答_15');
                                                    echo $step1_回答_15; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_16 = get_field('step1_回答_16');
                                                echo $step1_回答_16; ?>">
                                                    <?php $step1_回答_16 = get_field('step1_回答_16');
                                                    echo $step1_回答_16; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_17 = get_field('step1_回答_17');
                                                echo $step1_回答_17; ?>">
                                                    <?php $step1_回答_17 = get_field('step1_回答_17');
                                                    echo $step1_回答_17; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" key="qualifications" value="<?php $step1_回答_18 = get_field('step1_回答_18');
                                                echo $step1_回答_18; ?>">
                                                    <?php $step1_回答_18 = get_field('step1_回答_18');
                                                    echo $step1_回答_18; ?>
                                                </button>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s1-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <button class="next-button disabled js-s1-next-btn js-guide-s1-2"
                                                    step-to="2">次へ</button>
                                            </section>
                                        </footer>
                                    </section>

                                    <section class="form step2 js-step hidden" step="2">
                                        <header class="form-stepper">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/step2.png" />
                                        </header>
                                        <section class="form-body">
                                            <h3 class="heading-3"><?php $step2_質問 = get_field('step2_質問');
                                            echo $step2_質問; ?></h3>
                                            <section class="select-buttons mt-l js-guide-s2-1">
                                                <button class="btn select-button select-button-l js-select-button"
                                                    key="employmentType" value="<?php $step2_回答_1_text = get_field('step2_回答_1_text');
                                                    echo $step2_回答_1_text; ?>" to="3">
                                                    <img class="select-button-image-l" src="<?php $step2_回答_1_image = get_field('step2_回答_1_image');
                                                    echo $step2_回答_1_image; ?>" />
                                                    <?php $step2_回答_1_text = get_field('step2_回答_1_text');
                                                    echo $step2_回答_1_text; ?>
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button"
                                                    key="employmentType" value="<?php $step2_回答_2_text = get_field('step2_回答_2_text');
                                                    echo $step2_回答_2_text; ?>" to="3">
                                                    <img class="select-button-image-l" src="<?php $step2_回答_2_image = get_field('step2_回答_2_image');
                                                    echo $step2_回答_2_image; ?>" />
                                                    <?php $step2_回答_2_text = get_field('step2_回答_2_text');
                                                    echo $step2_回答_2_text; ?>
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button"
                                                    key="employmentType" value="<?php $step2_回答_3_text = get_field('step2_回答_3_text');
                                                    echo $step2_回答_3_text; ?>" to="3">
                                                    <img class="select-button-image-l" src="<?php $step2_回答_3_image = get_field('step2_回答_3_image');
                                                    echo $step2_回答_3_image; ?>" />
                                                    <?php $step2_回答_3_text = get_field('step2_回答_3_text');
                                                    echo $step2_回答_3_text; ?>
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button"
                                                    key="employmentType" value="<?php $step2_回答_4_text = get_field('step2_回答_4_text');
                                                    echo $step2_回答_4_text; ?>" to="3">
                                                    <img class="select-button-image-l" src="<?php $step2_回答_4_image = get_field('step2_回答_4_image');
                                                    echo $step2_回答_4_image; ?>" />
                                                    <?php $step2_回答_4_text = get_field('step2_回答_4_text');
                                                    echo $step2_回答_4_text; ?>
                                                </button>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s2-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn" step-to="1">
                                                    &lt;戻る
                                                </div>
                                                <div class="overlay hidden js-overlay js-guide-s2-overlay"></div>
                                                <div class="paging-button js-s2-next-btn js-guide-s2-2" step-to="3">
                                                    次の質問へ&gt;
                                                </div>
                                            </section>
                                        </footer>
                                    </section>

                                    <section class="form step4 js-step hidden" step="3">
                                        <header class="form-stepper">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/step3.png" />
                                        </header>
                                        <section class="form-body">
                                            <h3 class="heading-3">
                                                <?php $step3_質問 = get_field('step3_質問');
                                                echo $step3_質問; ?>
                                            </h3>
                                            <section class="select-buttons mt-l js-guide-s3-1">
                                                <button class="btn select-button select-button-l js-select-button" value="<?php $step3_回答_1_text = get_field('step3_回答_1_text');
                                                echo $step3_回答_1_text; ?>" key="relocationTiming" to="4">
                                                    <img class="select-button-image-l" src="<?php $step3_回答_1_image = get_field('step3_回答_1_image');
                                                    echo $step3_回答_1_image; ?>" />
                                                    <?php $step3_回答_1_text = get_field('step3_回答_1_text');
                                                    echo $step3_回答_1_text; ?>
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button" value="<?php $step3_回答_2_text = get_field('step3_回答_2_text');
                                                echo $step3_回答_2_text; ?>" key="relocationTiming" to="4">
                                                    <img class="select-button-image-l" src="<?php $step3_回答_2_image = get_field('step3_回答_2_image');
                                                    echo $step3_回答_2_image; ?>" />
                                                    <?php $step3_回答_2_text = get_field('step3_回答_2_text');
                                                    echo $step3_回答_2_text; ?>
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button" value="<?php $step3_回答_3_text = get_field('step3_回答_3_text');
                                                echo $step3_回答_3_text; ?>" key="relocationTiming" to="4">
                                                    <img class="select-button-image-l" src="<?php $step3_回答_3_image = get_field('step3_回答_3_image');
                                                    echo $step3_回答_3_image; ?>" />
                                                    <?php $step3_回答_3_text = get_field('step3_回答_3_text');
                                                    echo $step3_回答_3_text; ?>
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button" value="<?php $step3_回答_4_text = get_field('step3_回答_4_text');
                                                echo $step3_回答_4_text; ?>" key="relocationTiming" to="4">
                                                    <img class="select-button-image-l" src="<?php $step3_回答_4_image = get_field('step3_回答_4_image');
                                                    echo $step3_回答_4_image; ?>" />
                                                    <?php $step3_回答_4_text = get_field('step3_回答_4_text');
                                                    echo $step3_回答_4_text; ?>
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button" value="<?php $step3_回答_5_text = get_field('step3_回答_5_text');
                                                echo $step3_回答_5_text; ?>" key="relocationTiming" to="4">
                                                    <img class="select-button-image-l" src="<?php $step3_回答_5_image = get_field('step3_回答_5_image');
                                                    echo $step3_回答_5_image; ?>" />
                                                    <?php $step3_回答_5_text = get_field('step3_回答_5_text');
                                                    echo $step3_回答_5_text; ?>
                                                </button>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s3-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn" step-to="2">
                                                    &lt;戻る
                                                </div>
                                                <div class="paging-button js-s3-next-btn js-guide-s3-2" step-to="4">
                                                    次の質問へ&gt;
                                                </div>
                                            </section>
                                        </footer>
                                    </section>

                                    <section class="form step4 js-step hidden" step="4">
                                        <header class="form-stepper">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/step3.png" />
                                        </header>
                                        <section class="form-body">
                                            <h3 class="heading-3">
                                                <?php $step3_質問_転職回数 = get_field('step3_質問_転職回数');
                                                echo $step3_質問_転職回数; ?>
                                            </h3>
                                            <section class="input-wrapper">
                                                <select class="input js-job-change-input js-guide-s4-1" key="pastJobChanges">
                                                    <option value="">---</option>
                                                    <option value="0回">0回</option>
                                                    <option value="1回">1回</option>
                                                    <option value="2回">2回</option>
                                                    <option value="3回">3回</option>
                                                    <option value="4回">4回</option>
                                                    <option value="4回">4回</option>
                                                    <option value="6回">6回</option>
                                                    <option value="7回">7回</option>
                                                    <option value="8回">8回</option>
                                                    <option value="9回">9回</option>
                                                    <option value="10回">10回</option>
                                                    <option value="ll回以上">11回以上</option>
                                                </select>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s4-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn" step-to="3">
                                                    &lt;戻る
                                                </div>
                                                <div class="paging-button js-s4-next-btn js-guide-s4-2" step-to="5">
                                                    次の質問へ&gt;
                                                </div>
                                            </section>
                                        </footer>
                                    </section>

                                    <section class="form step5 js-step hidden" step="5">
                                        <header class="form-stepper">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/step4.png" />
                                        </header>
                                        <section class="form-body">
                                            <h3 class="heading-3"><?php $step4_質問 = get_field('step4_質問');
                                            echo $step4_質問; ?></h3>
                                            <section class="select-buttons mt-l js-guide-s5-1">
                                                <button
                                                    class="btn select-button select-button-flex select-button-w100 js-select-button"
                                                    value="<?php $step4_回答_1 = get_field('step4_回答_1');
                                                    echo $step4_回答_1; ?>" key="currentJobStatus" to="6">
                                                    <?php $step4_回答_1 = get_field('step4_回答_1');
                                                    echo $step4_回答_1; ?>
                                                </button>
                                                <button
                                                    class="btn select-button select-button-flex select-button-w100 js-select-button"
                                                    value="<?php $step4_回答_2 = get_field('step4_回答_2');
                                                    echo $step4_回答_2; ?>" key="currentJobStatus" to="6">
                                                    <?php $step4_回答_2 = get_field('step4_回答_2');
                                                    echo $step4_回答_2; ?>
                                                </button>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s5-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn" step-to="4">
                                                    &lt;戻る
                                                </div>
                                                <div class="paging-button js-s5-next-btn js-guide-s5-2" step-to="6">
                                                    次の質問へ&gt;
                                                </div>
                                            </section>
                                        </footer>
                                    </section>

                                    <section class="form step6 js-step hidden" step="6">
                                        <header class="form-stepper">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/step4.png" />
                                        </header>
                                        <section class="form-body">
                                            <h3 class="heading-3">
                                                <?php $step4_2_質問 = get_field('step4_2_質問');
                                                echo $step4_2_質問; ?>
                                            </h3>
                                            <section class="select-buttons mt-l js-guide-s6-1">
                                                <button class="btn select-button select-button-l js-select-button" value="<?php $step4_2_回答_1_text = get_field('step4_2_回答_1_text');
                                                echo $step4_2_回答_1_text; ?>" key="liftingOperations" to="7">
                                                    <img class="select-button-image-l" src="<?php $step4_2_回答_1_image = get_field('step4_2_回答_1_image');
                                                    echo $step4_2_回答_1_image; ?>" />
                                                    <?php $step4_2_回答_1_text = get_field('step4_2_回答_1_text');
                                                    echo $step4_2_回答_1_text; ?>
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button" value="<?php $step4_2_回答_2_text = get_field('step4_2_回答_2_text');
                                                echo $step4_2_回答_2_text; ?>" key="liftingOperations" to="7">
                                                    <img class="select-button-image-l" src="<?php $step4_2_回答_2_image = get_field('step4_2_回答_2_image');
                                                    echo $step4_2_回答_2_image; ?>" />
                                                    <?php $step4_2_回答_2_text = get_field('step4_2_回答_2_text');
                                                    echo $step4_2_回答_2_text; ?>
                                                </button>
                                                <button
                                                    class="btn select-button select-button-l select-button-w100 js-select-button"
                                                    value="<?php $step4_2_回答_3_text = get_field('step4_2_回答_3_text');
                                                    echo $step4_2_回答_3_text; ?>" key="liftingOperations" to="7">
                                                    <img class="select-button-image-l" src="<?php $step4_2_回答_3_image = get_field('step4_2_回答_3_image');
                                                    echo $step4_2_回答_3_image; ?>" />
                                                    <?php $step4_2_回答_3_text = get_field('step4_2_回答_3_text');
                                                    echo $step4_2_回答_3_text; ?>
                                                </button>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s6-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn" step-to="5">
                                                    &lt;戻る
                                                </div>
                                                <button class="next-button disabled js-s6-next-btn js-guide-s6-2"
                                                    step-to="7">次へ</button>
                                            </section>
                                        </footer>
                                    </section>

                                    <section class="form step7 js-step hidden" step="7">
                                        <header class="form-stepper">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/step4.png" />
                                        </header>
                                        <section class="form-body">
                                            <h3 class="heading-3"><?php $step4_3_質問 = get_field('step4_3_質問');
                                            echo $step4_3_質問; ?>
                                            </h3>
                                            <p class="heading-note">
                                                <span class="text-red">※未選択でも、次のページへ進めます。</span>
                                            </p>
                                            <section class="select-buttons mt-l js-guide-s7-1">
                                                <button class="btn select-button js-multi-select-button" value="<?php $step4_3_回答_1 = get_field('step4_3_回答_1');
                                                echo $step4_3_回答_1; ?>" key="preferences">
                                                    <?php $step4_3_回答_1 = get_field('step4_3_回答_1');
                                                    echo $step4_3_回答_1; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="<?php $step4_3_回答_2 = get_field('step4_3_回答_2');
                                                echo $step4_3_回答_2; ?>" key="preferences">
                                                    <?php $step4_3_回答_2 = get_field('step4_3_回答_2');
                                                    echo $step4_3_回答_2; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="<?php $step4_3_回答_3 = get_field('step4_3_回答_3');
                                                echo $step4_3_回答_3; ?>" key="preferences">
                                                    <?php $step4_3_回答_3 = get_field('step4_3_回答_3');
                                                    echo $step4_3_回答_3; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="<?php $step4_3_回答_4 = get_field('step4_3_回答_4');
                                                echo $step4_3_回答_4; ?>" key="preferences">
                                                    <?php $step4_3_回答_4 = get_field('step4_3_回答_4');
                                                    echo $step4_3_回答_4; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="<?php $step4_3_回答_5 = get_field('step4_3_回答_5');
                                                echo $step4_3_回答_5; ?>" key="preferences">
                                                    <?php $step4_3_回答_5 = get_field('step4_3_回答_5');
                                                    echo $step4_3_回答_5; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="<?php $step4_3_回答_6 = get_field('step4_3_回答_6');
                                                echo $step4_3_回答_6; ?>" key="preferences">
                                                    <?php $step4_3_回答_6 = get_field('step4_3_回答_6');
                                                    echo $step4_3_回答_6; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="<?php $step4_3_回答_7 = get_field('step4_3_回答_7');
                                                echo $step4_3_回答_7; ?>" key="preferences">
                                                    <?php $step4_3_回答_7 = get_field('step4_3_回答_7');
                                                    echo $step4_3_回答_7; ?>
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="<?php $step4_3_回答_8 = get_field('step4_3_回答_8');
                                                echo $step4_3_回答_8; ?>" key="preferences">
                                                    <?php $step4_3_回答_8 = get_field('step4_3_回答_8');
                                                    echo $step4_3_回答_8; ?>
                                                </button>
                                                <button class="btn select-button select-button-w100 js-multi-select-button" value="<?php $step4_3_回答_9 = get_field('step4_3_回答_9');
                                                echo $step4_3_回答_9; ?>" key="preferences">
                                                    <?php $step4_3_回答_9 = get_field('step4_3_回答_9');
                                                    echo $step4_3_回答_9; ?>
                                                </button>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s7-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn" step-to="6">
                                                    &lt;戻る
                                                </div>
                                                <button class="next-button active js-step-btn js-guide-s7-2" step-to="8">次へ</button>
                                            </section>
                                        </footer>
                                    </section>

                                    <section class="form step8 js-step hidden" step="8">
                                        <header class="form-stepper">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/step5.png" />
                                        </header>
                                        <p class="not-public">※公開されません</p>
                                        <section class="form-body">
                                            <h3 class="heading-3">お住まいの郵便番号</h3>
                                            <p class="heading-note">（ハイフンなし7桁）</p>

                                            <section class="input-wrapper">
                                                <input class="input js-postalcode-input js-guide-s8-1" placeholder="例)1230000"
                                                    type="text" inputmode="numeric" pattern="[0-9\s]{7}" maxlength="7" />
                                            </section>

                                            <div class="address-form-wrapper">
                                                <section class="address-form-toggle-wrapper">
                                                    <button class="address-form-toggle js-address-form-toggle">
                                                        郵便番号がわからない場合はこちら
                                                    </button>
                                                </section>
                                                <section class="address-form js-address-form hidden">
                                                    <section class="input-wrapper">
                                                        <select class="input js-pref-input js-guide-s8-2">
                                                        </select>
                                                    </section>
                                                    <section class="input-wrapper">
                                                        <select class="input js-city-input js-guide-s8-3">
                                                            <option value="">都道府県を選択してください</option>
                                                        </select>
                                                    </section>
                                                    <section class="input-wrapper">
                                                        <input class="input js-address-input js-guide-s8-4" placeholder="番地・建物名" />
                                                    </section>
                                                </section>
                                            </div>
                                        </section>
                                        <section class="form-support-person">
                                            <section class="form-person-image">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/support_1.png">
                                            </section>
                                            <section class="form-person-balloon">
                                                お近くの求人情報をお届けいたします。<br />
                                                希望勤務エリアがある方は、ご登録後に<br />
                                                設定可能です。
                                            </section>
                                        </section>
                                        <p class="job-openings-count js-job-counter hidden" style="margin-bottom: 30px;">
                                            対象住所付近の最新求人数: <span class="text-pink">4274件</span>
                                        </p>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s8-error-label">入力してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn" step-to="7">
                                                    &lt;戻る
                                                </div>
                                                <div class="overlay hidden js-overlay js-guide-s8-overlay"></div>
                                                <button class="next-button disabled js-s8-next-btn js-guide-s8-5"
                                                    step-to="9">次へ</button>
                                            </section>
                                        </footer>

                                    </section>

                                    <section class="form step9 js-step hidden" step="9">
                                        <header class="form-stepper">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/step6.png" />
                                        </header>

                                        <p class="not-public">※公開されません</p>
                                        <section class="form-body">
                                            <h3 class="heading-3">お名前</h3>
                                            <p class="heading-note">（漢字）</p>

                                            <section class="input-wrapper">
                                                <input class="input js-input-name js-guide-s9-1" placeholder="例)山田太郎" />
                                            </section>

                                            <h3 class="heading-3">生まれ年</h3>
                                            <p class="heading-note">（西暦）</p>

                                            <section class="input-wrapper">
                                                <select class="input js-input-birth-year js-guide-s9-2">
                                                    <option value="">---</option>
                                                    <?php
                                                    $step6_birthStart = get_field('step6_生まれ年度制限スタート');
                                                    $birthEnd = get_field('step6_生まれ年度制限エンド');
                                                    for ($i = $step6_birthStart; $i <= $birthEnd; $i++) {
                                                        echo "<option value='" . $i . "年'>{$i}年</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </section>

                                            <section class="form-support-person">
                                                <section class="form-person-image">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/support_1.png">
                                                </section>
                                                <section class="form-person-balloon">
                                                    給与情報などがより正確にわかります。
                                                </section>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s9-error-label">入力してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn" step-to="8">
                                                    &lt;戻る
                                                </div>
                                                <div class="overlay hidden js-overlay js-guide-s9-overlay"></div>
                                                <button class="next-button disabled js-s9-next-btn js-guide-s9-3"
                                                    step-to="10">次へ</button>
                                            </section>
                                        </footer>
                                    </section>

                                    <section class="form step10 js-step hidden" step="10">
                                        <header class="form-stepper">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/step7.png" />
                                        </header>

                                        <p class="not-public">※公開されません</p>
                                        <section class="form-body">
                                            <h3 class="heading-3">携帯番号</h3>
                                            <p class="heading-note">（ハイフンなし10桁or11桁）</p>

                                            <section class="input-wrapper">
                                                <input type="tel" class="input js-input-tel js-guide-s10-1"
                                                    placeholder="例)09012345678" />
                                            </section>

                                            <h3 class="heading-3">メールアドレス</h3>
                                            <!-- <p class="heading-note">（任意）</p> -->

                                            <section class="input-wrapper">
                                                <input type="email" class="input js-input-email js-guide-s10-2"
                                                    placeholder="例)driver@gmail.com" />
                                            </section>

                                            <p class="job-openings-count js-job-counter hidden">
                                                ご入力いただいた情報に当てはまる求人数: <span class="text-pink">4274件</span>
                                            </p>

                                            <section class="form-support-person">
                                                <section class="form-person-image">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/support_2.png">
                                                </section>
                                                <section class="form-person-balloon">
                                                    <span class="js-balloon-name"></span>様のお住まいの都道府県で多数の新着求人が見つかりました。
                                                </section>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s10-error-label">入力してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn" step-to="9">
                                                    &lt;戻る
                                                </div>
                                                <div class="overlay hidden js-overlay js-guide-s10-overlay"></div>
                                                <button class="cv-button js-cv-btn js-guide-s10-3">
                                                    <span class="cv-tagline">利用規約と個人情報の取り扱いに同意の上</span>
                                                    <span class="cv-main-text">登録してスカウトを待つ</span>
                                                </button>
                                            </section>
                                            <section class="terms">
                                                <a href="<?php $step7_利用規約_link = get_field('step7_利用規約_link'); echo $step7_利用規約_link;?>" target="_blank">利用規約</a>
                                                /
                                                <a href="<?php $step7_個人情報の取扱_link = get_field('step7_個人情報の取扱_link'); echo $step7_個人情報の取扱_link;?>" target="_blank">個人情報の取扱</a>
                                            </section>
                                        </footer>
                                    </section>
                                    <!--end-->
                                </section>
                                <div class="guide-arrow js-guide-arrow hidden">
                                    <div class="guide-arrow-anim"><img
                                            src="<?php echo get_template_directory_uri(); ?>/assets/img/arrow.png" /></div>
                                </div>
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