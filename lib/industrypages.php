<?php

function create_industrypages_post_types() {
		
	register_post_type( 'awards_industrypages',
		array(
			'labels' => array(
				'name' => __( 'Industry Pages' , 'thegeekieawards' ),
				'singular_name' => __( 'Industry Page' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Industry Page' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Industry Page' , 'thegeekieawards' ),
				'new_item' => __( 'New Industry Page' , 'thegeekieawards' ),
				'view_item' => __( 'View Industry Page' , 'thegeekieawards' ),
				'search_items' => __( 'Search Industry Pages' , 'thegeekieawards' ),
				'not_found' => __( 'No industry pages found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No industry pages found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Industry page for the awards.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'industry' , 'with_front' => false),
			'supports' => array( 'title', 'editor', 'thumbnail'),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_industrypages_metaboxes',
		)
	);

}
add_action( 'init', 'create_industrypages_post_types' );

function add_industrypages_metaboxes() {
	add_meta_box('add_industrypages_subtitle_box', __( 'Subtitle', 'thegeekieawards' ), 'add_industrypages_subtitle_box', 'awards_industrypages', 'normal', 'default');
	add_meta_box('add_industrypages_info_box', __( 'Industry Page Info', 'thegeekieawards' ), 'add_industrypages_info_box', 'awards_industrypages', 'normal', 'default');
}

function add_industrypages_subtitle_box($post) {
	$industry_subtitle = get_post_meta($post->ID, 'industry_subtitle', true);
	echo '<p><input type="text" name="industry_subtitle" id="industry_subtitle" value="' . $industry_subtitle . '" /></p>';
}

function add_industrypages_info_box($post) {
	//Year
	$year = date('Y'); 
	$industry_year = get_post_meta($post->ID, 'industry_year', true);
    if ($industry_year == '') $industry_year = $year; 
	echo '<p><label for="industry_year">Industry Page Year: </label>';
	echo '<select name="industry_year" id="industry_year">';
	
	for ($i = 2013;$i <= $year+1;$i++) 
	{ 
		$selected = $industry_year == $i ? " selected" : "";
		echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>'; 
	}
    echo '</select>';
    echo '</p>';

	//Header
	$industry_header = get_post_meta($post->ID, 'industry_header', true);
	if ($industry_header == '') $industry_header = 0; 
	echo '<p><label for="industry_header">Industry Page Header: </label>';
	echo sponhdimgs_dropdown('industry_header', 'industry_header', $industry_header);
	echo '</p>';

	//Background
	$industry_background = get_post_meta($post->ID, 'industry_background', true);
	if ($industry_background == '') $industry_background = 0; 
	echo '<p><label for="industry_background">Industry Page Background: </label>';
	echo sponbgimgs_dropdown('industry_background', 'industry_background', $industry_background);
	echo '</p>';
}

function save_industrypages_metadata( $post_id ) {
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $_POST['post_type'] != 'awards_industrypages' ) return;
 
    if ( isset( $_POST['industry_subtitle'] ) ) {
        update_post_meta( $post_id, 'industry_subtitle', strip_tags( $_POST['industry_subtitle'] ) );
    }

 	if ( isset( $_POST['industry_year'] ) ) {
        update_post_meta( $post_id, 'industry_year', strip_tags( $_POST['industry_year'] ) );
    }

    if ( isset( $_POST['industry_header'] ) ) {
        update_post_meta( $post_id, 'industry_header', strip_tags( $_POST['industry_header'] ) );
    }

    if ( isset( $_POST['industry_background'] ) ) {
        update_post_meta( $post_id, 'industry_background', strip_tags( $_POST['industry_background'] ) );
    }

    update_post_meta( $post_id, 'industry_sidebar', sprintf( 'industry_sidebar_%d' , $post_id  ) );
}
add_action('save_post', 'save_industrypages_metadata');

function register_all_industrypages_sidebars()
{
	$loop = new WP_Query( array( 'post_type' => 'awards_industrypages', 
								 'nopaging' => 'true', 
								 'orderby' => 'title', 
								 'order' => 'ASC' ) ); 
	while ( $loop->have_posts() )
	{
		$loop->the_post();

		$industry_sidebar = get_post_meta( get_the_ID() , 'industry_sidebar' , true );

	    register_sidebar( array(
			'name' => sprintf( __( 'Industry %s Sidebar', 'thegeekieawards' ), get_the_title() ),
			'id' => $industry_sidebar ,
			'description' => sprintf( __( 'Appears on the %s industry page', 'thegeekieawards' ), get_the_title() ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3><hr />',
		) );
	}
	wp_reset_query();
}

function awards_industrypages_columns($columns) {
	$columns[ 'industry_year' ] = __( 'Year', 'thegeekieawards' );
	$columns[ 'industry_header' ] = __( 'Header', 'thegeekieawards' );
	$columns[ 'industry_background' ] = __( 'Background', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_industrypages_columns', 'awards_industrypages_columns' );

function industrypages_custom_columns($column,$id) {
	switch ($column) {
		case 'industry_year':
			echo get_post_meta($id, 'industry_year', true);
			break;
		case 'industry_header':
			$industry_header = get_post_meta($id, 'industry_header', true);
			if ($industry_header == 0) {
				echo 'Default';
			} else {
				echo get_the_post_thumbnail($industry_header, 'gallery-thumbnail');
			}
			break;
		case 'industry_background':
			$industry_background = get_post_meta($id, 'industry_background', true);
			if ($industry_background == 0) {
				echo 'Default';
			} else {
				echo get_the_post_thumbnail($industry_background, 'gallery-thumbnail');
			}
			break;
		default:
			break;
	}
}
add_action("manage_posts_custom_column", "industrypages_custom_columns",10,2);

?>