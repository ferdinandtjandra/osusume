<div class="aside_pr_block">
    <p class="aside_pr_title">PR</p>
    <div class="aside_pr_main">
        <?php dynamic_sidebar('pr'); ?>
    </div>
</div>

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
if ($categories) { ?>
    <div class="aside_category_block">
        <p class="aside_category_title">カテゴリー</p>
        <ul class="aside_category_list">
            <?php foreach ($categories as $k => $category) { ?>
                <li class="aside_category_item">
                    <?php if($category->category_parent == 0) { ?>
                    <a href="<?php echo get_category_link($category->term_id) ?>" class="aside_category_link">
                    <?php } else { ?>
                    <a href="/ctg/<?php echo urldecode($category->slug); ?>" class="aside_category_link">
                    <?php } ?>
                        <img src="<?php the_field('category_icon', $category); ?>" alt="<?php echo $category->name ?>エージェント">
                        <span><?php echo $category->name; ?></span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>