<?php

function create_imagegallery_post_types() {
		
	register_post_type( 'awards_imagegallery',
		array(
			'labels' => array(
				'name' => __( 'Image Galleries' , 'thegeekieawards' ),
				'singular_name' => __( 'Image Gallery' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Image Gallery' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Image Gallery' , 'thegeekieawards' ),
				'new_item' => __( 'New Image Gallery' , 'thegeekieawards' ),
				'view_item' => __( 'View Image Gallery' , 'thegeekieawards' ),
				'search_items' => __( 'Search Image Galleries' , 'thegeekieawards' ),
				'not_found' => __( 'No Image Galleries found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No image galleries found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Image Galleries for the awards show.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'images' , 'with_front' => false),
			'supports' => array( 'title' ),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_imagegalleries_metaboxes'
		)
	);

}
add_action( 'init', 'create_imagegallery_post_types' );

function add_imagegalleries_metaboxes() {
	add_meta_box('image_box', __( 'Images', 'thegeekieawards' ), 'add_images_meta_box', 'awards_imagegallery', 'normal', 'default');
	add_meta_box('image_orderby_box', __( 'Image Gallery Order', 'thegeekieawards' ), 'add_image_orderby_box', 'awards_imagegallery', 'normal', 'default');
}

function add_images_meta_box($post) {
	 
    // Get images for this post
    $images = get_post_meta($post->ID, 'imagegallery_images', true);
	$count = 1;
	if (!empty($images) ) {
		foreach($images as $image) {
			output_image_add_box($count++, $image);
		}
	}
	echo '<div id="admin-list-end-marker" style="clear: both;"></div><a rel="image" href="#" id="add-admin-list" name="add-admin-list">Add Images</a>';
}

function output_image_add_box ($count, $image) {
	extract(shortcode_atts(array(
		'url' => '',
		'caption' => '',
		'featured' => false,
		'orderid' => 0
	), $image));
	
	$checked = "";
	if ($featured == true) {
		$checked = " checked";
	}
	
	echo 	'<div class="admin-list-box">
				<div class="removelink"><a href="#" id="admin-list-removebox[' . $count . ']" name="admin-list-removebox"><img src="' . get_template_directory_uri() . '/images/remove.gif" width="16" height="16" /></a></div>
				<div class="uplink"><a href="#" id="admin-list-upbox[' . $count . ']" name="admin-list-upbox"><img src="' . get_template_directory_uri() . '/images/up.png" width="16" height="16" /></a></div>
				<div class="downlink"><a href="#" id="admin-list-downbox[' . $count . ']" name="admin-list-downbox"><img src="' . get_template_directory_uri() . '/images/down.png" width="16" height="16" /></a></div>
				<div class="admin-list-item">
					<div class="label">Image:</div>
					<img class="list-thumbnail-image" id="list-thumbnail-image[' . $count . ']" src="' . $url . '" />
					<input type="hidden" id="imageurl[' . $count . ']" name="imageurl[' . $count . ']" value="' . $url . '">
					<input type="hidden" id="admin-list-order[' . $count . ']" name="admin-list-order[' . $count . ']" value="' . $count . '">
				</div>
				<div class="admin-list-item">
					<div class="label">Image Caption:</div>
					<div class="field"><input type="textbox" id="imagecaption[' . $count . ']" name="imagecaption[' . $count . ']" value="' . $caption . '" /></div>
				</div>
				<div class="admin-list-item">
					<div class="label">Featured:</div>
					<div class="field"><input type="radio" id="admin-list-featured[' . $count . ']" name="admin-list-featured" value="' . $count . '"' . $checked . ' /></div>
				</div>
				<div style="clear: both;"></div>
			</div>';
}

function add_image_orderby_box($post) {
	$orderby = get_post_meta($post->ID, 'image_orderby', true);
	
	echo '<select name="image_orderby" id="image_orderby">';
	for ($i = 1;$i < 101;$i++) 
	{ 
		$selected = $orderby == $i ? " selected" : "";
		echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>'; 
	}
		
    echo '</select>';
}

function save_images_metadata( $post_id ) {
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	if ( isset( $_POST['imageurl'] ) ) {
		$images = array();
		$foundFeatured = false;

		foreach ($_POST['admin-list-order'] as $key => $value) {
			$featured = false;
			if (isset( $_POST['admin-list-featured'] ) && $_POST['admin-list-featured'] == $key) {
				$featured = true;
			}
			
			$image = array(
				'url' => $_POST['imageurl'][$key],
				'caption' => $_POST['imagecaption'][$key],
				'featured' => $featured,
				'orderid' => $key
			);
			$images[intval($value)] = $image;
			
			if ($featured) {
				update_post_meta( $post_id, 'imagegallery_featured', $image );
				$foundFeatured = true;
			}
		}
		ksort($images);
		if (!$foundFeatured) {
			$images[key($images)]['featured'] = true;
			update_post_meta( $post_id, 'imagegallery_featured', reset($images) );
		}
		update_post_meta( $post_id, 'imagegallery_images', $images );
	}
	
	if ( isset( $_POST['image_orderby'] ) ) {
        update_post_meta( $post_id, 'image_orderby', strip_tags( $_POST['image_orderby'] ) );
    }
}
add_action('save_post', 'save_images_metadata');

function awards_imagegallery_columns($columns) {
	$columns[ 'imagegallery_featured_image' ] = __( 'Featured Image', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_imagegallery_columns', 'awards_imagegallery_columns' );

function imagegallery_custom_columns($column,$id) {
    switch ($column) {
        case 'imagegallery_featured_image':
			$image = get_post_meta($id, 'imagegallery_featured', true);
           	echo '<img src="' . $image['url'] . '" height="167" />'; 
           	break;
        default:
            break;
    }
}
add_action("manage_posts_custom_column", "imagegallery_custom_columns",10,2);

?>