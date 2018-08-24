<?php
/* ==================权限控制====================
 *                  Author: Kenta
 * 下方代码块主要功能是限制游客访问/评论特定页面.
 * 涉及钩子:
 *     add_meta_boxes
 *     save_post
 *     manage_page_posts_columns
 *     manage_post_posts_columns
 *     manage_pages_custom_column
 *     manage_posts_custom_column
 * 对内容的显示控制存在于以下文件中:
 *     content.php
 *     page.php
 * 对评论的显示控制存在于以下文件中:
 *     comments.php
 * =============================================
 */

/* 文章编辑器右侧的"访问权限"框
 *
 * Attention:
 * checkbox未选中时不在$_POST中出现
 * 为防止"快速编辑"提交的数据中不包含
 * 选项内容而导致判断为"非",请务必使用
 * 隐藏域作为选项的数据来源
 */
class clrs_access
{
    private function checked($val, $flag = null)
    {
        return 'yes' === $val ? (is_null($flag) ? true : $flag) : null;
    }

    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_post']);
        add_filter('manage_page_posts_columns', [$this, 'columnTitle_access']);
        add_filter('manage_post_posts_columns', [$this, 'columnTitle_access']);
        add_action('manage_pages_custom_column', [$this, 'columnContent_access'], 10, 2);
        add_action('manage_posts_custom_column', [$this, 'columnContent_access'], 10, 2);
    }

    public function add_meta_boxes()
    {
        add_meta_box('clrs_mtbox_postAccess', '访问权限', [$this, 'add_meta_boxes_content'], null, 'side', 'low');
    }

    public function add_meta_boxes_content($post)
    {
        $onlyMembersCanView = get_post_meta($post->ID, 'onlyMembersCanView', true);
        $onlyMembersCanComment = get_post_meta($post->ID, 'onlyMembersCanComment', true);

        echo "<input type='checkbox' {$this->checked($onlyMembersCanView, 'checked')} onclick='jQuery(\"#input_onlyMembersCanView\").val(this.checked?\"yes\":\"no\")' />";
        echo "<input type='hidden' name='onlyMembersCanView' id='input_onlyMembersCanView' value='{$onlyMembersCanView}' />";
        echo "<label for='onlyMembersCanView'>仅登录用户可浏览</label>";

        echo "<input type='checkbox' {$this->checked($onlyMembersCanComment, 'checked')} onclick='jQuery(\"#onlyMembersCanComment\").val(this.checked?\"yes\":\"no\")' />";
        echo "<input type='hidden' name='onlyMembersCanComment' id='onlyMembersCanComment' value='{$onlyMembersCanComment}' />";
        echo "<label for='onlyMembersCanComment'>仅登录用户可评论</label>";
    }

    public function save_post($post_id)
    {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        if (isset($_POST['onlyMembersCanView'])) {
            $onlyMembersCanView = 'yes' === $_POST['onlyMembersCanView'] ? 'yes' : 'no';
            update_post_meta($post_id, 'onlyMembersCanView', $onlyMembersCanView);
        }
        if (isset($_POST['onlyMembersCanComment'])) {
            $onlyMembersCanComment = 'yes' === $_POST['onlyMembersCanComment'] ? 'yes' : 'no';
            update_post_meta($post_id, 'onlyMembersCanComment', $onlyMembersCanComment);
        }
    }

    public function columnTitle_access($columns)
    {
        $columns['_clrs_access'] = '访问限制';

        return $columns;
    }

    public function columnContent_access($column_name, $id)
    {
        if ('_clrs_access' === $column_name) {
            $onlyMembersCanView = get_post_meta($id, 'onlyMembersCanView', true);
            $onlyMembersCanComment = get_post_meta($id, 'onlyMembersCanComment', true);

            if (!$this->checked($onlyMembersCanView) && !$this->checked($onlyMembersCanComment)) {
                echo '—';
            } else {
                $_cantdo = [];
                if ($this->checked($onlyMembersCanView)) {
                    array_push($_cantdo, '浏览');
                }

                if ($this->checked($onlyMembersCanComment)) {
                    array_push($_cantdo, '评论');
                }
                echo '游客不可 '.implode($_cantdo, '、');
            }
        }
    }
}
new clrs_access();
