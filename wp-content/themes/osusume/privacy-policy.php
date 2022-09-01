<?php
get_header();
?>
<main class="common_main">
    <div class="page_layout_block">
        <div class="page_layout_flex">
            <div class="page_layout_main">
                <div class="detail_editor_wrap">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>

        <div class="detail_related_block03"></div>
    </div>
    <a href="#" class="page_top_btn" id="TopBtn">
        <img src="<?php bloginfo('template_url'); ?>/assets/images/common/top_btn.png" alt="page top">
    </a>
</main>
<?php
get_footer();