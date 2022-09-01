<?php
global $type, $catId, $banners, $articleRecommends, $bottomBanner, $tags, $places, $placeName, $tagName;
$placeName = '全ての地方別';
$tagName = '全てのタグ';
$taxonomy = 'category';
$type = 'list';
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
foreach ($categories as $item) {
    $cat_ids[] = $item->cat_ID;
}
$bottomBannerData = array(
    'posts_per_page' => 5,
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
$type = 'list';
$taxonomy = 'category';
$cat_id = $GLOBALS['cat_id'];
$banners = $GLOBALS['banners'];
$articleRecommends = $GLOBALS['articleRecommends'];
$bottomBanner = $GLOBALS['bottomBanner'];
$tag_arr = $tags;
$place_arr = $places;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$url = $_SERVER['REQUEST_URI'];
$params = explode('/', $url);
$placeName = urldecode($params[2]);
$tagName = urldecode($params[3]);
$isNew = urldecode($params[4]);
$searchArticleArgs = [
    'showposts'   => $limit,
    'paged' => $paged,
    'post_type'     => 'post',
    'orderby' => 'date',
    'order' => 'desc',
    'meta_query'    => [
        [
            'key'       => 'type',
            'value'     => 1,
            'compare'   => '=',
        ],
    ]
];

if ($isNew == '新着') {
    $searchArticleArgs['date_query'] = [
        'column' => 'post_date',
        'after' => date('Y-m-d H:i:s',time()-3600*24*7),
    ];
}
if ($placeName != '全ての地方別' && $placeName != '' && $placeName != 'page') {
    $placeId = array_search($placeName, $places);
    if ($placeId) {
        $searchArticleArgs['meta_query'][] = [
            'key'       => 'place',
            'value'     => $placeId,
            'compare'   => 'LIKE',
        ];
    } else {
        header("HTTP/1.1 200 OK");
        include(TEMPLATEPATH.'/404.php');
        exit;
    }
} else {
    $placeName = '全ての地方別';
}
if ($tagName != '全てのタグ' && $tagName != '' && !is_numeric($tagName)) {
    $tagId = array_search($tagName, $tags);
    if ($tagId) {
        $searchArticleArgs['meta_query'][] = [
            'key'       => 'tag',
            'value'     => $tagId,
            'compare'   => 'LIKE',
        ];
    } else {
        header("HTTP/1.1 200 OK");
        include(TEMPLATEPATH.'/404.php');
        exit;
    }
} else {
    $tagName = '全てのタグ';
}
$articles = get_posts($searchArticleArgs);
$searchArticleArgs['numberposts'] = -1;
unset($searchArticleArgs['showposts']);
unset($searchArticleArgs['paged']);
$posts_count=count(get_posts($searchArticleArgs));
$maxPage = ceil($posts_count/$limit);
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
	<div class="pc_logo_block" style="height: 50px;">
		<div class="pc_logo_block_content">
			<a href="/" class="pc_logo">
				<img src="/wp-content/themes/twentynineteen/images/logo.svg" alt="Resort Baito Dive" style="height: 50px">
			</a>
		</div>
	</div>
</header>
<div class="pankuzu_wrap">
	<div class="common_wrap">
		<div class="common_inner">
			<ul class="pankuzu_list">
				<li class="pankuzu_item">
					<a href="/" class="pankuzu_link">リゾートバイトTOP</a>
				</li>
				<li class="pankuzu_item">
					記事一覧
				</li>
			</ul>
		</div>
	</div>
</div>
<?php get_template_part('template-parts/content/content', 'sp_bottom_menu'); ?>
<div class="main_content_wrap">
	<div class="common_wrap">
		<div class="common_inner">
			<div class="main_flex">
				<div class="main_left_side">
					<section class="column_list">
						<h2 class="common_title">
							<span class="dark_pink">L</span>IST<span class="common_title_detail">記事一覧</span>
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
                                        <?php $date = floor((time() - strtotime($value->post_date)) / 86400); ?>
                                        <?php if ($date <= 7): ?>
                                            <a href="/list/全ての地方別/全てのタグ/新着/" class="column_box_category new">
                                                <img src="/wp-content/themes/twentynineteen/images/icon_new.svg" alt="新着">
                                                新着
                                            </a>
                                        <?php endif ?>
                                        <?php foreach (get_the_category($value->ID) as $k => $val) { ?>
                                            <a href="/category_list/<?php echo $val->name; ?>/" class="column_box_category" style="border: 1px solid <?php echo get_field('color',$taxonomy . '_' . $val->term_id) ?>;color: <?php echo get_field('color',$taxonomy . '_' . $val->term_id) ?>;">
                                                <img src="<?php echo get_field('icon',$taxonomy . '_' . $val->term_id) ?>" alt="<?php echo $val->name; ?>">
                                                <?php echo $val->name; ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <div class="column_box_catchphrase">
                                        <?php echo get_post_custom_values('catch', $value->ID)[0] ?>
                                    </div>
                                </div>
                            <?php } ?>
						</div>
						<div class="btn_area">
                            <?php MBThemes_paging($maxPage);?>
						</div>
					</section>
				</div><!---/main_left_side--->
				<?php get_template_part('template-parts/content/content', 'right_side'); ?>
			</div>
		</div>
	</div>
</div><!---/main_content_wrap--->
