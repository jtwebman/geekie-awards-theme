<?php
/**
 * TheGeekieAwards functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * @package TheGeekieAwards 4.1
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */


include_once( get_template_directory() . '/lib/sponsors.php' ); //This file has all the logic for adding Sponsors Custom Post Type
include_once( get_template_directory() . '/lib/pastsponsors.php' ); //This file has all the logic for adding Sponsors Custom Post Type
include_once( get_template_directory() . '/lib/judges.php' ); //This file has all the logic for adding Judges Custom Post Type
include_once( get_template_directory() . '/lib/judges_widget.php' ); //This file adds the judges sidebar widget
include_once( get_template_directory() . '/lib/presenters.php' ); //This file has all the logic for adding presenters Custom Post Type
include_once( get_template_directory() . '/lib/presenters_widget.php' ); //This file adds the presenters sidebar widget
include_once( get_template_directory() . '/lib/news.php' ); //This file adds news post type
include_once( get_template_directory() . '/lib/newsposttype_widget.php' ); //This file adds the news post type sidebar widget
include_once( get_template_directory() . '/lib/newspost_featured.php' ); //This file adds the news post featured sidebar widget
include_once( get_template_directory() . '/lib/teammembers.php' ); //This file has all the logic for adding team members Custom Post Type
include_once( get_template_directory() . '/lib/teammembers_widget.php' ); //This file adds the team members sidebar widget
include_once( get_template_directory() . '/lib/slideshow.php' ); //This file has all the logic for adding slideshow custom type
include_once( get_template_directory() . '/lib/tickers.php' ); //This file has all the logic for adding slideshow custom type
include_once( get_template_directory() . '/lib/videos.php' ); //This file has all the logic for adding Video Gallery Custom Post Type
include_once( get_template_directory() . '/lib/images.php' ); //This file has all the logic for adding Image Gallery Custom Post Type
include_once( get_template_directory() . '/lib/sponsorbackgroundimages.php' ); //This file has all the logic for adding Sponsor Background Image Custom Post Type
include_once( get_template_directory() . '/lib/sponsorheaderimages.php' ); //This file has all the logic for adding Sponsor Header Image Custom Post Type
include_once( get_template_directory() . '/lib/categorynominees.php' ); //This file has all the logic for adding Category Nominees Custom Post Type
include_once( get_template_directory() . '/lib/categorywinners.php' ); //This file has all the logic for adding Category Winners Custom Post Type
include_once( get_template_directory() . '/lib/post.php' ); //This file adds fields onto the post for nominees
include_once( get_template_directory() . '/lib/industrypages.php' ); //This file has all the logic for adding Industry Pages Custom Post Type
include_once( get_template_directory() . '/lib/categoryhonors.php' ); //This file has all the logic for adding Category Honors Custom Post Type
include_once( get_template_directory() . '/lib/award_categories.php' ); //This file has all the logic for adding Award Category Custom Post Type
include_once( get_template_directory() . '/lib/award_categories_menu_widget.php' );


include_once( get_template_directory() . '/widgets/subpage-list-widget.php' ); //This is the subpage list widget

if ( ! isset( $content_width ) )
	$content_width = 670;


// Auto set image as featured to first iamge to fix Gravity Forms issue
function autoset_featured() {
	global $post;
	if (!empty($post)) {
		$already_has_thumb = has_post_thumbnail($post->ID);
		if (!$already_has_thumb)  {
			$attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );
			if ($attached_image) {
				foreach ($attached_image as $attachment_id => $attachment) {
					set_post_thumbnail($post->ID, $attachment_id);
				}
			}
		}
	}
}  //end function
add_action('the_post', 'autoset_featured');
add_action('save_post', 'autoset_featured');
add_action('draft_to_publish', 'autoset_featured');
add_action('new_to_publish', 'autoset_featured');
add_action('pending_to_publish', 'autoset_featured');
add_action('future_to_publish', 'autoset_featured');


