<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package universe-example
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

// создаем свою функцию вывода каждого коммента
function universal_theme_comment( $comment, $args, $depth ) {
    // проверяем в каком стиле у нас родтитель (ol, ul, div)
    	if ( 'div' === $args['style'] ) {
            // если стиль - div, то тег будет div
		$tag       = 'div';
		$add_below = 'comment';
	} else {
        // в другом случае комментарий будет li
		$tag       = 'li';
		$add_below = 'div-comment';
	}
// какие классы вешаем на каждый комментарий
	$classes = ' ' . comment_class( empty( $args['has_children'] ) ? '' : 'parent', null, null, false );
	?>

	<<?php echo $tag, $classes; ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) { ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
	} ?>
    <div class="comment-author-avatar">
    <?php 
    if ( $args['avatar_size'] != 0 ) {
        echo get_avatar( $comment, $args['avatar_size'] );
    }
    ?>
    </div>
    <div class="comment-content">
	<div class="comment-author vcard">
		<?php
		printf(
			__( '<cite class="fn">%s</cite>' ),
			get_comment_author_link()
        );
        
		?>
        	<span class="comment-meta commentmetadata">
		<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
			printf(
				__( '%1$s, %2$s' ),
				get_comment_date('F jS'),
				get_comment_time()
			); ?>
		</a>

		<?php edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>
	</span>
	</div>

	<?php if ( $comment->comment_approved == '0' ) { ?>
		<em class="comment-awaiting-moderation">
			<?php _e( 'Your comment is awaiting moderation.' ); ?>
		</em><br/>
	<?php } ?>



	<?php comment_text(); ?>

	<div class="comment-reply">
    <svg fill="#BCBFC2" width="14" height="14" class="icon comments-icon">
        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Comment-icon"></use>
    </svg>
		<?php
		comment_reply_link(
			array_merge(
				$args,
				array(
					'add_below' => $add_below,
					'depth'     => $depth,
					'max_depth' => $args['max_depth']
				)
			)
		); ?>
	</div>
    </div>
	<?php if ( 'div' != $args['style'] ) { ?>
		</div>
	<?php }
}

if ( post_password_required() ) {
	return;
}
?>
<div class="container">
<div id="comments" class="comments-area">

	<?php
	// Проверка, есть ли комментарии
	if ( have_comments() ) :
		?>
        <div class="comments-header">
		<h2 class="comments-title">
			<?php
			echo  _e('Comments ', 'universal') . '<span class="comments-count">' . get_comments_number() . '</span>'?>
		</h2><!-- .comments-title -->
        <a href="#form" class="comments-add-button">
            <svg width="18" height="18" class="icon eye-icon">
                <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Pencil"></use>
            </svg><?php  _e('Add comment', 'universal') ;?></a>
        </div>
<!-- навигация на предыдущие и на следующие страницы с комментариями -->
		<?php the_comments_navigation(); ?>

        <!-- Выводим список комментариев -->
		<ol class="comments-list">
			<?php
            // выводим каждый отдельный комментарий
			wp_list_comments(
				array(
					'style'      => 'ol',
                    'short_ping' => true,
                    'avatar_size' => 75,
                    'callback' => 'universal_theme_comment',
                    'login_text' =>  _e('Register to leave comment', 'universal'),
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'universe-theme' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form(array(
        'title_reply' => '',
		'comment_field' => '<div class="comment-form-comment" id="form">
		<label class="comment-label" for="comment">' . _x( 'What do you think about it?', 'noun', 'universal' ) . '</label>
		<div class="comment-wrapper">
		' . get_avatar( get_current_user_id(), 75) . '
		<div class="comment-textarea-wrapper">
		<textarea class="comment-textarea" id="comment" name="comment" aria-required="true"></textarea>
		</div>
		</div>
		</div>',
	    'must_log_in'          => '<p class="must-log-in">' . 
		 sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '
	    </p>',
	    'logged_in_as'         => '',
	    'comment_notes_before' => '<p class="comment-notes">
		<span id="email-notes">' . __( 'Your email address will not be published.' ) . '</span>'. 
		( $req ?  : '' ) . '
		</p>',
		'class_submit'         => 'comment-submit more',
		'label_submit' =>  _e('No entries', 'universal'),
		'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">Отправить</button>',
    ));
	?>

</div><!-- #comments -->
</div>
