<?php
/**
 * 添加用户字段“职位”
 *
 * @param array $user_contactmethods 默认用户字段
 * @return array
 */
function clrs_user_contact(array $user_contactmethods)
{
    $user_contactmethods['job'] = '职位';
    return $user_contactmethods;
}
add_filter('user_contactmethods', 'clrs_user_contact');

/**
 * 禁止填写姓名
 */
if (current_user_can('manage_options') && $pagenow == 'profile.php' && !isset($_COOKIE['admin'])) {
    add_action('admin_footer', function () { ?>
	<script>
	    jQuery(document).ready( function($) {
			$('.user-first-name-wrap input, .user-last-name-wrap input')
			.attr("disabled", "disabled")
			.attr("placeholder", "已禁用")
			.attr("value", "")
			.val('');
	    });
	</script>
	<?php 
});
}

/**
 * 注册时填写昵称
 */
add_action('register_form', 'additional_profile_fields', -1);
function additional_profile_fields()
{ ?>
    <p>
        <label><?php _e('昵称') ?><br />
        <input type="text" name="nickname" id="nickname" class="input" size="25" />
        </label>
    </p>
<?php 
}

// 检测表单字段是否为空，如果为空显示提示信息
add_action('register_post', function ($sanitized_user_login, $user_email, $errors) {
    if (!isset($_POST['nickname'])) {
        return $errors->add('nicknameempty', '<strong>ERROR</strong>: 请输入您的昵称.');
    }
}, 10, 3);

// 将用户填写的字段内容保存到数据库中
add_action('user_register', 'insert_register_fields');
function insert_register_fields($user_id)
{
    $nickname = apply_filters('pre_user_nickname', $_POST['nickname']);
    wp_update_user([
        'ID' => $user_id,
        'nickname' => $nickname,
        'display_name' => $nickname,
    ]);
}

/**
 * 登陆重定向
 */
if (!empty(get_option('clrs_login_redirect'))) {
    add_filter('login_redirect', function ($url, $query, $user) {
        if ($url === home_url() . '/wp-admin/') {
            return get_option('clrs_login_redirect');
        } else if (empty($url)) {
            return home_url();
        } else {
            return $url;
        }
    }, 10, 3);
}

/**
 * 发表评论时不需要填写“站点”
 *
 * @param array $fields 默认表单域
 * @return array
 */
function alter_comment_form_fields(array $fields)
{
    //$fields['author'] = '';
    //$fields['email'] = '';
    $fields['url'] = '';
    return $fields;
}
add_filter('comment_form_default_fields', 'alter_comment_form_fields');
