<?php
function custom_login()
{
    $clrs_opbg_des = clrs_checkRandURI(get_option('clrs_opbg_des'), 'clrs_opbg_des');
    $clrs_opcl_des = get_option('clrs_opcl_des');
    $clrs_opbg_mobi = clrs_checkRandURI(get_option('clrs_opbg_mobi'), 'clrs_opbg_mobi');
    $clrs_opcl_mobi = get_option('clrs_opcl_mobi');
    if (!empty($clrs_opcl_mobi)) {
        echo '<meta name="theme-color" content="' . $clrs_opcl_mobi . '" />';
    }
    echo "<style>";
    echo '@media screen and (min-width: 600px){';
    if (!empty($clrs_opbg_des)) echo "body { background-image: url('" . $clrs_opbg_des . "'); }";
    if (!empty($clrs_opcl_des)) echo "body { background-color: " . $clrs_opcl_des . "; }";
    include('functions.login.css');
    echo '}';
    echo "</style>";

    echo "<script type=\"text/javascript\">";
    echo "	jQuery(document).ready(function() {";
    echo "		  jQuery('input.input').attr('spellcheck', 'false');";
    echo "	});";
    echo "</script>";
}
add_action('login_head', 'custom_login');