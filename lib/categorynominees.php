<?php

function create_catnominees_post_types() {
		
	register_post_type( 'awards_catnominees',
		array(
			'labels' => array(
				'name' => __( 'Category Nominees' , 'thegeekieawards' ),
				'singular_name' => __( 'Category Nominee' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Category Nominee' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Category Nominee' , 'thegeekieawards' ),
				'new_item' => __( 'New Category Nominee' , 'thegeekieawards' ),
				'view_item' => __( 'View Category Nominee' , 'thegeekieawards' ),
				'search_items' => __( 'Search Category Nominee' , 'thegeekieawards' ),
				'not_found' => __( 'No category nominees found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No category nominees found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Category nominees for the awards.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'nominees' , 'with_front' => false),
			'supports' => array( 'title'),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_catnominee_metaboxes',
		)
	);

}
add_action( 'init', 'create_catnominees_post_types' );

function add_catnominee_metaboxes() {
	add_meta_box('add_subtitle_box', __( 'Subtitle', 'thegeekieawards' ), 'add_subtitle_box', 'awards_catnominees', 'normal', 'default');
	add_meta_box('add_catnominee_info_box', __( 'Category Nominee Info', 'thegeekieawards' ), 'add_catnominee_info_box', 'awards_catnominees', 'normal', 'default');
	add_meta_box('add_catnominee_selected_box', __( 'Category Nominees Selected', 'thegeekieawards' ), 'add_catnominee_selected_box', 'awards_catnominees', 'normal', 'default');
	add_meta_box('add_catnominee_top10_box', __( 'Category Top 10 Selected', 'thegeekieawards' ), 'add_catnominee_top10_box', 'awards_catnominees', 'normal', 'default');
}

function add_subtitle_box($post) {
	$nominee_subtitle = get_post_meta($post->ID, 'nominee_subtitle', true);
	echo '<p><input type="text" name="nominee_subtitle" id="nominee_subtitle" value="' . $nominee_subtitle . '" /></p>';
}

function add_catnominee_selected_box($post) {
	$args = array(
		'orderby' => 'rand', 
		'nopaging' => 'true',
		'meta_key' => 'nominated_category',
		'meta_value' => $post->ID
	 );

	echo '<ul>';

	$loop = new WP_Query($args);
	while($loop->have_posts()) {
		$loop->the_post();
		echo '<li><a href="' . get_edit_post_link(get_the_id()) . '">' . get_the_title() . '</a></li>';
	} 

	echo '</ul>';
}

function add_catnominee_top10_box($post) {
	$args = array(
		'orderby' => 'rand', 
		'nopaging' => 'true',
		'meta_key' => 'nominated_category_top10',
		'meta_value' => $post->ID
	 );

	echo '<ul>';

	$loop = new WP_Query($args);
	while($loop->have_posts()) {
		$loop->the_post();
		echo '<li><a href="' . get_edit_post_link(get_the_id()) . '">' . get_the_title() . '</a></li>';
	} 

	echo '</ul>';

	$nominee_top10_extra = htmlspecialchars(get_post_meta($post->ID, 'nominee_top10_extra', true));
	echo '<p><input type="text" name="nominee_top10_extra" id="nominee_top10_extra" value="' . $nominee_top10_extra . '" />(Comma delimited titles with no posts)</p>';
}

function add_catnominee_info_box($post) {
	//Year
	$year = date('Y'); 
	$nominee_year = get_post_meta($post->ID, 'nominee_year', true);
    if ($nominee_year == '') $nominee_year = $year; 
	echo '<p><label for="nominee_year">Category Nominee Year: </label>';
	echo '<select name="nominee_year" id="nominee_year">';
	
	for ($i = 2013;$i <= $year+1;$i++) 
	{ 
		$selected = $nominee_year == $i ? " selected" : "";
		echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>'; 
	}
    echo '</select>';
    echo '</p>';

    //Category
    $nominee_category = get_post_meta($post->ID, 'nominee_category', true);
    if ($nominee_category == '') $nominee_category = 0; 
    $args = array(
		'orderby'            => 'NAME', 
		'order'              => 'ASC',
		'hide_empty'         => 0, 
		'selected'           => $nominee_category,
		'name'               => 'nominee_category',
		'id'                 => 'nominee_category',
		'class'              => 'nominee-cat',
		'taxonomy'           => 'category',
		'hierarchical'       => 1, 
	);
    echo '<p><label for="nominee_category">Category Nominee Category: </label>';
	wp_dropdown_categories( $args ); 
	echo '</p>';

	//Header
	$nominee_header = get_post_meta($post->ID, 'nominee_header', true);
	if ($nominee_header == '') $nominee_header = 0; 
	echo '<p><label for="nominee_header">Category Nominee Header: </label>';
	echo sponhdimgs_dropdown('nominee_header', 'nominee_header', $nominee_header);
	echo '</p>';

	//Background
	$nominee_background = get_post_meta($post->ID, 'nominee_background', true);
	if ($nominee_background == '') $nominee_background = 0; 
	echo '<p><label for="nominee_background">Category Nominee Background: </label>';
	echo sponbgimgs_dropdown('nominee_background', 'nominee_background', $nominee_background);
	echo '</p>';
}

function save_catnominee_metadata( $post_id ) {
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $_POST['post_type'] != 'awards_catnominees' ) return;
 
    if ( isset( $_POST['nominee_subtitle'] ) ) {
        update_post_meta( $post_id, 'nominee_subtitle', strip_tags( $_POST['nominee_subtitle'] ) );
    }

 	if ( isset( $_POST['nominee_year'] ) ) {
        update_post_meta( $post_id, 'nominee_year', strip_tags( $_POST['nominee_year'] ) );
    }

    $nominee_category = 0;

    if ( isset( $_POST['nominee_category'] ) ) {
    	$nominee_category = strip_tags( $_POST['nominee_category'] );
        update_post_meta( $post_id, 'nominee_category', $nominee_category );
    }

    if ( isset( $_POST['nominee_header'] ) ) {
        update_post_meta( $post_id, 'nominee_header', strip_tags( $_POST['nominee_header'] ) );
    }

    if ( isset( $_POST['nominee_background'] ) ) {
        update_post_meta( $post_id, 'nominee_background', strip_tags( $_POST['nominee_background'] ) );
    }

    if ( isset( $_POST['nominee_top10_extra'] ) ) {
        update_post_meta( $post_id, 'nominee_top10_extra', strip_tags( $_POST['nominee_top10_extra'] ) );
    }

    update_post_meta( $post_id, 'nominee_sidebar', sprintf( 'nominee_sidebar_%s' , $nominee_category ) );
}
add_action('save_post', 'save_catnominee_metadata');

function register_all_sidebars()
{
	$loop = new WP_Query( array( 'post_type' => 'awards_catnominees', 
								 'nopaging' => 'true', 
								 'orderby' => 'title', 
								 'order' => 'ASC' ) ); 
	while ( $loop->have_posts() )
	{
		$loop->the_post();

		$nominee_category = get_post_meta( get_the_ID() , 'nominee_category' , true );
		$nominee_sidebar = get_post_meta( get_the_ID() , 'nominee_sidebar' , true );
		$category_name = get_cat_name( $nominee_category );

	    register_sidebar( array(
			'name' => sprintf( __( 'Nominee %s Sidebar', 'thegeekieawards' ), $category_name ),
			'id' => $nominee_sidebar ,
			'description' => sprintf( __( 'Appears on the %s nominee page', 'thegeekieawards' ), $category_name ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3><hr />',
		) );
	}
	wp_reset_query();
}

function awards_catnominees_columns($columns) {
	$columns[ 'nominee_year' ] = __( 'Year', 'thegeekieawards' );
	$columns[ 'nominee_category' ] = __( 'Category', 'thegeekieawards' );
	$columns[ 'nominee_header' ] = __( 'Header', 'thegeekieawards' );
	$columns[ 'nominee_background' ] = __( 'Background', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_catnominees_columns', 'awards_catnominees_columns' );

function categorynominees_custom_columns($column,$id) {
	switch ($column) {
		case 'nominee_year':
			echo get_post_meta($id, 'nominee_year', true);
			break;
		case 'nominee_category':
			echo get_cat_name(get_post_meta($id, 'nominee_category', true));
			break;
		case 'nominee_header':
			$nominee_header = get_post_meta($id, 'nominee_header', true);
			if ($nominee_header == 0) {
				echo 'Default';
			} else {
				echo get_the_post_thumbnail($nominee_header, 'gallery-thumbnail');
			}
			break;
		case 'nominee_background':
			$nominee_background = get_post_meta($id, 'nominee_background', true);
			if ($nominee_background == 0) {
				echo 'Default';
			} else {
				echo get_the_post_thumbnail($nominee_background, 'gallery-thumbnail');
			}
			break;
		default:
			break;
	}
}
add_action("manage_posts_custom_column", "categorynominees_custom_columns",10,2);

?>