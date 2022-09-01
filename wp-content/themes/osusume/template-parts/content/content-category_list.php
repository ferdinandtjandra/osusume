<?php
	// add by yamamoto
	global $type, $catId, $banners, $articleRecommends, $bottomBanner, $tags, $places, $catName, $placeName, $tagName;
	$nowUrl = $_SERVER['REQUEST_URI'];
	$catId = '';
	$tagId = '';
	$placeId = '';
	$catName = '全てのカテゴリー';
	$placeName = '全ての地方別';
	$tagName = '全てのタグ';
	$tags = get_field_object(TAG_FIELD_KEY)['choices'];
    $places = get_field_object(PLACE_FIELD_KEY)['choices'];
	$params = explode('/', rtrim($nowUrl, '/'));
	if (count($params) > 7) {
		loadCustomTemplate(TEMPLATEPATH.'/404.php');
	}
	if (!in_array('page', $params)) {
		if (isset($params[2]) && !empty($params[2])) {
			$catId = get_cat_ID(urldecode($params[2])) ? get_cat_ID(urldecode($params[2])) : '';
			$catName = urldecode($params[2]) ? urldecode($params[2]) : '全てのカテゴリー';
		}
		if (isset($params[3]) && !empty($params[3]) && !startWith($params[3], '?')) {
			$placeId = urldecode($params[3]) ? array_search(urldecode($params[3]), $places) : '';
			$placeName = urldecode($params[3]) ? urldecode($params[3]) : '全ての地方別';
		}

		if (isset($params[4]) && !empty($params[4])) {
			$tagId = urldecode($params[4]) ? array_search(urldecode($params[4]), $tags) : '';
			$tagName = urldecode($params[4]) ? urldecode($params[4]) : '全てのタグ';
		}
	} else{
		if (array_search('page', $params) >= 5) {
			if (isset($params[2]) && !empty($params[2])) {
				$catId = get_cat_ID(urldecode($params[2])) ? get_cat_ID(urldecode($params[2])) : '';
				$catName = urldecode($params[2]) ? urldecode($params[2]) : '全てのカテゴリー';
			}
			if (isset($params[3]) && !empty($params[3])) {
				$placeId = urldecode($params[3]) ? array_search(urldecode($params[3]), $places) : '';
				$placeName = urldecode($params[3]) ? urldecode($params[3]) : '全ての地方別';
			}

			if (isset($params[4]) && !empty($params[4])) {
				$tagId = urldecode($params[4]) ? array_search(urldecode($params[4]), $tags) : '';
				$tagName = urldecode($params[4]) ? urldecode($params[4]) : '全てのタグ';
			}
		} elseif(array_search('page', $params) == 4) {
			if (isset($params[2]) && !empty($params[2])) {
				$catId = get_cat_ID(urldecode($params[2])) ? get_cat_ID(urldecode($params[2])) : '';
				$catName = urldecode($params[2]) ? urldecode($params[2]) : '全てのカテゴリー';
			}
			if (isset($params[3]) && !empty($params[3])) {
				$placeId = urldecode($params[3]) ? array_search(urldecode($params[3]), $places) : '';
				$placeName = urldecode($params[3]) ? urldecode($params[3]) : '全ての地方別';
			}
		} elseif(array_search('page', $params) == 3) {
			if (isset($params[2]) && !empty($params[2])) {
				$catId = get_cat_ID(urldecode($params[2])) ? get_cat_ID(urldecode($params[2])) : '';
				$catName = urldecode($params[2]) ? urldecode($params[2]) : '全てのカテゴリー';
			}
		} else {
			loadCustomTemplate(TEMPLATEPATH.'/404.php');
		}
	}
	if ($catName == '全てのカテゴリー' || empty($catName)) {
		wp_redirect(home_url(), 200);
	}
	$type = 'category_list';
	$imageArr = ['img_bg01.png', 'img_bg02.png', 'img_bg03.png', 'img_bg04.png', 'img_bg05.png', 'img_bg06.png', 'img_bg07.png', 'img_bg08.png', 'img_bg09.png', 'img_bg10.png'];
	$taxonomy = 'category';
	$category = get_term($catId, $taxonomy);
	$limit = 10;
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
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	if (!empty($placeId) && !empty($tagId)) {
		$searchArticleArgs = array(
	        'showposts'   => $limit,
	        'paged' => $paged,
	        'post_type'     => 'post',
	        'orderby' => 'date',
		    'order' => 'desc',
	        'cat' => $catId,
	        'meta_query'    => array(
	        	'relation'		=> 'AND',
	            array(
	                'key'       => 'tag',
	                'value'     => $tagId,
	                'compare'   => 'LIKE',
	            ),
	            array(
	                'key'       => 'place',
	                'value'     => $placeId,
	                'compare'   => 'LIKE',
	            ),
	            array(
		            'key' => 'type',
		            'value' => '1'
		        )
	        ),
        );
	} elseif(!empty($placeId) && empty($tagId)) {
		$searchArticleArgs = array(
	        'showposts'   => $limit,
	        'paged' => $paged,
	        'post_type'     => 'post',
	        'orderby' => 'date',
		    'order' => 'desc',
	        'cat' => $catId,
	        'meta_query'    => array(
	        	'relation'		=> 'AND',
	            array(
	                'key'       => 'place',
	                'value'     => $placeId,
	                'compare'   => 'LIKE',
	            ),
	            array(
		            'key' => 'type',
		            'value' => '1'
		        )
	        ),
        );
	} elseif(empty($placeId) && !empty($tagId)) {
		$searchArticleArgs = array(
	        'showposts'   => $limit,
	        'paged' => $paged,
	        'post_type'     => 'post',
	        'orderby' => 'date',
		    'order' => 'desc',
	        'cat' => $catId,
	        'meta_query'    => array(
	        	'relation'		=> 'AND',
	            array(
	                'key'       => 'tag',
	                'value'     => $tagId,
	                'compare'   => 'LIKE',
	            ),
	            array(
		            'key' => 'type',
		            'value' => '1'
		        )
	        ),
        );
	} elseif(empty($placeId) && empty($tagId)) {
		$searchArticleArgs = array(
	        'showposts'   => $limit,
	        'paged' => $paged,
	        'post_type'     => 'post',
	        'orderby' => 'date',
		    'order' => 'desc',
	        'cat' => $catId,
	        'meta_query'    => array(
	            array(
		            'key' => 'type',
		            'value' => '1'
		        )
	        ),
        );
	} elseif(empty($placeId)) {
		$searchArticleArgs = array(
	        'showposts'   => $limit,
	        'paged' => $paged,
	        'post_type'     => 'post',
	        'orderby' => 'date',
		    'order' => 'desc',
	        // 'cat' => $catId,
	        'meta_query'    => array(
	            array(
		            'key' => 'type',
		            'value' => '1'
		        )
	        ),
        );
	}

	$articles = get_posts($searchArticleArgs);
	$searchArticleArgs['numberposts'] = -1;
	unset($searchArticleArgs['showposts']);
	unset($searchArticleArgs['paged']);
	$posts_count=count(get_posts($searchArticleArgs));
	$maxPage = ceil($posts_count/$limit);

	function startWith($str, $needle) {
		return strpos($str, $needle) === 0;
	}
