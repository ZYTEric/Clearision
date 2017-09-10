<?php
// 加载语言包
/*add_action('after_setup_theme', 'my_theme_setup');
function my_theme_setup()
{
    load_theme_textdomain('clrs', get_template_directory() . '/lang');
}*/

// 加载后台设置
include ('dashboard.php');
function clrs_menu_function()
{
    add_theme_page(
        __('设置', 'clrs'),
        __('设置', 'clrs'),
        'administrator',
        'clrs_menu',
        'clrs_dashboard'
    );
}
add_action('admin_menu', 'clrs_menu_function');


function clrs_admin_bar()
{
    global $wp_admin_bar;
    $wp_admin_bar->add_menu(array(
        'parent' => false,
        'id' => 'theme_setting',
        'title' => __('主题设置', 'dpt'),
        'href' => admin_url('themes.php?page=clrs_menu'),
    ));
}
add_action('wp_before_admin_bar_render', 'clrs_admin_bar');

// 加载文章格式支持

add_theme_support('post-formats', array('quote', 'status'));
// add_theme_support( 'post-formats', array( 'image', 'video' ) );

// 加载菜单设置

register_nav_menus(array(
    'main' => __('主菜单', 'clrs'),
    'next' => __('辅助链接', 'clrs')
));

// 加载小工具设置

if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => __('底部栏1', 'clrs'),
        'id' => 'one',
        'description' => '底部的工具栏',
        'class' => 'side_col',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));
}

if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => __('底部栏2', 'clrs'),
        'id' => 'two',
        'description' => '底部的工具栏',
        'class' => 'side_col',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));
}

// 获取博客标题

function clrs_title($title, $sep)
{
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    $title .= get_bloginfo('name');

    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) {
        $title = "$title $sep $site_description";
    }

    if ($paged >= 2 || $page >= 2) {
        $title = "$title $sep " . sprintf(__('页面 %s', 'clrs'), max($paged, $page));
    }

    return $title;
}

add_filter('wp_title', 'clrs_title', 10, 2);

// 首页 SNS 输出

function clrs_sns()
{
    // 修改此顺序可以改变输出顺序，记得修改对应的注释
    $clrs_sns = array(
        "profile" => "个人页",
        "gplus" => "Google+",
        "twitter" => "Twitter",
        "fb" => "Facebook",
        "weibo" => "SinaWeibo",
        "qqw" => "QQ",
        "github" => "Github"
    );
    foreach ($clrs_sns as $name => $title) {
        $clrs_sopt = 'clrs_s_' . $name;
        if (get_option($clrs_sopt) != null) {
            echo '<a href="' . get_option($clrs_sopt) . '" title="' . $title . '" target="_blank" class="tr_' . $name . '_a"><button class="tr_' . $name . '"></button></a>
';
        }
    }
}

// 定义页面导航

function clrs_pagenavi()
{
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

    $pagination = array(
        'base' => @add_query_arg('paged', '%#%'),
        'format' => '',
        'total' => $wp_query->max_num_pages,
        'current' => $current,
        'show_all' => false,
        'type' => 'plain',
        'end_size' => '0',
        'mid_size' => '5',
        'prev_text' => __('<span>上一页</span>', 'clrs'),
        'next_text' => __('<span>下一页</span>', 'clrs'),
        'before_page_number' => '<span>',
        'after_page_number' => '</span>'
    );

    if ($wp_rewrite->using_permalinks()) {
        $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged');
    }

    if (!empty($wp_query->query_vars['s'])) {
        $pagination['add_args'] = array('s' => get_query_var('s'));
    }

    echo paginate_links($pagination);
}

// 评论附加函数

function delete_comment_link($id)
{
    if (current_user_can('level_5')) {
        echo '<a class="comment-edit-link" href="' . admin_url("comment.php?action=cdc&c=$id") . '">删除</a> ';
    }
}

// 定义评论显示

