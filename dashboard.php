<?php
function clrs_dashboard()
{
    wp_enqueue_media();
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('clrs-colorpicker', get_template_directory_uri() . '/assets/scripts/wp-color-picker-alpha.min.js', array('wp-color-picker', 'media'), false, true);
    wp_enqueue_script('clrs-dashboard', get_template_directory_uri() . '/assets/scripts/dashboard.js', array('wp-color-picker', 'media'), false, true);
    ?>
    <style type="text/css">
        input[type="text"] {
            max-width: 510px;
        }

        textarea {
            font-size: 14px;
            font-family: Consolas, monospace, sans-serif, sans;
        }

        @media screen and (max-width: 782px) {
            table.noresp td,
            table.noresp th {
                display: table-cell !important;
                font-size: 16px;
            }
        }

        table.clearpm>tbody>tr>td {
            margin: 0;
            padding: 0;
            padding-bottom: 15px;
        }

        table.clearpm,
        table.clearpm>tbody>tr>td>input {
            width: 100%;
        }

        td textarea {
            width: 100%
        }

        .form-table {
            max-width: 900px;
        }

        .form-table>tbody>tr {
            border-bottom: 1px solid #bbb;
        }

        .form-table>tbody>tr>td:nth-child(1) {
            max-width: 300px;
        }

        .form-table>tbody>tr>td:nth-child(2) {
            max-width: 600px;
        }

        .wp-picker-container {
            position: absolute;
            z-index: 0;
        }

        .wp-picker-active {
            z-index: 1;
        }

        .wp-picker-input-wrap {
            min-width: 135px;
        }
    </style>

    <h1>
        <?php /*_e*/__('Clearision 主题设置', 'clrs'); ?>
    </h1>
    <?php $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'clrs_opt_common'; ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=clrs_menu&tab=clrs_opt_common" class="nav-tab <?php echo $active_tab == 'clrs_opt_common' ? 'nav-tab-active' : ''; ?>">常规设置</a>
        <a href="?page=clrs_menu&tab=clrs_opt_seo" class="nav-tab <?php echo $active_tab == 'clrs_opt_seo' ? 'nav-tab-active' : ''; ?>">SEO优化</a>
        <a href="?page=clrs_menu&tab=clrs_opt_social" class="nav-tab <?php echo $active_tab == 'clrs_opt_social' ? 'nav-tab-active' : ''; ?>">社交信息</a>
        <a href="?page=clrs_menu&tab=clrs_opt_advanced" class="nav-tab <?php echo $active_tab == 'clrs_opt_advanced' ? 'nav-tab-active' : ''; ?>">高级功能</a>
    </h2>
    <form method="post" name="clrs_form" id="clrs_form">
        <?php
        switch ($active_tab) {
            case 'clrs_opt_common' :
                clrs_opt_common();
                break;
            case 'clrs_opt_seo' :
                clrs_opt_seo();
                break;
            case 'clrs_opt_advanced' :
                clrs_opt_advanced();
                break;
            case 'clrs_opt_social' :
                clrs_opt_social();
                break;
        } ?>
            <?php submit_button(); ?>
            <?php wp_nonce_field('update-options'); ?>
            <input type="hidden" name="action" value="option_save" />
            <input type="hidden" name="page_options" value="clrs_copy_right" />
            <input type="hidden" name="option_save" value="yes" />
    </form>
    <?php 
}
/*        基础样式       */
function clrs_opt_common()
{
    if (isset($_POST['option_save'])) {
        $clrs_opbg_des = stripslashes($_POST['clrs_opbg_des']);
        update_option('clrs_opbg_des', $clrs_opbg_des);
        $clrs_opcl_des = stripslashes($_POST['clrs_opcl_des']);
        update_option('clrs_opcl_des', $clrs_opcl_des);

        $clrs_opbg_mobi = stripslashes($_POST['clrs_opbg_mobi']);
        update_option('clrs_opbg_mobi', $clrs_opbg_mobi);
        $clrs_opcl_mobi = stripslashes($_POST['clrs_opcl_mobi']);
        update_option('clrs_opcl_mobi', $clrs_opcl_mobi);

        $clrs_logo = stripslashes($_POST['clrs_logo']);
        update_option('clrs_logo', $clrs_logo);

        $clrs_ftlogo = stripslashes($_POST['clrs_ftlogo']);
        update_option('clrs_ftlogo', $clrs_ftlogo);

        $clrs_favi = stripslashes($_POST['clrs_favi']);
        update_option('clrs_favi', $clrs_favi);
    } ?>
    <table class="form-table">
        <tr>
            <td>
                <h3>桌面版背景</h3>(窗口宽度超过600px)</td>
            <td>
                <table class="clearpm noresp">
                    <tr>
                        <td>
                            背景图：<br />
                            <input type="text" name="clrs_opbg_des" class="input-clrs_opbg_des" id="clrs_opbg_des" placeholder="" value="<?php echo get_option('clrs_opbg_des'); ?>"
                            />
                        </td>
                        <td width="72px"><br />
                            <input type="button" name="upload_button" value="选择文件" id="upload_btn_opct" class="upload_btn button" data-fdname="clrs_opbg_des"
                                data-as="背景图片" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        背景色：<br />
                        <input type="text" name="clrs_opcl_des" class="input-clrs_opcl_des" data-alpha="true" id="clrs_opcl_des" placeholder=""
                            value="<?php echo get_option('clrs_opcl_des'); ?>" />
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <h3>手机版背景</h3>(窗口宽度小于600px)</td>
            <td>
                <table class="clearpm noresp">
                    <tr>
                        <td>
                            背景图：<br />
                            <input type="text" name="clrs_opbg_mobi" class="input-clrs_opbg_mobi" id="clrs_opbg_mobi" placeholder="" value="<?php echo get_option('clrs_opbg_mobi'); ?>"
                            />
                        </td>
                        <td width="72px"><br />
                            <input type="button" name="upload_button" value="选择文件" id="upload_btn_opct" class="upload_btn button" data-fdname="clrs_opbg_mobi"
                                data-as="背景图片" />
                        </td>
                    </tr>
                    <tr>
                    <td colspan="2">
                            背景色：<br />
                            <input type="text" name="clrs_opcl_mobi" class="input-clrs_opcl_mobi" data-alpha="true" id="clrs_opcl_mobi" placeholder=""
                                value="<?php echo get_option('clrs_opcl_mobi'); ?>" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <h3>LOGO头像</h3>
                <img src="<?php echo get_option('clrs_logo'); ?>" height="60px" class="img-clrs_logo" />
            </td>
            <td>
                <table class="clearpm noresp">
                    <tr>
                        <td>
                            <input type="text" name="clrs_logo" class="input-clrs_logo" id="clrs_logo" value="<?php echo get_option('clrs_logo'); ?>"
                            />
                        </td>
                        <td width="72px">
                            <input type="button" name="upload_button" value="选择文件" id="upload_btn_logo" class="upload_btn button" data-fdname="clrs_logo"
                                data-as="LOGO头像" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <h3>网站图标</h3>
                <img src="<?php echo get_option('clrs_favi'); ?>" height="32px" class="img-clrs_favi" />
            </td>
            <td>
                <table class="clearpm noresp">
                    <tr>
                        <td>
                            <input type="text" name="clrs_favi" class="input-clrs_favi" id="clrs_favi" value="<?php echo get_option('clrs_favi'); ?>"
                            />
                        </td>
                        <td width="72px">
                            <input type="button" name="upload_button" value="选择文件" id="upload_btn_ftlogo" class="upload_btn button" data-fdname="clrs_favi"
                                data-as="网站图标" /><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <h3>底部LOGO</h3>
                <img src="<?php echo get_option('clrs_ftlogo'); ?>" width="120px" class="img-clrs_ftlogo" />
            </td>
            <td>
                <table class="clearpm noresp">
                    <tr>
                        <td>
                            <input type="text" name="clrs_ftlogo" class="input-clrs_ftlogo" id="clrs_ftlogo" value="<?php echo get_option('clrs_ftlogo'); ?>"
                            />
                        </td>
                        <td width="72px">
                            <input type="button" name="upload_button" value="选择文件" id="upload_btn_ftlogo" class="upload_btn button" data-fdname="clrs_ftlogo"
                                data-as="底部LOGO" /><br />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
    <?php 
}
/*        SEO      */
function clrs_opt_seo()
{
    if (isset($_POST['option_save'])) {
        $clrs_keywd = stripslashes($_POST['clrs_keywd']);
        update_option('clrs_keywd', $clrs_keywd);

        $clrs_desc = stripslashes($_POST['clrs_desc']);
        update_option('clrs_desc', $clrs_desc);

        $clrs_cpyrt = stripslashes($_POST['clrs_cpyrt']);
        update_option('clrs_cpyrt', $clrs_cpyrt);

        $clrs_tongji = stripslashes($_POST['clrs_tongji']);
        update_option('clrs_tongji', $clrs_tongji);
    } ?>
    <table class="form-table">
        <tr>
            <td>
                <h3>
                    <?php /*_e*/__('网站关键字：', 'clrs'); ?>
                </h3>
            </td>
            <td><textarea name="clrs_keywd" id="clrs_keywd" rows="3" cols="60" style="font-size: 14px; font-family: Consolas, monospace, sans-serif, sans"><?php echo get_option('clrs_keywd'); ?></textarea></td>
        </tr>
        <tr>
            <td>
                <h3>
                    <?php /*_e*/__('网站介绍：', 'clrs'); ?>
                </h3>
            </td>
            <td><textarea name="clrs_desc" id="clrs_desc" rows="3" cols="60" style="font-size: 14px; font-family: Consolas, monospace, sans-serif, sans"><?php echo get_option('clrs_desc'); ?></textarea></td>
        </tr>
        <tr>
            <td>
                <h3>
                    <?php /*_e*/__('版权信息：', 'clrs'); ?>
                </h3>
            </td>
            <td>
                <textarea name="clrs_cpyrt" id="clrs_cpyrt" rows="3" cols="60" style="font-size: 14px; font-family: Consolas, monospace, sans-serif, sans"><?php echo get_option('clrs_cpyrt'); ?></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <h3>
                    <?php /*_e*/__('统计代码：', 'clrs'); ?>
                </h3>
            </td>
            <td><textarea name="clrs_tongji" rows="5" cols="60" placeholder="<?php /*_e*/__('输入网站统计代码', 'clrs'); ?>" style="font-size: 14px; font-family: Consolas, monospace, sans-serif, sans"><?php echo get_option('clrs_tongji'); ?></textarea></td>
        </tr>
    </table>
    <?php 
}
/*        社交信息       */
function clrs_opt_social()
{
    $clrs_sns = array(
        "profile" => "个人页",
        "gplus" => "Google+",
        "twitter" => "Twitter",
        "fb" => "Facebook",
        "weibo" => "SinaWeibo",
        "qqw" => "QQ",
        "github" => "Github"
    );
    if (isset($_POST['option_save'])) {
        $clrs_share = stripslashes($_POST['clrs_share']);
        update_option('clrs_share', $clrs_share);

        $clrs_author_display = stripslashes($_POST['clrs_author_display']);
        update_option('clrs_author_display', $clrs_author_display);

        $clrs_link_display = stripslashes($_POST['clrs_link_display']);
        update_option('clrs_link_display', $clrs_link_display);

        $clrs_link = stripslashes($_POST['clrs_link']);
        update_option('clrs_link', $clrs_link);

        foreach ($clrs_sns as $clrs_sns_id => $clrs_sns_name) {
            $clrs_sns_id = 'clrs_s_' . $clrs_sns_id;
            update_option($clrs_sns_id, stripslashes($_POST[$clrs_sns_id]));
        }
    } ?>

    <table class="form-table">
        <tr>
            <td>
                <h3>文章作者</h3>
            </td>
            <td>
                <input type="radio" name="clrs_author_display" value="yes" required="required" <?php clrs_va("clrs_author_display"); ?>/>
                <?php /*_e*/__('显示', 'clrs'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="clrs_author_display" value="no" required="required" <?php clrs_vb("clrs_author_display"); ?>/>
                <?php /*_e*/__('不显示', 'clrs'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <h3>社交图标</h3>
            </td>
            <td>
                <table class="clearpm">
                    <?php foreach ($clrs_sns as $clrs_sns_id => $clrs_sns_name) {
                        $clrs_sns_id = 'clrs_s_' . $clrs_sns_id; ?>
                    <tr>
                        <td style="width: 70px;">
                            <?php echo $clrs_sns_name; ?>
                        </td>
                        <td>
                            <input type="text" style="width: 100%" name="<?php echo $clrs_sns_id ?>" id="<?php echo $clrs_sns_id ?>" placeholder="http://"
                                value="<?php echo get_option($clrs_sns_id) ?>" />
                        </td>
                    </tr>
                    <?php 
                } ?>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <h3>分享代码</h3>
            </td>
            <td><textarea name="clrs_share" rows="5" cols="60" placeholder="<?php /*_e*/__('输入文章代码', 'clrs'); ?>" style="font-size: 14px; font-family: Consolas, monospace, sans-serif, sans"><?php echo get_option('clrs_share'); ?></textarea></td>
        </tr>
        <tr>
            <td>
                <h3>友情链接</h3>
            </td>
            <td>
                <input type="radio" name="clrs_link_display" value="yes" required="required" <?php clrs_va("clrs_link_display"); ?>                />
                <?php /*_e*/__('显示', 'clrs'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="clrs_link_display" value="no" required="required" <?php clrs_vb("clrs_link_display"); ?>                />
                <?php /*_e*/__('不显示', 'clrs'); ?><br><br>
                <textarea name="clrs_link" rows="10" cols="60" placeholder="<?php /*_e*/__('在这里使用 HTML 代码自定义友链区的内容', 'clrs'); ?>" style="font-size: 14px; font-family: Consolas, monospace, sans-serif, sans"><?php echo get_option('clrs_link'); ?></textarea>
            </td>
        </tr>
    </table>
    <?php 
}
/*        高级功能       */
function clrs_opt_advanced()
{
    if (isset($_POST['option_save'])) {
        $clrs_style = stripslashes($_POST['clrs_style']);
        update_option('clrs_style', $clrs_style);
        //jQuery
        $clrs_thrdptComs_jq = stripslashes($_POST['clrs_thrdptComs_jq']);
        update_option('clrs_thrdptComs_jq', $clrs_thrdptComs_jq);
        $clrs_thrdptComs_jq_ver = stripslashes($_POST['clrs_thrdptComs_jq_ver']);
        update_option('clrs_thrdptComs_jq_ver', $clrs_thrdptComs_jq_ver);
        //Font Awesome
        $clrs_thrdptComs_fa = stripslashes($_POST['clrs_thrdptComs_fa']);
        update_option('clrs_thrdptComs_fa', $clrs_thrdptComs_fa);
        $clrs_thrdptComs_fa_ver = stripslashes($_POST['clrs_thrdptComs_fa_ver']);
        update_option('clrs_thrdptComs_fa_ver', $clrs_thrdptComs_fa_ver);
    } ?>
    <table class="form-table">
        <tr>
            <td>
                <h3>第三方组件</h3>
            </td>
            <td>
                勾选后强制替换组件为设定的版本，不勾选则不作任何干涉。
                <table class="noresp">
                    <tr>
                        <td><input name="clrs_thrdptComs_jq" type="checkbox" value="yes" <?php clrs_va("clrs_thrdptComs_jq") ?
                                                                                                'checked' : ''; ?> /></td>
                        <td><a href="http://jquery.com/" target="_blank">jQuery</a></td>
                        <td>&nbsp;版本&nbsp;<input type="text" size="4" name="clrs_thrdptComs_jq_ver" id="clrs_thrdptComs_jq_ver"
                                placeholder="3.2.1" value="<?php echo get_option('clrs_thrdptComs_jq_ver'); ?>" /></td>
                    </tr>
                    <tr>
                        <td><input name="clrs_thrdptComs_fa" type="checkbox" value="yes" <?php clrs_va("clrs_thrdptComs_fa") ?
                                                                                                'checked' : ''; ?> /></td>
                        <td><a href="http://fontawesome.io/" target="_blank">Font Aweson</a></td>
                        <td>&nbsp;版本&nbsp;<input type="text" size="4" name="clrs_thrdptComs_fa_ver" id="clrs_thrdptComs_fa_ver"
                                placeholder="4.7.0" value="<?php echo get_option('clrs_thrdptComs_fa_ver'); ?>" /></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <h3>自定义样式</h3>
            </td>
            <td><textarea name="clrs_style" rows="10" cols="60" placeholder="<?php /*_e*/__('输入 CSS 代码，以便更新时不会被覆盖', 'clrs'); ?>" style="font-size: 14px; font-family: Consolas, monospace, sans-serif, sans"><?php echo get_option('clrs_style'); ?></textarea></td>
        </tr>
    </table>

    <?php 
}