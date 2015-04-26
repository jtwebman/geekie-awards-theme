<?php

function create_sponbgimg_post_types() {
		
	register_post_type( 'awards_sponbgimgs',
		array(
			'labels' => array(
				'name' => __( 'Sponsor BG Image' , 'thegeekieawards' ),
				'singular_name' => __( 'Sponsor Background Image' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Sponsor Background Image' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Sponsor Background Image' , 'thegeekieawards' ),
				'new_item' => __( 'New Sponsor Background Image' , 'thegeekieawards' ),
				'view_item' => __( 'View Sponsor Background Image' , 'thegeekieawards' ),
				'search_items' => __( 'Search Sponsor Background Images' , 'thegeekieawards' ),
				'not_found' => __( 'No sponsor background images found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No sponsor background images found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Sponsor Background Images used on sponsored pages.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'sponbgimgs' , 'with_front' => false),
			'supports' => array( 'title', 'thumbnail' ),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true
		)
	);

}
add_action( 'init', 'create_sponbgimg_post_types' );

function awards_sponbgimgs_columns($columns) {
	$columns[ 'sponbgimg_image' ] = __( 'Image', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_sponbgimgs_columns', 'awards_sponbgimgs_columns' );

function sponbgimgs_custom_columns($column,$id) {
    switch ($column) {
        case 'sponbgimg_image':
           echo the_post_thumbnail( 'thumbnail' ); 
           break;
        default:
            break;
    }
}
add_action("manage_posts_custom_column", "sponbgimgs_custom_columns",10,2);

function sponbgimgs_shordcode($atts) {
	extract(shortcode_atts(array(
		'class' => 'sponbgimgs',
		'selectedid' => 0
	), $atts));
	
	return sponhdimgs_dropdown('sponbgimg', $class, $selectedid);
}
add_shortcode( 'sponbgimgs' , 'sponbgimgs_shordcode' );

function sponbgimgs_dropdown($name, $class, $selectedid = 0) {
	$html = '';

	$args = array('post_type' => 'awards_sponbgimgs',
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