function clrs_comment($comment, $args, $depth)
{
    $comment_type = $comment->comment_type;
    if ($comment_type === 'pingback' ||
        $comment_type === 'trackback') {
        ?>
    <li <?php comment_class(); ?> id="comment-
        <?php comment_ID() ?>">
        <p>
            <?php echo 'Pingback '; ?>
            <?php comment_author_link(); ?>
            <?php edit_comment_link('编辑', '<span class="edit-link">', '</span>'); ?>
        </p>
    </li>
    <?php 
}
else { ?>
    <li <?php comment_class('clearfix'); ?>
        <?php echo $depth > 2 ? ' style="margin-left:-50px;margin-right:-15px;"' : null; ?> id="li-comment-
        <?php comment_ID() ?>" >
        <article id="comment-<?php comment_ID(); ?>" class="comment">
            <header class="comment-meta comment-author vcard">
                <?php
                echo get_avatar($comment, 44);
                printf(
                    '<div class="comment_meta_head"><cite class="fn">%1$s',
                    get_comment_author_link()
                );
                printf(
                    '%1$s </cite>', ($comment->user_id === $comment->post_author) ? '<span class="comment_meta_auth"> ' . __('', 'clrs') . '</span>' : ''
                );
                printf(
                    '</div><span class="comment_meta_time"><a href="%1$s"><time datetime="%2$s">%3$s</time></a></span>',
                    esc_url(get_comment_link($comment->comment_ID)),
                    get_comment_time('c'),
                    sprintf('%1$s %2$s', get_comment_date(), get_comment_time())
                );
                $wbos = get_option('clrs_wbos');
                if ($wbos == "yes") {
                    echo '<a href="javascript:void(0)" class="comment_ua_a">';
                    clrs_wp_useragent();
                    echo '</a>';
                };
                ?>
            </header>

            <?php if ('0' == $comment->comment_approved) : ?>
            <p class="comment-awaiting-moderation">
                <?php /*_e*/__('您的评论正在等待审核', 'clrs'); ?>
            </p>
            <?php endif; ?>

            <section class="comment-content comment">
                <?php comment_text(); ?>
                <?php edit_comment_link(__('编辑', 'clrs'), '<span class="edit-link">', '</span>'); ?>
                <?php delete_comment_link(get_comment_ID()); ?>
                <?php comment_reply_link(array_merge($args, array('reply_text' => __('回复', 'clrs'), 'after' => '', 'depth' => $depth, 'max_depth' => 100))); ?>
            </section>

        </article>
    </li>
    <?php

}
}

// 设置页单选按钮

function clrs_va($option)
{
    if (get_option($option) == "yes") {
        echo 'checked="true"';
    }
}

function clrs_vb($option)
{
    if (get_option($option) !== "yes") {
        echo 'checked="true"';
    }
}

//禁用发表评论时需要填写的“站点”
function alter_comment_form_fields($fields)
{
    //$fields['author'] = ''; //removes name field
    //$fields['email'] = ''; //removes email field
    $fields['url'] = ''; //removes website field
    return $fields;
}
add_filter('comment_form_default_fields', 'alter_comment_form_fields');

remove_filter('comment_text', 'make_clickable', 9);
include (get_stylesheet_directory() . '/func/parseURI.php');
add_filter('comment_text', 'kt_make_clickable');

// 评论添加@功能
function ludou_comment_add_at($comment_text, $comment = '')
{
    if ($comment->comment_parent > 0) {
        $comment_text = '回复 <a href="#comment-' . $comment->comment_parent . '">@' . get_comment_author($comment->comment_parent) . '</a>： ' . $comment_text;
    }

    return $comment_text;
}
add_filter('comment_text', 'ludou_comment_add_at', 20, 2);


if (!is_admin()) {
    add_action(
        'wp_enqueue_scripts',
        function () {
            wp_enqueue_style('clearision-style', get_template_directory_uri() . '/style.css');
            wp_register_script('clearision-init', get_template_directory_uri() . '/assets/scripts/script.js', ['jquery'], false, true);
            wp_enqueue_script('clearision-init');
        }
    );
}

//第三方库
if (!is_admin()) {
    //jQuery
    if (get_option('clrs_thrdptComs_jq') === 'yes') {
        add_action('wp_enqueue_scripts', function () {
            $jqVer = get_option('clrs_thrdptComs_jq_ver', '3.2.1');
            if (empty($jqVer)) {
                $jqVer = '3.2.1';
            }
            wp_deregister_script('jquery');
            wp_register_script('jquery', '//cdn.bootcss.com/jquery/' . $jqVer . '/jquery.min.js', [], $jqVer);
            wp_enqueue_script('jquery');
        }, 99);
    }

    //font-awesome
    if (get_option('clrs_thrdptComs_fa') === 'yes') {
        add_action('wp_enqueue_scripts', function (){
            global $wp_styles;
            $faVer = get_option('clrs_thrdptComs_fa_ver', '4.7.0');
            if (empty($faVer)) {
                $faVer = '4.7.0';
            }
            wp_enqueue_style('clearision-font-awesome', '//cdn.bootcss.com/font-awesome/' . $faVer . '/css/font-awesome.min.css', [], $faVer);
            if (is_array($wp_styles->registered)) {
                foreach ($wp_styles->registered as $script => $details) {
                    $src = isset($details->src) ? $details->src : false;
                    if (false !== strpos($script, 'clearision-font-awesome')) {
                        continue;
                    }
                    if (false !== strpos($script, 'fontawesome') || false !== strpos($script, 'font-awesome')) {
                        wp_dequeue_style($script);
                    }
                    if ($src && (false !== strpos($src, 'font-awesome') || false !== strpos($src, 'fontawesome'))) {
                        wp_dequeue_style($script);
                    }
                }
            }
        }, 11);
    }
}
