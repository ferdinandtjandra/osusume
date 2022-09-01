<?php
//inital
//Gets the article tags string
function get_tags_string($id)
{
    $tags = get_the_tags($id);
    $tag_string = '';
    if ($tags) {
        foreach ($tags as $k => $v) {
            $tag_string = $tag_string . $v->name . ',';
        }
        echo rtrim($tag_string, ',');
    } else {
        echo '';
    }
}

// Gets all the labels under the current category
function get_category_tags($args)
{
    global $wpdb;
    $tags = $wpdb->get_results
    ("
		SELECT DISTINCT terms2.term_id as tag_id, terms2.name as tag_name
		FROM
			$wpdb->posts as p1
			LEFT JOIN $wpdb->term_relationships as r1 ON p1.ID = r1.object_ID
			LEFT JOIN $wpdb->term_taxonomy as t1 ON r1.term_taxonomy_id = t1.term_taxonomy_id
			LEFT JOIN $wpdb->terms as terms1 ON t1.term_id = terms1.term_id,
 
			$wpdb->posts as p2
			LEFT JOIN $wpdb->term_relationships as r2 ON p2.ID = r2.object_ID
			LEFT JOIN $wpdb->term_taxonomy as t2 ON r2.term_taxonomy_id = t2.term_taxonomy_id
			LEFT JOIN $wpdb->terms as terms2 ON t2.term_id = terms2.term_id
		WHERE
			t1.taxonomy = 'category' AND p1.post_status = 'publish' AND terms1.term_id IN (" . $args['categories'] . ") AND
			t2.taxonomy = 'post_tag' AND p2.post_status = 'publish'
			AND p1.ID = p2.ID
		ORDER by tag_name
	");
    $count = 0;

    if ($tags) {
        foreach ($tags as $tag) {
            $mytag[$count] = get_term_by('id', $tag->tag_id, 'post_tag');
            $count++;
        }
    } else {
        $mytag = NULL;
    }

    return $mytag;
}

function my_custom_sidebar()
{
    $sidebars = array(
        'pr' => 'サイドバーPR',
        'websites' => 'サイドバー関連サイト'
    );
    foreach ($sidebars as $key => $value) {
        register_sidebar(
            array(
                'name' => $value,
                'id' => $key,
                'before_widget' => '<div class="widget-content">',
                'after_widget' => "</div>",
            )
        );
    }
}

add_action('widgets_init', 'my_custom_sidebar');

// Reviews and related sites
function custom_blog_init()
{
    $labels = array(
        'name' => _x('口コミ', 'post type general name'),
        'singular_name' => _x('口コミ', 'post type singular name'),
        'all_items' => __('投稿一覧'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,//管理画面・サイトへの表示の有無
        'publicly_queryable' => true,
        'show_ui' => true, //管理画面のメニューへの表示の有無
        'menu_position' => 5,//管理メニューでの表示位置
        'query_var' => true,
        'rewrite' => true,//パーマリンク設定
        'capability_type' => 'post',//権限タイプ
        'map_meta_cap' => true,//デフォのメタ情報処理を利用の有無
        'hierarchical' => true,//階層(親)の有無
        'menu_icon' => 'dashicons-admin-customizer',//アイコン画像
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'excerpt', 'trackbacks', 'comments', 'revisions', 'page-attributes'),
        'has_archive' => true,//アーカイブの有無
        'taxonomies' => array('category', 'post_tag')
    );
    register_post_type('comments', $args);

    $labels1 = array(
        'name' => _x('関連サイト', 'post type general name'),
        'singular_name' => _x('関連サイト', 'post type singular name'),
        'all_items' => __('投稿一覧'),
    );
    $args1 = array(
        'labels' => $labels1,
        'public' => true,//管理画面・サイトへの表示の有無
        'publicly_queryable' => true,
        'show_ui' => true, //管理画面のメニューへの表示の有無
        'menu_position' => 6,//管理メニューでの表示位置
        'query_var' => true,
        'rewrite' => true,//パーマリンク設定
        'capability_type' => 'post',//権限タイプ
        'map_meta_cap' => true,//デフォのメタ情報処理を利用の有無
        'hierarchical' => true,//階層(親)の有無
        'menu_icon' => 'dashicons-admin-customizer',//アイコン画像
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'excerpt', 'trackbacks', 'comments', 'revisions', 'page-attributes'),
        'has_archive' => true,//アーカイブの有無
        'taxonomies' => array('category', 'post_tag')
    );
    register_post_type('related_sites', $args1);

}

add_action('init', 'custom_blog_init');

// Url optimization
function loadCustomTemplate($template)
{
    header("HTTP/1.1 200 OK");
    include($template);
    exit;
}

function templateRedirect()
{
    $url = $_SERVER['REQUEST_URI'];
    $params = explode('/', $url);
    $page = $params[1];
    if ($page == 'tag') {
        wp_redirect(home_url('/'));
        exit();
    }
    foreach ($params as $k => $v) {
        switch ($params[$k]) {
            case 'ctg':
                loadCustomTemplate(TEMPLATEPATH . '/category.php');
                break;
            case 'tag':
                loadCustomTemplate(TEMPLATEPATH . '/category.php');
                break;
            case 'status':
                loadCustomTemplate(TEMPLATEPATH . '/category.php');
                break;
            case 'page':
                loadCustomTemplate(TEMPLATEPATH . '/category.php');
                break;
            case 'terms':
                loadCustomTemplate(TEMPLATEPATH . '/terms.php');
                break;
            case 'privacy-policy':
                loadCustomTemplate(TEMPLATEPATH . '/privacy-policy.php');
                break;
            case 'company':
                loadCustomTemplate(TEMPLATEPATH . '/company.php');
                break;  
        }
    }
}

