<?php

function create_news_post_types() {
		
	register_post_type( 'awards_news',
		array(
			'labels' => array(
				'name' => __( 'News Posts' , 'thegeekieawards' ),
				'singular_name' => __( 'News Post' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New News Post' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit News Post' , 'thegeekieawards' ),
				'new_item' => __( 'New News Post' , 'thegeekieawards' ),
				'view_item' => __( 'View News Post' , 'thegeekieawards' ),
				'search_items' => __( 'Search News Posts' , 'thegeekieawards' ),
				'not_found' => __( 'No news posts found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No news posts found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'News posts for the site.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'news' , 'with_front' => false),
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_news_metaboxes'
		)
	);
	
	register_taxonomy( 'awards_news_type', 'awards_news',  
		array(
			'label' => __( 'News Post Categories' , 'thegeekieawards' ),
			'labels' => array(
				'name' => __( 'News Post Categories' , 'thegeekieawards' ),
				'singular_name' => __( 'News Post Category' , 'thegeekieawards' ),
				'menu_name' => __( 'News Post Categories' , 'thegeekieawards' ),
				'all_items'  => __( 'Add New News Post Category' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit News Post Category' , 'thegeekieawards' ),
				'view_item' => __( 'View News Post Category' , 'thegeekieawards' ),
				'update_item'  => __( 'Update News Post Category' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New News Post Category' , 'thegeekieawards' ),
			),
			'show_tagcloud' => true,
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'hierarchical' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'news-categories' , 'with_front' => false, 'hierarchical' => true ),
		)
	);
}
add_action( 'init', 'create_news_post_types' );

function add_news_metaboxes() {
	add_meta_box('add_news_video', __( 'News Video URL', 'thegeekieawards' ), 'add_news_video', 'awards_news', 'normal', 'default');
	add_meta_box('add_news_mp3', __( 'News MP3 URL', 'thegeekieawards' ), 'add_news_mp3', 'awards_news', 'normal', 'default');
	add_meta_box('add_news_featured', __( 'Featured News Post', 'thegeekieawards' ), 'add_news_featured', 'awards_news', 'normal', 'default');
}

function add_news_featured($post) {

	$featured = get_post_meta($post->ID, 'news_featured', true);

	if ($featured)
		echo '<input type="checkbox" class="admin-input-full-width" name="news_featured" id="news_featured" checked="checked">';
	else
		echo '<input type="checkbox" class="admin-input-full-width" name="news_featured" id="news_featured" >';
}

function add_news_video($post) {

	$url = get_post_meta($post->ID, 'video', true);
	$nonce = wp_create_nonce( 'awards_news_post' );

	echo '<input type="text" class="admin-input-full-width" name="video" maxlength="255" value="' . $url . '" id="video" autocomplete="off">';
	echo '<input type="hidden" name="post_nonce" maxlength="255" value="' . $nonce . '" id="post_nonce">';
}

function add_news_mp3($post) {

	$url = get_post_meta($post->ID, 'mp3', true);

	echo '<input type="text" class="admin-input-full-width" name="mp3" maxlength="255" value="' . $url . '" id="mp3" autocomplete="off">';
}

function save_news_metadata( $post_id ) {
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	//if ( isset( $_POST['post_nonce'] ) ) return;
	//if ( !wp_verify_nonce( $_POST['post_nonce'], 'awards_news_post' )) return;
 
	if ( isset( $_POST['video'] ) ) {
        update_post_meta( $post_id, 'video', strip_tags( $_POST['video'] ) );
    }
	if ( isset( $_POST['mp3'] ) ) {
        update_post_meta( $post_id, 'mp3', strip_tags( $_POST['mp3'] ) );
    }
	if ( isset( $_POST['news_featured'] ) ) {
		update_post_meta( $post_id, 'news_featured', true);
    } else {
		update_post_meta( $post_id, 'news_featured', false);	
	}
}
add_action('save_post', 'save_news_metadata');

function awards_news_columns($columns) {
	$columns[ 'news_post_type' ] = __( 'News Post Type', 'thegeekieawards' );
	$columns[ 'news_image' ] = __( 'Image', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_news_columns', 'awards_news_columns' );

function news_custom_columns($column,$id) {
    switch ($column) {
        case 'news_post_type':
           echo get_the_term_list( $id, 'awards_news_type', '', ', ', '' );
           break;
		case 'news_image':
           echo the_post_thumbnail( 'thumbnail' ); 
           break;
        default:
            break;
    }
}
add_action( 'manage_posts_custom_column' , 'news_custom_columns' , 10 , 2 );

?>