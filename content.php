<?php
$onlyMembersCanView = get_post_meta(get_the_ID(), 'onlyMembersCanView', true)=== 'yes' ? true : false;
?>
<hgroup class="post_header">
	<h2 class="post_title">
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</h2>

	<div class="post_tag">
		<?php $adis = get_option('clrs_adis');
		if ($adis == "yes") {
			$c_adis = "";
		}
		else {
			$c_adis = 'style="display:none;"';
		};
		the_tags('', ' ', '');
		?>
		<span class="post_tag_col" <?php echo $c_adis; ?>><a><i class="fa fa-user" aria-hidden="true">&nbsp;作者 <?php the_author();?></i></a></span>

		<span class="post_tag_col"><a><i class="fa fa-calendar" aria-hidden="true">&nbsp;<?php echo the_time('Y-m-d') ?></i></a></span>

		<?php if (function_exists('the_views')) { ?>
		<span class="post_tag_col"><a><i class="fa fa-eye" aria-hidden="true">&nbsp;<?php the_views(); ?></i></a></span>
		<?php } ?>

		<span class="post_tag_col"><a href="<?php comments_link(); ?>" ><i class="fa fa-comments" aria-hidden="true">&nbsp;<?php comments_number(__('暂无评论', 'clrs'), __('评论 (1)', 'clrs'), __('评论 (%)', 'clrs')); ?></i></a></span>
		<span class="post_tag_col"><?php echo edit_post_link(__('<i class="fa fa-pencil-square-o"></i> 编辑', 'clrs')); ?></span>
	</div>
</hgroup>
<div class="post_content"><?php
if($onlyMembersCanView && !is_user_logged_in()){
    $_na_msg = get_option('clrs_noaccess');
    $_na_msg = str_replace('{{page_url}}', urlencode(home_url(add_query_arg(array(),$wp->request))),$_na_msg);
    echo empty($_na_msg) ? '本页面仅向已登录用户开放':do_shortcode($_na_msg);
}else{
    if (get_post_format() == 'quote') {
        echo '<a href="'; the_permalink(); echo '">';
        the_content('');
        echo '</a>';
    }else{
        the_content('');
    }
}
?>
	<h2 class="post_h_quote">
		<?php the_title(); ?>
	</h2>
	
	<p style="text-align: right; font-size: .8em;">
		最后修订于&nbsp;<?php echo esc_html( get_the_modified_time('Y年m月d日') ); ?>
	</p>
</div>