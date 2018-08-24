<?php get_header(); ?>

<div class="page-warp">
<div class="content">

<?php while (have_posts()) : the_post(); ?>

<article <?php post_class(); ?>>
	<?php get_template_part('content'); ?>
	<nav class='post_nav_bds'>
	<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class='goHome'>
		<i class="fa fa-home" aria-hidden="true">&nbsp; 返回首页</i>
	</a>
	<?php
	$clrs_share = get_option('clrs_share');
	if (!empty($clrs_share)) {
		echo clrs_shortcode_content($clrs_share);
	}
	?>
	<div style='clear: both;' />
	</nav>
</article>
</div>
</div> 
<?php comments_template('', true); ?>
<?php endwhile; // end of the loop. ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
