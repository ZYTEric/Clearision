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

		<span class="post_tag_col"><a><i class="fa fa-clock-o" aria-hidden="true">&nbsp;发布于 <?php echo the_time('Y/m/d') ?></i></a></span>

		<?php if (function_exists('the_views')) { ?>
		<span class="post_tag_col"><a><i class="fa fa-book" aria-hidden="true">&nbsp;<?php the_views(); ?></i></a></span>
		<?php } ?>

		<span class="post_tag_col"><a href="<?php comments_link(); ?>" ><i class="fa fa-comments" aria-hidden="true">&nbsp;<?php comments_number(__('暂无评论', 'clrs'), __('评论 (1)', 'clrs'), __('评论 (%)', 'clrs')); ?></i></a></span>
		<span class="post_tag_col"><?php echo edit_post_link(__('编辑文章', 'clrs')); ?></span>
	</div>
</hgroup>

<div class="post_content">
	<?php if (get_post_format() == 'quote') { ?>
	<a href="<?php the_permalink(); ?>">
		<?php the_content(''); ?>
	</a>
	<?php 
}
else {
	the_content('');
}; ?>
	<h2 class="post_h_quote">
		<?php the_title(); ?>
	</h2>
</div>