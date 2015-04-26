<?php

function create_sponhdimg_post_types() {
		
	register_post_type( 'awards_sponhdimgs',
		array(
			'labels' => array(
				'name' => __( 'Sponsor HD Image' , 'thegeekieawards' ),
				'singular_name' => __( 'Sponsor Header Image' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Sponsor Header Image' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Sponsor Header Image' , 'thegeekieawards' ),
				'new_item' => __( 'New Sponsor Header Image' , 'thegeekieawards' ),
				'view_item' => __( 'View Sponsor Header Image' , 'thegeekieawards' ),
				'search_items' => __( 'Search Sponsor Header Images' , 'thegeekieawards' ),
				'not_found' => __( 'No sponsor header images found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No sponsor header images found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Sponsor header images used on sponsor pages.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'sponhdimgs' , 'with_front' => false),
			'supports' => array( 'title', 'thumbnail' ),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true
		)
	);

}
add_action( 'init', 'create_sponhdimg_post_types' );

function awards_sponhdimgs_columns($columns) {
	$columns[ 'sponhdimg_image' ] = __( 'Image', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_sponhdimgs_columns', 'awards_sponhdimgs_columns' );

function sponhdimgs_custom_columns($column,$id) {
    switch ($column) {
        case 'sponhdimg_image':
           echo the_post_thumbnail( 'thumbnail' ); 
           break;
        default:
            break;
    }
}
add_action("manage_posts_custom_column", "sponhdimgs_custom_columns",10,2);

function sponhdimgs_shordcode($atts) {
	extract(shortcode_atts(array(
		'class' => 'sponhdimgs',
		'selectedid' => 0
	), $atts));
	
	return sponhdimgs_dropdown('sponhdimg', $class, $selectedid);
}
add_shortcode( 'sponhdimgs' , 'sponhdimgs_shordcode' );

function sponhdimgs_dropdown($name, $class, $selectedid = 0) {
	$html = '';

	$args = array('post_type' => 'awards_sponhdimgs',
		'orderby' => 'title', 
		'order' => 'asc',
		'nopaging' => 'true',
	 );

	$html .=  '<select id="' . $name . '" name="' . $name . '" class="' . $class . '">';
	if ($selectedid == 0) {
		$html .=  '<option value="0" selected>Site Default</option>';
	} else {
		$html .=  '<option value="default">Site Default</option>';
	}

	$loop = new WP_Query($args);
	while($loop->have_posts()) : $loop->the_post();	
		$post_id = get_the_id();
		if ($selectedid == $post_id) {
			$html .=  '<option value="' . $post_id . '" selected>' . get_the_title() . '</option>';
		} else {
			$html .=  '<option value="' . $post_id . '">' . get_the_title() . '</option>';
		}
	endwhile;
	
	$html .=  '</select>';

	wp_reset_postdata();
	return $html;
}

?>