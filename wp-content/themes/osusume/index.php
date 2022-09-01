<?php get_header(); ?>
    <main class="common_main">
        <div class="header_pankuzu_block">
            <div class="common_inner">
                <div class="header_pankuzu_inner">
                    <ul class="header_pankuzu_list">
                        <li class="header_pankuzu_item">
                            <a href="<?php bloginfo('url'); ?>" class="header_pankuzu_link">TOP</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="common_inner">
            <h1 class="page_title01">
                おすすめ転職エージェント比較&ランキング
            </h1>
        </div>
        <div class="page_mv_block">
            <div class="common_inner h100">
                <h2 class="page_mv_title">
                    <div class="common_pc_640">
                        <svg width="498" height="57" viewBox="0 0 498 57">
                            <text class="background" x="0" y="80%">
                                おすすめ転職エージェント
                            </text>
                            <text class="foreground" x="0" y="80%">
                                おすすめ転職エージェント
                            </text>
                        </svg>
                        <svg width="498" height="57" viewBox="0 0 498 57">
                            <text class="background" x="0" y="80%">
                                ランキング
                            </text>
                            <text class="foreground" x="0" y="80%">
                                ランキング
                            </text>
                        </svg>
                    </div>
                    <div class="common_sp_640">
                        <svg width="200" height="30" viewBox="0 0 200 40">
                            <text class="background" x="0" y="80%">
                                おすすめ転職エージェント
                            </text>
                            <text class="foreground" x="0" y="80%">
                                おすすめ転職エージェント
                            </text>
                        </svg>
                        <svg width="200" height="30" viewBox="0 0 200 40">
                            <text class="background" x="0" y="80%">
                                ランキング
                            </text>
                            <text class="foreground" x="0" y="80%">
                                ランキング
                            </text>
                        </svg>
                    </div>
                </h2>
            </div>
        </div>
        <div class="page_category-menu_block">
            <div class="common_inner">
                <div class="page_category-menu_main">
                    <h2 class="page_category-menu_head_title">
                        おすすめ転職エージェントカテゴリー
                    </h2>
                    <ul class="page_category-menu_list">
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
                        foreach ($categories as $k => $category) { ?>
                            <li class="page_category-menu_item">
                                <?php if($category->category_parent == 0) { ?>
                                <a href="<?php echo get_category_link($category->term_id) ?>" class="page_category-menu_link">
                                <?php } else { ?>
                                    <a href="/ctg/<?php echo urldecode($category->slug); ?>" class="page_category-menu_link">
                                <?php } ?>
                                    <img src="<?php the_field('category_icon', $category); ?>" alt="<?php echo $category->name ?>">
                                    <h3 class="page_category-menu_title">
                                        <?php echo str_limit($category->name, 28); ?>
                                        <span>
                                            <?php echo str_limit($category->description, 14); ?>
                                            </span>
                                    </h3>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page_layout_block">
            <div class="page_layout_flex">
                <?php include 'index_body.php'; ?>
                <?php get_sidebar('index'); ?>
            </div>
        </div>
        <a href="#" class="page_top_btn" id="TopBtn">
            <img src="<?php bloginfo('template_url'); ?>/assets/images/common/top_btn.png" alt="page top">
        </a>
    </main>
<?php
get_footer();