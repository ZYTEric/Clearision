<?php
class clrs_news{
    public function __construct(){
        $this->regist_newsletters_type();
        add_shortcode('newsletter', [$this, 'shortcode_newsletter']);
        add_shortcode('newsletters', [$this, 'shortcode_newsletters']);
    }
    
    public function regist_newsletters_type(){
        //https://codex.wordpress.org/Function_Reference/register_post_type
        register_post_type( 'newsletters',
            array(
                'labels' => array(
                    'name' => '新闻',
                    'singular_name' => '简讯',
                    'add_new'=>'写简讯',
                    'add_new_item'=>'创建新的简讯',
                    'edit_item'=>'编辑简讯',
                    'view_item'=>'查看简讯',
                    'view_items'=>'查看简讯',
                    'search_items' => '搜索简讯',
                    'not_found'=>'找不到可用的简讯',
                    'not_found'=>'在回收站中找不到可用的简讯',
                    'menu_name'=>'简讯'
                ),
            'public' => true,
            'has_archive' => true,
            'show_in_menu' => true,
            'show_in_nav_menus'=>false,
            'show_in_admin_bar'=>false,
            'menu_position'=> 25,
            'menu_icon' => 'dashicons-media-document',
            'exclude_from_search' => 'true',
            'publicly_queryable' => true,
		    'query_var' => true,
		    'supports' => array( 'title', 'editor', 'author', 'excerpt', 'comments' ),
		    'rewrite' => ['slug' => 'newsletters', 'with_front' => true]
            )
        );
    }
    
    public function shortcode_newsletter($atts, $content = ''){
        $atts = shortcode_atts([
            'title' => '',
            'time' => null,
            'open' => false,
        ], $atts, 'newsletter');
        $atts['open'] = !empty($atts['open']);
        
        [$newsletter, $uid] = $this->shortcode_newsletters_itemJs();
        $newsletter.= $this->shortcode_newsletters_itemCss();
        $newsletter.= $this->shortcode_newsletters_itemHtml($atts['title'], $atts['time'], $content, $uid, $atts['open']);
        return $newsletter;
    }
    
    public function shortcode_newsletters($atts, $content = ''){
        $atts = shortcode_atts([
            'amount' => 5,
            'open' => '1',
            'popen' => '',
        ], $atts, 'newsletters');
        $atts['open'] = explode(',', $atts['open']);
        $atts['popen'] = explode(',', $atts['popen']);
        $posts = (new WP_Query())->query(array(
            'post_type' => 'newsletters',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => (int)$atts['amount']
        ));
        
        [$newsletters, $uid] = $this->shortcode_newsletters_itemJs();
        $newsletters.= $this->shortcode_newsletters_itemCss();
        for($i = 0; $i <= count($posts) - 1; $i++){
            $post = $posts[$i];
            $newsletters .= $this->shortcode_newsletters_itemPost($post, $uid, in_array($i + 1,$atts['open']) || in_array($post->ID,$atts['popen']));
        }
        
        return $newsletters;
    }
    
    public function shortcode_newsletters_itemCss(){
        static $cssImported = false;
        if(!$cssImported){
            $cssImported = true;
            $content = '<style>'.file_get_contents((get_template_directory().'/functions.news.css')).'</style>';
            $content = preg_replace('/(\n\ +)|(\n)/', '',$content);
            return $content;
        }
        return '';
    }
    
    public function shortcode_newsletters_itemJs(){
        static $uid = 0;
        $uid++;
        $js="<script>".
        "$(function () {" .
        /**/"$('.newsletters_warp.nl_$uid .nl_title').bind('click', function (e) {" .
        /* */"$(e.target).parents('.newsletters_warp').toggleClass('open')" .
        /**/"});" .
        "});" .
        "</script>";
        
        return [$js, $uid];
    }
    
    public function shortcode_newsletters_itemPost(\WP_Post $post, string $uid, bool $open){
        $title = preg_replace('/^【.+?】/','',$post->post_title);
        $time = date('Y-m-d',strtotime($post->post_date));
        $body = $post->post_content;
        return $this->shortcode_newsletters_itemHtml($title, $time, $body, $uid, $open);
    }
    
    public function shortcode_newsletters_itemHtml(?string $title, ?string $time, ?string $body, string $uid, bool $open){
        return "" .
        '<table class="newsletters_warp no_border nl_'.$uid . ($open ? ' open': null) . '">' .
        '<tr class="newsletters_header">' .
        '    <td class="nl_icon">' .
        '        <i class="fa fa-fw fa-chevron-right"></i>' .
        '    </td>' .
        '    <td class="nl_title">'.$title.'</td>' .
            (empty($time) ? '' : '<td class="nl_time">'.$time.'</td>') .
        '</tr>' .
        '<tr class="newsletters_body">' .
        '    <td /><td class="nl_body"' . (empty($time) ? '' : 'colspan="2"') . '><div>'.$body.'</div></td>' .
        '</tr>' .
        "</table>" . PHP_EOL;
    }
}

new clrs_news();