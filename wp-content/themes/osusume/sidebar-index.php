<aside class="page_layout_aside">
    <?php include 'sidebar_common.php' ?>

    <?php
    $args_cat = array(
        'hide_empty' => false,
        'orderby' => 'id',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'public_way',
                'value' => true
            ),
        )
    );
    $categories_cat = get_categories($args_cat);
    $cats = '';
    foreach ($categories_cat as $k_cat => $v_cat) {
        $cats .= $v_cat->term_id . ',';
    }

    $args = array(
        'numberposts' => 10,
        'category' => $cats,
        'orderby' => 'id',
        'order' => 'DESC',
        'meta_query' => array(
            array(
                'key' => 'detail_pick_up',
                'value' => true
            )
        ),
        'post_type' => 'post',
        'post_status' => 'publish'
    );
    $posts = get_posts($args);
    if ($posts) { ?>
        <div class="aside_recommend_block">
            <p class="aside_recommend_title">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/aside/icon01.png" alt="注目の記事">
                注目の記事
            </p>
            <ul class="aside_recommend_list">
                <?php foreach ($posts as $post) { ?>
                    <li class="aside_recommend_item">
                        <a href="<?php the_permalink() ?>" class="aside_recommend_link">
                            <div class="aside_recommend_pic" style="background-image: url(<?php the_field('detail_img', $post->ID) ?>)"></div>
                            <div class="aside_recommend_main">
                                <h3 class="title"><span><?php echo $post->post_title ?></span></h3>
                                <p class="text">
                                    <?php echo get_the_excerpt(); ?>
                                </p>
                                <p class="date"><?php the_modified_time('Y-m-d'); ?></p>
                            </div>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <?php
    $args = array(
        'numberposts' => 10,
        'category' => $cats,
        'orderby' => 'modified',
        'order' => 'DESC',
        'post_type' => 'post',
        'post_status' => 'publish'
    );
    $posts = get_posts($args);
    if ($posts) { ?>
        <div class="aside_recently_block">
            <p class="aside_recently_title">
                最近の投稿
            </p>
            <ul class="aside_recently_list">
                <?php foreach ($posts as $post) { ?>
                    <li class="aside_recently_item">
                        <h3 class="aside_recently_item_title">
                            <a href="<?php the_permalink() ?>" class="link">
                                <?php echo $post->post_title ?>
                            </a>
                        </h3>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <?php
    $args = array(
        'numberposts' => 10,
        'category' => $cats,
        'orderby' => 'meta_value',
        'order' => 'DESC',
        'meta_key' => 'views',
        'post_type' => 'post',
        'post_status' => 'publish'
    );
    $posts = get_posts($args);
    if ($posts) { ?>
        <div class="aside_ranking_block">
            <p class="aside_ranking_title">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/aside/icon02.png"
                     alt="転職記事ランキング">
                転職記事ランキング
            </p>
            <ul class="aside_ranking_list">
                <?php foreach ($posts as $postk => $post) {
                    $postk++ ?>
                    <li class="aside_ranking_item">
                        <a href="<?php the_permalink() ?>" class="aside_ranking_link">
                            <div class="aside_ranking_pic" style="background-image: url(<?php the_field('detail_img', $post->ID) ?>);">
                            <span style="background:
                            <?php
                            switch ($postk) {
                                case 1:
                                    echo "#F3F800";
                                    break;
                                case 2:
                                    echo "#C6C6C4";
                                    break;
                                case 3:
                                    echo "#A0A400";
                                    break;
                                case 4:
                                    echo "#B7B6FF";
                                    break;
                                case 5:
                                    echo "#FF7272";
                                    break;
                                default:
                                    echo "#FF7272";
                            }
                            ?>;"
                            >
                                <small><?php echo $postk; ?></small></span>
                            </div>
                            <h3 class="aside_ranking_item_title">
                                <?php echo $post->post_title ?>
                            </h3>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <div class="aside_related_block">
        <p class="aside_related_title">
            関連サイト
        </p>
        <?php dynamic_sidebar('websites'); ?>
    </div>
</aside>