function thegeekieawards_setup() {
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	register_nav_menu( 'primary', __( 'Primary Menu', 'thegeekieawards' ) );
	register_nav_menu( 'home', __( 'Home Sub-Menu', 'thegeekieawards' ) );
	register_nav_menu( 'homevoting', __( 'Home Voting Sub-Menu', 'thegeekieawards' ) );
	register_nav_menu( 'homecategory', __( 'Home Category Sub-Menu', 'thegeekieawards' ) );
	register_nav_menu( 'footer', __( 'Footer Menu', 'thegeekieawards' ) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 320, 180 );

	// Add Sponsor Thumbnail Size
	add_image_size( 'category-thumbnail', 155, 155, true );
	add_image_size( 'sponsor-thumbnail', 244, 150, true );
	add_image_size( 'judge-thumbnail', 235, 235, true );
	add_image_size( 'slide-thumbnail', 200, 66, false );
	add_image_size( 'gallery-thumbnail', 155, 117, false );

	/* Set call JS right before </body> instead */
	$in_footer = true;
}
add_action( 'after_setup_theme', 'thegeekieawards_setup' );

/**
 * Add Styles
 */
function thegeekieawards_add_my_stylesheet() {

	/* Add Google Web Fonts */
	wp_register_style( 'font-carme', 'http://fonts.googleapis.com/css?family=Carme' );
    wp_enqueue_style( 'font-carme' );

	wp_enqueue_style( 'reset', get_template_directory_uri() . '/css/reset.css', array( ), '20130325', 'all' );
	wp_enqueue_style( 'text', get_template_directory_uri() . '/css/text.css', array( 'reset' ), '20130325', 'all' );

	wp_enqueue_style( 'jquery.fancybox', get_template_directory_uri() . '/css/jquery.fancybox.css', array( ), '20130329', 'all' );
	wp_enqueue_style( 'jquery.fancybox-buttons', get_template_directory_uri() . '/css/jquery.fancybox-buttons.css', array( 'jquery.fancybox' ), '20130329', 'all' );
	wp_enqueue_style( 'jquery.fancybox-thumbs', get_template_directory_uri() . '/css/jquery.fancybox-thumbs.css', array( 'jquery.fancybox' ), '20130329', 'all' );

	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css', array(  ), '20130329', 'all' );

	wp_enqueue_style( 'li-scroller', get_template_directory_uri() . '/css/li-scroller.css', array(  ), '20130329', 'all' );

	wp_enqueue_style( 'thegeekieawards-styles', get_stylesheet_uri() , array( 'reset', 'text' ), '20130325', 'all');
}
add_action( 'wp_enqueue_scripts', 'thegeekieawards_add_my_stylesheet' );

