<?php /* Template Name: 留言板 */
get_header(); ?>

<div id="page-warp">
<div id="content">

<?php while ( have_posts() ) : the_post(); ?>

<div class="post_warp">

	<div class="post_content"><?php the_content(); ?></div>

	<?php comments_template( '', true ); ?>

</div>

<?php endwhile; ?>

</div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
