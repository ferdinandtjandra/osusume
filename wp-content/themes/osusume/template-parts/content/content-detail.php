<?php
	global $correlationArticles, $bottomBanner, $banners, $articleType, $places, $tags;
	$taxonomy = 'category';
	$nowUrl = $_SERVER['REQUEST_URI'];
	$params = explode('/', rtrim($nowUrl, '/'));
	if (count($params) > 3) {
		loadCustomTemplate(TEMPLATEPATH.'/404.php');
	}
	if (isset($params[2]) && !empty($params[2])) {
		$articleId = $params[2];
	} else {
		loadCustomTemplate(TEMPLATEPATH.'/404.php');
	}
	$articleType = '関連記事';
	$article = get_post($articleId);
	$category = get_the_category($articleId);
	$catIds = array_column($category, 'term_id');
	$places = get_field_object(PLACE_FIELD_KEY)['choices'];
	$tags = get_field_object(TAG_FIELD_KEY)['choices'];
	$placeIds = get_post_meta($articleId, 'place', false)[0];
	$tagIds = get_post_meta($articleId, 'tag', false)[0];
	$tagNameArr = [];

	if($tagIds){
		foreach ($tagIds as $key => $value) {
			if (isset($tags[$value]) && !empty($tags[$value])) {
				array_push($tagNameArr, $tags[$value]);
			}
		}
	}
	$banners = get_posts(array(
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
	));
	$bottomBanner = get_posts(array(
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
	));
	$correlationArticles = get_posts(array(
	    'posts_per_page' => 5,
	    'orderby' => 'date',
	    'order' => 'desc',
	    'category__in' => $catIds,
	    'post__not_in' => [$articleId],
	    'meta_query' => array(
	        array(
	            'key' => 'type',
	            'value' => '1'
	        )
	    )
	));

	$totalArticles = get_posts(array(
	    'posts_per_page' => -1,
	    'orderby' => 'date',
	    'order' => 'asc',
	    'meta_query' => array(
	        array(
	            'key' => 'type',
	            'value' => '1'
	        )
	    )
	));
	$totalArticleIds = array_column($totalArticles, 'ID');

	$minIds = [];
	$maxIds = [];
	foreach ($totalArticleIds as $key => $value) {
		if ($value > $articleId) {
			array_push($maxIds, $value);
		}
		if ($value < $articleId) {
			array_push($minIds, $value);
		}
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
		<div class="category_img" style="background-image:url(<?php  echo wp_get_attachment_image_src(get_post_thumbnail_id($article->ID), 'full')[0] ?>);">
			<div class="category_img_inner">
				<div class="slide_text">
					<div class="slide_text_l mb_30">
						<span class="pink"><?php echo mb_substr(trim($article->post_title), 0, 1, 'utf-8'); ?></span><?php if (strlen($article->post_title) > 10): ?><?php echo mb_substr(trim($article->post_title), 1, strlen($article->post_title)/2, 'utf-8'); ?><br><?php echo mb_substr($article->post_title , strlen($article->post_title)/2+1, strlen($article->post_title), 'utf-8'); ?>
						<?php else: ?><?php echo mb_substr(trim($article->post_title), 1, strlen(trim($article->post_title)), 'utf-8'); ?><?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="sp_category_img_block">
	<div class="sp_category_img_wrap">
		<div class="sp_category_img_inner">
			<div class="sp_category_img_link">
				<div class="sp_category_img" style="background-image:url(<?php  echo wp_get_attachment_image_src(get_post_thumbnail_id($article->ID), 'full')[0] ?>);">
				</div>
				<div class="sp_slide_text mt_0">
					<div class="sp_slide_text_l">
						<span class="pink"><?php echo mb_substr(trim($article->post_title), 0, 1, 'utf-8'); ?></span><?php if (strlen($article->post_title) > 10): ?><?php echo mb_substr(trim($article->post_title), 1, strlen($article->post_title)/2, 'utf-8'); ?><br><?php echo mb_substr($article->post_title , strlen($article->post_title)/2+1, strlen($article->post_title), 'utf-8'); ?>
						<?php else: ?><?php echo mb_substr(trim($article->post_title), 1, strlen(trim($article->post_title)), 'utf-8'); ?><?php endif ?>
					</div>
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
					<a href="<?php echo home_url() ?>" class="pankuzu_link">リゾートバイトTOP</a>
				</li>
				<li class="pankuzu_item">
					<?php if (isset(get_the_category($article->ID)[0]) && !empty(get_the_category($article->ID)[0])): ?>
						<a href="/category_list/<?php echo get_the_category($article->ID)[0]->name ?>/" class="pankuzu_link">
							<?php echo get_the_category($article->ID)[0]->name ?>
							<?php if (!empty($tagNameArr)): ?>
								<?php foreach ($tagNameArr as $key => $value): ?>
									<?php echo '・'.$value; ?>
								<?php endforeach ?>
							<?php endif ?>
						</a>
					<?php endif ?>
				</li>
				<li class="pankuzu_item">
					<?php echo $article->post_title; ?>
				</li>
			</ul>
		</div>
	</div>
</div>
<?php get_template_part('template-parts/content/content', 'sp_bottom_menu'); ?>
<div class="main_content_detail_wrap">
	<div class="common_wrap">
		<div class="common_inner">
			<div class="main_flex">
				<div class="main_left_side">
					<section class="column_detail">
						<div id="column_editor">
							<?php $date = floor((time() - strtotime($article->post_date)) / 86400); ?>
							<div class="detail_page_category">
								<?php if ($date <= 7): ?>
									<a href="/list/全ての地方別/全てのタグ/新着/" class="column_box_category new">
										<img src="/wp-content/themes/twentynineteen/images/icon_new.svg" alt="新着">
										新着
									</a>
								<?php endif ?>
								<?php foreach (get_the_category($article->ID) as $k => $val) { ?>
									<a href="<?php echo '/category_list/'.$val->name ?>/" class="column_box_category" style="border: 1px solid <?php echo get_field('color',$taxonomy . '_' . $val->term_id) ?>;color: <?php echo get_field('color',$taxonomy . '_' . $val->term_id) ?>;">
										<img src="<?php echo get_field('icon',$taxonomy . '_' . $val->term_id) ?>" alt="<?php echo $val->name; ?>">
										<?php echo $val->name; ?>
									</a>

								<?php } ?>
							</div>
							<?php if ($placeIds): ?>
								<ul class="tag_search_list">
									<?php foreach ($placeIds as $key => $value) {?>
										<li class="tag_search_item">
											<a href="<?php echo '/list/'.$places[$value].'/全てのタグ/' ?>" class="tag_wrap">
												<div class="tag_inner">
													<div class="tag_inner_inner">
														<?php echo $places[$value]; ?>
													</div>
												</div>
											</a>
										</li>
									<?php } ?>
								</ul>
							<?php endif ?>
							<div id="column_content_editor">
								<?php echo $article->post_content; ?>
							</div>
						</div>
						<div class="detail_prev_next_btn">
							<?php if (false && !empty($minIds)): ?>
								<a href="<?php echo '/detail/'.max($minIds) ?>/" class="detail_prev_btn">
									前の記事へ
									<img src="/wp-content/themes/twentynineteen/images/arrow_left.svg" alt="">
								</a>
							<?php endif ?>
							<?php if (false && !empty($maxIds)): ?>
								<a href="<?php echo '/detail/'.min($maxIds) ?>/" class="detail_next_btn">
									次の記事へ
									<img src="/wp-content/themes/twentynineteen/images/arrow_right.svg" alt="">
								</a>
							<?php endif ?>

							<a href="<?php echo '/list/' ?>" class="detail_prev_btn">
								記事一覧に戻る
								<img src="/wp-content/themes/twentynineteen/images/arrow_left.svg" alt="">
							</a>
						</div>
					</section>
				</div><!---/main_left_side--->
				<div class="main_right_side mt_0">
					<div class="main_right_content">
						<?php if ($correlationArticles): ?>
							<section class="relation">
								<div class="common_black_title">
									<h2>RELATION</h2>
									<p>関連記事</p>
								</div>
								<ul class="right_side_column_box_wrap">
									<?php foreach ($correlationArticles as $key => $value): ?>
										<li class="right_side_column_box">
											<a href="<?php echo '/detail/'.$value->ID ?>/" class="right_side_column_img" style="background-image:url(<?php  echo wp_get_attachment_image_src(get_post_thumbnail_id($value->ID), 'full')[0] ?>);">
											</a>
											<a href="<?php echo '/detail/'.$value->ID ?>/">
												<h3 class="right_side_column_box_title">
													<?php echo $value->post_title ?>
												</h3>
											</a>
											<?php $date = floor((time() - strtotime($value->post_date)) / 86400); ?>
											<?php if ($date <= 7): ?>
												<a href="/list/全ての地方別/全てのタグ/新着/" class="column_box_category new">
													<img src="/wp-content/themes/twentynineteen/images/icon_new.svg" alt="新着">
													新着
												</a>
											<?php endif ?>
											<?php foreach (get_the_category($value->ID) as $val) { ?>
												<a href="<?php echo '/category_list/'.$val->name.'/全ての地方別/全てのタグ/'?>" class="column_box_category" style="border: 1px solid <?php echo get_field('color',$taxonomy . '_' . $val->term_id) ?>;color: <?php echo get_field('color',$taxonomy . '_' . $val->term_id) ?>;">
													<img src="<?php echo get_field('icon',$taxonomy . '_' . $val->term_id) ?>" alt="<?php echo $val->name; ?>">
													<?php echo $val->name; ?>
												</a>

											<?php } ?>
											<a href="<?php echo '/detail/'.$value->ID ?>/" class="right_side_column_box_text">
												<?php echo strip_tags($value->post_content) ?>
											</a>
										</li>
									<?php endforeach ?>
								</ul>
							</section>
						<?php endif ?>


						<?php require('_job_recommend.php') ?>
					</div>
				</div><!---/main_right_side--->
			</div>
		</div>
	</div>
</div><!---/main_content_wrap--->
