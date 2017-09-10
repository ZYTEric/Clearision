<?php if ( post_password_required() ) return; ?>
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

  'comment_field' =>  '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" required aria-required="true"></textarea></p>',
  'must_log_in' => '<p class="must-log-in">' .
    sprintf(
      __( '你必须 <a href="%s">登录</a> 后评论。' , 'clrs' ),
      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
    ) . '</p>',

  'logged_in_as' => '<p class="logged-in-as">' .
    sprintf(
    __('以 <a href="%1$s">%2$s</a> 登录。 <a href="%3$s" title="Log out of this account">退出</a>','clrs'),
      admin_url( 'profile.php' ),
      $user_identity,
      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
    ) . '</p>',

  'comment_notes_before' => __('发表评论','clrs'),

  'comment_notes_after' => '',

  'fields' => apply_filters( 'comment_form_default_fields', array(

    'author' =>
      '<input placeholder="'.__('昵称','clrs').'" id="author" name="author" type="text" required="required" value="' . esc_attr( $commenter['comment_author'] ) .
      '" />',

    'email' =>
      '<input placeholder="'.__('邮箱','clrs').'" id="email" name="email" type="email" required="required" value="' . esc_attr(  $commenter['comment_author_email'] ) .
      '" />',

    'url' =>
      '<input placeholder="'.__('站点','clrs').'" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
      '" />'
    )
  ),
);
?>

	<?php comment_form($comments_args); ?>


</div>