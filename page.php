<?php get_header(); ?>

<div id="page-warp">
<div id="content">

<?php while (have_posts()) : the_post(); ?>

<div class="post_warp">
	<hgroup class="post_header">
		<h2 class="post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	</hgroup>
	<div class="post_content"><?php the_content(); ?></div>
  <nav class='post_nav_bds'>
	<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class='goHome'>
		<i class="fa fa-home" aria-hidden="true">&nbsp; 返回首页</i>
	</a>
	<?php
	$clrs_share = get_option('clrs_share');
	if (!empty($clrs_share)) {
		echo $clrs_share;
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