add_action('template_redirect', 'templateRedirect');

// URL string to array
function str_array($str)
{
    $str = trim($str, '/');
    $str_array = explode("/", $str);
    $new_array = array();
    foreach ($str_array as $k => $v) {
        if ($k < count($str_array) / 2) {
            $k = $k * 2;
            $new_array[$str_array[$k]] = $str_array[$k + 1];
        }
    }
    return $new_array;
}

// tdk
function tdk($page, $ctg = '', $tag = '', $post_title = '')
{
    switch ($page) {
        case 'index':
            return array('title' => '人材紹介エージェント研究所|転職エージェントのおすすめを人材紹介エージェント研究所
が紹介！',
                'description' => '人材紹介エージェント研究所が厳選した'. $ctg .'を紹介しています。様々な'. $ctg .'ジャンルを紹介しますの>でご参考まで。'
            );
            break;
        case 'category':
            return array('title' => $ctg . '|人材紹介エージェント研究所',
                'description' => '人材紹介エージェント研究所による' . $ctg . 'の一覧ページです。' . $ctg . 'の参考にどうぞ'
            );
            break;
        case 'category_tag':
            return array('title' => $ctg . 'の' . $tag . 'をご紹介|人材紹介エージェント研究所',
                'description' => '人材紹介エージェント研究所による' . $ctg . 'の' . $tag . '一覧ページです。' . $ctg . 'の' . $tag . 'の>参考にどうぞ'
            );
            break;
        case 'single':
            return array('title' => $post_title . '|' . $ctg . '転職エージェント',
                'description' => '人材紹介エージェント研究所がご紹介「' . $post_title . '」' . $ctg . 'のおすすめに。'
            );
            break;
    }
}

function MBThemes_paging($max_page)
{
    global $wp_query, $paged;
    if ($max_page == 1) return;
    echo '<div class="btn_area"><ul class="page_list">';
    if (empty($paged)) $paged = 1;
    if ($paged > 1) ;
    echo '<li class="page_prev">';
    previous_posts_link('前へ');
    echo '</li>';
    $status = 0;
    if ($max_page > 5 && $max_page - $paged >= 4) {
        for ($i = $paged - 1; $i <= $max_page; $i++) {
            if ($i > 0) {
                if ($i <= $paged + 2 && $paged == 1) {
                    $i == $paged ? print "<li class=\"page_item\"><div class=\"page_link active\">
													<span>{$i}</span>
												</div></li>" : p_link($i);
                } elseif ($i <= $paged + 1) {
                    $i == $paged ? print "<li class=\"page_item\"><div class=\"page_link active\">
													<span>{$i}</span>
												</div></li>" : p_link($i);
                }
                if ($status == 0 && $i > $paged + 3) {
                    echo "<li class='dot'>...</span></li>";
                    $status = 1;
                }
                if ($i > $max_page - 1 && $i <= $max_page) {
                    $i == $paged ? print "<li class=\"page_item\"><div class=\"page_link active\">
												<span>{$i}</span>
											</div></li>" : p_link($i);
                }
            }
        }
    } else if ($max_page > 5 && $max_page - $paged <= 4) {
        for ($i = $max_page - 4; $i <= $max_page; $i++) {
            if ($i > 0) {
                $i == $paged ? print "<li class=\"page_item\"><div class=\"page_link active\">
												<span>{$i}</span>
											</div></li>" : p_link($i);
            }
        }
    } else {
        if ($max_page >= 11) {
            for ($i = $max_page - ($max_page - 7); $i <= $max_page; $i++) {
                if ($i > 0) {
                    if ($i >= ($max_page - ($max_page - 7 - ($max_page - 11))) && $i <= $max_page) {
                        $i == $paged ? print "<li class=\"page_item\"><div class=\"page_link active\">
														<span>{$i}</span>
													</div></li>" : p_link($i);
                    }
                }
            }
        } else {
            for ($i = $paged - 1; $i <= $max_page; $i++) {
                if ($i > 0) {
                    if ($i >= $paged - 1 && $i <= $max_page) {
                        $i == $paged ? print "<li class=\"page_item\"><div class=\"page_link active\">
														<span>{$i}</span>
													</div></li>" : p_link($i);
                    }
                }
            }
        }
    }
    echo '<li class="page_next">';
    next_posts_link('次へ', $max_page);
    echo '</li>';
    echo '</ul></div>';
}

function p_link($i, $title = '')
{
    if ($title == '') {
        $title = "{$i}";
    }
    echo "<li class='page_item'><a href='", esc_html(get_pagenum_link($i)), "' class='page_link'><span>{$title}</span></a></li>";
}


function str_limit($value, $limit = 100, $end = '...')
{
    if (mb_strwidth($value, 'UTF-8') <= $limit) {
        return $value;
    }

    return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')).$end;
}

?>
