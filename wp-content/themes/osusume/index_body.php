<?php
$args = array(
    'hide_empty' => false,
    'meta_key' => 'ctg_ranking',
    'orderby' => 'meta_value_num',
    'order' => 'desc',
    'meta_query' => array(
        array(
            'key' => 'public_way',
            'value' => true
        ),
    )
);
$categories = get_categories($args);
?>
<div class="page_layout_main">
    <div class="top_contents_block">
        <img src="<?php bloginfo('template_url'); ?>/assets/images/top/pic05.png" alt="目次" class="top_contents_pic">
        <p class="top_contents_title"><span>目次</span></p>
        <ul class="top_contents_list">
            <?php
            foreach ($categories as $category_k => $category) { ?>
                <li class="top_contents_item">
                    <a href="#Block<?php echo $category_k + 1; ?>" class="top_contents_link">
                        <span class="num1" style="font-size: 20px;color: #1a4473;font-style: italic;margin: 0 10px 0 0;white-space: nowrap;"><?php echo $category_k + 1; ?></span>
                        <p class="text">
                            <?php echo str_limit($category->name, 38); ?>
                            </p>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <?php
    foreach ($categories as $category_k => $category_data) {
        $category_v = $category_data->term_id;
        ?>
        <!-- block -->
        <div class="top_block" id="Block<?php echo $category_k + 1; ?>">
            <?php if($category_data->category_parent == 0) { ?>
                <a href="<?php echo get_category_link($category_v) ?>">
            <?php } else { ?>
                <a href="/ctg/<?php echo urldecode($category_data->slug); ?>">
            <?php } ?>
                <h2 class="page_title02 mb15">
                    <?php echo $category_data->name; ?> by 人材紹介エージェント研究所
                </h2>
            </a>

            <p class="page_text01 mb30">
                <?php the_field('category_description', $category_data); ?>
            </p>

            <section class="top_appeal_block01">
                <h1 class="page_title03 mb15">
                    <?php echo $category_data->name; ?>の3つの魅力
                </h1>
                <ul class="top_appeal_list">
                    <li class="top_appeal_item">
                        <div class="top_appeal_item_title">
                            <img src="<?php bloginfo('template_url'); ?>/assets/images/top/num01.svg" alt="1">
                            <h2 class="title">
                                <?php the_field('charm1_title', $category_data); ?>
                            </h2>
                        </div>
                        <div class="top_appeal_item_main">
                            <img src="<?php the_field('charm1_icon', $category_data); ?>" alt="<?php the_field('charm1_title', $category_data); ?>">
                            <p class="top_appeal_text">
                                <?php the_field('charm1_comment', $category_data); ?>
                            </p>
                        </div>
                    </li>
                    <li class="top_appeal_item">
                        <div class="top_appeal_item_title">
                            <img src="<?php bloginfo('template_url'); ?>/assets/images/top/num02.svg" alt="1">
                            <h2 class="title">
                                <?php the_field('charm2_title', $category_data); ?>
                            </h2>
                        </div>
                        <div class="top_appeal_item_main">
                            <img src="<?php the_field('charm2_icon', $category_data); ?>" alt="<?php the_field('charm2_title', $category_data); ?>">
                            <p class="top_appeal_text">
                                <?php the_field('charm2_comment', $category_data); ?>
                            </p>
                        </div>
                    </li>
                    <li class="top_appeal_item">
                        <div class="top_appeal_item_title">
                            <img src="<?php bloginfo('template_url'); ?>/assets/images/top/num03.svg" alt="1">
                            <h2 class="title">
                                <?php the_field('charm3_title', $category_data); ?>
                            </h2>
                        </div>
                        <div class="top_appeal_item_main">
                            <img src="<?php the_field('charm3_icon', $category_data); ?>" alt="<?php the_field('charm3_title', $category_data); ?>">
                            <p class="top_appeal_text">
                                <?php the_field('charm3_comment', $category_data); ?>
                            </p>
                        </div>
                    </li>
                </ul>
            </section>
            <section class="top_talk_block01">
                <h1 class="page_title04 mb30">
                    <?php echo $category_data->name; ?> by 人材紹介エージェント研究所
                </h1>
                <?php the_field('chart', $category_data); ?>
            </section>

            <?php
            $args = array(
                'numberposts' => 10,
                'offset' => 0,
                'category' => $category_v,
                'orderby' => 'modified',
                'order' => 'DESC',
                'post_type' => 'post',
                'post_status' => 'publish');

            $posts = get_posts($args);
            if ($posts) { ?>
                <!-- block -->
                <?php if ($category_k == 0) { ?>
                    <section class="top_column_block01">
                        <h1 class="page_title04 mb30">
                            おすすめの<?php echo $category_data->name; ?>記事
                        </h1>
                        <h2 class="page_title03 mb15">
                            新着記事
                        </h2>
                        <div class="top_column_article_wrap">
                        <?php foreach ($posts as $post_k => $post) { ?>

                            <?php if ($post_k > 2) {
                                break;
                            } ?>
                            <article class="top_column_article">
                                <a href="<?php the_permalink() ?>" class="top_column_link">
                                    <?php if ($post_k == 0) { ?>
                                        <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/label01.svg" alt="最新" class="label">
                                    <?php } ?>
                                    <div class="top_column_flex">
                                        <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>)"></div>
                                        <div class="top_column_main">
                                            <h3 class="title text_overflow">
                                                <?php the_title(); ?>
                                            </h3>
                                            <p class="text">
                                                <?php echo get_the_excerpt(); ?>
                                            </p>
                                            <p class="date"><?php the_time('Y.m.d'); ?></p>
                                            <?php if ($post_k == 2) { ?>
                                                <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/icon01.svg" alt="star" class="icon">
                                            <?php } ?>
                                        </div>
                                    </div>
                                </a>
                            </article>

                        <?php } ?>
                        </div>
                    </section>

                <?php } ?>
                <!-- block1_end -->


                <!-- block2 -->
                <?php if ($category_k == 1) { ?>
                    <section class="top_column_block02">
                        <h1 class="page_title04 mb30">
                            おすすめの<?php echo $category_data->name; ?>記事
                        </h1>
                        <h2 class="page_title03 mb15">
                            新着記事
                        </h2>
                        <div class="top_column_flex">
                            <?php foreach ($posts as $post_k => $post) { ?>
                                <?php if ($post_k > 3) {
                                    break;
                                } ?>
                                <article class="top_column_article">
                                    <a href="<?php the_permalink() ?>" class="top_column_link">
                                        <?php if ($post_k == 0) { ?>
                                            <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/label02.svg" alt="new" class="label">
                                        <?php } ?>

                                        <?php if ($post_k == 3) { ?>
                                            <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/label03.svg" alt="おすすめ" class="label">
                                        <?php } ?>

                                        <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);"></div>
                                        <div class="top_column_main">
                                            <h3 class="title">
                                                <?php the_title(); ?>
                                            </h3>
                                            <p class="text">
                                                <?php echo get_the_excerpt(); ?>
                                            </p>
                                            <span class="date"><?php the_time('Y年m月d日'); ?></span>
                                        </div>
                                    </a>
                                </article>
                            <?php } ?>
                        </div>
                    </section>
                <?php } ?>
                <!-- block2_end -->


                <!-- block3 -->
                <?php if ($category_k == 2) { ?>
                    <section class="top_column_block03">
                        <h1 class="page_title04 mb30">
                            おすすめの<?php echo $category_data->name; ?>記事
                        </h1>
                        <h2 class="page_title03 mb15">
                            新着記事
                        </h2>
                        <div class="top_column_flex">
                            <?php foreach ($posts as $post_k => $post) { ?>

                                <?php if ($post_k > 3) {
                                    break;
                                } ?>
                                <article class="top_column_article">
                                    <a href="<?php the_permalink() ?>" class="top_column_link">
                                        <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);">
                                            <?php if ($post_k == 0) { ?>
                                                <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/icon02.svg" alt="star" class="icon">
                                            <?php } ?>
                                        </div>

                                        <div class="top_column_main">
                                            <h3 class="title">
                                                <?php the_title(); ?>
                                            </h3>
                                            <div class="top_column_info">
                                                <span class="date"><?php the_time('Y年m月d日'); ?></span>
                                                <span class="num"><?php echo get_post_meta($post->ID, 'views', true); ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </article>

                            <?php } ?>
                        </div>
                    </section>

                <?php } ?>
                <!-- block3_end -->


                <!-- block4 -->
                <?php if ($category_k == 3) { ?>

                    <section class="top_column_block04">
                        <h1 class="page_title04 mb30">
                            おすすめの<?php echo $category_data->name; ?>記事
                        </h1>
                        <h2 class="page_title03 mb15">
                            新着記事
                        </h2>
                        <div class="top_column_flex">
                            <?php foreach ($posts as $post_k => $post) { ?>

                                <?php if ($post_k > 3) {
                                    break;
                                } ?>
                                <article class="top_column_article">
                                    <a href="<?php the_permalink() ?>"
                                       class="top_column_link<?php if ($post_k == 0) { ?> latest<?php } ?>">
                                        <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);"></div>
                                        <div class="top_column_main">
                                            <p class="category">
                                                <?php echo $category_data->name; ?>
                                            </p>
                                            <h3 class="title">
                                                <?php the_title(); ?>
                                            </h3>
                                            <p class="date"><?php the_time('Y.m.d'); ?></p>
                                        </div>
                                        <?php if ($post_k == 0) { ?><p class="label">最新</p><?php } ?>
                                    </a>
                                </article>
                            <?php } ?>
                        </div>
                    </section>
                <?php } ?>
                <!-- block4_end -->


                <!-- block5 -->

                <?php if ($category_k == 4) { ?>

                    <section class="top_column_block05">
                        <h1 class="page_title04 mb30">
                            おすすめの<?php echo $category_data->name; ?>記事
                        </h1>
                        <h2 class="page_title03 mb15">
                            新着記事
                        </h2>
                        <div class="top_column_flex">

                            <?php foreach ($posts as $post_k => $post) {
                                if ($post_k == 0) { ?>
                                    <article class="top_column_main_article">
                                        <a href="<?php the_permalink() ?>" class="top_column_link" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);">
                                            <p class="label">NEW</p>
                                            <div class="top_column_main">
                                                <p class="category"><?php echo $category_data->name; ?></p>
                                                <h3 class="title">
                                                    <?php the_title(); ?>
                                                </h3>
                                                <p class="date"><?php the_time('Y.m.d'); ?></p>
                                            </div>
                                        </a>
                                    </article>
                                <?php } ?>
                            <?php } ?>

                            <div class="top_column_sub">
                                <?php foreach ($posts as $post_k => $post) {
                                    if ($post_k == 1) { ?>

                                        <article class="top_column_sub_article">
                                            <a href="<?php the_permalink() ?>" class="top_column_link" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);">
                                                <div class="top_column_main">
                                                    <p class="category"><?php echo $category_data->name; ?></p>
                                                    <h3 class="title">
                                                        <?php the_title(); ?>
                                                    </h3>
                                                </div>
                                            </a>
                                        </article>
                                    <?php } ?>
                                <?php } ?>

                                    <?php foreach ($posts as $post_k => $post) {
                                        if ($post_k == 2) { ?>
                                            <article class="top_column_sub_article">
                                                <a href="<?php the_permalink() ?>" class="top_column_link" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);">
                                                    <div class="top_column_main">
                                                        <p class="category"><?php echo $category_data->name; ?></p>
                                                        <h3 class="title">
                                                            <?php the_title(); ?>
                                                        </h3>
                                                    </div>
                                                </a>
                                            </article>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php foreach ($posts as $post_k => $post) {
                                        if ($post_k == 3) { ?>
                                            <article class="top_column_sub_article">
                                                <a href="<?php the_permalink() ?>" class="top_column_link" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);">
                                                    <div class="top_column_main">
                                                        <p class="category"><?php echo $category_data->name; ?></p>
                                                        <h3 class="title">
                                                            <?php the_title(); ?>
                                                        </h3>
                                                    </div>
                                                </a>
                                            </article>
                                        <?php } ?>
                                    <?php } ?>

                            </div>
                        </div>
                    </section>
                <?php } ?>
                <!-- block5_end -->


                <!-- block6 -->
                <?php if ($category_k == 5) { ?>
                    <section class="top_column_block06">
                        <h1 class="page_title04 mb30">
                            おすすめの<?php echo $category_data->name; ?>記事
                        </h1>
                        <h2 class="page_title03 mb15">
                            新着記事
                        </h2>
                        <div class="top_column_flex">
                            <?php foreach ($posts as $post_k => $post) { ?>

                                <?php if ($post_k > 2) {
                                    break;
                                } ?>
                                <article class="top_column_article">
                                    <a href="<?php the_permalink() ?>" class="top_column_link" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);">

                                        <?php if ($post_k == 0) { ?>
                                            <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/icon04.svg" alt="star" class="icon">
                                        <?php } ?>

                                        <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);"></div>

                                        <div class="top_column_main">
                                            <p class="category"><?php echo $category_data->name; ?></p>
                                            <h3 class="title" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;width: 200px;">
                                                <?php the_title(); ?>
                                            </h3>
                                            <p class="date">
                                                <?php the_time('Y.m.d'); ?>
                                            </p>
                                        </div>
                                    </a>
                                </article>
                            <?php } ?>
                        </div>
                    </section>
                <?php } ?>
                <!-- block6_end -->


                <!-- block7 -->
                <?php if ($category_k == 6) { ?>
                    <section class="top_column_block07">
                        <h1 class="page_title04 mb30">
                            おすすめの<?php echo $category_data->name; ?>記事
                        </h1>
                        <h2 class="page_title03 mb15">
                            新着記事
                        </h2>
                        <div class="top_column_flex">
                            <?php foreach ($posts as $post_k => $post) { ?>
                                <?php if ($post_k == 0) { ?>
                                    <article class="top_column_main_article">
                                        <a href="<?php the_permalink() ?>" class="top_column_link">
                                            <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);">
                                                <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/icon05.svg" alt="good" class="icon">
                                                <p class="category"><?php echo $category_data->name; ?></p>
                                            </div>
                                            <div class="top_column_main">
                                                <h3 class="title">
                                                    <?php the_title(); ?>
                                                </h3>
                                                <p class="date"><?php the_time('Y.m.d'); ?></p>
                                                <p class="text">
                                                    <?php echo get_the_excerpt(); ?>
                                                </p>
                                            </div>
                                        </a>
                                    </article>
                                <?php } ?>
                            <?php } ?>
                            <div class="top_column_sub">
                                <?php foreach ($posts as $post_k => $post) { ?>
                                    <?php if ($post_k > 0 && $post_k < 5) { ?>
                                        <article class="top_column_article">
                                            <a href="<?php the_permalink() ?>" class="top_column_link">
                                                <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);">
                                                    <p class="category"><?php echo $category_data->name; ?></p>
                                                </div>
                                                <div class="top_column_main">
                                                    <h3 class="title">
                                                        <?php the_title(); ?>
                                                    </h3>
                                                    <p class="date"><?php the_time('Y.m.d'); ?></p>
                                                </div>
                                            </a>
                                        </article>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </section>
                <?php } ?>

                <!-- block7_end -->


                <!-- block8 -->
                <?php if ($category_k == 7) { ?>
                    <section class="top_column_block08">
                        <h1 class="page_title04 mb30">
                            おすすめの<?php echo $category_data->name; ?>記事
                        </h1>
                        <h2 class="page_title03 mb15">
                            新着記事
                        </h2>
                        <div class="top_column_flex">

                            <?php foreach ($posts as $post_k => $post) { ?>
                                <?php if ($post_k > 5) {
                                    break;
                                } ?>
                                <article class="top_column_article">
                                    <a href="<?php the_permalink() ?>" class="top_column_link">
                                        <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);">
                                            <?php if ($post_k == 0 || $post_k == 5) { ?>
                                                <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/icon06.svg" alt="check" class="icon">
                                            <?php } ?>
                                        </div>
                                        <div class="top_column_main">
                                            <h3 class="title">
                                                <?php the_title(); ?>
                                            </h3>
                                            <p class="text">
                                                <?php echo get_the_excerpt(); ?>
                                            </p>
                                            <p class="date"><?php the_time('Y.m.d'); ?></p>
                                        </div>
                                    </a>
                                </article>
                            <?php } ?>
                        </div>
                    </section>
                <?php } ?>
                <!-- block8_end -->


                <!-- block9 -->
                <?php if ($category_k == 8) { ?>
                    <section class="top_column_block09">
                        <h1 class="page_title04 mb30">
                            おすすめの<?php echo $category_data->name; ?>記事
                        </h1>
                        <h2 class="page_title03 mb15">
                            新着記事
                        </h2>
                        <div class="top_column_flex">

                            <?php foreach ($posts as $post_k => $post) { ?>

                                <?php if ($post_k > 7) {
                                    break;
                                } ?>

                                <article class="top_column_article">
                                    <a href="<?php the_permalink() ?>" class="top_column_link">
                                        <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);">

                                            <?php if ($post_k == 0) { ?>
                                                <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/icon07.svg" alt="check" class="icon">
                                            <?php } ?>

                                            <p class="category"><?php echo $category_data->name; ?></p>
                                        </div>
                                        <div class="top_column_main">
                                            <h3 class="title">
                                                <?php the_title(); ?>
                                            </h3>
                                            <p class="text">
                                                <?php echo get_the_excerpt(); ?>
                                            </p>
                                            <p class="date"><?php the_time('Y.m.d'); ?></p>
                                        </div>
                                    </a>
                                </article>
                            <?php } ?>
                        </div>
                    </section>
                <?php } ?>

                <!-- block9_end -->

                <!-- block10 -->
                <?php if ($category_k == 9) { ?>
                    <section class="top_column_block10">
                        <h1 class="page_title04 mb30">
                            おすすめの<?php echo $category_data->name; ?>記事
                        </h1>
                        <h2 class="page_title03 mb15">
                            新着記事
                        </h2>
                        <div class="top_column_flex">
                            <?php foreach ($posts as $post_k => $post) { ?>
                                <?php if ($post_k == 0) { ?>
                                    <article class="top_column_main_article">
                                        <a href="<?php the_permalink() ?>" class="top_column_link">
                                            <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);">
                                                <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/label04.svg" class="label">
                                                <p class="category"><?php echo $category_data->name; ?></p>
                                            </div>
                                            <div class="top_column_main">
                                                <h3 class="title">
                                                    <?php the_title(); ?>
                                                </h3>
                                                <p class="text">
                                                    <?php echo get_the_excerpt(); ?>
                                                </p>
                                                <p class="date"><?php the_time('Y.m.d'); ?></p>
                                            </div>
                                        </a>
                                    </article>
                                <?php } ?>
                            <?php } ?>
                            <div class="top_column_sub_flex">
                                <?php foreach ($posts as $post_k => $post) { ?>
                                    <?php if ($post_k > 0 && $post_k < 5) { ?>
                                        <article class="top_column_article">
                                            <a href="<?php the_permalink() ?>" class="top_column_link">
                                                <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);">
                                                    <?php if ($post_k == 1) { ?>
                                                        <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/label04.svg" class="label">
                                                    <?php } ?>
                                                    <p class="category"><?php echo $category_data->name; ?></p>
                                                </div>
                                                <div class="top_column_main">
                                                    <h3 class="title">
                                                        <?php the_title(); ?>
                                                    </h3>
                                                    <p class="date"><?php the_time('Y.m.d'); ?></p>
                                                </div>
                                            </a>
                                        </article>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </section>
                <?php } ?>
                <!-- block10_end -->


                <!-- block11 -->
                <?php if ($category_k == 10) { ?>
                    <section class="top_column_block11">
                        <h1 class="page_title04 mb30">
                            おすすめの<?php echo $category_data->name; ?>記事
                        </h1>
                        <h2 class="page_title03 mb15">
                            新着記事
                        </h2>
                        <div class="top_column_flex">
                            <?php foreach ($posts as $post_k => $post) { ?>
                                <?php if ($post_k == 0) { ?>
                                    <article class="top_column_article">
                                        <a href="<?php the_permalink() ?>" class="top_column_link">
                                            <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);"></div>
                                            <div class="top_column_main">
                                                <p class="category"><?php echo $category_data->name; ?></p>
                                                <h3 class="title">
                                                    <?php the_title(); ?>
                                                </h3>
                                                <p class="text">
                                                    <?php echo get_the_excerpt(); ?>
                                                </p>
                                                <p class="date"><?php the_time('Y.m.d'); ?></p>
                                            </div>
                                        </a>
                                    </article>
                                <?php } ?>
                            <?php } ?>

                            <?php foreach ($posts as $post_k => $post) { ?>
                                <?php if ($post_k > 0 && $post_k < 5) { ?>
                                    <article class="top_column_article">
                                        <a href="<?php the_permalink() ?>" class="top_column_link">
                                            <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);"></div>
                                            <div class="top_column_main">
                                                <p class="category"><?php echo $category_data->name; ?></p>
                                                <h3 class="title">
                                                    <?php the_title(); ?>
                                                </h3>
                                                <p class="text">
                                                    <?php echo get_the_excerpt(); ?>
                                                </p>
                                                <p class="date"><?php the_time('Y.m.d'); ?></p>
                                            </div>
                                        </a>
                                    </article>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </section>
                <?php } ?>
                <!-- block11_end -->

                <!-- block12 -->
                <?php if ($category_k == 11) { ?>
                    <section class="top_column_block12">
                        <h1 class="page_title04 mb30">
                            おすすめの<?php echo $category_data->name; ?>記事
                        </h1>
                        <h2 class="page_title03 mb15">
                            新着記事
                        </h2>

                        <div class="top_column_article_wrap">
                        <?php foreach ($posts as $post_k => $post) { ?>
                            <?php if ($post_k < 4) { ?>
                                <article class="top_column_article">
                                    <a href="<?php the_permalink() ?>" class="top_column_link" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);">
                                    <?php if ($post_k == 0) { ?>
                                        <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/label05.svg" alt="new" class="label">
                                    <?php } ?>
                                        <div class="top_column_main">
                                            <p class="category"><?php echo $category_data->name; ?></p>
                                            <h3 class="title">
                                                <?php the_title(); ?>
                                            </h3>
                                            <p class="date"><?php the_time('Y.m.d'); ?></p>
                                        </div>
                                    </a>
                                </article>
                            <?php } ?>
                        <?php } ?>
                        </div>
                    </section>
                <?php } ?>
                <!-- block12_end -->
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>
