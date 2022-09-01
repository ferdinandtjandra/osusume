<?php
global $type, $catId, $banners, $articleRecommends, $bottomBanner, $tags, $places, $placeName, $tagName;
$placeName = '全ての地方別';
$tagName = '全てのタグ';
$taxonomy = 'category';
$type = 'index';
$imageArr = ['img_bg01.png', 'img_bg02.png', 'img_bg03.png', 'img_bg04.png', 'img_bg05.png', 'img_bg06.png', 'img_bg07.png', 'img_bg08.png', 'img_bg09.png', 'img_bg10.png'];
$limit = 10;
$args = array(
    'type' => 'post',
    'child_of' => 0,
    'parent' => '',
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => 0, //(检测是否绑定文章, 1/true为有绑定文章的)
    'hierarchical' => '',
    'exclude' => '',
    'include' => '',
    'number' => '',
    'taxonomy' => $taxonomy,
    'pad_counts' => false
);
$categories = get_categories($args);
$cat_ids = [];
foreach ($categories as $key => $item) {
    if($key < 2) {
        $cat_ids[] = $item->cat_ID;
    }
}
$bottomBannerData = array(
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'desc',
    'meta_query' => array(
        array(
            'key' => 'position',
            'value' => '2'
        ),
        array(
            'key' => 'type',
            'value' => '2'
        )
    )
);
$bottomBanner = get_posts($bottomBannerData);

$tags = get_field_object(TAG_FIELD_KEY)['choices'];
$places = get_field_object(PLACE_FIELD_KEY)['choices'];
$type = $GLOBALS['type'];
$taxonomy = 'category';
foreach ($tags as $key => $value) {
    $articleData = get_posts(array(
        'numberposts'   => -1,
        'post_type'     => 'post',
        'meta_query'    => array(
            array(
                'key'       => 'tag',
                'value'     => $key,
                'compare'   => 'LIKE',
            ),
            array(
                'key' => 'type',
                'value' => '1'
            )
        ),
    ));
    if (!empty($articleData)) {
        $tag_arr[$key] = $value;
    }
}
foreach ($places as $key => $value) {
    $placeData = get_posts(array(
        'numberposts'   => -1,
        'post_type'     => 'post',
        'meta_query'    => array(
            array(
                'key'       => 'place',
                'value'     => $key,
                'compare'   => 'LIKE',
            ),
            array(
                'key' => 'type',
                'value' => '1'
            )
        ),
    ));
    if ($placeData) {
        $place_arr[$key] = $value;
    }
}
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$searchArticleArgs = array(
    'showposts'   => $limit,
    'paged' => $paged,
    'post_type'     => 'post',
    'orderby' => 'date',
    'order' => 'desc',
    'meta_query'    => array(
        array(
            'key'       => 'type',
            'value'     => '1',
            'compare'   => '=',
        ),
    ),
    'date_query' => [
        'column' => 'post_date',
        'after' => date('Y-m-d H:i:s',time()-3600*24*7),
    ]
);
$articles = get_posts($searchArticleArgs);
$bannerData = array(
    'posts_per_page' => 5,
    'orderby' => 'date',
    'order' => 'desc',
    'meta_query' => array(
        array(
            'key' => 'position',
            'value' => '1'
        ),
        array(
            'key' => 'type',
            'value' => '2'
        )
    )
);
$banners = get_posts($bannerData);
$args = array(
    'posts_per_page' => 5,
    'orderby' => 'date',
    'order' => 'desc',
    'meta_query' => array(
        array(
            'key' => 'is_recommend',
            'value' => '1'
        ),
        array(
            'key' => 'type',
            'value' => '1'
        )
    )
);
$articleRecommends = get_posts($args);
?>

<?php require('_sp_header.php') ?>

