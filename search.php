<?php
/*
Template Name: Search Page
*/

get_header();?>
<style>
    .post-index-header .post_content .searchform input#s{
        width: calc(100% - 60px);
    }
    nav.post_nav_bds{
        padding-bottom: 0 !important;
        margin-bottom: -13.6px;
    }
</style>
<?php if (have_posts()) : ?>
    <div id="page-warp">
    	<div id="content">
            <article class="post-index-header post type-page status-publish hentry">
    			<hgroup class="post_header" style="padding-bottom: .8em;">
                	<h2 class="post_title"><?php echo isset($_GET['s']) ? $_GET['s'] : '(空)'; ?> 的搜索结果</h2>
                </hgroup>
                <div class="post_content">
					<?php get_search_form(); ?>
                </div>
    		</article>
    	</div>
    </div>
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
				<hgroup class="post_header" style="padding-bottom: .8em;"><h2 class="post_title">
					<?php echo isset($_GET['s']) ? $_GET['s'] : '(空)'; ?> 的搜索结果</h2>
                </hgroup>
                <div class="post_content">
                    <?php get_search_form(); ?><br>
					<p>很抱歉，没有找到与“<?php echo isset($_GET['s']) ? $_GET['s'] : '(空)'; ?>”相关的结果。请检查您输入的关键词是否正确。</p>
                </div>
                <nav class="post_nav_bds">
                	<a href="<?php echo $clrs_siteURL; ?>" rel="home" class="goHome">
                		<i class="fa fa-home" aria-hidden="true">&nbsp; 返回首页</i>
                	</a>
                </nav>
    		</article>
    	</div>
    </div>
<?php endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>