<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

// Do not delete these lines
	if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) { ?>
	<!--<div class="commentlist_container web_boxp">-->
	<h3 id="comments"><?php comments_number("No Responses",'One Response', "% Responses");?> to "<?php the_title(); ?>"</h3>

	<!-- <div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
-->

	<ol class="commentlist">
	<?php wp_list_comments('callback=mytheme_comment');?>
	</ol>
	<div class="pagination"><?php paginate_comments_links(); ?></div>
	<?php /* <div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div> <?php */ ?>
    <!--</div> web boxp div end here-->
 <?php }
 	else { // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php } ?>


<?php if ( comments_open() ) : ?>

<div class="web_boxp commentform"><?php
$args = array(

'comment_field' => '<p class="comment-form-comment"><label for="comment">Comment</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
'fields' => apply_filters( 'comment_form_default_fields', array(

	'author' =>
		'<div class="row"><div class="col-sm-4"><p class="comment-form-author">' .
		'<input id="author" name="author" type="text" value="" placeholder="Name" required="required" /></p></div>',

	'email' =>
		'<div class="col-sm-4"><p class="comment-form-email">' .
		'<input id="email" name="email" type="email" value="" placeholder="Email" required="required" /></p></div>',

	'url' =>
		'<div class="col-sm-4"><p class="comment-form-url">'.
		'<input id="url" name="url" type="text" value="" placeholder="Website" /></p></div></div>'
	)

),
'comment_notes_before' => '<p class="comment-notes">We'."'".'re glad you have chosen to leave a comment. Please keep in mind that all comments are moderated according to our comment policy, and all links are nofollow. Let\'s have a personal and meaningful conversation.</p>',
'logged_in_as' => '<p class="logged-in-as">' . sprintf( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', admin_url( 'profile.php' ), $user_identity, wp_logout_url(HOME_URL) ) . '</p>'
);
comment_form( $args );
?></div>
<?php  endif; // if you delete this the sky will fall on your head ?>
