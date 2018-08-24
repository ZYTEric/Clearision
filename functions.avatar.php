<?php
class clrs_avatar
{
    public function __construct()
    {
        add_action('show_user_profile', array($this, 'edit_user_profile'));
        add_action('edit_user_profile', array($this, 'edit_user_profile'));

        add_action('personal_options_update', array($this, 'edit_user_profile_update'));
        add_action('edit_user_profile_update', array($this, 'edit_user_profile_update'));
        
        add_filter('pre_get_avatar_data', array($this, 'avatar_default_url'), 1, 2);
        
        if (!empty(get_option('clrs_default_avatar'))) {
            add_filter('avatar_defaults', array($this, 'replacer_default_avata'));
        }
        
        
        add_filter('get_avatar_data', array($this, 'replacer_avatar_domain'));
        
    }

    public function edit_user_profile($profileuser)
    {
        wp_enqueue_media();?>
        <div id="clrs_avatar_template">
            <table>
                <tr>
                    <td style="width: 50px;" valign="top" id="avatar_img_warp">
                        <?php echo get_avatar($profileuser->ID); ?>
                    </td>
                    <td>
                        <?php if (current_user_can('upload_files')) {
                            echo '<input type="text" readonly name="clrs_avatar-path" id="clrs_avatar-path" />';
                            echo '<input type="button" name="upload_button" value="选择文件" id="clrs_avatar_upload_btn" class="upload_btn button" data-fdname="clrs_avatar-path" data-as="头像" /><br />';
                            if (empty($profileuser->avatar)) {
                                echo '<span class="description">'.__('尚未设置本地头像，请点击“浏览”按钮上传本地头像。', 'clrs_avatars').'</span>';
                            } else {
                                echo '<input type="checkbox" name="clrs_avatar-erase" /> '.__('移除本地头像', 'clrs_avatars').'<br />';
                                echo '<span class="description">'.__('移除本地头像后，将恢复使用 Gravatar 头像。', 'clrs_avatars').'</span>';
                            }
                        } else {
                            if (empty($profileuser->avatar)) {
                                echo '<span class="description">'.__('尚未设置本地头像，请在 Gravatar.com 网站设置头像。', 'clrs_avatars').'</span>';
                            } else {
                                echo '<span class="description">'.__('你没有上传权限，如需要修改本地头像，请联系站点管理员。', 'clrs_avatars').'</span>';
                            }
                        } ?>
                    </td>
                </tr>
            </table>
        </div>
        <script>
            var clrs_avatar_template = jQuery('#clrs_avatar_template').html();
            jQuery('#clrs_avatar_template').remove();
            jQuery('tr.user-profile-picture > td').html(clrs_avatar_template);
            jQuery('tr.user-profile-picture > th').html(<?php echo json_encode(__('个人头像', 'clrs_avatars')) ?>,);
            jQuery(document).ready(function() {
                var ashu_upload_frame;
                jQuery('.upload_btn').click(function(event) {
                    var inputIns = jQuery(this);
                    var value_id = jQuery(this).data('fdname');
                    event.preventDefault();
                    if (ashu_upload_frame) {
                        ashu_upload_frame.open();
                        return;
                    }
                    ashu_upload_frame = wp.media({
                        title: <?php echo json_encode(__('选择图片', 'clrs_avatars')) ?>,
                        button: {
                            text: <?php echo json_encode(__('确定', 'clrs_avatars')) ?>,
                        },
                        multiple: false
                    });
                    ashu_upload_frame.on('select', function() {
                        attachment = ashu_upload_frame.state().get('selection').first().toJSON();
                        jQuery('input#' + inputIns.data('fdname')).val(attachment.url).trigger('change');
                    });

                    ashu_upload_frame.open();
                });
                
                jQuery('#clrs_avatar-path').bind('change', function(){
                    jQuery('#avatar_img_warp img').attr('src', jQuery('#clrs_avatar-path').val());
                });
            });
        </script>
    <?php }

    public function edit_user_profile_update($user_id)
    {
        if (!empty($avatarURI = $_POST['clrs_avatar-path'])) {
            if (
                0 !== strpos($avatarURI, clrs_getResURL()) &&
                0 !== strpos($avatarURI, clrs_getSiteURL())
            ) {
                add_action('user_profile_update_errors', function ($m) {
                    $m->add('avatar_error', __('头像更新失败: 请选择有效的<strong>站内</strong>图片文件', 'clrs_avatars'));
                });

                return;
            }

            update_user_meta($user_id, 'avatar', $avatarURI);
        } elseif (!empty($_POST['clrs_avatar-erase'])) {
            $this->avatar_delete($user_id);
        }
    }

    public function avatar_delete($user_id)
    {
        delete_user_meta($user_id, 'avatar');
    }
    
    public function avatar_default_url($args, $id_or_email)
    {
        $userInfo = clrs_userInfo($id_or_email);
        if ($userInfo && $userInfo instanceof WP_User) {
            $avatar = get_user_meta($userInfo->ID, 'avatar', true);
            if (!empty($avatar) && clrs_startWith($avatar, 'http') && !$args['force_default']) {
                $args['url'] = $avatar;
            }
        }
        return $args;
    }
    
    public function replacer_default_avata($avatar_defaults)
    {
        $avatar = get_option('clrs_default_avatar');
        $avatar_defaults[$avatar] = __("主题默认头像", 'clrs_avatars');
        return $avatar_defaults;
    }
    
    function replacer_avatar_domain($args)
    {
        if (!empty(get_option('clrs_avatar_domain'))) {
            $avatar_domain = get_option('clrs_avatar_domain');
            $args['url'] = preg_replace('/^http[s]?:\/\/(secure|\d{1,2}).gravatar.com/', $avatar_domain, $args['url']);
        }
        
        $args['url'] = preg_replace('/^http:/', 'https:', $args['url']);
        
        return $args;
    }
}

new clrs_avatar();