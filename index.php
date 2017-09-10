<?php get_header(); ?>

<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
	<div id="page-warp">
		<div id="content">

			<article <?php post_class(); ?>>

				<?php get_template_part('content'); ?>

			</article>
		</div>
	</div>
	<?php endwhile; ?>

	<div id="page_nav">
		<?php clrs_pagenavi(); ?>
	</div>

	<?php  else : ?>
	<div id="page-warp">
		<div id="content">

			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title">
						<?php /*_e*/__('找不到内容', 'clrs'); ?>
					</h1>
				</header>

				<div class="entry-content">
					<p>
						<?php /*_e*/__('对不起，没有找到相关的内容，请重试', 'clrs'); ?>
					</p>
					<?php get_search_form(); ?>
				</div>
			</article>
		</div>
	</div>
<?php endif; ?>
<?php $ldis = get_option('clrs_link_display');
$c_ldis = $ldis !== "yes" ? 'style="display: none"' : ''; ?>
<div id="link" <?php echo $c_ldis; ?>>
	<div id="link_content">
		<h3 id="link-head">
			<?php /*_e*/__('友情链接', 'clrs'); ?>
		</h3>
		<?php echo get_option('clrs_link'); ?>
	</div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>