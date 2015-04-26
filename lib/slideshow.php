<?php

function create_slideshow_post_types() {
		
	register_post_type( 'awards_slideshow',
		array(
			'labels' => array(
				'name' => __( 'Slideshow' , 'thegeekieawards' ),
				'singular_name' => __( 'Slide' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Slide' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Slide' , 'thegeekieawards' ),
				'new_item' => __( 'New Slide' , 'thegeekieawards' ),
				'view_item' => __( 'View Slide' , 'thegeekieawards' ),
				'search_items' => __( 'Search Slides' , 'thegeekieawards' ),
				'not_found' => __( 'No slides found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No slides found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Slides for the awards show.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'slides' , 'with_front' => false),
			'supports' => array( 'title', 'thumbnail' ),
			'hierarchical' => false,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_slideshow_metaboxes'
		)
	);

}
add_action( 'init', 'create_slideshow_post_types' );

function add_slideshow_metaboxes() {
	add_meta_box('slideshow_url_box', __( 'Slide URL', 'thegeekieawards' ), 'add_slideshow_url', 'awards_slideshow', 'normal', 'default');
	add_meta_box('slideshow_orderby_box', __( 'Slide Order', 'thegeekieawards' ), 'add_slideshow_orderby_box', 'awards_slideshow', 'normal', 'default');
}

function remove_slide_image_box() {
	remove_meta_box( 'postimagediv', 'awards_slideshow', 'side' );
	add_meta_box('postimagediv', __('Slide Image'), 'post_thumbnail_meta_box', 'awards_slideshow', 'normal', 'default');
}
//add_action('do_meta_boxes', 'remove_slide_image_box');

function add_slideshow_url($post) {

	$url = get_post_meta($post->ID, 'slide_url', true);

	echo '<input type="text" class="admin-input-full-width" name="slide_url" maxlength="255" value="' . $url . '" id="slide_url" autocomplete="off">';
}

function add_slideshow_orderby_box($post) {
	$orderby = get_post_meta($post->ID, 'slide_orderby', true);
	
	echo '<select name="slide_orderby" id="slide_orderby">';
	for ($i = 1;$i < 101;$i++) 
	{ 
		$selected = $orderby == $i ? " selected" : "";
		echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>'; 
	}
		
    echo '</select>';
}

function save_slide_metadata( $post_id ) {
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
 
 	if ( isset( $_POST['slide_url'] ) ) {
        update_post_meta( $post_id, 'slide_url', strip_tags( $_POST['slide_url'] ) );
    }
	
	if ( isset( $_POST['slide_orderby'] ) ) {
        update_post_meta( $post_id, 'slide_orderby', strip_tags( $_POST['slide_orderby'] ) );
    }
}
add_action('save_post', 'save_slide_metadata');

function slide_orderby_filter($orderby, &$query){
    global $wpdb;
    if (get_query_var("post_type") == "awards_slideshow" && get_query_var("orderby") == "" ) {	
         return "CAST($wpdb->postmeta.meta_value  AS SIGNED) ASC";
    }
    return $orderby;
 }
add_filter( 'posts_orderby', 'slide_orderby_filter', 10, 2);

function slide_join_filter($join){
    global $wpdb, $wp_query;
    if (get_query_var("post_type") == "awards_slideshow" && get_query_var("orderby") == "" ) {	
         $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'slide_orderby'";
    }
    return $join;
 }
add_filter( 'posts_join', 'slide_join_filter', 10, 1);

function awards_slideshow_columns($columns) {
	$columns[ 'slide_image' ] = __( 'Image', 'thegeekieawards' );
	$columns[ 'slide_orderby' ] = __( 'Order By', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_slideshow_columns', 'awards_slideshow_columns' );

function slideshow_custom_columns($column,$id) {
    switch ($column) {
        case 'slide_image':
           echo the_post_thumbnail( 'slide-thumbnail' ); 
           break;
		case 'slide_orderby':
           echo get_post_meta($id, 'slide_orderby', true);
           break;
        default:
            break;
    }
}
add_action("manage_posts_custom_column", "slideshow_custom_columns",10,2);

function slideshow_ui() {
	$html = '<div class="slideshowcontainer"><div id="slideshowslider"class="flexslider">';
	$html .= '<a class="previous" href="#"><img src="' . get_template_directory_uri() . '/images/nav_left.png" alt="previous" width="64" height="64" /></a>';
    $html .= '<a class="next" href="#"><img src="' . get_template_directory_uri() . '/images/nav_right.png" alt="next" width="64" height="64" /></a>';
	$html .= '<ul class="slides">';

	$args = array('post_type' => 'awards_slideshow',
		'meta_key' => 'slide_orderby',
		'orderby' => 'meta_value_num',
        'order' => 'ASC',
		'posts_per_page' => -1
	 );

	$myposts = get_posts($args);
	$has_one = false;
	
	foreach( $myposts as $post ) : 
		$has_one = true;
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
		$slide_url = get_post_meta( $post->ID, 'slide_url', true);
		$html .=  '<li><a href="' . $slide_url . '"><img alt="' . $post->post_title . '" src="' . $feat_image . '" width="960" height="302" /></a></li>';
	endforeach;
	
	$html .= '</ul></div></div>';
	
	if ($has_one) 
		return $html;
	else 
		return '';
}

?>