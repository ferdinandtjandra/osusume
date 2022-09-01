<?php
    $placeName = $GLOBALS['placeName'] ? $GLOBALS['placeName'] : '全ての地方別';
    $tagName = $GLOBALS['tagName'] ? $GLOBALS['tagName'] : '全てのタグ';
    $taxonomy = 'category';
    $banners = $GLOBALS['banners'];
    $articleRecommends = $GLOBALS['articleRecommends'];
?>
<div class="main_right_side">
    <div class="main_right_content">
        <?php if ($banners): ?>
            <section class="banner_area">
                <ul class="banner_list">
                    <?php foreach ($banners as $key => $value) { ?>
                        <li class="banner_item">
                            <a href="<?php echo get_field('url', $value->ID); ?>" class="banner_link">
                                <img src="<?php echo get_field('image', $value->ID)['url']; ?>" alt="">
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </section>
        <?php endif ?>

        <?php if ($articleRecommends): ?>
            <section class="ranking">
                <div class="common_black_title">
                    <h2>RANKING</h2>
                    <p>人気記事</p>
                </div>
                <ul class="right_side_column_box_wrap">
                    <?php foreach ($articleRecommends as $key => $value) {?>
                        <li class="right_side_column_box">
                            <a href="/detail/<?php echo $value->ID; ?>/" class="right_side_column_img" style="background-image:url(<?php  echo wp_get_attachment_image_src(get_post_thumbnail_id($value->ID), 'full')[0] ?>);">
                                <div class="crown_img">
                                    <p class="ranking_number">
                                        <span><?php echo $key+1 ?></span>
                                    </p>
                                </div>
                            </a>
                            <a href="/detail/<?php echo $value->ID; ?>/">
                                <h3 class="right_side_column_box_title">
                                    <?php echo $value->post_title ?>
                                </h3>
                            </a>
                            <?php $dateDiff = floor((time() - strtotime($value->post_date)) / 86400); ?>
                            <?php if ($dateDiff <= 7): ?>
                                <a href="/list/全ての地方別/全てのタグ/新着/" class="column_box_category new">
                                    <img src="/wp-content/themes/twentynineteen/images/icon_new.svg" alt="新着">
                                    新着
                                </a>
                            <?php endif ?>
                            <?php foreach (get_the_category($value->ID) as $k => $val) { ?>
                                <a href="/category_list/<?php echo $val->name; ?>/" class="right_side_column_box_category area" style="border: 1px solid <?php echo get_field('color',$taxonomy . '_' . $val->term_id) ?>;color: <?php echo get_field('color',$taxonomy . '_' . $val->term_id) ?>;">
                                    <img src="<?php echo get_field('icon',$taxonomy . '_' . $val->term_id) ?>" alt="<?php echo $val->name; ?>">
                                    <?php echo $val->name; ?>
                                </a>
                            <?php } ?>
                            <a href="/detail/<?php echo $value->ID; ?>/" class="right_side_column_box_text">
                                <?php echo strip_tags($value->post_content) ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </section>
        <?php endif ?>

        <?php require('_job_recommend.php') ?>
    </div>
</div><!---/main_right_side--->
