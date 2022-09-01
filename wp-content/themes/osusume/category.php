<?php
get_header();
$url_data = str_array($_SERVER['REQUEST_URI']);
$category_datas = get_category_by_slug($url_data['ctg']);
if (!empty($url_data['tag'])) {
    $tag_datas = get_tags(array('name' => urldecode($url_data['tag'])))[0];
}
if (empty($tag_datas)) {
    $tag_datas->name = '';
}
$tag_datas->names = urldecode($tag_datas->name);
$tag_datas->name = $tag_datas->slug;
?>
    <main class="common_main">

        <div class="header_pankuzu_block">
			<div class="common_inner">
				<div class="header_pankuzu_inner">
					<ul class="header_pankuzu_list">
						<li class="header_pankuzu_item">
							<a href="<?php bloginfo('url'); ?>" class="header_pankuzu_link">TOP</a>
						</li>

						<?php if (is_category()) { ?>
                            <li class="header_pankuzu_item">

                                <?php if($category_datas->category_parent == 0) { ?>
                                <a href="<?php echo get_category_link(get_category_by_slug($url_data['ctg'])->term_id) ?>" class="header_pankuzu_link">
                                <?php } else { ?>
                                <a href="/ctg/<?php echo urldecode($category_datas->slug); ?>" class="header_pankuzu_link">
                                <?php } ?>
                                <?php echo get_category(get_query_var('cat'))->name; ?></a>

                            </li>
                        <?php } ?>

                        <?php if (str_array($_SERVER['REQUEST_URI'])['ctg'] && str_array($_SERVER['REQUEST_URI'])['tag']) { ?>
                            <li class="header_pankuzu_item">
                                <a href="<?php echo get_category_link(get_category_by_slug($url_data['ctg'])->term_id) ?>" class="header_pankuzu_link"><?php echo get_category_by_slug($url_data['ctg'])->name; ?></a>
                            </li>
                            <li class="header_pankuzu_item">
                                <?php echo urldecode(str_array($_SERVER['REQUEST_URI'])['tag']) ?>
                            </li>
                        <?php } ?>

                        <?php if (is_single()) { ?>
                            <li class="header_pankuzu_item">
                                <?php if(get_the_category()[0]->category_parent == 0) { ?>
                                <a href="<?php echo get_category_link(get_the_category()[0]->term_id); ?>" class="header_pankuzu_link"><?php echo get_the_category()[0]->cat_name; ?></a>
                                <?php } else { ?>
                                <a href="/ctg/<?php echo urldecode(get_the_category()[0]->slug); ?>" class="header_pankuzu_link"><?php echo get_the_category()[0]->cat_name; ?></a>
                                <?php } ?>
                            </li>
                            <li class="header_pankuzu_item">
                                <?php echo $post->post_title ?>
                            </li>

                        <?php } ?>

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
                                <a href="<?php echo get_category_link($category->term_id) ?>" class="page_category-menu_link <?php if ($category_datas->term_id == $category->term_id) {
                                    echo 'active';
                                } ?>">
                                <?php } else { ?>
                                <a href="/ctg/<?php echo urldecode($category->slug); ?>" class="page_category-menu_link <?php if ($category_datas->term_id == $category->term_id) {
                                    echo 'active';
                                } ?>">
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
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page_category-mv_block">
            <div class="common_inner">
                <div class="page_category-mv_inner" style="background-image: url(<?php the_field('category_image', $category_datas); ?>);">
                    <h2 class="page_category-mv_title">
                        <?php
                        if (empty($tag_datas->name)) {
                            echo $category_datas->name;
                        } else {
                            echo $category_datas->name . ' ' . urldecode($tag_datas->names);
                        } ?>
                    </h2>
                    <ul class="page_category-mv_list">

                        <?php
                        $args = array('categories' => $category_datas->term_id);
                        $tags_data = get_category_tags($args);
                        if(!empty($tags_data)) {
                            foreach ($tags_data as $tags_data_k => $tags_data_v) { ?>

                                <li class="page_category-mv_item">
                                    <a href="/ctg/<?php echo $category_datas->slug . '/tag/' . $tags_data_v->name ?>" class="page_category-mv_tag">
                                        <?php echo $tags_data_v->name; ?>
                                    </a>
                                </li>

                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page_layout_block">
            <div class="page_layout_flex">
                <div class="page_layout_main">
                    <div class="top_block">
                        <h2 class="page_title02 mb15">
                            <?php echo $category_datas->name; ?> by 人材紹介エージェント研究所
                        </h2>
                        <p class="page_text01 mb30">
                            <?php the_field('category_description', $category_datas); ?>
                        </p>
                        <section class="top_appeal_block01">
                            <h1 class="page_title03 mb15">
                                <?php echo $category_datas->name; ?>の3つの魅力
                            </h1>
                            <ul class="top_appeal_list">
                                <?php for ($i = 1; $i <= 3; $i++) { ?>
                                    <li class="top_appeal_item">
                                        <div class="top_appeal_item_title">
                                            <img src="<?php bloginfo('template_url'); ?>/assets/images/top/num0<?php echo $i; ?>.svg" alt="<?php echo $i; ?>">
                                            <h2 class="title">
                                                <?php the_field('charm' . $i . '_title', $category_datas); ?>
                                            </h2>
                                        </div>
                                        <div class="top_appeal_item_main">
                                            <img src="<?php the_field('charm' . $i . '_icon', $category_datas); ?>" alt="<?php the_field('charm' . $i . '_title', $category_datas); ?>">
                                            <p class="top_appeal_text">
                                                <?php the_field('charm' . $i . '_comment', $category_datas); ?>
                                            </p>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </section>
                        <section class="top_talk_block01">
                            <h1 class="page_title04 mb30">
                                <?php echo $category_datas->name; ?> by 人材紹介エージェント研究所
                            </h1>
                            <div class="detail_editor_wrap">
                                <?php the_field('chart', $category_datas); ?>
                            </div>
                        </section>
                        <?php
                        $args = array(
                            'numberposts' => 3,
                            'tag' => $tag_datas->name,
                            'category' => $category_datas->term_id,
                            'orderby' => 'modified',
                            'order' => 'DESC',
                            'post_type' => 'post',
                            'post_status' => 'publish'
                        );
                        $category_id = $category_datas->term_id;
                        $posts = get_posts($args);
                        if ($posts) { ?>
                            <section class="top_column_block01">
                                <h1 class="page_title04 mb30">
                                    <?php
                                    if (empty($tag_datas->name)) {
                                        echo 'おすすめの' . $category_datas->name . '記事';
                                    } else {
                                        echo 'おすすめの' . $category_datas->name . ' ' . urldecode($tag_datas->names) . 'の記事';
                                    } ?>
                                </h1>
                                <h2 class="page_title03 mb15">
                                    新着記事
                                </h2>
                                <div class="top_column_article_wrap">
                                <?php
                                foreach ($posts as $post_k => $post) { ?>
                                    <article class="top_column_article">
                                        <a href="<?php the_permalink($post->ID) ?>" class="top_column_link">
                                            <?php if ($post_k == 0) { ?>
                                                <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/label01.svg" alt="最新" class="label">
                                            <?php } ?>
                                            <div class="top_column_flex">
                                                <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>)"></div>
                                                <div class="top_column_main">
                                                    <h3 class="title text_overflow">
                                                        <?php echo $post->post_title; ?>
                                                    </h3>
                                                    <p class="text">
                                                        <?php echo !empty($post->post_excerpt) ? $post->post_excerpt : mb_strimwidth(strip_tags($post->post_content), 0, 70, " "); ?>
                                                    </p>
                                                    <p class="date"><?php echo date("Y/m/d", strtotime($post->post_modified)); ?></p>
                                                    <?php end($posts)->ID == $post->ID; ?>
                                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/icon01.svg" alt="star" class="icon" <?php if (end($posts)->ID != $post->ID) { ?> style="display: none;" <?php } ?>>
                                                </div>
                                            </div>
                                        </a>
                                    </article>
                                <?php } ?>
                                </div>
                            </section>
                        <?php } ?>
                    </div>

                    <?php
                    $limit = 20;
                    $args = array(
                        'tag' => $tag_datas->name,
                        'showposts' => $limit,
                        'paged' => $url_data['page'],
                        'category' => $category_datas->term_id,
                        'orderby' => 'modified',
                        'order' => 'DESC',
                        'post_type' => 'post',
                        'post_status' => 'publish'
                    );
                    $category_id = $category_datas->term_id;
                    $posts = get_posts($args);
                    $post_count_args = $args;
                    $post_count_args['numberposts'] = -1;
                    unset($post_count_args['showposts']);
                    unset($post_count_args['paged']);
                    $posts_count = count(get_posts($post_count_args));
                    $page_count = ceil($posts_count / $limit);
                    ?>

                    <?php if (get_field('article_style', $category_datas) == 0) { ?>
                        <div class="top_block">
                            <h2 class="page_title02 mb30">
                                <?php
                                if (empty($tag_datas->name)) {
                                    echo $category_datas->name . '記事一覧';
                                } else {
                                    echo $category_datas->name . ' ' . urldecode($tag_datas->names) . 'の記事一覧';
                                } ?>
                            </h2>
                            <?php if ($posts) { ?>

                                <section class="top_column_block02">
                                    <h1 class="page_title04 mb30">
                                        <?php
                                        if (empty($tag_datas->name)) {
                                            echo $category_datas->name . '記事';
                                        } else {
                                            echo $category_datas->name . ' ' . urldecode($tag_datas->names) . 'の記事';
                                        } ?>
                                    </h1>
                                    <div class="top_column_flex">

                                        <?php foreach ($posts as $post_k => $post) { ?>

                                            <article class="top_column_article">
                                                <a href="<?php the_permalink($post->ID) ?>" class="top_column_link">

                                                    <?php if (get_field('detail_pick_up', $post->ID) == true && $post_k != 0) { ?>
                                                        <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/label03.svg" alt="new" class="label">
                                                    <?php } ?>

                                                    <?php if ($post_k == 0 && empty($url_data['page'])) { ?>
                                                        <img src="<?php bloginfo('template_url'); ?>/assets/images/top/column/label02.svg" alt="new" class="label">
                                                    <?php } ?>

                                                    <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);"></div>
                                                    <div class="top_column_main">
                                                        <h3 class="title">
                                                            <?php echo $post->post_title; ?>
                                                        </h3>
                                                        <p class="text">
                                                            <?php echo !empty($post->post_excerpt) ? $post->post_excerpt : mb_strimwidth(strip_tags($post->post_content), 0, 70, " "); ?>
                                                        </p>
                                                        <span class="date"><?php echo date("Y年m月d日", strtotime($post->post_modified)); ?></span>
                                                    </div>
                                                </a>
                                            </article>

                                        <?php } ?>
                                    </div>
                                </section>

                                <div class="pager_wrap"> <?php MBThemes_paging($page_count); ?> </div>

                            <?php } ?>

                            <section class="page_ranking_block01">
                                <h1 class="page_title04 mb15">
                                    ランキング
                                </h1>
                                <p class="page_ranking_text mb20">
                                    総合比較の結果、ランキング上位の<?php echo $category_datas->name; ?>
                                    はずばり下記の3社になりました！
                                </p>
                                <ul class="page_ranking_list">
                                    <li class="page_ranking_item">
                                        <div class="page_ranking_num">
                                            <p class="num">第<span>1</span>位</p>
                                        </div>
                                        <div class="page_ranking_info">
                                            <div class="category_title" style="text-align: center;"><?php echo get_field('no_1', $category_datas)['no1_title']; ?></div>
                                            <div class="page_ranking_logo" style="background-image: url(<?php echo get_field('no_1', $category_datas)['no1_icon']; ?>);"></div>
                                            <a href="<?php echo get_field('no_1', $category_datas)['no1_review']; ?>" class="page_btn01">口コミ・評価</a>
                                        </div>
                                    </li>
                                    <li class="page_ranking_item">
                                        <div class="page_ranking_num">
                                            <p class="num">第<span>2</span>位</p>
                                        </div>
                                        <div class="page_ranking_info">
                                            <div class="category_title" style="text-align: center;"><?php echo get_field('no_2', $category_datas)['no2_title']; ?></div>
                                            <div class="page_ranking_logo" style="background-image: url(<?php echo get_field('no_2', $category_datas)['no2_icon']; ?>);"></div>
                                            <a href="<?php echo get_field('no_2', $category_datas)['no2_review']; ?>" class="page_btn01">口コミ・評価</a>
                                        </div>
                                    </li>
                                    <li class="page_ranking_item">
                                        <div class="page_ranking_num">
                                            <p class="num">第<span>3</span>位</p>
                                        </div>
                                        <div class="page_ranking_info">
                                            <div class="category_title" style="text-align: center;"><?php echo get_field('no_3', $category_datas)['no3_title']; ?></div>
                                            <div class="page_ranking_logo" style="background-image: url(<?php echo get_field('no_3', $category_datas)['no3_icon']; ?>);"></div>
                                            <a href="<?php echo get_field('no_3', $category_datas)['no3_review']; ?>" class="page_btn01">口コミ・評価</a>
                                        </div>
                                    </li>
                                </ul>
                            </section>
                        </div>
                    <?php } ?>

                    <?php if (get_field('article_style', $category_datas) == 1) { ?>

                        <div class="top_block">
                            <h2 class="page_title02 mb30">
                                <?php
                                if (empty($tag_datas->name)) {
                                    echo $category_datas->name . '記事一覧';
                                } else {
                                    echo $category_datas->name . ' ' . $tag_datas->name . 'の記事一覧';
                                } ?>
                            </h2>
                            <?php if ($posts) { ?>
                                <section class="top_column_block04">
                                    <h1 class="page_title04 mb30">
                                        <?php
                                        if (empty($tag_datas->name)) {
                                            echo $category_datas->name . '記事';
                                        } else {
                                            echo $category_datas->name . ' ' . $tag_datas->name . 'の記事';
                                        } ?>
                                    </h1>
                                    <div class="top_column_flex">
                                        <?php foreach ($posts as $post_k => $post) { ?>
                                            <article class="top_column_article">
                                                <a href="<?php the_permalink($post->ID) ?>" class="top_column_link latest">
                                                    <div class="top_column_pic" style="background-image: url(<?php the_field("detail_img", $post->ID) ?>);"></div>
                                                    <div class="top_column_main">
                                                        <p class="category"><?php echo $category_datas->name; ?></p>
                                                        <h3 class="title">
                                                            <?php echo $post->post_title; ?>
                                                        </h3>
                                                        <p class="date"><?php echo date("Y.m.d", strtotime($post->post_modified)); ?></p>
                                                    </div>
                                                    <?php if ((get_field('detail_pick_up', $post->ID) == true) && $post_k != 0) { ?>
                                                        <p class="label" style="background:#FFD572">おすすめ</p>
                                                    <?php } ?>

                                                    <?php if ($post_k == 0 && empty($url_data['page'])) { ?>
                                                        <p class="label">最新</p>
                                                    <?php } ?>
                                                </a>
                                            </article>
                                        <?php } ?>
                                    </div>
                                </section>

                                <div class="pager_wrap"> <?php MBThemes_paging($page_count); ?> </div>

                            <?php } ?>
                            <section class="page_ranking_block02">
                                <h1 class="page_title04 mb15">
                                    ランキング
                                </h1>
                                <p class="page_ranking_text mb20">
                                    総合比較の結果、ランキング上位の<?php echo $category_datas->name; ?>
                                    はずばり下記の3社になりました！
                                </p>
                                <div class="page_ranking_list">
                                    <dl class="page_ranking_item">
                                        <dt class="page_ranking_num">
                                            第<span>1</span>位
                                        </dt>
                                        <dd class="page_ranking_info">
                                            <div class="category_title" style="text-align: center;"><?php echo get_field('no_1', $category_datas)['no1_title']; ?></div>
                                            <div class="page_ranking_logo" style="background-image: url(<?php echo get_field('no_1', $category_datas)['no1_icon']; ?>);"></div>
                                            <a href="<?php echo get_field('no_1', $category_datas)['no1_review']; ?>"
                                               class="page_btn01">口コミ・評価</a>
                                        </dd>
                                    </dl>
                                    <dl class="page_ranking_item">
                                        <dt class="page_ranking_num">
                                            第<span>2</span>位
                                        </dt>
                                        <dd class="page_ranking_info">
                                            <div class="category_title" style="text-align: center;"><?php echo get_field('no_2', $category_datas)['no2_title']; ?></div>
                                            <div class="page_ranking_logo" style="background-image: url(<?php echo get_field('no_2', $category_datas)['no2_icon']; ?>);"></div>
                                            <a href="<?php echo get_field('no_2', $category_datas)['no2_review']; ?>"
                                               class="page_btn01">口コミ・評価</a>
                                        </dd>
                                    </dl>
                                    <dl class="page_ranking_item">
                                        <dt class="page_ranking_num">
                                            第<span>3</span>位
                                        </dt>
                                        <dd class="page_ranking_info">
                                            <div class="category_title" style="text-align: center;"><?php echo get_field('no_3', $category_datas)['no3_title']; ?></div>
                                            <div class="page_ranking_logo" style="background-image: url(<?php echo get_field('no_3', $category_datas)['no3_icon']; ?>);"></div>
                                            <a href="<?php echo get_field('no_3', $category_datas)['no3_review']; ?>"
                                               class="page_btn01">口コミ・評価</a>
                                        </dd>
                                    </dl>
                                </div>
                            </section>
                        </div>
                    <?php } ?>

                    <?php
                    if (get_field("is_show_rank", $category_datas) == 1) { ?>
                        <div class="top_block">
                            <h2 class="page_title02 mb30">
                                <?php echo $category_datas->name; ?>総合ランキング
                            </h2>
                            <div class="detail_editor_wrap">
                                <div class="page_table_block">
                                    <table class="page_table01">
                                        <?php
                                        $no_array = array();
                                        for ($i = 1;
                                             $i < 30;
                                             $i++) {
                                            $no_array[] = $i;
                                        }
                                        $no_data = array();
                                        foreach ($no_array as $no_k => $no_v) {
                                            $no_num = 'no_' . $no_v;
                                            $data = get_field($no_num, $category_datas);
                                            if (empty($data)) {
                                                break;
                                            }
                                            $no_data[] = $data;
                                        }
                                        ?>
                                        <tr>
                                            <th class="page_table_title width01" rowspan="2">総合<br>ランキング</th>
                                            <th class="page_table_title width02" rowspan="2">転職エージェント名</th>
                                            <th class="page_table_title width03" colspan="2">待遇比較</th>
                                            <th class="page_table_title width02" rowspan="2">ランキング</th>
                                        </tr>
                                        <tr>
                                            <th class="page_table_title width01"><?php the_field("wage", $category_datas) ?></th>
                                            <th class="page_table_title width01"><?php the_field("vacation", $category_datas) ?></th>
                                        </tr>

                                        <?php foreach ($no_data as $no_data_k => $no_data_v) {
                                            $list_num = $no_data_k + 1;
                                            ?>
                                            <tr>
                                                <td class="page_table_info rank0<?php echo $list_num; ?>">
                                                    <p class="rank_text">第<span><?php echo $list_num ?></span>位</p>
                                                </td>
                                                <td class="page_table_info">
                                                    <div class="category_title"><?php echo $no_data_v['no' . $list_num . '_title'] ?></div>
                                                    <div class="page_table_logo" style="background-image: url(<?php echo $no_data_v['no' . $list_num . '_icon'] ?>);"></div>
                                                    <a href="<?php echo $no_data_v['no' . $list_num . '_detail'] ?>"
                                                       class="page_btn01">詳細</a>
                                                </td>
                                                <td class="page_table_info salery">
                                                    <?php echo $no_data_v['no' . $list_num . '_salary'] ?>
                                                </td>
                                                <td class="page_table_info">
                                                    <?php echo $no_data_v['no' . $list_num . '_holiday'] ?>
                                                </td>
                                                <td class="page_table_info">
                                                    <?php echo $no_data_v['no' . $list_num . '_ranking'] ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="top_block">
                        <h2 class="page_title02 mb30">
                            <?php the_field('recommended', $category_datas); ?>がおすすめの3つの理由！
                        </h2>
                        <ul class="page_point_list01 mb30">
                            <?php for ($i = 1; $i <= 3; $i++) { ?>
                                <li class="page_point_item">
                                    <h3 class="page_point_title">
                                        <img src="<?php bloginfo('template_url'); ?>/assets/images/page/check_icon.svg" alt="point">
                                        <?php the_field('reason' . $i . '_title', $category_datas); ?>
                                    </h3>
                                    <p class="page_point_text">
                                        <?php the_field('reason' . $i . '_description', $category_datas); ?>
                                    </p>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                        $args = array(
                            'offset' => 0,
                            'category' => $category_datas->term_id,
                            'order' => 'DESC',
                            'post_type' => 'comments',
                            'post_status' => 'publish'
                        );
                        $posts_data = get_posts($args);
                        $points = 0;
                        $num = 0;
                        if ($posts_data) {
                            foreach ($posts_data as $posts_data_k => $posts_data_v) {
                                $num++;
                                $points += $posts_data_v->good_review_score;
                            }
                            $average = round($points / $num, 2);
                        } else {
                            $average = 0;
                        }

                        $average_int = intval($average);
                        $average_empty = 5 - ceil($average);
                        ?>

                        <section class="page_voice_block01">
                            <h1 class="page_voice_title">
                                <span><?php the_field('recommended', $category_datas); ?>の口コミ</span>
                            </h1>
                            <div class="page_voice_info">
                                <p class="title">口コミ平均<span>(<?php echo $num; ?>件)</span></p>
                                <div class="page_voice_info_inner">
                                    <p class="score"><?php echo $average; ?>点</p>
                                    <ul class="page_voice_star_list">
                                        <?php for ($i = 0;
                                                   $i < $average_int;
                                                   $i++) { ?>
                                            <li class="page_voice_star_item">
                                                <img src="<?php bloginfo('template_url'); ?>/assets/images/page/star03.svg" alt="star">
                                            </li>
                                        <?php } ?>
                                        <?php if ($average != $average_int) { ?>
                                            <li class="page_voice_star_item">
                                                <img src="<?php bloginfo('template_url'); ?>/assets/images/page/star02.svg" alt="star">
                                            </li>
                                        <?php } ?>
                                        <?php for ($i = 0;
                                                   $i < $average_empty;
                                                   $i++) { ?>
                                            <li class="page_voice_star_item">
                                                <img src="<?php bloginfo('template_url'); ?>/assets/images/page/star01.svg" alt="star">
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>

                            <?php foreach ($posts_data as $postk => $post) {
                                $postk = $postk * 2;
                                $post_left_id = $posts_data[$postk]->ID;
                                $post_right_id = $posts_data[$postk + 1]->ID;
                                ?>
                                <ul class="page_voice_list mb20">
                                    <?php if ($posts_data[$postk]) { ?>
                                        <li class="page_voice_item">
                                            <?php if (get_field('good_review_score', $post_left_id) >= 3) { ?>
                                                <p class="page_voice_item_title" style="background: #e678af;color:#fff">
                                                    良い評価・口コミ</p>
                                            <?php } else { ?>
                                                <p class="page_voice_item_title" style="background: #959595;color:#fff">
                                                    低い評価・口コミ</p>
                                            <?php } ?>

                                            <div class="page_voice_item_main">
                                                <div class="page_voice_item_info">
                                                    <div class="page_voice_item_info_left">
                                                        <img src="<?php the_field('good_review_image', $post_left_id); ?>" alt="<?php the_field('category_description', $post->ID); ?>">
                                                        <p class="name">

                                                        <?php the_field('good_review_name', $post_left_id); ?>
                                                        <span>
                                                            <?php the_field('good_review_age', $post_left_id); ?>
                                                            ・<?php the_field('good_review_gender', $post_left_id); ?>
                                                        </span>

                                                        </p>
                                                    </div>
                                                    <div class="page_voice_item_info_right">
                                                        <p class="score"><?php the_field('good_review_score', $post_left_id); ?>
                                                            点</p>
                                                        <ul class="page_voice_star_list">

                                                            <?php for ($i = 0;
                                                                       $i < get_field('good_review_score', $post_left_id);
                                                                       $i++) { ?>
                                                                <li class="page_voice_star_item">
                                                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/star03.svg" alt="star">
                                                                </li>
                                                            <?php } ?>

                                                            <?php for ($i = 0;
                                                                       $i < 5 - get_field('good_review_score', $post_left_id);
                                                                       $i++) { ?>
                                                                <li class="page_voice_star_item">
                                                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/star01.svg" alt="star">
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <p class="page_voice_item_text" id="<?php echo 'comment_' . $postk; ?>">
                                                    <?php the_field('good_review_comment', $post_left_id); ?>
                                                </p>

                                                <div class="align_right" style="display: none;">
                                                    <button type="button" class="page_voice_more_btn ViewBtn">
                                                        全て表示
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>

                                    <?php if ($posts_data[$postk + 1]) { ?>
                                        <li class="page_voice_item">

                                            <?php if (get_field('good_review_score', $post_right_id) >= 3) { ?>
                                                <p class="page_voice_item_title" style="background: #e678af;color:#fff">
                                                    良い評価・口コミ</p>
                                            <?php } else { ?>
                                                <p class="page_voice_item_title" style="background: #959595;color:#fff">
                                                    低い評価・口コミ</p>
                                            <?php } ?>
                                            <div class="page_voice_item_main">
                                                <div class="page_voice_item_info">
                                                    <div class="page_voice_item_info_left">
                                                        <img src="<?php the_field('good_review_image', $post_right_id); ?>" alt="<?php the_field('category_description', $post->ID); ?>">
                                                        <p class="name">

                                                        <?php the_field('good_review_name', $post_right_id); ?>

                                                        <span>
                                                            <?php the_field('good_review_age', $post_right_id); ?>
                                                            ・<?php the_field('good_review_gender', $post_right_id); ?>
                                                        </span>

                                                        </p>
                                                    </div>
                                                    <div class="page_voice_item_info_right">
                                                        <p class="score"><?php the_field('good_review_score', $post_right_id); ?>
                                                            点</p>
                                                        <ul class="page_voice_star_list">
                                                            <?php for ($i = 0;
                                                                       $i < get_field('good_review_score', $post_right_id);
                                                                       $i++) { ?>
                                                                <li class="page_voice_star_item">
                                                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/star03.svg" alt="star">
                                                                </li>
                                                            <?php } ?>

                                                            <?php for ($i = 0;
                                                                       $i < 5 - get_field('good_review_score', $post_right_id);
                                                                       $i++) { ?>
                                                                <li class="page_voice_star_item">
                                                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/star01.svg" alt="star">
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <p class="page_voice_item_text" id="<?php echo 'comment_' . ($postk + 1); ?>">
                                                    <?php the_field('good_review_comment', $post_right_id); ?>
                                                </p>


                                                <div class="align_right" style="display: none;">
                                                    <button type="button" class="page_voice_more_btn ViewBtn">
                                                        全て表示
                                                    </button>
                                                </div>

                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                            <a href="<?php the_field('jobs_detail_link', $category_datas); ?>" class="page_btn02">
                                <?php the_field('recommended', $category_datas); ?>を詳しく見る
                            </a>
                        </section>
                    </div>
                    <div class="top_block">
                        <h2 class="page_title02 mb30">
                            おすすめ2社徹底比較！
                        </h2>
                        <div class="page_compare_block">
                            <img src="<?php bloginfo('template_url'); ?>/assets/images/page/pic01.png" alt="徹底比較" class="page_compare_pic">
                            <table class="page_compare_table">
                                <tr>

                                    <td class="page_compare_info">
                                        <div class="category_title"><?php echo get_field('company1_title', $category_datas); ?></div>
                                        <div class="page_compare_logo" style="background-image: url(<?php the_field('company1_image', $category_datas); ?>"></div>
                                    </td>


                                    <td class="page_compare_info"></td>


                                    <td class="page_compare_info">
                                        <div class="category_title"><?php echo get_field('company2_title', $category_datas); ?></div>
                                        <div class="page_compare_logo" style="background-image: url(<?php the_field('company2_image', $category_datas); ?>);"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="page_compare_info">
                                        <ul class="page_compare_star_list">
                                            <?php for ($i = 0;
                                                       $i < get_field('company1_salary_points', $category_datas);
                                                       $i++) { ?>
                                                <li class="page_compare_star_item">
                                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/star03.svg" alt="star">
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                    <th class="page_compare_title"><?php echo get_field('compare1_title', $category_datas); ?></th>
                                    <td class="page_compare_info">
                                        <ul class="page_compare_star_list">
                                            <?php for ($i = 0;
                                                       $i < get_field('company2_salary_points', $category_datas);
                                                       $i++) { ?>
                                                <li class="page_compare_star_item">
                                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/star03.svg" alt="star">
                                                </li>
                                            <?php } ?>

                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="page_compare_info">
                                        <ul class="page_compare_star_list">
                                            <?php for ($i = 0;
                                                       $i < get_field('company1_support_points', $category_datas);
                                                       $i++) { ?>
                                                <li class="page_compare_star_item">
                                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/star03.svg" alt="star">
                                                </li>
                                            <?php } ?>

                                        </ul>
                                    </td>
                                    <th class="page_compare_title"><?php echo get_field('compare2_title', $category_datas); ?></th>
                                    <td class="page_compare_info">
                                        <ul class="page_compare_star_list">

                                            <?php for ($i = 0;
                                                       $i < get_field('company2_support_points', $category_datas);
                                                       $i++) { ?>
                                                <li class="page_compare_star_item">
                                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/star03.svg" alt="star">
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="page_compare_info">
                                        <ul class="page_compare_star_list">
                                            <?php for ($i = 0;
                                                       $i < get_field('company1_treatment_points', $category_datas);
                                                       $i++) { ?>
                                                <li class="page_compare_star_item">
                                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/star03.svg" alt="star">
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                    <th class="page_compare_title"><?php echo get_field('compare3_title', $category_datas); ?></th>
                                    <td class="page_compare_info">
                                        <ul class="page_compare_star_list">
                                            <?php for ($i = 0;
                                                       $i < get_field('company2_treatment_points', $category_datas);
                                                       $i++) { ?>
                                                <li class="page_compare_star_item">
                                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/star03.svg" alt="star">
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <ul class="page_compare_list">
                            <li class="page_compare_item">
                                <h3 class="title">
                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/compare_icon01.svg" alt="<?php echo get_field('compare1_title', $category_datas); ?>">
                                    <span><?php echo get_field('compare1_title', $category_datas) . 'で比較'; ?></span>
                                </h3>
                                <p class="text">

                                    <?php the_field('salary_comparison', $category_datas); ?>
                                </p>
                            </li>
                            <li class="page_compare_item">
                                <h3 class="title">
                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/compare_icon02.svg" alt="<?php echo get_field('compare2_title', $category_datas); ?>">
                                    <span><?php echo get_field('compare2_title', $category_datas) . 'で比較'; ?></span>
                                </h3>
                                <p class="text">
                                    <?php the_field('support_comparison', $category_datas); ?>
                                </p>
                            </li>
                            <li class="page_compare_item">
                                <h3 class="title">
                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/compare_icon03.svg" alt="<?php echo get_field('compare3_title', $category_datas); ?>">
                                    <span><?php echo get_field('compare3_title', $category_datas) . 'で比較'; ?></span>
                                </h3>
                                <p class="text">
                                    <?php the_field('treatment_comparison', $category_datas); ?>
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="top_block">
                        <h2 class="page_title02 mb30">
                            関連サイト
                        </h2>
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
                            <div class="page_related_block">
                                <?php foreach ($posts as $post_k => $post) { ?>
                                    <article class="page_related_article">
                                        <a href="<?php the_field("related_site1_link", $post->ID) ?>" class="page_related_link">
                                            <div class="page_related_pic" style="background-image: url(<?php the_field("related_site1_img", $post->ID) ?>);">
                                                <?php if ($post_k == 0) { ?>
                                                    <img src="<?php bloginfo('template_url'); ?>/assets/images/page/related_icon.svg" alt="icon" class="icon">
                                                <?php } ?>
                                            </div>
                                            <div class="page_related_main">
                                                <h3 class="title"><?php echo $post->post_title; ?></h3>
                                                <p class="text">
                                                    <?php echo $post->post_content; ?>
                                                </p>
                                            </div>
                                        </a>
                                    </article>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="top_block">
                        <h2 class="page_title02 mb30">
                            よく見られている<?php echo $category_datas->name; ?>キーワード
                        </h2>
                        <ul class="page_keyword_list">
                            <?php
                            $args = array('categories' => $category_datas->term_id);
                            $tags_data = get_category_tags($args);
                            foreach ($tags_data as $tags_data_k => $tags_data_v) { ?>
                                <li class="page_keyword_item">
                                    <a href="/ctg/<?php echo $category_datas->slug . '/tag/' . $tags_data_v->name ?>" class="page_keyword_link">
                                        <?php echo $tags_data_v->name; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php get_sidebar('category'); ?>
            </div>

            <div class="common_inner">
                <section class="page_blog_wrap">
                    <div class="detail_editor_wrap">
                        <?php the_field('blog', $category_datas); ?>
                    </div>
                </section>
            </div>

        </div>
        <a href="#" class="page_top_btn" id="TopBtn">
            <img src="<?php bloginfo('template_url'); ?>/assets/images/common/top_btn.png" alt="page top">
        </a>
    </main>
    <script>
        var num = <?php echo count($posts_data); ?>;
        for (var i = 0; i < num; i++) {
            var height = $('#comment_' + i).height();

            if (height >= 94) {
                $('#comment_' + i).next().show();
            }
        }
    </script>
<?php
get_footer();
