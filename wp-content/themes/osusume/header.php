<!doctype html>
<html lang="ja">
<head>
    <?php wp_head(); ?>
    <meta charset="UTF-8">
    <title><?php
        $url_data = str_array($_SERVER['REQUEST_URI']);
        $category_datas = get_category_by_slug($url_data['ctg']);

        if (is_home()) {
            echo tdk('index')['title'];
        }
        if (is_category()) {
            echo tdk('category', $category_datas->name)['title'];
        }
        if (urldecode($url_data['tag'])) {
            echo tdk('category_tag', $category_datas->name, urldecode($url_data['tag']))['title'];
        }
        if (is_single()) {
            echo tdk('single', get_the_category()[0]->cat_name, '', $post->post_title)['title'];
        }
        ?></title>

    <meta name="description" content="<?php
    if (is_home()) {
        echo tdk('index')['description'];
    }
    if (is_category()) {
        echo tdk('category', $category_datas->name)['description'];
    }
    if (urldecode($url_data['tag'])) {
        echo tdk('category_tag', $category_datas->name, urldecode($url_data['tag']))['description'];
    }
    if (is_single()) {
        if (empty($post->description)) {
            echo tdk('single', get_the_category()[0]->cat_name, '', $post->post_title)['description'];
        } else {
            echo $post->description;
        }
    }
    ?>">
    <meta name="Keywords" content="">
    <!-- ピンチによる拡大・縮小ができない -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <!-- ピンチによる拡大・縮小ができる -->
    <!-- <meta name="viewport" content="width=device-width,initial-scale=1.0"> -->
    <meta name="format-detection" content="telephone=no,address=no,email=no">
    <meta property="og:type" content="website">
    <meta property="og:title" content="">
    <meta property="og:image" content="">
    <meta property="og:site_name" content="">
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/reset.css" media="all">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/style.css" media="all">

    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/assets/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/assets/js/common.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/assets/js/flexibility.js"></script>

    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script><![endif]-->
</head>

<body>
<header>
    <div class="header_wrap">
        <?php
        $last_modified_post_args = array(
            'numberposts' => 1,
            'orderby' => 'modified',
            'order' => 'DESC',
            'post_type' => 'post',
            'post_status' => 'publish');
        $last_modified_post = get_posts($last_modified_post_args);
        ?>
        <p class="header_info_text">
            著者：転職研究所　<?php echo get_the_modified_time('Y年n月j日', $last_modified_post[0]->ID); ?>更新
        </p>
        <div class="header_logo_block">
            <div class="common_inner">
                <div class="header_logo_inner">
                    <?php
                        $url_data = str_array($_SERVER['REQUEST_URI']);
                        if(isset($url_data['ctg'])) {
                            $current_ctg = get_category_by_slug($url_data['ctg']);
                        }

                        if(is_single()) {
                            $post_cat = get_the_category()[0];
                        }
                    ?>

                    <?php if(!empty($current_ctg)){ ?>
                        <a href="/ctg/<?php echo urldecode($current_ctg->slug); ?>" class="header_logo">
                            <?php if(!empty(get_field('ctg_logo', $current_ctg))){ ?>
                                <img src="<?php the_field('ctg_logo', $current_ctg); ?>" alt="<?php echo $current_ctg->name ?>">
                            <?php } ?>
                            <span><?php echo $current_ctg->name ?></span>
                        </a>
                    <?php } else if(!empty($post_cat)) { ?>
                        <a href="/ctg/<?php echo urldecode($post_cat->slug); ?>" class="header_logo">
                            <?php if(!empty(get_field('ctg_logo', $post_cat))){ ?>
                                <img src="<?php the_field('ctg_logo', $post_cat); ?>" alt="<?php echo $post_cat->cat_name ?>">
                            <?php } ?>
                            <span><?php echo $post_cat->cat_name ?></span>
                        </a>
                    <?php } else { ?>
                        <a href="<?php bloginfo('url'); ?>" class="header_logo">
                            <img src="<?php bloginfo('template_url'); ?>/assets/images/logo/lo_sample.png" alt="人材紹介エージェント研究所">
                            <span>人材紹介エージェント研究所</span>
                        </a>
                    <?php } ?>

                    <button type="button" class="header_menu_btn" id="MenuOpenBtn">
                        <span class="top"></span>
                        <span class="bottom"></span>
                        <span class="text">MENU</span>
                    </button>
                </div>
            </div>
		</div>
    </div>

    <div class="header_menu_wrap" id="MenuWindow">
        <nav class="header_menu_block">
            <ul class="header_menu_list">
                <?php
                    $args = array(
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
                    $categories = get_categories($args);
                    foreach ($categories as $category) {
                        $thiscat = get_category($category->term_id);
                        $val = get_field('pick_up', $thiscat);
                        if ($val == true) {
                ?>
                        <?php
                        $args_childs = array(
                                            'hide_empty' => false,
                                            'child_of' => $category->term_id,
                                            'order' => 'ASC',
                                            'meta_query' => array(
                                                array(
                                                    'key' => 'public_way',
                                                    'value' => true
                                                ),
                                            )
                                        );
                        $child_category = get_categories($args_childs);
                        ?>
                        <?php if ($child_category) { ?>
                            <li class="header_menu_item">
                                <p class="header_menu_title MenuPopBtn">
                                    <?php echo str_limit($category->name, 40); ?>
                                    <span><?php echo str_limit($category->description, 20); ?></span>
                                </p>
                                <div class="header_menu_popup">
                                    <ul class="header_menu_sublist">
                                        <?php foreach ($child_category as $child_category_k => $child_category_v) { ?>
                                            <li class="header_menu_subitem">
                                                <a href="/ctg/<?php echo $child_category_v->slug ?>" class="header_menu_sublink"><?php echo $child_category_v->name; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } else { ?>
                            <li class="header_menu_item">
                                <a href="/ctg/<?php echo urldecode($category->slug); ?>" class="header_menu_link">
                                    <?php echo str_limit($category->name, 40); ?>
                                    <span><?php echo str_limit($category->description, 20); ?></span>
                                </a>
                            </li>
                        <?php } ?>
                <?php }} ?>
            </ul>
        </nav>
    </div>
</header>