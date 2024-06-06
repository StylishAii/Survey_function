<?php get_header(); ?>
<div id="content" <?php column_class(); ?>>
    <div id="inner-content" class="wrap cf">
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
                            <?php
                            get_template_part('parts/single/entry-header');
                            ?>
                            <div class="entry-content">


                                <section class="card">
                                    <section class="form step0 js-step">
                                        <section class="form-body">
                                            <h3 class="heading-3">
                                                <?php $question_first = get_field('question_first');
                                                echo $question_first;
                                                ?>
                                            </h3>
                                            <section class="step0-buttons">
                                                <?php $answer_first_first = get_field('answer_first_first');
                                                $answer_first_second = get_field('answer_first_second'); ?>
                                                <button class="step0-button js-feel-btn js-guide-s0-1"
                                                    value="<?php echo $answer_first_first; ?>">
                                                    <?php echo $answer_first_first; ?>
                                                </button>
                                                <button class="step0-button js-feel-btn"
                                                    value="<?php echo $answer_first_second; ?>">
                                                    <?php echo $answer_first_second; ?>
                                                </button>
                                            </section>
                                        </section>
                                    </section>



                                    <section class="form step1 js-step hidden">
                                        <header class="form-stepper">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/step1.png" />
                                        </header>
                                        <section class="form-body">
                                            <h3 class="heading-3"><?php $q_b = get_field('q_b');
                                            echo $q_b; ?></h3>
                                            <p class="heading-note">
                                                <?php $q_b_subtitle = get_field('q_b_subtitle');
                                                echo $q_b_subtitle; ?></p>

                                            <section class="select-buttons mt-l js-guide-s1-1">
                                                <button class="btn select-button js-multi-select-button" value="AT普通">
                                                    AT普通(H29/3以降)
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="AT(5t･8t限定)">
                                                    AT(5t･8t限定)
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="MT普通(H29/3以降)">
                                                    MT普通(H29/3以降)
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="MT準中型(5t限定)">
                                                    MT準中型(5t限定)
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="準中型免許">
                                                    準中型免許
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="MT中型(8t限定)">
                                                    MT中型(8t限定)
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="中型免許">
                                                    中型免許
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="大型免許">
                                                    大型免許
                                                </button>
                                            </section>
                                            <section class="step1-more-button-wrapper js-step1-more-button-wrapper">
                                                <button class="step1-more-button js-step1-more-button">
                                                    それ以外の資格 ▼
                                                </button>
                                            </section>
                                            <section class="select-buttons js-step1-additional-selectors hidden">
                                                <button class="btn select-button js-multi-select-button" value="普通二種">
                                                    普通二種
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="大型二種">
                                                    大型二種
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="けん引免許">
                                                    けん引免許
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="運行管理者(旅客)">
                                                    運行管理者(旅客)
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="運行管理者(貨物)">
                                                    運行管理者(貨物)
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="玉掛け">
                                                    玉掛け
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="小型移動式クレーン">
                                                    小型移動式クレーン
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="車両系建設機械">
                                                    車両系建設機械
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="フォークリフト">
                                                    フォークリフト
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="その他">
                                                    その他
                                                </button>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s1-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <button class="next-button disabled js-s1-next-btn js-guide-s1-2">次へ</button>
                                            </section>
                                        </footer>
                                    </section>
                                    <section class="form step2 js-step hidden">
                                        <header class="form-stepper">
                                            <img src="images/step2.png" />
                                        </header>
                                        <section class="form-body">
                                            <h3 class="heading-3">雇用形態のご希望はありますか？</h3>
                                            <section class="select-buttons mt-l js-guide-s2-1"><button
                                                    class="btn select-button select-button-l js-select-button" value="正社員">
                                                    <img class="select-button-image-l" src="images/working_style_1.png" />
                                                    正社員
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button" value="業務委託">
                                                    <img class="select-button-image-l" src="images/working_style_2.png" />
                                                    業務委託
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button" value="アルバイト">
                                                    <img class="select-button-image-l" src="images/working_style_3.png" />
                                                    アルバイト
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button" value="その他">
                                                    <img class="select-button-image-l" src="images/working_style_4.png" />
                                                    その他
                                                </button>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s2-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn">&lt;戻る</div>
                                                <div class="overlay hidden js-overlay js-guide-s2-overlay"></div>
                                                <div class="paging-button js-s2-next-btn js-guide-s2-2">次の質問へ&gt;</div>
                                            </section>
                                        </footer>
                                    </section>
                                    <section class="form step4 js-step hidden">
                                        <header class="form-stepper"><img src="images/step3.png" /></header>
                                        <section class="form-body">
                                            <h3 class="heading-3">転職はいつ頃がご希望ですか？</h3>
                                            <section class="select-buttons mt-l js-guide-s3-1"><button
                                                    class="btn select-button select-button-l js-select-button" value="すぐに">
                                                    <img class="select-button-image-l" src="images/seek_speed_1.png" />
                                                    すぐに
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button" value="1ヶ月以内">
                                                    <img class="select-button-image-l" src="images/seek_speed_2.png" />
                                                    1ヶ月以内
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button" value="3ヶ月以内">
                                                    <img class="select-button-image-l" src="images/seek_speed_3.png" />
                                                    3ヶ月以内
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button" value="6ヶ月以内">
                                                    <img class="select-button-image-l" src="images/seek_speed_4.png" />
                                                    6ヶ月以内
                                                </button>
                                                <button
                                                    class="btn select-button select-button-l select-button-w100 js-select-button"
                                                    value="未定">
                                                    <img class="select-button-image-l" src="images/seek_speed_5.png" />
                                                    未定
                                                </button>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s3-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn">&lt;戻る</div>
                                                <div class="paging-button js-s3-next-btn js-guide-s3-2">次の質問へ&gt;</div>
                                            </section>
                                        </footer>
                                    </section>
                                    <section class="form step4 js-step hidden">
                                        <header class="form-stepper"><img src="images/step3.png" /></header>
                                        <section class="form-body">
                                            <h3 class="heading-3">これまでの転職回数</h3>
                                            <section class="input-wrapper"><select class="input js-job-change-input js-guide-s4-1">
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
                                                </select></section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s4-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn">&lt;戻る</div>
                                                <div class="paging-button js-s4-next-btn js-guide-s4-2">次の質問へ&gt;</div>
                                            </section>
                                        </footer>
                                    </section>
                                    <section class="form step5 js-step hidden">
                                        <header class="form-stepper"><img src="images/step4.png" /></header>
                                        <section class="form-body">
                                            <h3 class="heading-3">お仕事のご状況</h3>
                                            <section class="select-buttons mt-l js-guide-s5-1"><button
                                                    class="btn select-button select-button-flex select-button-w100 js-select-button"
                                                    value="離職中または退職確定">
                                                    離職中または退職確定
                                                </button>
                                                <button
                                                    class="btn select-button select-button-flex select-button-w100 js-select-button"
                                                    value="現職中">
                                                    現職中
                                                </button>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s5-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn">&lt;戻る</div>
                                                <div class="paging-button js-s5-next-btn js-guide-s5-2">次の質問へ&gt;</div>
                                            </section>
                                        </footer>
                                    </section>
                                    <section class="form step6 js-step hidden">
                                        <header class="form-stepper"><img src="images/step4.png" /></header>
                                        <section class="form-body">
                                            <h3 class="heading-3">荷物の手積み手降ろしは可能ですか？</h3>
                                            <section class="select-buttons mt-l js-guide-s6-1"><button
                                                    class="btn select-button select-button-l js-select-button" value="問題なし">
                                                    <img class="select-button-image-l" src="images/carry_level_1.png" />
                                                    問題なし
                                                </button>
                                                <button class="btn select-button select-button-l js-select-button" value="求人の条件次第">
                                                    <img class="select-button-image-l" src="images/carry_level_2.png" />
                                                    求人の条件次第
                                                </button>
                                                <button
                                                    class="btn select-button select-button-l select-button-w100 js-select-button"
                                                    value="不可">
                                                    <img class="select-button-image-l" src="images/carry_level_3.png" />
                                                    不可
                                                </button>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s6-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn">&lt;戻る</div>
                                                <button class="next-button disabled js-s6-next-btn js-guide-s6-2">次へ</button>

                                            </section>
                                        </footer>
                                    </section>
                                    <section class="form step7 js-step hidden">
                                        <header class="form-stepper"><img src="images/step4.png" /></header>
                                        <section class="form-body">
                                            <h3 class="heading-3">こだわり条件（複数選択可）</h3>
                                            <p class="heading-note"><span class="text-red">※未選択でも、次のページへ進めます。</span></p>

                                            <section class="select-buttons mt-l js-guide-s7-1">
                                                <button class="btn select-button js-multi-select-button" value="日払い、前払いOK">
                                                    日払い、前払いOK
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="持病持ちOK">
                                                    持病持ちOK
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="刺青OK">
                                                    刺青OK
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="ひげOK">
                                                    ひげOK
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="茶髪OK">
                                                    茶髪OK
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="車内喫煙OK">
                                                    車内喫煙OK
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="寮、社宅あり">
                                                    寮、社宅あり
                                                </button>
                                                <button class="btn select-button js-multi-select-button" value="長距離希望">
                                                    長距離希望
                                                </button>
                                                <button class="btn select-button select-button-w100 js-multi-select-button"
                                                    value="未経験者歓迎">
                                                    未経験者歓迎
                                                </button>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s7-error-label">選択してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn">&lt;戻る</div>
                                                <button class="next-button active js-step-btn js-guide-s7-2">次へ</button>
                                            </section>
                                        </footer>
                                    </section>
                                    <section class="form step8 js-step hidden">
                                        <header class="form-stepper"><img src="images/step5.png" /></header>
                                        <p class="not-public">※公開されません</p>

                                        <section class="form-body">
                                            <h3 class="heading-3">お住まいの郵便番号</h3>
                                            <p class="heading-note">（ハイフンなし7桁）</p>

                                            <section class="input-wrapper"><input class="input js-postalcode-input js-guide-s8-1"
                                                    maxlength="7" pattern="[0-9\s]{7}" type="text" placeholder="例)1230000" />
                                            </section>
                                            <div class="address-form-wrapper">
                                                <section class="address-form-toggle-wrapper"><button
                                                        class="address-form-toggle js-address-form-toggle">
                                                        郵便番号がわからない場合はこちら
                                                    </button></section>
                                                <section class="address-form js-address-form hidden">
                                                    <section class="input-wrapper">

                                                    </section>
                                                    <section class="input-wrapper"><select
                                                            class="input js-city-input js-guide-s8-3">
                                                            <option value="">都道府県を選択してください</option>
                                                        </select></section>
                                                    <section class="input-wrapper"><input
                                                            class="input js-address-input js-guide-s8-4" type="text"
                                                            placeholder="番地・建物名" /></section>
                                                </section>
                                            </div>
                                        </section>
                                        <section class="form-support-person">
                                            <section class="form-person-image"><img src="images/support_1.png" /></section>
                                            <section class="form-person-balloon">お近くの求人情報をお届けいたします。
                                                希望勤務エリアがある方は、ご登録後に
                                                設定可能です。</section>
                                        </section>
                                        <p class="job-openings-count js-job-counter hidden" style="margin-bottom: 30px;">
                                            対象住所付近の最新求人数:
                                            <span class="text-pink">4274件</span>
                                        </p>

                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s8-error-label">入力してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn">&lt;戻る</div>
                                                <div class="overlay hidden js-overlay js-guide-s8-overlay"></div>
                                                <button class="next-button disabled js-s8-next-btn js-guide-s8-5">次へ</button>
                                            </section>
                                        </footer>
                                    </section>
                                    <section class="form step9 js-step hidden">
                                        <header class="form-stepper"><img src="images/step6.png" /></header>
                                        <p class="not-public">※公開されません</p>
                                        <section class="form-body">
                                            <h3 class="heading-3">お名前</h3>
                                            <p class="heading-note">（フルネーム）</p>
                                            <section class="input-wrapper"><input class="input js-input-name js-guide-s9-1"
                                                    type="text" placeholder="例)山田太郎" /></section>
                                            <h3 class="heading-3">生まれ年</h3>
                                            <p class="heading-note">（西暦4年）</p>
                                            <section class="input-wrapper">
                                                <select class="input js-input-birth-year js-guide-s9-2">
                                                    <option value="">---</option>
                                                    <option value="2005">2005年</option>
                                                    <option value="2004">2004年</option>
                                                    <option value="2003">2003年</option>
                                                    <option value="2002">2002年</option>
                                                    <option value="2001">2001年</option>
                                                    <option value="2000">2000年</option>
                                                    <option value="1999">1999年</option>
                                                    <option value="1998">1998年</option>
                                                    <option value="1997">1997年</option>
                                                    <option value="1996">1996年</option>
                                                    <option value="1995">1995年</option>
                                                    <option value="1994">1994年</option>
                                                    <option value="1993">1993年</option>
                                                    <option value="1992">1992年</option>
                                                    <option value="1991">1991年</option>
                                                    <option value="1990">1990年</option>
                                                    <option value="1989">1989年</option>
                                                    <option value="1988">1988年</option>
                                                    <option value="1987">1987年</option>
                                                    <option value="1986">1986年</option>
                                                    <option value="1985">1985年</option>
                                                    <option value="1984">1984年</option>
                                                    <option value="1983">1983年</option>
                                                    <option value="1982">1982年</option>
                                                    <option value="1981">1981年</option>
                                                    <option value="1980">1980年</option>
                                                    <option value="1979">1979年</option>
                                                    <option value="1978">1978年</option>
                                                    <option value="1977">1977年</option>
                                                    <option value="1976">1976年</option>
                                                    <option value="1975">1975年</option>
                                                    <option value="1974">1974年</option>
                                                    <option value="1973">1973年</option>
                                                    <option value="1972">1972年</option>
                                                    <option value="1971">1971年</option>
                                                    <option value="1970">1970年</option>
                                                    <option value="1969">1969年</option>
                                                    <option value="1968">1968年</option>
                                                    <option value="1967">1967年</option>
                                                    <option value="1966">1966年</option>
                                                    <option value="1965">1965年</option>
                                                    <option value="1964">1964年</option>
                                                    <option value="1963">1963年</option>
                                                    <option value="1962">1962年</option>
                                                    <option value="1961">1961年</option>
                                                    <option value="1960">1960年</option>
                                                    <option value="1959">1959年</option>
                                                    <option value="1958">1958年</option>
                                                    <option value="1957">1957年</option>
                                                    <option value="1956">1956年</option>
                                                    <option value="1955">1955年</option>
                                                    <option value="1954">1954年</option>
                                                    <option value="1953">1953年</option>
                                                    <option value="1952">1952年</option>
                                                    <option value="1951">1951年</option>
                                                    <option value="1950">1950年</option>
                                                    <option value="1949">1949年</option>
                                                    <option value="1948">1948年</option>
                                                    <option value="1947">1947年</option>
                                                    <option value="1946">1946年</option>
                                                    <option value="1945">1945年</option>
                                                    <option value="1944">1944年</option>
                                                    <option value="1943">1943年</option>
                                                </select>
                                            </section>
                                            <section class="form-support-person">
                                                <section class="form-person-image"><img src="images/support_1.png" /></section>
                                                <section class="form-person-balloon">給与情報などがより正確にわかります。</section>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s9-error-label">入力してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn">&lt;戻る</div>
                                                <div class="overlay hidden js-overlay js-guide-s9-overlay"></div>
                                                <button class="next-button disabled js-s9-next-btn js-guide-s9-3">次へ</button>
                                            </section>
                                        </footer>
                                    </section>
                                    <section class="form step10 js-step hidden">
                                        <header class="form-stepper"><img src="images/step7.png" /></header>
                                        <p class="not-public">※公開されません</p>

                                        <section class="form-body">
                                            <h3 class="heading-3">携帯番号</h3>
                                            <p class="heading-note">（ハイフンなし10桁or11桁）</p>

                                            <section class="input-wrapper"><input class="input js-input-tel js-guide-s10-1"
                                                    type="tel" placeholder="例)09012345678" /></section>
                                            <h3 class="heading-3">メールアドレス</h3>
                                            <p class="heading-note">（任意）</p>

                                            <section class="input-wrapper"><input class="input js-input-email js-guide-s10-2"
                                                    type="email" placeholder="例)driver@gmail.com" /></section>
                                            <p class="job-openings-count js-job-counter hidden">ご入力いただいた情報に当てはまる求人数: <span
                                                    class="text-pink">4274件</span></p>

                                            <section class="form-support-person">
                                                <section class="form-person-image"><img src="images/support_2.png" /></section>
                                                <section class="form-person-balloon">様のお住まいの都道府県で多数の新着求人が見つかりました。</section>
                                            </section>
                                        </section>
                                        <footer class="form-footer">
                                            <section class="error-label hidden js-error-label js-s10-error-label">入力してください</section>
                                            <section class="form-footer-content">
                                                <div class="paging-button js-step-btn" style="width: 40px;">&lt;戻る</div>
                                                <div class="overlay hidden js-overlay js-guide-s10-overlay"></div>
                                                <button class="cv-button js-cv-btn js-guide-s10-3">
                                                    <span class="cv-tagline">利用規約と個人情報の取り扱いに同意の上</span>
                                                    <span class="cv-main-text">求人を探しに行く</span>
                                                </button>

                                            </section>
                                            <section class="terms"><a href="#" target="_blank" rel="noopener">利用規約</a>
                                                /
                                                <a href="#" target="_blank" rel="noopener">個人情報の取扱</a>
                                            </section>
                                        </footer>
                                    </section>
                                </section>

                                <div class="guide-arrow js-guide-arrow hidden">
                                    <div class="guide-arrow-anim"><img src="images/arrow.png" /></div>
                                </div>
                            </div>
                            <footer class="entry-footer">
                                <?php insert_social_buttons(); ?>
                            </footer>
                    </main>
                    <?php get_sidebar(); ?>
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