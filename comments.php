<?php
if ( post_password_required() ) return;
$onlyMembersCanComment = get_post_meta(get_the_ID(), 'onlyMembersCanComment', true) === 'yes' ? true : false;
if($onlyMembersCanComment && !is_user_logged_in()) return;
?>
<div id="comment" class="comment">

	<?php if ( have_comments() ) : ?>

		<ol class="comment_list">
			<?php wp_list_comments( array( 'callback' => 'clrs_comment', 'style' => 'ol' ) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav" class="navigation" role="navigation">
			<div class="comment-nav-prev"><?php previous_comments_link( __('&larr; 更旧的评论','clrs') ); ?></div>
			<div class="comment-nav-next"><?php next_comments_link( __('更新的评论 &rarr;','clrs') ); ?></div>
		</nav>
		<?php endif; ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments" style="display:none; "><?php __('对不起，这里禁止评论','clrs'); ?></p>
		<?php endif; ?>

	<?php endif; ?>

<?php $comments_args = array(
  'id_form'           => 'comment_form',
  'id_submit'         => 'comment_submit',
  'title_reply'       => '',
  'title_reply_to'    => __('评论 %s','clrs'),
  'cancel_reply_link' => __('撤销评论','clrs'),
  'label_submit'      => __('提交','clrs'),

  'comment_field' =>  '<div class="row"><div class="col-12" ><p class="comment-form-comment"><textarea style="max-width: none; width: 100%;" id="comment" name="comment" rows="8" required aria-required="true"></textarea></p></div></div>',
  'must_log_in' => '<p class="must-log-in">' .
    sprintf(
      __( '你必须 <a href="%s">登录</a> 后评论。' , 'clrs' ),
      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
    ) . '</p>',

  'logged_in_as' => '<p class="logged-in-as">' .
    sprintf(
    __('您当前使用的账号是 <a href="%1$s">%2$s</a> 。 <a href="%3$s" title="注销并返回登录界面">退出</a>','clrs'),
      admin_url( 'profile.php' ),
      $user_identity,
      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
    ) . '</p>',

  'comment_notes_before' => '<div class="row"><div class="col-12">发表评论</div></div>',

  //'comment_notes_after' => '',
  'submit_field'         => '<div class="row"><div class="col-12">%1$s %2$s</div></div>',
  'fields' => apply_filters( 'comment_form_default_fields', array(

    'author' =>
      '<div class="col-12 col-sm-6"><input style="width: 100%;" placeholder="'.__('昵称','clrs').'" id="author" name="author" type="text" required="required" value="' . esc_attr( $commenter['comment_author'] ) .
      '" /></div>',

    'email' =>
      '<div class="col-12 col-sm-6" ><input style="width: 100%;" placeholder="'.__('邮箱','clrs').'" id="email" name="email" type="email" required="required" value="' . esc_attr(  $commenter['comment_author_email'] ) .
      '" /></div>',

    'url' =>
      '<div class="col-12 col-sm-6"><input placeholder="'.__('站点','clrs').'" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
      '" /></div>'
    )
  ),
);

add_action('comment_form_top', function(){
  echo '<div class="container-fluid" style="margin: unset;">';
});

add_action('comment_form_before_fields', function(){
  echo '<div class="row">';
});

add_action('comment_form_after_fields', function(){
  echo '</div>';
});

add_action('comment_form', function(){
  echo '</div>';
});
?>

	<?php comment_form($comments_args); ?>


</div>