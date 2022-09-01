<?php
    $jobargs = array(
        'posts_per_page' => 20,
        'orderby' => 'date',
        'order' => 'desc',
        'meta_query' => array(
            array(
                'key' => 'type',
                'value' => '3'
            )
        )
    );
    $jobRecommends = get_posts($jobargs);
?>

<?php if ($jobRecommends): ?>
<section class="recommend_job">
    <div class="common_black_title">
        <h2>RECOMMEND</h2>
        <p>おすすめ求人</p>
    </div>
    <ul class="recommend_job_list">
        <?php foreach ($jobRecommends as $key => $value) {?>
        <li class="recommend_job_item">
            <a href="<?php echo get_field('job_url', $value->ID); ?>" class="recommend_job_link">
                <div class="recommend_job_img" style="background-image:url(<?php  echo wp_get_attachment_image_src(get_post_thumbnail_id($value->ID), 'full')[0] ?>)">
                </div>
                <div class="recommend_job_tag">
                    RECOMMEND
                </div>
                <h3 class="recommend_job_title">
                    <?php echo $value->post_title ?>
                </h3>
                <ul class="recommend_job_detail_list">
                    <li class="recommend_job_detail_item">
                        <h4 class="recommend_job_content_title">
                            エリア
                        </h4>
                        <p class="recommend_job_content_text">
                            <?php echo get_field('job_area', $value->ID); ?>
                        </p>
                    </li>
                    <li class="recommend_job_detail_item">
                        <h4 class="recommend_job_content_title">
                            職種
                        </h4>
                        <p class="recommend_job_content_text">
                            <?php echo get_field('job_category', $value->ID); ?>
                        </p>
                    </li>
                    <li class="recommend_job_detail_item">
                        <h4 class="recommend_job_content_title">
                            時給
                        </h4>
                        <p class="recommend_job_content_text">
                            <?php echo get_field('job_pay', $value->ID); ?>
                        </p>
                    </li>
                    <li class="recommend_job_detail_item">
                        <h4 class="recommend_job_content_title">
                            期間
                        </h4>
                        <p class="recommend_job_content_text">
                            <?php echo get_field('job_period', $value->ID); ?>
                        </p>
                    </li>
                    <li class="recommend_job_detail_item">
                        <h4 class="recommend_job_content_title">
                            募集人数
                        </h4>
                        <p class="recommend_job_content_text">
                            <?php echo get_field('job_application_num', $value->ID); ?>
                        </p>
                    </li>
                    <li class="recommend_job_detail_item">
                        <h4 class="recommend_job_content_title">
                            応募条件
                        </h4>
                        <p class="recommend_job_content_text">
                            <?php echo get_field('job_application_conditions', $value->ID); ?>
                        </p>
                    </li>
                </ul>
            </a>
        </li>
        <?php } ?>
    </ul>
</section>
<?php endif ?>
