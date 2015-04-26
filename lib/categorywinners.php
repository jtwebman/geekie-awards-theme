<?php

function create_catwinners_post_types() {
		
	register_post_type( 'awards_catwinners',
		array(
			'labels' => array(
				'name' => __( 'Category Winners' , 'thegeekieawards' ),
				'singular_name' => __( 'Category Winner' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Category Winner' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Category Winner' , 'thegeekieawards' ),
				'new_item' => __( 'New Category Winner' , 'thegeekieawards' ),
				'view_item' => __( 'View Category Winner' , 'thegeekieawards' ),
				'search_items' => __( 'Search Category Winner' , 'thegeekieawards' ),
				'not_found' => __( 'No category winners found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No category winners found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Category winners for the awards.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'winners' , 'with_front' => false),
			'supports' => array( 'title'),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_catwinner_metaboxes',
		)
	);

}
add_action( 'init', 'create_catwinners_post_types' );

function add_catwinner_metaboxes() {
	add_meta_box('add_subtitlewinner_box', __( 'Subtitle', 'thegeekieawards' ), 'add_subtitlewinner_box', 'awards_catwinners', 'normal', 'default');
	add_meta_box('add_catwinner_info_box', __( 'Category Winner Info', 'thegeekieawards' ), 'add_catwinner_info_box', 'awards_catwinners', 'normal', 'default');
	add_meta_box('add_catwinner_selected_box', __( 'Category Winner Selected', 'thegeekieawards' ), 'add_catwinner_selected_box', 'awards_catwinners', 'normal', 'default');
	add_meta_box('add_catwinner_honors_selected_box', __( 'Category Honors Selected', 'thegeekieawards' ), 'add_catwinner_honors_selected_box', 'awards_catwinners', 'normal', 'default');
	add_meta_box('add_catwinnernominee_selected_box', __( 'Category Nominees Selected', 'thegeekieawards' ), 'add_catwinnernominee_selected_box', 'awards_catwinners', 'normal', 'default');
	add_meta_box('add_catwinnernominee_top10_box', __( 'Category Top 10 Selected', 'thegeekieawards' ), 'add_catwinnernominee_top10_box', 'awards_catwinners', 'normal', 'default');
}

function add_subtitlewinner_box($post) {
	$winner_subtitle = get_post_meta($post->ID, 'winner_subtitle', true);
	echo '<p><input type="text" name="winner_subtitle" id="winner_subtitle" value="' . $winner_subtitle . '" /></p>';
}

function add_catwinner_selected_box($post) {
	$args = array(
		'orderby' => 'rand', 
		'nopaging' => 'true',
		'meta_key' => 'winner_category',
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

function get_categorynominee_post_Id_from_categorywinner($post_id) {
	$winner_category = get_post_meta( $post_id , 'winner_category' , true );
	$args = array(
		'meta_key' => 'nominee_category',
		'meta_value' => $winner_category,
		'post_type' => 'awards_catnominees'
	 );
	$post_id_return = 0;

	$loop = new WP_Query($args);
	while($loop->have_posts()) {
		$loop->the_post();
		$post_id_return = get_the_ID(); 
	} 

	return $post_id_return;
}

function add_catwinnernominee_selected_box($post) {
	$nominee_post_id = get_categorynominee_post_Id_from_categorywinner($post->ID);

	$args = array(
		'orderby' => 'rand', 
		'nopaging' => 'true',
		'meta_key' => 'nominated_category',
		'meta_value' => $nominee_post_id
	 );

	echo '<ul>';

	$loop = new WP_Query($args);
	while($loop->have_posts()) {
		$loop->the_post();
		echo '<li><a href="' . get_edit_post_link(get_the_id()) . '">' . get_the_title() . '</a></li>';
	} 

	echo '</ul>';
}

function add_catwinner_honors_selected_box($post) {
	$winner_category = get_post_meta( $post->ID  , 'winner_category' , true );

	$honorargs = array(
		'meta_key' => 'honor_category',
		'meta_value' => $winner_category,
		'post_type' => 'awards_cathonors'
	 );

	echo '<ul>';

	$honorloop = new WP_Query($honorargs);
	foreach ( $honorloop->posts as $honorpost ) :
		$postargs = array(
			'orderby' => 'NAME', 
			'order' => 'ASC',
			'nopaging' => 'true',
			'meta_key' => 'category_honor',
			'meta_value' => $honorpost->ID
		 );
		$postloop = new WP_Query($postargs);
		foreach ( $postloop->posts as $post ) :
			echo '<li><a href="' . get_edit_post_link($honorpost->ID) . '">' . $honorpost->post_title . ' - ' . $post->post_title . '</a></li>';
		endforeach;
	endforeach;

	echo '</ul>';
}

function add_catwinnernominee_top10_box($post) {

	$nominee_post_id = get_categorynominee_post_Id_from_categorywinner($post);

	$args = array(
		'orderby' => 'rand', 
		'nopaging' => 'true',
		'meta_key' => 'nominated_category_top10',
		'meta_value' => $nominee_post_id
	 );

	echo '<ul>';

	$loop = new WP_Query($args);
	while($loop->have_posts()) {
		$loop->the_post();
		echo '<li><a href="' . get_edit_post_link(get_the_id()) . '">' . get_the_title() . '</a></li>';
	} 

	echo '</ul>';
}

function add_catwinner_info_box($post) {
	//Year
	$year = date('Y'); 
	$winner_year = get_post_meta($post->ID, 'winner_year', true);
    if ($winner_year == '') $winner_year = $year; 
	echo '<p><label for="winner_year">Category Winner Year: </label>';
	echo '<select name="winner_year" id="winner_year">';
	
	for ($i = 2013;$i <= $year+1;$i++) 
	{ 
		$selected = $winner_year == $i ? " selected" : "";
		echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>'; 
	}
    echo '</select>';
    echo '</p>';

    //Category
    $winner_category = get_post_meta($post->ID, 'winner_category', true);
    if ($winner_category == '') $winner_category = 0; 
    $args = array(
		'orderby'            => 'NAME', 
		'order'              => 'ASC',
		'hide_empty'         => 0, 
		'selected'           => $winner_category,
		'name'               => 'winner_category',
		'id'                 => 'winner_category',
		'class'              => 'winner-cat',
		'taxonomy'           => 'category',
		'hierarchical'       => 1, 
	);
    echo '<p><label for="winner_category">Category Winner Category: </label>';
	wp_dropdown_categories( $args ); 
	echo '</p>';

	//Header
	$winner_header = get_post_meta($post->ID, 'winner_header', true);
	if ($winner_header == '') $winner_header = 0; 
	echo '<p><label for="winner_header">Category Winner Header: </label>';
	echo sponhdimgs_dropdown('winner_header', 'winner_header', $winner_header);
	echo '</p>';

	//Background
	$winner_background = get_post_meta($post->ID, 'winner_background', true);
	if ($winner_background == '') $winner_background = 0; 
	echo '<p><label for="winner_background">Category Winner Background: </label>';
	echo sponbgimgs_dropdown('winner_background', 'winner_background', $winner_background);
	echo '</p>';

	$winner_video = htmlspecialchars(get_post_meta($post->ID, 'winner_video', true));
	echo '<p><label for="winner_video">Category Winner Video: </label>';
	echo '<input type="text" name="winner_video" id="winner_video" value="' . $winner_video . '" />(YouTube Video URL)</p>';
}

function save_catwinner_metadata( $post_id ) {
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $_POST['post_type'] != 'awards_catwinners' ) return;
 
    if ( isset( $_POST['winner_subtitle'] ) ) {
        update_post_meta( $post_id, 'winner_subtitle', strip_tags( $_POST['winner_subtitle'] ) );
    }

 	if ( isset( $_POST['winner_year'] ) ) {
        update_post_meta( $post_id, 'winner_year', strip_tags( $_POST['winner_year'] ) );
    }

    $winner_category = 0;

    if ( isset( $_POST['winner_category'] ) ) {
    	$winner_category = strip_tags( $_POST['winner_category'] );
        update_post_meta( $post_id, 'winner_category', $winner_category );
    }

    if ( isset( $_POST['winner_header'] ) ) {
        update_post_meta( $post_id, 'winner_header', strip_tags( $_POST['winner_header'] ) );
    }

    if ( isset( $_POST['winner_background'] ) ) {
        update_post_meta( $post_id, 'winner_background', strip_tags( $_POST['winner_background'] ) );
    }

    if ( isset( $_POST['winner_video'] ) ) {
        update_post_meta( $post_id, 'winner_video', strip_tags( $_POST['winner_video'] ) );
    }

    update_post_meta( $post_id, 'winner_sidebar', sprintf( 'winner_sidebar_%s' , $winner_category ) );
}
add_action('save_post', 'save_catwinner_metadata');

function register_all_winner_sidebars()
{
	$loop = new WP_Query( array( 'post_type' => 'awards_catwinners', 
								 'nopaging' => 'true', 
								 'orderby' => 'title', 
								 'order' => 'ASC' ) ); 
	while ( $loop->have_posts() )
	{
		$loop->the_post();

		$winner_category = get_post_meta( get_the_ID() , 'winner_category' , true );
		$winner_sidebar = get_post_meta( get_the_ID() , 'winner_sidebar' , true );
		$category_name = get_cat_name( $winner_category );

	    register_sidebar( array(
			'name' => sprintf( __( 'Winner %s Sidebar', 'thegeekieawards' ), $category_name ),
			'id' => $winner_sidebar ,
			'description' => sprintf( __( 'Appears on the %s winner page', 'thegeekieawards' ), $category_name ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3><hr />',
		) );
	}
	wp_reset_query();
}

function awards_catwinners_columns($columns) {
	$columns[ 'winner_year' ] = __( 'Year', 'thegeekieawards' );
	$columns[ 'winner_category' ] = __( 'Category', 'thegeekieawards' );
	$columns[ 'winner_header' ] = __( 'Header', 'thegeekieawards' );
	$columns[ 'winner_background' ] = __( 'Background', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_catwinners_columns', 'awards_catwinners_columns' );

function categorywinners_custom_columns($column,$id) {
	switch ($column) {
		case 'winner_year':
			echo get_post_meta($id, 'winner_year', true);
			break;
		case 'winner_category':
			echo get_cat_name(get_post_meta($id, 'winner_category', true));
			break;
		case 'winner_header':
			$winner_header = get_post_meta($id, 'winner_header', true);
			if ($winner_header == 0) {
				echo 'Default';
			} else {
				echo get_the_post_thumbnail($winner_header, 'gallery-thumbnail');
			}
			break;
		case 'winner_background':
			$winner_background = get_post_meta($id, 'winner_background', true);
			if ($winner_background == 0) {
				echo 'Default';
			} else {
				echo get_the_post_thumbnail($winner_background, 'gallery-thumbnail');
			}
			break;
		default:
			break;
	}
}
add_action("manage_posts_custom_column", "categorywinners_custom_columns",10,2);

?>