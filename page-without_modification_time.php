<?php /* Template Name: without modification time */ ?>
<?php
get_header();
$onlyMembersCanView = get_post_meta(get_the_ID(), 'onlyMembersCanView', true)=== 'yes' ? true : false;
?>

<div class="page-warp">
<div class="content">

<?php while (have_posts()) : the_post(); ?>


	<hgroup class="post_header">
		<h2 class="post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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
		<span class="post_tag_col"><?php echo edit_post_link(__('<i class="fa fa-pencil-square-o"></i> 编辑', 'clrs')); ?></span>
	        </div>
	</hgroup>
	<div class="post_content"><?php
    if($onlyMembersCanView && !is_user_logged_in()){
        $_na_msg = get_option('clrs_noaccess');
        $_na_msg = str_replace('{{page_url}}', urlencode(home_url(add_query_arg(array(),$wp->request))),$_na_msg);
        echo empty($_na_msg) ? '本页面仅对登录用户开放':do_shortcode($_na_msg);
    }else{
	    the_content();?>
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


</div>
</div>
	<?php comments_template('', true); ?>

<?php endwhile; // end of the loop. ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>