<aside class="page_layout_aside">
    <?php include 'sidebar_common.php' ?>
    <?php
    $url_data = str_array($_SERVER['REQUEST_URI']);
    $category_datas = get_category_by_slug($url_data['ctg']);
    $url_data = str_array($_SERVER['REQUEST_URI']);

    if (!empty($url_data['tag'])) {
        $tag_datas = get_tags(array('name' => urldecode($url_data['tag'])))[0];
    }
    if (empty($tag_datas)) {
        $tag_datas->name = '';
    }
    $args = array(
        'numberposts' => 10,
        'category' => $category_datas->term_id,
        'orderby' => 'id',
        'order' => 'DESC',
        'meta_query' => array(
            array(
                'key' => 'detail_pick_up',
                'value' => true
            )
        ),
        'post_type' => 'post',
        'post_status' => 'publish',
        'tag' => $tag_datas->name
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
        'category' => $category_datas->term_id,
        'orderby' => 'modified',
        'order' => 'DESC',
        'post_type' => 'post',
        'post_status' => 'publish',
        'tag' => $tag_datas->name,
    );
    $posts = get_posts($args);
    if ($posts) { ?>
        <div class="aside_recently_block">
            <ul class="aside_recently_list">
                <p class="aside_recently_title">
                    最近の投稿
                </p>
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
        'category' => $category_datas->term_id,
        'orderby' => 'meta_value',
        'order' => 'DESC',
        'meta_key' => 'views',
        'post_type' => 'post',
        'post_status' => 'publish',
        'tag' => $tag_datas->name
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
                    $postk++; ?>
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

    <?php
    $args = array(
        'numberposts' => 6,
        'offset' => 0,
        'category' => $category_datas->term_id,
        'orderby' => 'modified',
        'order' => 'DESC',
        'post_type' => 'related_sites',
        'post_status' => 'publish');

    $posts = get_posts($args);
    if ($posts) { ?>
    <div class="aside_related_block">
        <p class="aside_related_title">
            関連サイト
        </p>
        <ul class="aside_related_list">
            <?php foreach ($posts as $post_k => $post) { ?>
                <li class="aside_related_item">
                    <a href="<?php the_field("related_site1_link", $post->ID) ?>" class="aside_related_link" target="_blank" rel="nofollow">
                        <img src="<?php the_field("related_site1_img", $post->ID) ?>" alt="関連サイト名が入ります" class="aside_related_icon">
                        <h3 class="aside_related_name">
                            <?php echo $post->post_title; ?>
                        </h3>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <?php } ?>
    </div>
</aside>