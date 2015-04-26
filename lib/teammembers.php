<?php

function create_teammember_post_types() {
		
	register_post_type( 'awards_teammembers',
		array(
			'labels' => array(
				'name' => __( 'Team Members' , 'thegeekieawards' ),
				'singular_name' => __( 'Team Member' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Team Member' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Team Member' , 'thegeekieawards' ),
				'new_item' => __( 'New Team Member' , 'thegeekieawards' ),
				'view_item' => __( 'View Team Member' , 'thegeekieawards' ),
				'search_items' => __( 'Search Team Members' , 'thegeekieawards' ),
				'not_found' => __( 'No team members found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No team member found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Team Members for the awards show.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'team' , 'with_front' => false),
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_teammembers_metaboxes'
		)
	);

}
add_action( 'init', 'create_teammember_post_types' );

function add_teammembers_metaboxes() {
	add_meta_box('teammember_title_box', __( 'Team Member Title', 'thegeekieawards' ), 'add_teammember_title', 'awards_teammembers', 'normal', 'default');
	add_meta_box('teammember_credit_box', __( 'Team Member Credit', 'thegeekieawards' ), 'add_teammember_credit', 'awards_teammembers', 'normal', 'default');
	add_meta_box('teammember_orderby_box', __( 'Team Member Order', 'thegeekieawards' ), 'add_teammember_orderby_box', 'awards_teammembers', 'normal', 'default');
}

function add_teammember_title($post) {

	$title = get_post_meta($post->ID, 'teammember_title', true);

	echo '<input type="text" class="admin-input-full-width" name="teammember_title" maxlength="100" value="' . $title . '" id="teammember_title" autocomplete="off">';
}

function add_teammember_credit($post) {

	$credit = get_post_meta($post->ID, 'teammember_credit', true);

	echo '<textarea cols="80" rows="5" class="admin-input-full-width" name="teammember_credit" id="teammember_credit" autocomplete="off">' . $credit . '</textarea>';
}

function add_teammember_orderby_box($post) {
	$orderby = get_post_meta($post->ID, 'teammember_orderby', true);
	
	echo '<select name="teammember_orderby" id="teammember_orderby">';
	for ($i = 1;$i < 101;$i++) 
	{ 
		$selected = $orderby == $i ? " selected" : "";
		echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>'; 
	}
		
    echo '</select>';
}

function save_teammember_metadata( $post_id ) {
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
 
 	if ( isset( $_POST['teammember_title'] ) ) {
        update_post_meta( $post_id, 'teammember_title', strip_tags( $_POST['teammember_title'] ) );
    }
 
	if ( isset( $_POST['teammember_credit'] ) ) {
        update_post_meta( $post_id, 'teammember_credit', strip_tags( $_POST['teammember_credit'] ) );
    }
	
	if ( isset( $_POST['teammember_orderby'] ) ) {
        update_post_meta( $post_id, 'teammember_orderby', strip_tags( $_POST['teammember_orderby'] ) );
    }
}
add_action('save_post', 'save_teammember_metadata');

function teammember_orderby_filter($orderby, &$query){
    global $wpdb;
    if (get_query_var("post_type") == "awards_teammembers" && get_query_var("orderby") == "" ) {	
         return "CAST($wpdb->postmeta.meta_value  AS SIGNED) ASC";
    }
    return $orderby;
 }
add_filter( 'posts_orderby', 'teammember_orderby_filter', 10, 2);

function teammember_join_filter($join){
    global $wpdb, $wp_query;
    if (get_query_var("post_type") == "awards_teammembers" && get_query_var("orderby") == "" ) {	
         $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'teammember_orderby'";
    }
    return $join;
 }
add_filter( 'posts_join', 'teammember_join_filter', 10, 1);

function teammembers_shordcode($atts) {
	global $post;
	extract(shortcode_atts(array(
		'class' => 'teammember',
		'size' => '150',
		'showname' => 'true',
		'imageonly' => 'true',
	), $atts));
	
	$html = '';

	$args = array('post_type' => 'awards_teammembers',
		'meta_key' => 'teammember_orderby',
		'orderby' => 'meta_value_num',
        'order' => 'ASC',
		'posts_per_page' => -1
	 );

	$myposts = get_posts($args);
	foreach( $myposts as $post ) : setup_postdata($post);
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_id() ) );
		if ( $showname == 'true' ) {
			$html .=  '<div class="' . $class . '"><a href="' . get_permalink() . '"><img alt="' . get_the_title() . '" src="' . $feat_image . '" width="' . $size . '" height="' . $size . '" /><span>' . get_the_title() . ' Full Bio</span></a>';
		} else {
			$html .=  '<div class="' . $class . '"><a href="' . get_permalink() . '"><img alt="' . get_the_title() . '" src="' . $feat_image . '" width="' . $size . '" height="' . $size . '" /></a>';
		}
		if($imageonly == 'false') {
			$html .= '<h4>' . get_the_title() . '</h4>';
			$title = get_post_meta( get_the_id(), 'teammember_title', true);
			$html .= '<h5>' . $title . '</h4>';
			$credit = get_post_meta( get_the_id(), 'teammember_credit', true);
			$html .= '<div class="teammember-credit">' . $credit . '</div>';
		}
		$html .= '</div>';
	endforeach;
	return $html;
}
add_shortcode( 'team' , 'teammembers_shordcode' );

function awards_teammembers_columns($columns) {
	$columns[ 'teammember_image' ] = __( 'Image', 'thegeekieawards' );
	$columns[ 'teammember_orderby' ] = __( 'Order By', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_teammembers_columns', 'awards_teammembers_columns' );

function teammembers_custom_columns($column,$id) {
    switch ($column) {
        case 'teammember_image':
           echo the_post_thumbnail( 'thumbnail' ); 
           break;
		case 'teammember_orderby':
           echo get_post_meta($id, 'teammember_orderby', true);
           break;
        default:
            break;
    }
}
add_action("manage_posts_custom_column", "teammembers_custom_columns",10,2);

?>