<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bones.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once( 'library/bones.php' ); // if you remove this, bones will break
/*
3. library/admin.php
	- removing some default WordPress dashboard widgets
	- an example custom dashboard widget
	- adding custom login css
	- changing text in footer of admin
*/
// require_once( 'library/admin.php' ); // this comes turned off by default
/*
4. library/translation/translation.php
	- adding support for other languages
*/
// require_once( 'library/translation/translation.php' ); // this comes turned off by default

/* import CPT */
require_once('library/cpt-case.php');

/*
	Custom Columns in UI for "Case" CPT
 */

add_filter( 'manage_edit-case_columns', 'my_edit_case_columns' ) ;
function my_edit_case_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'case_id' => __( 'Case ID' ),
		'comments' => __('Comments'),
		'date' => __( 'Date' )
	);
	return $columns;
}

add_action( 'manage_case_posts_custom_column', 'my_manage_case_columns', 10, 2 );
function my_manage_case_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case 'case_id':
			$actions = array();
		    $post_type_object = get_post_type_object( $post->post_type );
		    $can_edit_post = current_user_can( $post_type_object->cap->edit_post, $post->ID );

		    // show Case ID
		    printf( __( 'SME%s' ), $post_id );

		    // show actions
		    if ( $can_edit_post && 'trash' != $post->post_status ) {
		        $actions['edit'] = '<a href="' . get_edit_post_link( $post->ID, true ) . '" title="' . esc_attr( __( 'Edit this item' ) ) . '">' . __( 'Edit' ) . '</a>';
		        $actions['inline hide-if-no-js'] = '<a href="#" class="editinline" title="' . esc_attr( __( 'Edit this item inline' ) ) . '">' . __( 'Quick&nbsp;Edit' ) . '</a>';
		    }
		    if ( current_user_can( $post_type_object->cap->delete_post, $post->ID ) ) {
		        if ( 'trash' == $post->post_status )
		            $actions['untrash'] = "<a title='" . esc_attr( __( 'Restore this item from the Trash' ) ) . "' href='" . wp_nonce_url( admin_url( sprintf( $post_type_object->_edit_link . '&amp;action=untrash', $post->ID ) ), 'untrash-' . $post->post_type . '_' . $post->ID ) . "'>" . __( 'Restore' ) . "</a>";

		        elseif ( EMPTY_TRASH_DAYS )
		            $actions['trash'] = "<a class='submitdelete' title='" . esc_attr( __( 'Move this item to the Trash' ) ) . "' href='" . get_delete_post_link( $post->ID ) . "'>" . __( 'Trash' ) . "</a>";

		        if ( 'trash' == $post->post_status || !EMPTY_TRASH_DAYS )
		            $actions['delete'] = "<a class='submitdelete' title='" . esc_attr( __( 'Delete this item permanently' ) ) . "' href='" . get_delete_post_link( $post->ID, '', true ) . "'>" . __( 'Delete Permanently' ) . "</a>";
		    }
	        if ( in_array( $post->post_status, array( 'pending', 'draft', 'future' ) ) ) {
	            if ( $can_edit_post )
	                $actions['view'] = '<a href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) . '" title="' . esc_attr( sprintf( __( 'Preview &#8220;%s&#8221;' ), $title ) ) . '" rel="permalink">' . __( 'Preview' ) . '</a>';

	        } elseif ( 'trash' != $post->post_status ) {
	                $actions['view'] = '<a href="' . get_permalink( $post->ID ) . '" title="' . esc_attr( sprintf( __( 'View &#8220;%s&#8221;' ), $title ) ) . '" rel="permalink">' . __( 'View' ) . '</a>';
	        }

	        // spit it out
		    echo WP_List_Table::row_actions( $actions );
			break;
		default :
			break;
	}
}

/*
	Custom Rewrite stuff to allow post ids in permalinks
 */
add_action('init', 'case_rewrite');
function case_rewrite() {
	global $wp_rewrite;
	$queryarg = 'post_type=case&p=';
	$wp_rewrite->add_rewrite_tag('%cpt_id%', '([^/]+)', $queryarg);
	$wp_rewrite->add_permastruct('case', '/case/SME%cpt_id%', false);
}

add_filter('post_type_link', 'case_permalink', 1, 3);
function case_permalink($post_link, $id = 0, $leavename) {
	if(get_post_type() == 'case') {
		global $wp_rewrite;
		$post = &get_post($id);
		if ( is_wp_error( $post ) )
			return $post;
		$newlink = $wp_rewrite->get_extra_permastruct('case');
		$newlink = str_replace("%cpt_id%", $post->ID, $newlink);
		$newlink = home_url(user_trailingslashit($newlink));
		return $newlink;
	} else {
		return $post_link;
	}
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );
/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php
				/*
					this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
					echo get_avatar($comment,$size='32',$default='<path_to_url>' );
				*/
				?>
				<?php // custom gravatar call ?>
				<?php
					// create variable
					$bgauthemail = get_comment_author_email();
				?>
				<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
				<?php // end custom gravatar call ?>
				<?php printf(__( '<cite class="fn">%s</cite>', 'bonestheme' ), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>
				<?php edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
	<?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __( 'Search for:', 'bonestheme' ) . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__( 'Search the Site...', 'bonestheme' ) . '" />
	<input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) .'" />
	</form>';
	return $form;
} // don't remove this bracket!


/************* POST STATUS AJAX  *****************/
add_action('wp_enqueue_scripts', 'updatePostStatusScripts');
add_action("wp_ajax_nopriv_updatePostStatus", "postStatusNoAction");
add_action("wp_ajax_updatePostStatus", "updatePostStatus");

function updatePostStatusScripts() {
	wp_enqueue_script('update-post-status', get_template_directory_uri().'/library/js/update-post-status.js', array('jquery'));
	wp_localize_script('update-post-status', 'PT_Ajax', array(
		'ajaxUrl' 	=> admin_url('admin-ajax.php'),
		'nextNonce' => wp_create_nonce('update_status_nonce'),
	));
}

function updatePostStatus() {
	if (empty($_POST['nextNonce'])
		|| empty($_POST['postId'])
		|| empty($_POST['statusId'])
		|| !wp_verify_nonce($_POST['nextNonce'], 'update_status_nonce')) {
		die;
	}
	$post = get_post($_POST['postId']);
	wp_set_post_terms($_POST['postId'], array($_POST['statusId']), 'status', false);
	die('ok');
}

/*
 * If users are not logged-in, they shouldn't be able to modify the status.
 * The link won't be in the front-end, but someone might try to be clever.
 */
function postStatusNoAction() {
	return;
}

?>