function load_custom_wp_admin_style_scripts() {
    wp_enqueue_style( 'custom.admin.styles' , get_template_directory_uri() . '/css/custom.admin.styles.css', array( ), '20130329', 'all' );

	wp_enqueue_script( 'odpquery', get_template_directory_uri() . '/js/odpquery.js', array( 'jquery' ), '', true );
	wp_localize_script( 'odpquery', 'ajax_scripts', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	wp_enqueue_script( 'videosadmin', get_template_directory_uri() . '/js/videosadmin.js', array( 'odpquery' ), '', true );
	wp_localize_script( 'videosadmin', 'globalinfo', array( 'themeurl' => get_template_directory_uri() ) );

	wp_enqueue_script( 'movepastsponsor', get_template_directory_uri() . '/js/movepastsponsor.js', array( 'jquery' ), '', true );

	wp_enqueue_style( 'videoadmin-styles', get_template_directory_uri() . '/css/videoadmin.css', array( ), '20130325', 'all');

	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style_scripts' );


/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 */
function thegeekieawards_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'thegeekieawards' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'thegeekieawards_wp_title', 10, 2 );

/**
 * Registers our main widget area and the front page widget areas.
 */
function thegeekieawards_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'thegeekieawards' ),
		'id' => 'main-sidebar',
		'description' => __( 'Appears on posts and pages except the optional Home Page template, which has its own widgets', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'Home Page Sidebar', 'thegeekieawards' ),
		'id' => 'home-sidebar',
		'description' => __( 'Appears when using the optional Home Page template.', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	register_sidebar( array(
		'name' => __( 'Ticket Page Sidebar', 'thegeekieawards' ),
		'id' => 'ticket-sidebar',
		'description' => __( 'Appears when using the optional Ticket Page template.', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'Event Page Sidebar', 'thegeekieawards' ),
		'id' => 'event-sidebar',
		'description' => __( 'Appears when using the optional Event Page template.', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'Judge Page Sidebar', 'thegeekieawards' ),
		'id' => 'judge-sidebar',
		'description' => __( 'Appears when using the judge single template.', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'Presenter Page Sidebar', 'thegeekieawards' ),
		'id' => 'presenter-sidebar',
		'description' => __( 'Appears when using the presenter single template.', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'Team Member Page Sidebar', 'thegeekieawards' ),
		'id' => 'teammember-sidebar',
		'description' => __( 'Appears when using the team member single template.', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'Geekie Works Sidebar', 'thegeekieawards' ),
		'id' => 'geekie-sidebar',
		'description' => __( 'Appears with all things dealing with blog posts.', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'News Sidebar', 'thegeekieawards' ),
		'id' => 'news-sidebar',
		'description' => __( 'Appears with all things dealing with news posts.', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'Enter Work Sidebar', 'thegeekieawards' ),
		'id' => 'enterwork-sidebar',
		'description' => __( 'Right side for Enter Your Work Pages.', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'Home All Widgets Left ', 'thegeekieawards' ),
		'id' => 'home-left-sidebar',
		'description' => __( 'All widgets for the left side of the home page.', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'Home All Widgets Right ', 'thegeekieawards' ),
		'id' => 'home-right-sidebar',
		'description' => __( 'All widgets for the right side of the home page.', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'Category 2013 Sidebar', 'thegeekieawards' ),
		'id' => 'category2013-sidebar',
		'description' => __( 'All widgets for the right side of the 2013 category pages', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'Category 2014 Sidebar', 'thegeekieawards' ),
		'id' => 'category2014-sidebar',
		'description' => __( 'All widgets for the right side of the 2014 category pages', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'Quick Facts Sidebar', 'thegeekieawards' ),
		'id' => 'quickfacts-sidebar',
		'description' => __( 'Right side for Quick Facts Pages', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_all_sidebars();
	register_all_industrypages_sidebars();
	register_all_winner_sidebars();

  register_sidebar( array(
		'name' => __( 'Home Voting Left', 'thegeekieawards' ),
		'id' => 'home-voting-left-sidebar',
		'description' => __( 'All widgets for the left side of the home page.', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	) );

	register_sidebar( array(
		'name' => __( 'Awards Category Sidebar', 'thegeekieawards' ),
		'id' => 'awards-category-sidebar',
		'description' => __( 'Displayed o nthe right of all awards category pages', 'thegeekieawards' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><hr />',
	));

}
add_action( 'widgets_init', 'thegeekieawards_widgets_init' );

function tag_2014_init() {

	register_taxonomy(
		'2014_tags',
		'post',
		array(
			'label' => __( '2014 Tags' , 'thegeekieawards' ),
			'labels' => array(
				'name' => __( '2014 Tags' , 'thegeekieawards' ),
				'singular_name' => __( '2014 Tag' , 'thegeekieawards' ),
				'menu_name' => __( '2014 Tags' , 'thegeekieawards' ),
				'all_items'  => __( 'Add New 2014 Tag' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit 2014 Tag' , 'thegeekieawards' ),
				'view_item' => __( 'View 2014 Tag' , 'thegeekieawards' ),
				'update_item'  => __( 'Update 2014 Tag' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New 2014 Tag' , 'thegeekieawards' ),
			),
			'show_tagcloud' => true,
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'hierarchical' => false,
			'query_var' => true,
			'rewrite' => array('slug' => '2014tags' , 'with_front' => false, 'hierarchical' => true ),
		)
	);
}
add_action( 'init', 'tag_2014_init' );

function tag_2015_init() {

	register_taxonomy(
		'2015_tags',
		'post',
		array(
			'label' => __( '2015 Tags' , 'thegeekieawards' ),
			'labels' => array(
				'name' => __( '2015 Tags' , 'thegeekieawards' ),
				'singular_name' => __( '2015 Tag' , 'thegeekieawards' ),
				'menu_name' => __( '2015 Tags' , 'thegeekieawards' ),
				'all_items'  => __( 'Add New 2015 Tag' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit 2015 Tag' , 'thegeekieawards' ),
				'view_item' => __( 'View 2015 Tag' , 'thegeekieawards' ),
				'update_item'  => __( 'Update 2015 Tag' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New 2015 Tag' , 'thegeekieawards' ),
			),
			'show_tagcloud' => true,
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'hierarchical' => false,
			'query_var' => true,
			'rewrite' => array('slug' => '2015tags' , 'with_front' => false, 'hierarchical' => true ),
		)
	);
}
add_action( 'init', 'tag_2015_init' );

if ( ! function_exists( 'thegeekieawards_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own thegeekieawards_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function thegeekieawards_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'thegeekieawards' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'thegeekieawards' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'thegeekieawards' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'thegeekieawards' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'thegeekieawards' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'thegeekieawards' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'thegeekieawards' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'thegeekieawards_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own thegeekieawards_entry_meta() to override in a child theme.
 */
function thegeekieawards_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'thegeekieawards' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'thegeekieawards' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'thegeekieawards' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'thegeekieawards' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'thegeekieawards' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'thegeekieawards' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/**
 * Adjust body class based on theme setup
 */
function thegeekieawards_body_class( $classes ) {
	$background_color = get_background_color();

	// If no side bars set full-width
	if ( is_page_template( 'full-width.php' ) )
		$classes[] = 'full-width';

	return $classes;
}
add_filter( 'body_class', 'thegeekieawards_body_class' );

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 */
function thegeekieawards_content_width() {
	if ( is_attachment() || ! is_active_sidebar( 'main-sidebar' ) || is_page_template( 'full-width.php' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'thegeekieawards_content_width' );

function category_template_redirect() {
  if (is_category() && !is_feed()) {
    if (is_category(get_cat_id('2013 Categories')) || cat_is_ancestor_of(get_cat_id('2013 Categories'), get_query_var('cat'))) {
      load_template(TEMPLATEPATH . '/category-2013.php');
      exit;
    }
		if (is_category(get_cat_id('2014 Categories')) || cat_is_ancestor_of(get_cat_id('2014 Categories'), get_query_var('cat'))) {
      load_template(TEMPLATEPATH . '/category-2014.php');
      exit;
    }
  }
	if (is_single()) {
		$category = get_the_category();

		$category2013 = get_cat_id('2013 Categories');
		if (cat_is_ancestor_of($category2013, $category[0]->cat_ID)) {
      load_template(TEMPLATEPATH . '/single-2013.php');
      exit;
    }

		$category2014 = get_cat_id('2014 Categories');
		if (cat_is_ancestor_of($category2014, $category[0]->cat_ID)) {
      load_template(TEMPLATEPATH . '/single-2014.php');
      exit;
    }
	}
}

add_action('template_redirect', 'category_template_redirect');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function thegeekieawards_customize_preview_js() {
	wp_enqueue_script( 'thegeekieawards-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'thegeekieawards_customize_preview_js' );

/**
 * Add all standard js files
 */
function thegeekieawards_js() {
	/* Make sure IE backwards compatible */
	wp_enqueue_script( 'css3-mediaqueries', get_template_directory_uri() . '/js/css3-mediaqueries.js', array( ), '', true );
	/*wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5shiv.js', array( ), '', true ); Add in header instead for the condition of IE < 9 */

	/* Add SuperFish Menu System */
	wp_enqueue_script( 'jquery-columnizer', get_template_directory_uri() . '/js/jquery.columnizer.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'hoverintent', get_template_directory_uri() . '/js/hoverIntent.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery', 'hoverintent' ), '', true );
	wp_enqueue_script( 'mainmenu', get_template_directory_uri() . '/js/mainmenu.js', array( 'jquery', 'hoverintent', 'superfish' ), '', true );

	wp_enqueue_script( 'jquery.fancybox.pack', get_template_directory_uri() . '/js/jquery.fancybox.pack.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'jquery.fancybox-buttons', get_template_directory_uri() . '/js/jquery.fancybox-buttons.js', array( 'jquery' , 'jquery.fancybox.pack' ), '', true );
	wp_enqueue_script( 'jquery.fancybox-media', get_template_directory_uri() . '/js/jquery.fancybox-media.js', array( 'jquery' , 'jquery.fancybox.pack' ), '', true );
	wp_enqueue_script( 'jquery.fancybox-thumbs', get_template_directory_uri() . '/js/jquery.fancybox-thumbs.js', array( 'jquery' , 'jquery.fancybox.pack' ), '', true );
	wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/fancybox.js', array( 'jquery' , 'jquery.fancybox.pack' , 'jquery.fancybox-buttons' , 'jquery.fancybox-media' , 'jquery.fancybox-thumbs' ), '', true );

	wp_enqueue_script( 'jquery.flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/flexslider.js', array( 'jquery.flexslider' ), '', true );
	wp_enqueue_script( 'flexslider.manualDirectionControls', get_template_directory_uri() . '/js/jquery.flexslider.manualDirectionControls.js', array( 'flexslider' ), '', true );

	wp_enqueue_script( 'jquery.li-scroller', get_template_directory_uri() . '/js/jquery.li-scroller.1.0.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'liscroller', get_template_directory_uri() . '/js/li-scroller.js', array( 'jquery', 'jquery.li-scroller' ), '', true );

	wp_enqueue_script( 'odpquery', get_template_directory_uri() . '/js/odpquery.js', array( 'jquery' ), '', true );
	wp_localize_script( 'odpquery', 'ajax_scripts', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	wp_enqueue_script( 'videogallery', get_template_directory_uri() . '/js/videogallery.js', array( 'jquery' ), '', true );
}
add_action ( 'wp_head', 'thegeekieawards_js');

/* Change Expert Length */
function custom_trim_excerpt($text) { // Fakes an excerpt if needed
	global $post;
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$text = strip_tags($text);
		$excerpt_length = 20;
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
			array_push($words, '...');
			$text = implode(' ', $words);
		}
	}
	return $text;
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_trim_excerpt');

/* Fix the tags widget to display as a unordered list */
function custom_tag_cloud_widget($args) {
	$args['format'] = 'list'; //ul with a class of wp-tag-cloud
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'custom_tag_cloud_widget' );


function my_mce_editor_buttons( $buttons ) {

    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'my_mce_editor_buttons' );

function my_change_mce_options( $init ) {
  $init['remove_linebreaks']=false;
  $init['wpautop']=false;

  $init['theme_advanced_disable'] = 'forecolor,underline,spellchecker,wp_help';

  $init['extended_valid_elements'] = 'span[!class]';

  $style_formats = array (
    array(
      'title' => 'Underline',
      'inline' => 'span',
      'classes' => 'underline-text'
    ),
    array(
      'title' => 'Highlight',
      'inline' => 'span',
      'classes' => 'highlight-text'
    ),
    array(
      'title' => 'Pink',
      'inline' => 'span',
      'classes' => 'pink-text'
    ),
    array(
      'title' => 'Red',
      'inline' => 'span',
      'classes' => 'red-text'
    ),
  );

  $init['style_formats'] = json_encode( $style_formats );

  $init['style_formats_merge'] = false;
  return $init;
}
add_filter('tiny_mce_before_init', 'my_change_mce_options');

function thegeekieawards_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );
	if ( $wp_query->max_num_pages > 1 ) : ?>
		<div id="<?php echo $html_id; ?>" class="page-navi" role="navigation">
			<?php
			$big = 999999999; // need an unlikely integer

			echo thegeekieawards_paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '/page/%#%',
				'total' => $wp_query->max_num_pages,
				'current' => max( 1, get_query_var('paged') ),
				'prev_next' => True,
				'prev_text' => __('«'),
				'next_text' => __('»'),
				'type' => 'list'
			));
			?>
		</div><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}

/* Copy of the paginate_links to make a custom version for Geekie Awards */
function thegeekieawards_paginate_links( $args = '' ) {
	$defaults = array(
		'base' => '%_%', // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
		'format' => '?page=%#%', // ?page=%#% : %#% is replaced by the page number
		'total' => 1,
		'current' => 0,
		'show_all' => false,
		'prev_next' => true,
		'prev_text' => __('&laquo; Previous'),
		'next_text' => __('Next &raquo;'),
		'end_size' => 1,
		'mid_size' => 2,
		'type' => 'plain',
		'add_args' => false, // array of query args to add
		'add_fragment' => ''
	);

	$args = wp_parse_args( $args, $defaults );
	extract($args, EXTR_SKIP);

	// Who knows what else people pass in $args
	$total = (int) $total;
	if ( $total < 2 )
		return;
	$current  = (int) $current;
	$end_size = 0  < (int) $end_size ? (int) $end_size : 1; // Out of bounds?  Make it the default.
	$mid_size = 0 <= (int) $mid_size ? (int) $mid_size : 2;
	$add_args = is_array($add_args) ? $add_args : false;
	$r = '';
	$page_links = array();
	$n = 0;
	$dots = false;

	if ( $prev_next && $current && 1 < $current ) :
		$link = str_replace('%_%', 2 == $current ? '' : $format, $base);
		$link = str_replace('%#%', $current - 1, $link);
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );
		$link .= $add_fragment;
		$page_links[] = '<a class="middle-button prev" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '"><span class="middle-right"></span>' . $prev_text . '</a>';
	endif;
	for ( $n = 1; $n <= $total; $n++ ) :
		$n_display = number_format_i18n($n);
		if ( $show_all || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
			$link = str_replace('%_%', 1 == $n ? '' : $format, $base);
			$link = str_replace('%#%', $n, $link);
			if ( $add_args )
				$link = add_query_arg( $add_args, $link );
			$link .= $add_fragment;
			$page_links[] = '<a class="middle-button" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '"><span class="middle-right"></span>' . $n_display . '</a>';
			$dots = true;
		elseif ( $dots && !$show_all ) :
			$page_links[] = '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>';
			$dots = false;
		endif;
	endfor;
	if ( $prev_next && $current && ( $current < $total || -1 == $total ) ) :
		$link = str_replace('%_%', $format, $base);
		$link = str_replace('%#%', $current + 1, $link);
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );
		$link .= $add_fragment;
		$page_links[] = '<a class="next middle-button" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '"><span class="middle-right"></span>' . $next_text . '</a>';
	endif;
	switch ( $type ) :
		case 'array' :
			return $page_links;
			break;
		case 'list' :
			$r .= "<ul>\n\t<li>";
			$r .= join("</li>\n\t<li>", $page_links);
			$r .= "</li>\n</ul>\n";
			break;
		default :
			$r = join("\n", $page_links);
			break;
	endswitch;
	return $r;
}

function get_excerpt_from_content_by_char_length($content, $length) {
	$the_excerpt = strip_tags(strip_shortcodes($content));
	if (strlen($the_excerpt) <= $length) return $the_excerpt;
	else return substr($the_excerpt, 0, $length) . '...';
}

/* Functiosn to handle the Open Data Protocol requests to external page */
function open_data_protocol_request_callback() {
	$url = $_GET['url'];

	header( 'Content-type: application/json' );

	$html = file_get_contents_curl($url);

	$doc = new DOMDocument();
	@$doc->loadHTML($html);

	$metas = $doc->getElementsByTagName('meta');

	$title = "";
	$imageurl = "";
	$desc = "";
	$width = 0;
	$height = 0;
	$embedurl = '';

	for ($i = 0; $i < $metas->length; $i++)
	{
		$meta = $metas->item($i);
		if($meta->getAttribute('property') == 'og:title')
			$title = $meta->getAttribute('content');
		if($meta->getAttribute('property') == 'og:image')
			$imageurl = $meta->getAttribute('content');
		if($meta->getAttribute('property') == 'og:description')
			$desc = $meta->getAttribute('content');
		if($meta->getAttribute('property') == 'og:video:width')
			$width = intval( $meta->getAttribute('content') );
		if($meta->getAttribute('property') == 'og:video:height')
			$height = intval( $meta->getAttribute('content') );
		if($meta->getAttribute('name') == 'twitter:player')
			$embedurl = $meta->getAttribute('content');
	}

	echo sprintf('{"title": %s, "desc": %s, "imageurl": %s, "width": %d, "height": %d, "embedurl": %s}',
				json_encode($title), json_encode($desc), json_encode($imageurl), $width, $height, json_encode($embedurl));

	die();
}
add_action('wp_ajax_nopriv_open_data_protocol_request', 'open_data_protocol_request_callback');
add_action('wp_ajax_open_data_protocol_request', 'open_data_protocol_request_callback');

function get_video_gallery_callback() {
	$postid = $_GET['postid'];

	header( 'Content-type: application/json' );

	echo json_encode(get_post_meta($postid, 'videogallery_videos', true));
	die();
}
add_action('wp_ajax_nopriv_get_video_gallery', 'get_video_gallery_callback');
add_action('wp_ajax_get_video_gallery', 'get_video_gallery_callback');

function file_get_contents_curl($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.1; Windows XP)'); //Fake like IE 6.0

    $data = curl_exec($ch);
    if (empty( $data ))
    {
    	$data = '{ "Url" : "' . json_encode($url) . '", "Error " : "' . json_encode(curl_error($ch)) . '"}';
    }
    curl_close($ch);

    return $data;

}

function add_rel_to_gallery($markup, $id, $size, $permalink, $icon, $text) {
	return str_replace('href=', 'rel="fancybox" href=', $markup);
}
add_filter('wp_get_attachment_link', 'add_rel_to_gallery', 10, 6);

/* Sets the Gravity Form Tags to 2014 tags and also sets meta data to post for the current year */
function set_gform_post_submission($entry, $form){
	$post_id = $entry["post_id"];
	add_post_meta($post_id, 'submit_year', date("Y"), true);

	$tags = wp_get_post_tags($post_id,  array( 'fields' => 'names' ) );

	wp_set_object_terms($post_id, $tags, '2015_tags', true);
	wp_set_object_terms($post_id, '', 'post_tag', false);
}
add_action('gform_post_submission', 'set_gform_post_submission', 10, 2);

function searchfilter($query) {
	if ($query->is_search && !is_admin()) {
		$query->set('post_type','post');
	}
	if ( is_post_type_archive('awards_presenters') && $query->is_main_query() ) {
		$query->set( 'meta_key',  'presenter_featured_orderby' );
		$query->set( 'orderby', 'meta_value_num title' );
		$query->set( 'order', 'asc' );
	}
	return $query;
}
add_filter('pre_get_posts','searchfilter');
