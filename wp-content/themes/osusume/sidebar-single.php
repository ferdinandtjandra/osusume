<aside class="page_layout_aside">
    <?php include 'sidebar_common.php';
    $detail_sidebar_style = get_field("detail_sidebar_style", $post->ID);
    $category_data = get_the_category()[0];
    $category_id = $category_data->term_id;
    ?>
    <?php
    $args = array(
        'numberposts' => 10,
        'category' => $category_id,
        'orderby' => 'id',
        'order' => 'DESC',
        'meta_query' => array(
            array(
                'key' => 'detail_pick_up',
                'value' => true
            ),
        ),
        'post_type' => 'post',
        'post_status' => 'publish'
    );
    $posts_recommended = get_posts($args); ?>
    <?php if ($detail_sidebar_style == 0) { ?>
        <div class="aside_recommend_block">
            <p class="aside_recommend_title">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/aside/icon01.png" alt="注目の記事">
                注目の記事
            </p>
            <ul class="aside_recommend_list">
                <?php foreach ($posts_recommended as $post) { ?>
                    <li class="aside_recommend_item">
                        <a href="<?php the_permalink() ?>" class="aside_recommend_link">
                            <div class="aside_recommend_pic" style="background-image: url(<?php the_field('detail_img', $post->ID) ?>);"></div>
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

    <div class="aside_recently_block">
        <p class="aside_recently_title">
            最近の投稿
        </p>
        <?php
        $args = array(
            'numberposts' => 10,
            'category' => $category_id,
            'orderby' => 'modified',
            'order' => 'DESC',
            'post_type' => 'post',
            'post_status' => 'publish'
        );
        $posts = get_posts($args); ?>
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

    <?php
    $args = array(
        'numberposts' => 10,
        'category' => $category_id,
        'orderby' => 'meta_value',
        'order' => 'DESC',
        'meta_key' => 'views',
        'post_type' => 'post',
        'post_status' => 'publish'
    );
    $posts_sentiment = get_posts($args); ?>
    <?php if ($detail_sidebar_style == 0) { ?>
        <div class="aside_ranking_block">
            <p class="aside_ranking_title">
                <img src="<?php bloginfo('template_url'); ?>/assets/images/aside/icon02.png" alt="転職記事ランキング">
                転職記事ランキング
            </p>
            <ul class="aside_ranking_list">
                <?php foreach ($posts_sentiment as $postk => $post) {
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

    <div class="aside_related_block">
        <p class="aside_related_title">
            関連サイト
        </p>
        <?php
        $args = array(
            'numberposts' => 6,
            'offset' => 0,
            'category' => $category_id,
            'orderby' => 'modified',
            'order' => 'DESC',
            'post_type' => 'related_sites',
            'post_status' => 'publish');

        $post_sidebar = get_posts($args);
        if ($post_sidebar) { ?>
            <ul class="aside_related_list">
                <?php foreach ($post_sidebar as $post_k => $post) { ?>
                    <li class="aside_related_item">
                        <a href="<?php the_field("related_site1_link", $post->ID) ?>" class="aside_related_link"
                           target="_blank" rel="nofollow">
                            <img src="<?php the_field("related_site1_img", $post->ID) ?>" alt="関連サイト名が入ります" class="aside_related_icon">
                            <h3 class="aside_related_name">
                                <?php the_title(); ?>
                            </h3>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        </ul>
    </div>

    <?php if ($detail_sidebar_style == 1) { ?>
        <div class="aside_column_block01">
            <ul class="tab_list">
                <li class="tab_item AsideTabItem active" data-tab="AsideTab01">人気記事</li>
                <li class="tab_item AsideTabItem" data-tab="AsideTab02">おすすめ</li>
            </ul>
            <div class="column">
                <ul class="list AsideTab01 active">
                    <?php foreach ($posts_sentiment as $posts_k => $post) {
                        $posts_k++;
                        ?>
                        <li class="item">
                            <a href="<?php the_permalink() ?>" class="link">
                                <div class="sub">
                                    <span class="num"><?php echo $posts_k; ?></span>
                                    <div class="pic" style="background-image: url(<?php the_field('detail_img', $post->ID) ?>);"></div>
                                </div>
                                <div class="main">
                                    <h3 class="title">
                                        <?php echo $post->post_title ?>
                                    </h3>
                                    <p class="category" style="background: #00bcd4;"><?php echo get_the_category()[0]->name ?></p>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <ul class="list AsideTab02">
                    <?php foreach ($posts_recommended as $posts_k => $post) { ?>
                        <li class="item">
                            <a href="<?php the_permalink() ?>" class="link">
                                <div class="sub">
                                    <div class="pic" style="background-image: url(<?php the_field('detail_img', $post->ID) ?>);"></div>
                                </div>
                                <div class="main">
                                    <h3 class="title">
                                        <?php echo $post->post_title ?>
                                    </h3>
                                    <p class="category" style="background: #00bcd4;"><?php echo get_the_category()[0]->name ?></p>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php } ?>

    <?php if ($detail_sidebar_style == 2) { ?>
        <div class="aside_column_block02">
            <p class="main_title">転職の人気記事</p>
            <ul class="list">
                <?php foreach ($posts_sentiment as $posts_k => $post) {
                    $posts_k++;
                    ?>
                    <li class="item">
                        <a href="<?php the_permalink() ?>" class="link">
                            <div class="sub">
                                <div class="pic" style="background-image: url(<?php the_field('detail_img', $post->ID) ?>);">
                                    <span class="num"><small><?php echo $posts_k; ?></small></span>
                                </div>
                            </div>
                            <div class="main">
                                <p class="date">
                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/detail/icon01.svg" alt="date"><?php the_time('Y-m-d'); ?>
                                </p>
                                <h3 class="title">
                                    <?php echo $post->post_title ?>
                                </h3>
                            </div>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="aside_column_block03">
            <p class="page_title03 mb10">転職のおすすめ記事</p>
            <ul class="list">
                <?php foreach ($posts_recommended as $posts_k => $post) {
                    $posts_k++;
                    ?>
                    <li class="item">
                        <a href="<?php the_permalink() ?>" class="link">
                            <span class="num"><?php echo $posts_k; ?></span>
                            <h3 class="title">
                                <?php echo $post->post_title ?>
                            </h3>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
</aside>