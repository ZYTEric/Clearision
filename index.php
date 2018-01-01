<?php get_header(); ?>
<?php
    $clrs_index_header = get_option('clrs_index_header');
    $clrs_index_header_title = get_option('clrs_index_header_title');
    $clrs_index_header_link = get_option('clrs_index_header_link');
    if(is_home() && $wp_query->query_vars['paged'] <2 && !empty($clrs_index_header)){ ?>
    <div id="page-warp">
    	<div id="content">
            <article class="post-index-header post type-page status-publish hentry">
                <?php if(!empty($clrs_index_header_title)){ ?>
    			<hgroup class="post_header" style="padding-bottom: .8em;">
                	<h2 class="post_title">
                	    <?php if(!empty($clrs_index_header_link)){ ?>
                		<a href="<?php echo $clrs_index_header_link; ?>"><?php echo $clrs_index_header_title ?></a>
                		<?php } else { ?>
                		<?php echo $clrs_index_header_title ?>
                		<?php } ?>
                	</h2><br />
                </hgroup>
                <?php } ?>
                <div class="post_content">
                    <?php echo clrs_shortcode_content(wpautop($clrs_index_header)); ?>
                </div>
    		</article>
    	</div>
    </div>
<?php } ?>
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
            <article class="post-index-header post type-page status-publish hentry">
    			<hgroup class="post_header" style="padding-bottom: .8em;">
                	<h2 class="post_title">找不到内容</h2>
                </hgroup>
                <div class="post_content">
                    <p>对不起，没有找到相关的内容，请重试</p>
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
			<?php __('友情链接', 'clrs'); ?>
		</h3>
		<?php echo get_option('clrs_link'); ?>
	</div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>