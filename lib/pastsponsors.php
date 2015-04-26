<?php

include_once( get_template_directory() . '/lib/class.TaxonomyOrderby.php' );
$TaxonomyOrderby = new TaxonomyOrderby('awards_pastsponsor_type');
	
function create_past_sponsor_post_types() {
		
	register_post_type( 'awards_past_sponsors',
		array(
			'labels' => array(
				'name' => __( 'Past Sponsors' , 'thegeekieawards' ),
				'singular_name' => __( 'Past Sponsor' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Past Sponsor' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Past Sponsor' , 'thegeekieawards' ),
				'new_item' => __( 'New Past Sponsor' , 'thegeekieawards' ),
				'view_item' => __( 'View Past Sponsor' , 'thegeekieawards' ),
				'search_items' => __( 'Search Past Sponsors' , 'thegeekieawards' ),
				'not_found' => __( 'No past sponsors found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No past sponsors found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Past sponsors that have helped out the show.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'pastsponsors' , 'with_front' => false),
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_past_sponsors_metaboxes'
		)
	);
	
	register_taxonomy( 'awards_past_sponsor_type', 'awards_past_sponsors',  
		array(
			'label' => __( 'Past Sponsor Types' , 'thegeekieawards' ),
			'labels' => array(
				'name' => __( 'Past Sponsor Types' , 'thegeekieawards' ),
				'singular_name' => __( 'Past Sponsor Type' , 'thegeekieawards' ),
				'menu_name' => __( 'Past Sponsor Type' , 'thegeekieawards' ),
				'all_items'  => __( 'Add New Past Sponsor Type' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Past Sponsor Type' , 'thegeekieawards' ),
				'view_item' => __( 'View Past Sponsor Type' , 'thegeekieawards' ),
				'update_item'  => __( 'Update Past Sponsor Type' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Past Sponsor Type' , 'thegeekieawards' ),
			),
			'show_tagcloud' => false,
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'rewrite' => array('slug' => 'past-sponsor-types' , 'with_front' => false),
		)
	);
}
add_action( 'init', 'create_past_sponsor_post_types' );

//Removes the default sponsor type tag meta box from the add / edit sponsor post type.
function my_remove_past_sponsors_meta_boxes() { 
	remove_meta_box('tagsdiv-awards_sponsor_type', 'awards_past_sponsors', 'side'); 
} 
add_action( 'admin_menu', 'my_remove_past_sponsors_meta_boxes' ); 

function add_past_sponsors_metaboxes() {
	add_meta_box('past_sponsor_url_box', __( 'Past Sponsor URL', 'thegeekieawards' ), 'add_past_sponsor_url', 'awards_past_sponsors', 'normal', 'default');
	add_meta_box('past_sponsor_type_box', __( 'Past Sponsor Type', 'thegeekieawards' ), 'add_past_sponsor_type_box', 'awards_past_sponsors', 'normal', 'high');
	add_meta_box('past_sponsor_orderby_box', __( 'Past Sponsor Order', 'thegeekieawards' ), 'add_past_sponsor_orderby_box', 'awards_past_sponsors', 'normal', 'default');
}

function add_past_sponsor_url($post) {

	$url = get_post_meta($post->ID, 'past_sponsor_url', true);

	echo '<input type="text" class="admin-input-full-width" name="past_sponsor_url" maxlength="255" value="' . $url . '" id="past_sponsor_url" autocomplete="off">';
}

function add_past_sponsor_type_box($post) {	
	include_once( get_template_directory() . '/lib/class.TaxonomyOrderby.php' );
	
	$args = array( 'hide_empty' => 0 , 'orderby' => TaxonomyOrderby::ORDERBY_KEY );
	$allterms = get_terms( array ('awards_past_sponsor_type') , $args );
	
	$terms = wp_get_post_terms( $post->ID, 'awards_past_sponsor_type');
	$term_id = 0;
	if ( is_array( $terms ) ) {
		foreach ($terms as $term ) {
			$term_id = $term->term_id;
		}
	}
	
	echo '<select class="admin-input-full-width" name="past_sponsor_type" id="past_sponsor_type">';
	foreach ( $allterms as $term ) {
		$selected = $term->term_id == $term_id ? " selected" : "";
		echo '<option value="' . $term->term_id . '"' . $selected . '>' . $term->name . '</option>'; 
	} 
    echo '</select>';
}

function add_past_sponsor_orderby_box($post) {
	$orderby = get_post_meta($post->ID, 'past_sponsor_orderby', true);
	
	echo '<select name="past_sponsor_orderby" id="past_sponsor_orderby">';
	for ($i = 1;$i < 101;$i++) 
	{ 
		$selected = $orderby == $i ? " selected" : "";
		echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>'; 
	}
		
    echo '</select>';
}

function save_past_sponsor_metadata( $post_id ) {
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
 
	if ( isset( $_POST['past_sponsor_url'] ) ) {
        update_post_meta( $post_id, 'past_sponsor_url', strip_tags( $_POST['past_sponsor_url'] ) );
    }
	if ( isset( $_POST['past_sponsor_orderby'] ) ) {
        update_post_meta( $post_id, 'past_sponsor_orderby', strip_tags( $_POST['past_sponsor_orderby'] ) );
    }
	if ( isset( $_POST['past_sponsor_type'] ) ) {
		wp_set_post_terms( $post_id, array( (int) $_POST['past_sponsor_type'] ), 'awards_past_sponsor_type', false );
    }
}
add_action('save_post', 'save_past_sponsor_metadata');

function awards_past_sponsors_columns($columns) {
	$columns[ 'past_sponsor_type' ] = __( 'Past Sponsor Type', 'thegeekieawards' );
	$columns[ 'past_sponsor_image' ] = __( 'Image', 'thegeekieawards' );
	$columns[ 'past_sponsor_orderby' ] = __( 'Order', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_past_sponsors_columns', 'awards_past_sponsors_columns' );

function past_sponsor_custom_columns($column,$id) {
    switch ($column) {
        case 'past_sponsor_type':
           echo get_the_term_list( $id, 'awards_past_sponsor_type', '', ', ', '' );
           break;
		case 'past_sponsor_image':
           echo the_post_thumbnail( 'sponsor-thumbnail' ); 
           break;
		case 'past_sponsor_orderby':
           echo get_post_meta($id, 'past_sponsor_orderby', true);
           break;
        default:
            break;
    }
}
add_action("manage_posts_custom_column", "past_sponsor_custom_columns",10,2);

function past_sponsor_orderby_filter($orderby, &$query){
    global $wpdb;
    if (get_query_var("post_type") == "awards_past_sponsors" && get_query_var("orderby") == "" ) {	
         return "CAST($wpdb->postmeta.meta_value  AS SIGNED) ASC";
    }
    return $orderby;
 }
add_filter( 'posts_orderby', 'past_sponsor_orderby_filter', 10, 2);

function past_sponsor_join_filter($join){
    global $wpdb;
    if (get_query_var("post_type") == "awards_past_sponsors" && get_query_var("orderby") == "" ) {	
         $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'past_sponsor_orderby'";
    }
    return $join;
 }
add_filter( 'posts_join', 'past_sponsor_join_filter', 10, 1);

function past_sponsors_shordcode($atts) {
	$html = '';
	
	$args = array( 'hide_empty' => 1 , 'orderby' => TaxonomyOrderby::ORDERBY_KEY );
	$allterms = get_terms( array ('awards_past_sponsor_type') , $args );
	
	foreach($allterms as $term) {		
    	$args = array('post_type' => 'awards_past_sponsors',
			'orderby' => 'meta_value_num', 
			'order' => 'asc',
			'meta_key' => 'past_sponsor_orderby', 
			'nopaging' => true,
			'tax_query' => array(
				array(
					'taxonomy' => 'awards_past_sponsor_type',
					'field' => 'slug',
					'terms' => $term->slug,
				),
			),
		 );

     	$loop = new WP_Query($args);
		if($loop->have_posts()) {
			while($loop->have_posts()) : $loop->the_post();				
				$url = get_post_meta( get_the_id(), 'past_sponsor_url', true);
				if ( !is_string($url) ) {
					$url = get_permalink();
				}
				
				$html .=  get_the_post_thumbnail(get_the_id(), 'sponsor-thumbnail', array( 'class' => 'past-sponsor-image' ));
			endwhile;
		}
		$html .=  '<p>&nbsp;</p>';
	}
	wp_reset_postdata();
	return $html;
}
add_shortcode( 'past_sponsors' , 'past_sponsors_shordcode' );

function past_sponsors_carousel_ui() {
	$has_one = false;
	$html = '<div class="bottom-main-content homepage"><h1>2013 Sponsors</h1><div id="sponsorcarousel" class="flexslider">';
	$html .= '<a class="previous" href="#"><img src="' . get_template_directory_uri() . '/images/nav_left.png" alt="previous" width="64" height="64" /></a>';
    $html .= '<a class="next" href="#"><img src="' . get_template_directory_uri() . '/images/nav_right.png" alt="next" width="64" height="64" /></a>';
	$html .= '<ul class="slides">';

	$args = array( 'hide_empty' => 1 , 'orderby' => TaxonomyOrderby::ORDERBY_KEY );
	$allterms = get_terms( array ('awards_past_sponsor_type') , $args );
	
	foreach($allterms as $term) {
		if (strcasecmp($term->name, 'Geekie Friends') != 0) {	
			$args = array('post_type' => 'awards_past_sponsors',
				'orderby' => 'meta_value_num', 
				'order' => 'asc',
				'meta_key' => 'past_sponsor_orderby', 
				'nopaging' => true,
				'tax_query' => array(
					array(
						'taxonomy' => 'awards_past_sponsor_type',
						'field' => 'slug',
						'terms' => $term->slug,
					),
				),
			 );
	
			$loop = new WP_Query($args);
			if($loop->have_posts()) {
				while($loop->have_posts()) : $loop->the_post();				
					$url = get_post_meta( get_the_id(), 'past_sponsor_url', true);
					if ( !is_string($url) ) {
						$url = get_permalink();
					}
					$has_one = true;
					$feat_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
					$html .=  '<li><img alt="' . $post->post_title . '" src="' . $feat_image . '" width="163" height="100" /></li>';
				endwhile;
			}
		}
	}
	wp_reset_postdata();
	
	$html .= '</ul></div></div>';
	
	if ($has_one) 
		return $html;
	else 
		return 'Nothing found';
}

?>