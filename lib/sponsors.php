<?php

include_once( get_template_directory() . '/lib/class.TaxonomyOrderby.php' );
$TaxonomyOrderby = new TaxonomyOrderby('awards_sponsor_type');

function create_sponsor_post_types() {

	register_post_type( 'awards_sponsors',
		array(
			'labels' => array(
				'name' => __( 'Sponsors' , 'thegeekieawards' ),
				'singular_name' => __( 'Sponsor' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Sponsor' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Sponsor' , 'thegeekieawards' ),
				'new_item' => __( 'New Sponsor' , 'thegeekieawards' ),
				'view_item' => __( 'View Sponsor' , 'thegeekieawards' ),
				'search_items' => __( 'Search Sponsors' , 'thegeekieawards' ),
				'not_found' => __( 'No sponsors found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No sponsors found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Sponsors that have help out the site.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'sponsors' , 'with_front' => false),
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_sponsors_metaboxes'
		)
	);

	register_taxonomy( 'awards_sponsor_type', 'awards_sponsors',
		array(
			'label' => __( 'Sponsor Types' , 'thegeekieawards' ),
			'labels' => array(
				'name' => __( 'Sponsor Types' , 'thegeekieawards' ),
				'singular_name' => __( 'Sponsor Type' , 'thegeekieawards' ),
				'menu_name' => __( 'Sponsor Type' , 'thegeekieawards' ),
				'all_items'  => __( 'Add New Sponsor Type' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Sponsor Type' , 'thegeekieawards' ),
				'view_item' => __( 'View Sponsor Type' , 'thegeekieawards' ),
				'update_item'  => __( 'Update Sponsor Type' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Sponsor Type' , 'thegeekieawards' ),
			),
			'show_tagcloud' => false,
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'rewrite' => array('slug' => 'sponsor-types' , 'with_front' => false),
		)
	);
}
add_action( 'init', 'create_sponsor_post_types' );

//Removes the default sponsor type tag meta box from the add / edit sponsor post type.
function my_remove_meta_boxes() {
	remove_meta_box('tagsdiv-awards_sponsor_type', 'awards_sponsors', 'side');
}
add_action( 'admin_menu', 'my_remove_meta_boxes' );

function add_sponsors_metaboxes() {
	add_meta_box('sponsor_url_box', __( 'Sponsor URL', 'thegeekieawards' ), 'add_sponsor_url', 'awards_sponsors', 'normal', 'default');
	add_meta_box('sponsor_type_box', __( 'Sponsor Type', 'thegeekieawards' ), 'add_sponsor_type_box', 'awards_sponsors', 'normal', 'high');
	add_meta_box('sponsor_orderby_box', __( 'Sponsor Order', 'thegeekieawards' ), 'add_sponsor_orderby_box', 'awards_sponsors', 'normal', 'default');
}

function add_sponsor_url($post) {

	$url = get_post_meta($post->ID, '_sponsor_url', true);

	echo '<input type="text" class="admin-input-full-width" name="sponsor_url" maxlength="255" value="' . $url . '" id="sponsor_url" autocomplete="off">';
}

function add_sponsor_type_box($post) {
	include_once( get_template_directory() . '/lib/class.TaxonomyOrderby.php' );

	$args = array( 'hide_empty' => 0 , 'orderby' => TaxonomyOrderby::ORDERBY_KEY );
	$allterms = get_terms( array ('awards_sponsor_type') , $args );

	$terms = wp_get_post_terms( $post->ID, 'awards_sponsor_type');
	$term_id = 0;
	if ( is_array( $terms ) ) {
		foreach ($terms as $term ) {
			$term_id = $term->term_id;
		}
	}

	echo '<select class="admin-input-full-width" name="sponsor_type" id="sponsor_type">';
	foreach ( $allterms as $term ) {
		$selected = $term->term_id == $term_id ? " selected" : "";
		echo '<option value="' . $term->term_id . '"' . $selected . '>' . $term->name . '</option>';
	}
    echo '</select>';
}

function add_sponsor_orderby_box($post) {
	$orderby = get_post_meta($post->ID, '_sponsor_orderby', true);

	echo '<select name="sponsor_orderby" id="sponsor_orderby">';
	for ($i = 1;$i < 101;$i++)
	{
		$selected = $orderby == $i ? " selected" : "";
		echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
	}

    echo '</select>';
}

function save_sponsor_metadata( $post_id ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	if ( isset( $_POST['sponsor_url'] ) ) {
        update_post_meta( $post_id, '_sponsor_url', strip_tags( $_POST['sponsor_url'] ) );
    }
	if ( isset( $_POST['sponsor_orderby'] ) ) {
        update_post_meta( $post_id, '_sponsor_orderby', strip_tags( $_POST['sponsor_orderby'] ) );
    }
	if ( isset( $_POST['sponsor_type'] ) ) {
		wp_set_post_terms( $post_id, array( (int) $_POST['sponsor_type'] ), 'awards_sponsor_type', false );
    }
}
add_action('save_post', 'save_sponsor_metadata');

function awards_sponsors_columns($columns) {
	$columns[ 'sponsor_type' ] = __( 'Sponsor Type', 'thegeekieawards' );
	$columns[ 'sponsor_image' ] = __( 'Image', 'thegeekieawards' );
	$columns[ 'sponsor_orderby' ] = __( 'Order', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_sponsors_columns', 'awards_sponsors_columns' );

function sponsor_custom_columns($column,$id) {
    switch ($column) {
        case 'sponsor_type':
           echo get_the_term_list( $id, 'awards_sponsor_type', '', ', ', '' );
           break;
		case 'sponsor_image':
           echo the_post_thumbnail( 'sponsor-thumbnail' );
           break;
		case 'sponsor_orderby':
           echo get_post_meta($id, '_sponsor_orderby', true);
           break;
        default:
            break;
    }
}
add_action("manage_posts_custom_column", "sponsor_custom_columns",10,2);

function sponsor_orderby_filter($orderby, &$query){
    global $wpdb;
    if (get_query_var("post_type") == "awards_sponsors" && get_query_var("orderby") == "" ) {
         return "CAST($wpdb->postmeta.meta_value  AS SIGNED) ASC";
    }
    return $orderby;
 }
add_filter( 'posts_orderby', 'sponsor_orderby_filter', 10, 2);

function sponsor_join_filter($join){
    global $wpdb;
    if (get_query_var("post_type") == "awards_sponsors" && get_query_var("orderby") == "" ) {
         $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = '_sponsor_orderby'";
    }
    return $join;
 }
add_filter( 'posts_join', 'sponsor_join_filter', 10, 1);

function sponsors_shordcode($atts) {
	$html = '';

	$args = array( 'hide_empty' => 1 , 'orderby' => TaxonomyOrderby::ORDERBY_KEY );
	$allterms = get_terms( array ('awards_sponsor_type') , $args );

	foreach($allterms as $term) {
		$html .=  '<h4>' . $term->name . '</h4>';
		$html .=  '<p>' . $term->description . '</p>';

    	$args = array('post_type' => 'awards_sponsors',
			'orderby' => 'meta_value_num',
			'order' => 'asc',
			'meta_key' => '_sponsor_orderby',
			'nopaging' => true,
			'tax_query' => array(
				array(
					'taxonomy' => 'awards_sponsor_type',
					'field' => 'slug',
					'terms' => $term->slug,
				),
			),
		 );

     	$loop = new WP_Query($args);
		if($loop->have_posts()) {
			while($loop->have_posts()) : $loop->the_post();
				$url = get_post_meta( get_the_id(), '_sponsor_url', true);
				if ( !is_string($url) ) {
					$url = get_permalink();
				}

				$html .=  '<a href="' . $url . '" target="_blank">' . get_the_post_thumbnail(get_the_id(), 'sponsor-thumbnail', array( 'class' => 'sponsor_image' )) . '</a><div class="sponsor_text"><p>' . get_the_content();
				$html .=  '</p><p><a href="' . $url . '" target="_blank"><strong>' . get_the_title() . '</strong></a></p></div><hr />';
			endwhile;
		}
		$html .=  '<p>&nbsp;</p>';
	}
	wp_reset_postdata();
	return $html;
}
add_shortcode( 'sponsors' , 'sponsors_shordcode' );

function sponsors_carousel_ui() {
	$has_one = false;
	$html = '<div class="bottom-main-content homepage"><h1>2015 Sponsors</h1><div id="sponsorcarousel" class="flexslider">';
	$html .= '<a class="previous" href="#"><img src="' . get_template_directory_uri() . '/images/nav_left.png" alt="previous" width="64" height="64" /></a>';
    $html .= '<a class="next" href="#"><img src="' . get_template_directory_uri() . '/images/nav_right.png" alt="next" width="64" height="64" /></a>';
	$html .= '<ul class="slides">';

	$args = array( 'hide_empty' => 1 , 'orderby' => TaxonomyOrderby::ORDERBY_KEY );
	$allterms = get_terms( array ('awards_sponsor_type') , $args );

	foreach($allterms as $term) {
		if (strcasecmp($term->name, 'Geekie Friends') != 0) {
			$args = array('post_type' => 'awards_sponsors',
				'orderby' => 'meta_value_num',
				'order' => 'asc',
				'meta_key' => '_sponsor_orderby',
				'nopaging' => true,
				'tax_query' => array(
					array(
						'taxonomy' => 'awards_sponsor_type',
						'field' => 'slug',
						'terms' => $term->slug,
					),
				),
			 );

			$loop = new WP_Query($args);
			if($loop->have_posts()) {
				while($loop->have_posts()) : $loop->the_post();
					$url = get_post_meta( get_the_id(), '_sponsor_url', true);
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

function sponsor_action_row($actions, $post){
    //check for your post type
    if ($post->post_type =="awards_sponsors"){
        $actions['Move to Past Sponsor'] = '<a href="#" class="move-to-past-sponsor" data-params=\'{"postid":"' . $post->ID . '"}\'>Move to Past Sponsor</a>';
    }
    return $actions;
}
add_filter('post_row_actions','sponsor_action_row', 10, 2);

function move_to_past_sponsor_callback() {
	$post = get_post(intval( $_POST['postid'] ));
	$new_post = array(
	  'post_type'     => 'awards_past_sponsors',
	  'post_title'    => $post->post_title,
	  'post_content'  => $post->post_content,
	  'post_status'   => 'draft',
	  'post_author'   => $post->post_author
	);
	$new_post_id = wp_insert_post($new_post);
	add_post_meta($new_post_id, 'past_sponsor_url', get_post_meta( $post->ID, '_sponsor_url', true ), true);
	add_post_meta($new_post_id, 'past_sponsor_orderby', get_post_meta( $post->ID, '_sponsor_orderby', true ), true);

	$args = array(
		'post_parent' => $post->ID,
		'post_type'   => 'attachment',
		'numberposts' => 1,
		'post_status' => 'any'
	);
	$attachments = get_children( $args );
	if ( $attachments ) {
		foreach ( $attachments as $attachment ) {
			wp_insert_attachment($attachment, get_attached_file( $attachment->ID ), $new_post_id);
			set_post_thumbnail($new_post_id, $attachment->ID );
		}
	}
	$args = array( 'hide_empty' => 0 , 'orderby' => TaxonomyOrderby::ORDERBY_KEY );
	$allterms = get_terms( array ('awards_past_sponsor_type') , $args );
	wp_set_post_terms( $new_post_id, array( (int) $allterms[0]->term_id ), 'awards_past_sponsor_type', false);

	wp_delete_post($post->ID, true);
	die( admin_url() . 'post.php?post=' . $new_post_id . '&action=edit');
}
add_action('wp_ajax_move_to_past_sponsor', 'move_to_past_sponsor_callback');

?>
