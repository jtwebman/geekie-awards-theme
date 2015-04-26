<?php

function create_judge_post_types() {
		
	register_post_type( 'awards_judges',
		array(
			'labels' => array(
				'name' => __( 'Judges' , 'thegeekieawards' ),
				'singular_name' => __( 'Judge' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Judge' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Judge' , 'thegeekieawards' ),
				'new_item' => __( 'New Judge' , 'thegeekieawards' ),
				'view_item' => __( 'View Judge' , 'thegeekieawards' ),
				'search_items' => __( 'Search Judges' , 'thegeekieawards' ),
				'not_found' => __( 'No judges found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No judges found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Judges for the awards.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'judges' , 'with_front' => false),
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
		)
	);

}
add_action( 'init', 'create_judge_post_types' );

function judges_shordcode($atts) {
	extract(shortcode_atts(array(
		'class' => 'judge',
		'size' => '150',
		'showname' => 'true'
	), $atts));
	
	$html = '';

	$args = array('post_type' => 'awards_judges',
		'orderby' => 'title', 
		'order' => 'asc',
		'nopaging' => 'true',
	 );

	$loop = new WP_Query($args);
	if($loop->have_posts()) {
		while($loop->have_posts()) : $loop->the_post();		
			$feat_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_id() ) );
			if ( $showname == 'true' ) {
				$html .=  '<div class="' . $class . '"><a href="' . get_permalink() . '"><img alt="' . get_the_title() . '" src="' . $feat_image . '" width="' . $size . '" height="' . $size . '" /><span>' . get_the_title() . '</span></a></div>';
			} else {
				$html .=  '<div class="' . $class . '"><a href="' . get_permalink() . '"><img alt="' . get_the_title() . '" src="' . $feat_image . '" width="' . $size . '" height="' . $size . '" /></a></div>';
			}
		endwhile;
	}

	wp_reset_postdata();
	return $html;
}
add_shortcode( 'judges' , 'judges_shordcode' );

function awards_judges_columns($columns) {
	$columns[ 'judge_image' ] = __( 'Image', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_judges_columns', 'awards_judges_columns' );

function judges_custom_columns($column,$id) {
    switch ($column) {
        case 'judge_image':
           echo the_post_thumbnail( 'thumbnail' ); 
           break;
        default:
            break;
    }
}
add_action("manage_posts_custom_column", "judges_custom_columns",10,2);

?>