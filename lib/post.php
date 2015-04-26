<?php

function post_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'add_post_meta_boxes' );
}
add_action( 'load-post.php', 'post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'post_meta_boxes_setup' );

function add_post_meta_boxes() {
	add_meta_box('add_winner_category_box', __( 'Win Category', 'thegeekieawards' ), 'add_winner_category_box', 'post', 'side', 'high');
	add_meta_box('add_nominee_category_box', __( 'Nominated Category', 'thegeekieawards' ), 'add_nominee_category_box', 'post', 'side', 'high');
	add_meta_box('add_nominee_category_top10_box', __( 'Category Top 10', 'thegeekieawards' ), 'add_nominee_category_top10_box', 'post', 'side', 'high');
	add_meta_box('add_honor_category_box', __( 'Category Honor', 'thegeekieawards' ), 'add_honor_category_box', 'post', 'side', 'high');
}

function add_winner_category_box($post) {	
	$winner_category = get_post_meta($post->ID, 'winner_category', true);
    $args = array('post_type' => 'awards_catwinners',
		'orderby' => 'title', 
		'order' => 'asc',
		'post_status' => array('publish', 'pending', 'draft', 'future', 'private'),
		'numberposts' => -1,
	 );

	$myposts = get_posts( $args );

	echo  '<select id="winner_category" name="winner_category" class="winner_category">';
	if ($selectedid == 0) {
		echo '<option value="0" selected>Not a Winner</option>';
	} else {
		echo '<option value="default">Not the Winner</option>';
	}
	foreach ( $myposts as $post ) {
		$post_id = $post->ID;
		$post_year = get_post_meta($post_id, 'winner_year', true); 
		if ($winner_category == $post_id) {
			echo '<option value="' . $post_id . '" selected>' . $post_year  . ' - ' . $post->post_title . '</option>';
		} else {
			echo '<option value="' . $post_id . '">' . $post_year  . ' - ' . $post->post_title . '</option>';
		}
	} 
	echo '</select>';
}

function add_nominee_category_box($post) {	
	$nominated_category = get_post_meta($post->ID, 'nominated_category', true);
    $args = array('post_type' => 'awards_catnominees',
		'orderby' => 'title', 
		'order' => 'asc',
		'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
		'numberposts' => -1,
	 );

	$myposts = get_posts( $args );

	echo  '<select id="nominated_category" name="nominated_category" class="nominated_category">';
	if ($selectedid == 0) {
		echo '<option value="0" selected>Not Nominated</option>';
	} else {
		echo '<option value="default">Not Nominated</option>';
	}
	foreach ( $myposts as $post ) {
		$post_id = $post->ID;
		$post_year = get_post_meta($post_id, 'nominee_year', true); 
		if ($nominated_category == $post_id) {
			echo '<option value="' . $post_id . '" selected>' . $post_year . ' - ' . $post->post_title . '</option>';
		} else {
			echo '<option value="' . $post_id . '">' . $post_year . ' - ' . $post->post_title . '</option>';
		}
	} 
	echo '</select>';
}

function add_honor_category_box($post) {
	$category_honor = get_post_meta($post->ID, 'category_honor', true);
    $args = array('post_type' => 'awards_cathonors',
		'orderby' => 'meta_value title', 
		'meta_key' => 'honor_category',
		'order' => 'asc',
		'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
		'numberposts' => -1,
	 );

	$myposts = get_posts( $args );

	echo  '<select id="category_honor" name="category_honor" class="category_honor">';
	if ($selectedid == 0) {
		echo '<option value="0" selected>No Category Honor</option>';
	} else {
		echo '<option value="default">No Category Honor</option>';
	}
	foreach ( $myposts as $post ) {
		$post_id = $post->ID;
		$honor_category = get_cat_name(get_post_meta($post->ID, 'honor_category', true));
		$post_year = get_post_meta($post_id, 'honor_year', true); 
		if ($category_honor == $post_id) {
			echo '<option value="' . $post_id . '" selected>' . $post_year . ' - ' . $honor_category . ' - ' . $post->post_title . '</option>';
		} else {
			echo '<option value="' . $post_id . '">' . $post_year . ' - ' . $honor_category . ' - ' . $post->post_title . '</option>';
		}
	} 
	echo '</select>';
}

function add_nominee_category_top10_box($post) {	
	$nominated_category = get_post_meta($post->ID, 'nominated_category_top10', true);
    $args = array('post_type' => 'awards_catnominees',
		'orderby' => 'title', 
		'order' => 'asc',
		'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
		'numberposts' => -1,
	 );

	$myposts = get_posts( $args );

	echo  '<select id="nominated_category_top10" name="nominated_category_top10" class="nominated_category_top10">';
	if ($selectedid == 0) {
		echo '<option value="0" selected>Not in Top 10</option>';
	} else {
		echo '<option value="default">Not in Top 10</option>';
	}
	foreach ( $myposts as $post ) {
		$post_id = $post->ID;
		$post_year = get_post_meta($post_id, 'nominee_year', true); 
		if ($nominated_category == $post_id) {
			echo '<option value="' . $post_id . '" selected>' . $post_year . ' - ' . $post->post_title . '</option>';
		} else {
			echo '<option value="' . $post_id . '">' . $post_year . ' - ' . $post->post_title . '</option>';
		}
	} 
	echo '</select>';
}

function save_post_metadata( $post_id ) {
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $_POST['post_type'] !=  'post' ) return;

	if ( isset( $_POST['winner_category'] ) ) {
		update_post_meta( $post_id, 'winner_category', strip_tags( $_POST['winner_category'] ) );
    }

	if ( isset( $_POST['nominated_category'] ) ) {
		update_post_meta( $post_id, 'nominated_category', strip_tags( $_POST['nominated_category'] ) );
    }

    if ( isset( $_POST['nominated_category_top10'] ) ) {
		update_post_meta( $post_id, 'nominated_category_top10', strip_tags( $_POST['nominated_category_top10'] ) );
    }

    if ( isset( $_POST['category_honor'] ) ) {
		update_post_meta( $post_id, 'category_honor', strip_tags( $_POST['category_honor'] ) );
    }
}
add_action('save_post', 'save_post_metadata');

?>