?>

<?php require('_sp_header.php') ?>
<!---/sp_header--->
<header class="pc_category_img_area">
    <div class="pc_logo_block">
        <div class="pc_logo_block_content">
            <a href="<?php echo home_url(); ?>" class="pc_logo">
                <img src="/wp-content/themes/twentynineteen/images/logo.svg" alt="Resort Baito Dive">
            </a>
        </div>
    </div>
    <div class="category_img_wrap">
        <div class="category_img" style="background-image:url(<?php echo get_field('image',$taxonomy . '_' . $catId);?>);">
            <div class="category_img_inner">
                <div class="slide_text">
                    <h1 class="slide_text_l mb_30">
                        <span class="pink"><?php echo mb_substr(trim($category->name), 0 , 1, 'utf-8'); ?></span><?php echo mb_substr($category->name , 1, strlen($category->name), 'utf-8'); ?>
                    </h1>
					<?php if (get_field('description',$taxonomy . '_' . $catId)): ?>
	                    <div class="slide_text_detail c_b pt_30">
	                        <?php echo get_field('description',$taxonomy . '_' . $catId);?>
	                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="sp_category_img_block">
    <div class="sp_category_img_wrap">
        <div class="sp_category_img_inner">
            <div class="sp_category_img_link">
                <div class="sp_category_img" style="background-image:url(<?php echo get_field('image',$taxonomy . '_' . $catId);?>);">
                </div>
                <div class="sp_slide_text mt_0">
                    <h2 class="sp_slide_text_l">
                        <span class="pink"><?php echo mb_substr(trim($category->name), 0 , 1, 'utf-8'); ?></span><?php echo mb_substr($category->name , 1, strlen($category->name), 'utf-8'); ?>
                    </h2>
					<?php if (get_field('description',$taxonomy . '_' . $catId)) {?>
	                    <div class="sp_slide_text_detail c_b">
	                        <?php echo get_field('description',$taxonomy . '_' . $catId);?>
	                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pankuzu_wrap">
	<div class="common_wrap">
		<div class="common_inner">
			<ul class="pankuzu_list">
				<li class="pankuzu_item">
					<a href="<?php echo home_url(); ?>" class="pankuzu_link">リゾートバイトTOP</a>
				</li>
				<li class="pankuzu_item">
					<?php echo $category->name ?>
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
							<span class="dark_pink">L</span>IST<span class="common_title_detail"><?php echo $category->name ?>の記事一覧</span>
						</h2>
						<div class="column_box_wrap">
							<?php foreach ($articles as $key => $value) { ?>
								<div class="column_box <?php if($key%2 == 0){?>box_white<?php }else{ ?> box_pink<?php } ?>">
									<a href="<?php echo '/detail/'.$value->ID ?>/" class="column_box_img">
										<div class="<?php if($key%2 == 0){?>column_box_img_bg_left<?php }else{ ?>column_box_img_bg_right<?php } ?>">
											<img src="/wp-content/themes/twentynineteen/images/<?php echo $imageArr[$key] ?>" alt="">
										</div>
										<div class="column_box_img_main" style="background-image: url(<?php  echo wp_get_attachment_image_src(get_post_thumbnail_id($value->ID), 'full')[0] ?>);">
										</div>
									</a>
									<div class="column_box_detail">
										<a href="<?php echo '/detail/'.$value->ID ?>/">
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
											<a href="<?php echo '/category_list/'.$val->name.'/'.$placeName.'/'.$tagName.'/' ?>" class="column_box_category" style="border: 1px solid <?php echo get_field('color',$taxonomy . '_' . $val->term_id) ?>;color: <?php echo get_field('color',$taxonomy . '_' . $val->term_id) ?>;">
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
