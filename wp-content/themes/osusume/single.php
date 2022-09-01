<?php
get_header();
$detail_style = get_field("detail_style", $post->ID);
$single = $post->ID;
$cat_name = get_the_category()[0]->cat_name;
$cat_id = get_the_category()[0]->term_id;
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
                                <a href="<?php echo get_category_link(get_category_by_slug($url_data['ctg'])->term_id) ?>" class="header_pankuzu_link"><?php echo get_category(get_query_var('cat'))->name; ?></a>
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


        <?php if (get_field("detail_head_style", $post->ID) == 1) { ?>
            <div class="detail_mv_block01">
                <div class="common_inner">
                    <ul class="category_list">
                        <li class="category_item"><?php echo $cat_name; ?></li>
                    </ul>
                    <h1 class="title">
                        <?php the_title(); ?>
                    </h1>
                    <div class="info_block">
                        <p class="upload_date">
                            <img src="<?php bloginfo('template_url'); ?>/assets/images/detail/icon01.svg" alt="アップロード日">
                            <?php the_time('Y/m/d'); ?>
                        </p>
                        <p class="renewal_date">
                            <img src="<?php bloginfo('template_url'); ?>/assets/images/detail/icon02.svg" alt="更新日">
                            <?php the_modified_time('Y/m/d'); ?>
                        </p>
                    </div>
                    <div class="pic" style="background-image: url(<?php echo get_field('detail_img'); ?>);"></div>
                    <div class="sns_block">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(the_permalink()) ?>" target="_blank" class="fb_btn">
                            <img src="<?php bloginfo('template_url'); ?>/assets/images/detail/fb_icon.svg" alt="Facebook">
                            Facebook
                        </a>

                        <a href="http://twitter.com/share?url=<?php echo urlencode(the_permalink()) ?>" target="_blank" class="twitter_btn">
                            <img src="<?php bloginfo('template_url'); ?>/assets/images/detail/twitter_icon.svg"
                                 alt="Twitter">
                            Twitter
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php
        if (get_field("detail_head_style", $post->ID) == 0) { ?>

            <div class="detail_mv_block02">
                <div class="common_inner">
                    <p class="category">
                        <img src="<?php bloginfo('template_url'); ?>/assets/images/detail/icon03.svg" alt="カテゴリー"><?php echo $cat_name; ?>
                    </p>
                    <h1 class="title"><?php the_title(); ?></h1>

                    <div class="info_flex">

                            <p class="date">
                                <img src="<?php bloginfo('template_url'); ?>/assets/images/detail/icon01.svg" alt="アップロード日"><?php the_modified_time('Y/m/d'); ?>
                            </p>
                            <p class="writer_name"><?php echo get_the_author_meta('display_name', $post->post_author) ?></p>

                    </div>

                    <div class="pic" style="background-image: url(<?php echo get_field('detail_img'); ?>);"></div>

                    <div class="info_block">

                        <div class="sns_block">
                            <a href="http://twitter.com/share?url=<?php echo urlencode(the_permalink()) ?>" target="_blank" class="twitter_btn">
                                <img src="<?php bloginfo('template_url'); ?>/assets/images/detail/twitter_icon.svg" alt="twitter">
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(the_permalink()) ?>" target="_blank" class="fb_btn">
                                <img src="<?php bloginfo('template_url'); ?>/assets/images/detail/fb_icon.svg" alt="facebook">
                            </a>
                            <a href="https://social-plugins.line.me/lineit/share?url=<?php echo urlencode(the_permalink()) ?>" class="line_btn" target="_blank">
                                <img src="<?php bloginfo('template_url'); ?>/assets/images/detail/line_icon.svg" alt="line">
                            </a>
                        </div>
                    </div>


                </div>
            </div>

        <?php } ?>

        <div class="page_layout_block">
            <?php
            $args = array(
                'numberposts' => 5,
                'offset' => 0,
                'category' => $cat_id,
                'orderby' => 'modified',
                'order' => 'DESC',
                'post_type' => 'post',
                'post_status' => 'publish');
            $posts = get_posts($args); ?>

            <div class="page_layout_flex">
                <div class="page_layout_main">
                    <div class="detail_editor_wrap">
                        <?php the_content(); ?>
                    </div>
                    <!-- 関連記事 -->
                    <?php
                    if ($detail_style == 0) { ?>
                        <div class="detail_related_block01">
                            <h2 class="main_title"><span>関連記事</span></h2>
                            <div class="inner">
                                <ul class="list">
                                    <?php foreach ($posts as $post_k => $post0) { ?>
                                        <?php if ($single != $post0->ID) { ?>
                                            <li class="item">
                                                <a href="<?php echo get_permalink($post0->ID) ?>" class="link">
                                                    <div class="main">
                                                        <h3 class="title">
                                                            <?php echo $post0->post_title; ?>
                                                        </h3>
                                                        <p class="text">
                                                            <?php echo !empty($post0->post_excerpt) ? $post0->post_excerpt : mb_strimwidth(strip_tags($post0->post_content), 0, 70, " "); ?>
                                                        </p>
                                                        <ul class="category_list">
                                                            <li class="category_item" style="background: #d23c31;"><?php echo $cat_name; ?>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="pic" style="background-image: url(<?php the_field('detail_img', $post0->ID) ?>);"></div>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($detail_style == 1) { ?>
                        <div class="detail_related_block02">
                            <h2 class="page_title02 mb20">
                                あわせて読みたい記事リスト
                            </h2>
                            <ul class="list">
                                <?php foreach ($posts as $post_k => $post1) { ?>
                                    <?php if ($single != $post1->ID) { ?>
                                        <li class="item">
                                            <a href="<?php echo get_permalink($post1->ID) ?>" class="link">
                                                <?php echo $post1->post_title; ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
                <?php get_sidebar('single'); ?>

            </div>
            <!-- 関連記事 -->
            <div class="detail_related_block03">
                <?php
                $args_related = array(
                    'numberposts' => 5,
                    'offset' => 0,
                    'category' => $cat_id,
                    'orderby' => 'modified',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'post_status' => 'publish');
                $posts = get_posts($args_related); ?>

                <?php if ($detail_style == 2) { ?>
                    <div class="common_inner">
                        <h3 class="main_title">
                            <span><?php echo $cat_name; ?></span>の関連記事
                        </h3>
                        <ul class="list">
                            <?php foreach ($posts as $post2) { ?>
                                <?php if ($single != $post2->ID) { ?>
                                    <li class="item">
                                        <a href="<?php echo get_permalink($post2->ID) ?>" class="link">
                                            <div class="pic" style="background-image: url(<?php the_field('detail_img', $post2->ID) ?>);"></div>
                                            <p class="date">
                                                <img src="<?php bloginfo('template_url'); ?>/assets/images/detail/clock_icon.svg" alt="time">
                                                <?php echo date("Y.m.d", strtotime($post2->post_modified)); ?>
                                            </p>
                                            <h3 class="title">
                                                <?php echo $post2->post_title ?>
                                            </h3>
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
        <a href="#" class="page_top_btn" id="TopBtn">
            <img src="<?php bloginfo('template_url'); ?>/assets/images/common/top_btn.png" alt="page top">
        </a>
    </main>
<?php
get_footer();