<header class="pc_slide_area">
    <div class="pc_logo_block">
        <div class="pc_logo_block_content">
            <a href="/" class="pc_logo">
                <img src="/wp-content/themes/twentynineteen/images/logo.svg" alt="Resort Baito Dive">
            </a>
            <div class="slide_number_block">
                <div class="slide_number">
                    <span id="slickIndex">1</span>/<?php echo count($cat_ids);?>
                </div>
                <div class="slide_prev_btn" id="slickPrev">
                    <img src="/wp-content/themes/twentynineteen/images/slide_prev_arrow.svg" alt="">
                </div>
                <div class="slide_next_btn" id="slickNext">
                    <img src="/wp-content/themes/twentynineteen/images/slide_next_arrow.svg" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="slide_block_wrap">
        <ul class="slide_block">
            <?php foreach ($cat_ids as $k => $cat_id) { ?>
                <?php $category = get_term($cat_id,$taxonomy); ?>
                <li class="slide_item" style="background-image:url(<?php the_field('image', $taxonomy.'_'.$cat_id);?>)">
                    <a href="/category_list/<?php echo $category->name;?>/" class="slide_link">
                        <div class="slide_text">
                            <p class="slide_text_s">
                                <?php the_field('description_1', $taxonomy.'_'.$cat_id);?>
                            </p>
                            <h3 class="slide_text_m">
                                <span class="blue"><?php echo mb_substr(get_field('description_2', $taxonomy.'_'.$cat_id), 0, 1, 'utf-8');?></span><?php echo mb_substr(get_field('description_2', $taxonomy.'_'.$cat_id),  1, strlen(get_field('description_2',$taxonomy.'_'.$cat_id)), 'utf-8'); ?>
                            </h3>
                            <?php if ($k == 0){?>
                                <h1 class="slide_text_l">
                                    <span class="pink"><?php echo mb_substr($category->name, 0, 1, 'utf-8');?></span><?php echo mb_substr($category->name,  1, strlen($category->name), 'utf-8'); ?>
                                </h1>
                            <?php } else { ?>
                                <h2 class="slide_text_l">
                                    <span class="pink"><?php echo mb_substr($category->name, 0, 1, 'utf-8');?></span><?php echo mb_substr($category->name,  1, strlen($category->name), 'utf-8'); ?>
                                </h2>
                            <?php }?>

                            <div class="slide_text_detail">
                                <?php the_field('description_3', $taxonomy.'_'.$cat_id);?><br>
                                <?php the_field('description_4', $taxonomy.'_'.$cat_id);?>
                            </div>
                        </div>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</header>
<div class="sp_slide_block">
    <ul class="sp_slide_list">
        <?php foreach ($cat_ids as $k => $cat_id) { ?>
            <?php $category = get_term($cat_id,$taxonomy); ?>
            <li class="sp_slide_item">
                <a href="/category_list/<?php echo $category->name;?>/" class="sp_slide_link">
                    <div class="sp_slide_img" style="background-image:url(<?php the_field('image', $taxonomy.'_'.$cat_id);?>);">
                    </div>
                    <div class="sp_slide_text">
                        <p class="sp_slide_text_s">
                            <?php the_field('description_1', $taxonomy.'_'.$cat_id);?>
                        </p>
                        <h3 class="sp_slide_text_m">
                            <span class="blue"><?php echo mb_substr(get_field('description_2', $taxonomy.'_'.$cat_id), 0, 1, 'utf-8');?></span><?php echo mb_substr(get_field('description_2', $taxonomy.'_'.$cat_id),  1, strlen(get_field('description_2',$taxonomy.'_'.$cat_id)), 'utf-8'); ?>
                        </h3>
                        <?php if ($k == 0) {?>
                            <h1 class="sp_slide_text_l">
                                <span class="pink"><?php echo mb_substr($category->name, 0, 1, 'utf-8');?></span><?php echo mb_substr($category->name,  1, strlen($category->name), 'utf-8'); ?>
                            </h1>
                        <?php } else {?>
                            <h2 class="sp_slide_text_l">
                                <span class="pink"><?php echo mb_substr($category->name, 0, 1, 'utf-8');?></span><?php echo mb_substr($category->name,  1, strlen($category->name), 'utf-8'); ?>
                            </h2>
                        <?php }?>
                        <div class="sp_slide_text_detail">
                            <?php the_field('description_3', $taxonomy.'_'.$cat_id);?><br>
                            <?php the_field('description_4', $taxonomy.'_'.$cat_id);?>
                        </div>
                    </div>
                </a>
            </li>
        <?php } ?>
    </ul>
    <div class="sp_slide_number">
        <div class="slide_number_block">
            <div class="slide_number">
                <span id="slickIndexSp">1</span>/<?php echo count($cat_ids);?>
            </div>
            <div class="slide_prev_btn" id="slickPrevSp">
                <img src="/wp-content/themes/twentynineteen/images/slide_prev_arrow.svg" alt="">
            </div>
            <div class="slide_next_btn" id="slickNextSp">
                <img src="/wp-content/themes/twentynineteen/images/slide_next_arrow.svg" alt="">
            </div>
        </div>
    </div>
</div>
<?php get_template_part('template-parts/content/content', 'sp_bottom_menu'); ?>
<section class="category_menu">
    <div class="common_wrap">
        <div class="common_inner">
            <ul class="category_menu_list">
                <li class="category_menu_item">
                    <a href="/list/全ての地方別/全てのタグ/新着/" class="category_menu_link">
                        <img src="/wp-content/themes/twentynineteen/images/icon_new.svg" alt="新着">
                        <p class="category_menu_name">新着</p>
                    </a>
                </li>
                <li class="category_menu_item">
                    <a href="/category_list/エリア特集/" class="category_menu_link">
                        <img src="/wp-content/themes/twentynineteen/images/icon_area.svg" alt="エリア特集">
                        <p class="category_menu_name">エリア特集</p>
                    </a>
                </li>
                <li class="category_menu_item">
                    <a href="/category_list/キャンペーン/" class="category_menu_link">
                        <img src="/wp-content/themes/twentynineteen/images/icon_campaign.svg" alt="キャンペーン">
                        <p class="category_menu_name">キャンペーン</p>
                    </a>
                </li>
                <li class="category_menu_item">
                    <a href="/category_list/お役立ち情報/" class="category_menu_link">
                        <img src="/wp-content/themes/twentynineteen/images/icon_useful.svg" alt="お役立ち">
                        <p class="category_menu_name">お役立ち</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section><!---/category_menu--->
<section class="tag_menu">
    <div class="common_wrap">
        <div class="common_inner">
            <!--タブ-->
            <ul class="tab-group">
                <li class="tab_wrap is-active">
                    <div class="tab_inner">
                        <img src="/wp-content/themes/twentynineteen/images/icon_area_g.svg" alt="地方別" class="tab_icon">
                        <p class="tab_name">
                            地方別
                        </p>
                        <div class="tab is-active">
                            <img src="/wp-content/themes/twentynineteen/images/icon_arrow_up.svg" alt="" class="tab_arrow_icon">
                        </div>
                    </div>
                </li>
                <li class="tab_wrap">
                    <div class="tab_inner">
                        <img src="/wp-content/themes/twentynineteen/images/icon_tag_g.svg" alt="タグ一覧" class="tab_icon">
                        <p class="tab_name">
                            タグ一覧
                        </p>
                        <div class="tab">
                            <img src="/wp-content/themes/twentynineteen/images/icon_arrow_up.svg" alt="" class="tab_arrow_icon">
                        </div>
                    </div>
                </li>
            </ul>
            <!--タブを切り替えて表示するコンテンツ-->
            <div class="panel-group">
                <div class="panel is-show">
                    <ul class="tag_search_list">
                        <?php foreach ($place_arr as $k => $v) { ?>
                            <li class="tag_search_item">
                                <a href="/list/<?php echo $v; ?>/<?php echo $tagName; ?>/" class="tag_wrap">
                                    <div class="tag_inner">
                                        <div class="tag_inner_inner">
                                            <?php echo $v; ?>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div><!---/地方別--->
                <div class="panel">
                    <ul class="tag_search_list">
                        <?php foreach ($tag_arr as $k => $v) { ?>
                            <li class="tag_search_item">
                                <a href="/list/<?php echo $placeName;?>/<?php echo $v; ?>/" class="tag_wrap">
                                    <div class="tag_inner">
                                        <div class="tag_inner_inner">
                                            <?php echo $v; ?>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div><!---/タグ一覧--->
            </div>
        </div>
    </div>
</section><!---/tag_menu--->
<div class="main_content_wrap">
    <div class="common_wrap">
        <div class="common_inner">
            <div class="main_flex">
                <div class="main_left_side">
                    <section class="column_list">
                        <h2 class="common_title">
                            <span class="dark_pink">N</span>EW<span class="common_title_detail">新着記事</span>
                        </h2>
                        <div class="column_box_wrap">
                            <?php foreach ($articles as $key => $value) { ?>
                                <div class="column_box <?php if($key%2 == 0){?>box_white<?php }else{ ?> box_pink<?php } ?>">
                                    <a href="/detail/<?php echo $value->ID ?>/" class="column_box_img">
                                        <div class="<?php if($key%2 == 0){?>column_box_img_bg_left<?php }else{ ?>column_box_img_bg_right<?php } ?>">
                                            <img src="/wp-content/themes/twentynineteen/images/<?php echo $imageArr[$key] ?>" alt="">
                                        </div>
                                        <div class="column_box_img_main" style="background-image: url(<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($value->ID), 'full')[0] ?>);">
                                        </div>
                                    </a>
                                    <div class="column_box_detail">
                                        <a href="/detail/<?php echo $value->ID ?>/">
                                            <h3 class="column_box_title">
                                                <?php echo $value->post_title ?>
                                            </h3>
                                            <p class="column_box_text">
                                                <?php echo strip_tags($value->post_content) ?>
                                            </p>
                                        </a>
                                        <a href="/list/全ての地方別/全てのタグ/新着/" class="column_box_category new">
                                            <img src="/wp-content/themes/twentynineteen/images/icon_new.svg" alt="新着">
                                            新着
                                        </a>
                                        <?php foreach (get_the_category($value->ID) as $k => $val) { ?>
                                            <a href="/category_list/<?php echo $val->name; ?>/" class="column_box_category" style="border: 1px solid <?php echo get_field('color',$taxonomy . '_' . $val->term_id) ?>;color: <?php echo get_field('color',$taxonomy . '_' . $val->term_id) ?>;"><img src="<?php echo get_field('icon',$taxonomy . '_' . $val->term_id) ?>" alt="<?php echo $val->name; ?>"><?php echo $val->name; ?></a>
                                        <?php } ?>
                                    </div>
                                    <div class="column_box_catchphrase">
                                        <?php echo get_post_custom_values('catch', $value->ID)[0] ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="btn_area">
                            <a href="/list/" class="more_btn">
                                VIEW MORE
                                <img src="/wp-content/themes/twentynineteen/images/arrow_right.svg" alt="VIEW MORE">
                            </a>
                        </div>
                    </section>
                </div><!---/main_left_side--->
            <?php get_template_part('template-parts/content/content', 'right_side'); ?>
            </div>
        </div>
    </div>
</div><!---/main_content_wrap--->
