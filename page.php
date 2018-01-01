<?php
get_header();
$onlyMembersCanView = get_post_meta(get_the_ID(), 'onlyMembersCanView', true)=== 'yes' ? true : false;
?>

<div id="page-warp">
<div id="content">

<?php while (have_posts()) : the_post(); ?>

<div class="post_warp">
	<hgroup class="post_header">
		<h2 class="post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	</hgroup>
	<div class="post_content"><?php
    if($onlyMembersCanView && !is_user_logged_in()){
        $_na_msg = get_option('clrs_noaccess');
        $_na_msg = str_replace('{{page_url}}', urlencode(home_url(add_query_arg(array(),$wp->request))),$_na_msg);
        echo empty($_na_msg) ? '本页面仅对登陆用户开放':do_shortcode($_na_msg);
    }else{
	    the_content();?>
		<p style="text-align: right; font-size: .8em;">
			最后修订于&nbsp;<?php echo esc_html( get_the_modified_time('Y年m月d日') ); ?>
		</p>
    <?php }
	?></div>
  <nav class='post_nav_bds'>
	<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class='goHome'>
		<i class="fa fa-home" aria-hidden="true">&nbsp; 返回首页</i>
	</a>
	<?php
	$clrs_share = get_option('clrs_share');
	if (!empty($clrs_share)) {
		echo str_replace('{{theme_dir}}',get_template_directory_uri(),$clrs_share);
	}
	?>
	<div style='clear: both;' />
	</nav>
	<?php comments_template('', true); ?>
</div>

<?php endwhile; // end of the loop. ?>

</div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>