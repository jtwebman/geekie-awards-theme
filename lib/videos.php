<?php

function create_videogallery_post_types() {
		
	register_post_type( 'awards_videogallery',
		array(
			'labels' => array(
				'name' => __( 'Video Galleries' , 'thegeekieawards' ),
				'singular_name' => __( 'Video Gallery' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Vide Gallery' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Video Gallery' , 'thegeekieawards' ),
				'new_item' => __( 'New Video Gallery' , 'thegeekieawards' ),
				'view_item' => __( 'View Video Gallery' , 'thegeekieawards' ),
				'search_items' => __( 'Search Video Galleries' , 'thegeekieawards' ),
				'not_found' => __( 'No vide Galleries found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No video galleries found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Video Galleries for the awards show.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'videos' , 'with_front' => false),
			'supports' => array( 'title' ),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_videogalleries_metaboxes'
		)
	);

}
add_action( 'init', 'create_videogallery_post_types' );

function add_videogalleries_metaboxes() {
	add_meta_box('videos_box', __( 'Videos', 'thegeekieawards' ), 'add_videos_meta_box', 'awards_videogallery', 'normal', 'default');
	add_meta_box('video_orderby_box', __( 'Video Gallery Order', 'thegeekieawards' ), 'add_video_orderby_box', 'awards_videogallery', 'normal', 'default');
}

function add_videos_meta_box($post) {

	$videos = get_post_meta($post->ID, 'videogallery_videos', true);
	$count = 1;
	if ( is_array( $videos ) ) {
		foreach($videos as $video) {
			output_video_add_box($count++, $video);
		}
	} else {
		output_video_add_box($count, array());
	}
	echo '<div id="admin-list-end-marker" style="clear: both;"><a rel="video" href="#" id="add-admin-list" name="add-admin-list">Add More</a>';
}

function output_video_add_box ($count, $video) {
	extract(shortcode_atts(array(
		'url' => '',
		'embedurl' => '',
		'title' => '',
		'description' => '',
		'thumbnailurl' => get_template_directory_uri() . '/images/noimage.png',
		'width' => 0,
		'height' => 0,
		'featured' => false,
		'orderid' => 0
	), $video));
	
	$checked = "";
	if ($featured == true) {
		$checked = " checked";
	}
	
	echo 	'<div class="admin-list-box">
				<div class="removelink"><a href="#" id="admin-list-removebox[' . $count . ']" name="admin-list-removebox"><img src="' . get_template_directory_uri() . '/images/remove.gif" width="16" height="16" /></a></div>
				<div class="uplink"><a href="#" id="admin-list-upbox[' . $count . ']" name="admin-list-upbox"><img src="' . get_template_directory_uri() . '/images/up.png" width="16" height="16" /></a></div>
				<div class="downlink"><a href="#" id="admin-list-downbox[' . $count . ']" name="admin-list-downbox"><img src="' . get_template_directory_uri() . '/images/down.png" width="16" height="16" /></a></div>
				<div class="admin-list-item">
					<div class="label">Video URL:</div>
					<div class="field"><input type="textbox" id="videourl[' . $count . ']" name="videourl[' . $count . ']" value="' . $url . '" /></div><img src="' . get_template_directory_uri() . '/images/loading.gif" width="40" height="40" id="loadingimg[' . $count . ']" style="display:none;" />
				</div>
				<div class="admin-list-item">
					<div class="label">Video Image:</div>
					<img class="list-thumbnail-image" id="list-thumbnail-image[' . $count . ']" src="' . $thumbnailurl . '" />
					<input type="hidden" id="videoimgurl[' . $count . ']" name="videoimgurl[' . $count . ']" value="' . $thumbnailurl . '" />
					<input type="hidden" id="videoimgwidth[' . $count . ']" name="videoimgwidth[' . $count . ']" value="' . $width . '" />
					<input type="hidden" id="videoimgheight[' . $count . ']" name="videoimgheight[' . $count . ']" value="' . $height . '" />
					<input type="hidden" id="embedurl[' . $count . ']" name="embedurl[' . $count . ']" value="' . $embedurl . '" />
					<input type="hidden" id="admin-list-order[' . $count . ']" name="admin-list-order[' . $count . ']" value="' . $count . '">
				</div>
				<div class="admin-list-item">
					<div class="label">Video Title:</div>
					<div class="field"><input type="textbox" id="videotitle[' . $count . ']" name="videotitle[' . $count . ']" value="' . $title . '" /></div>
				</div>
				<div class="admin-list-item videodescriptionfield">
					<div class="label">Video Description:</div>
					<div class="field"><textarea id="videodescription[' . $count . ']" name="videodescription[' . $count . ']">' . $description . '</textarea></div>
				</div>
				<div class="admin-list-item">
					<div class="label">Featured:</div>
					<div class="field"><input type="radio" id="videofeatured[' . $count . ']" name="videofeatured" value="' . $count . '"' . $checked . ' /></div>
				</div>
				<div style="clear: both;"></div>
			</div>';
}

function add_video_orderby_box($post) {
	$orderby = get_post_meta($post->ID, 'video_orderby', true);
	
	echo '<select name="video_orderby" id="video_orderby">';
	for ($i = 1;$i < 101;$i++) 
	{ 
		$selected = $orderby == $i ? " selected" : "";
		echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>'; 
	}
		
    echo '</select>';
}

function save_videos_metadata( $post_id ) {
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	if ( isset( $_POST['videoimgurl'] ) ) {
		$videos = array();
		$foundFeatured = false;
		foreach ($_POST['admin-list-order'] as $key => $value) {
			
			$featured = false;
			if (isset( $_POST['admin-list-featured'] ) && $_POST['admin-list-featured'] == $key) {
				$featured = true;
			}
			
			$video = array(
				'url' => $_POST['videourl'][$key],
				'title' => $_POST['videotitle'][$key],
				'description' => $_POST['videodescription'][$key],
				'width' => intval($_POST['videoimgwidth'][$key]),
				'height' => intval($_POST['videoimgheight'][$key]),
				'thumbnailurl' => $_POST['videoimgurl'][$key],
				'embedurl' => $_POST['embedurl'][$key],
				'featured' => $featured,
				'orderid' => $key
			);
			$videos[intval($value)] = $video;
			
			if ($featured) {
				update_post_meta( $post_id, 'videogallery_featured', $video );
				$foundFeatured = true;
			}
		}
		ksort($videos);
		if (!$foundFeatured) {
			$videos[key($videos)]['featured'] = true;
			update_post_meta( $post_id, 'videogallery_featured', reset($videos) );
		}
		update_post_meta( $post_id, 'videogallery_videos', $videos );
	}
	
	if ( isset( $_POST['video_orderby'] ) ) {
        update_post_meta( $post_id, 'video_orderby', strip_tags( $_POST['video_orderby'] ) );
    }
}
add_action('save_post', 'save_videos_metadata');

function awards_videogallery_columns($columns) {
	$columns[ 'videogallery_featured_image' ] = __( 'Featured Image', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_videogallery_columns', 'awards_videogallery_columns' );

function videogallery_custom_columns($column,$id) {
    switch ($column) {
        case 'videogallery_featured_image':
           echo the_post_thumbnail( 'thumbnail' ); 
           break;
        default:
            break;
    }
}
add_action("manage_posts_custom_column", "videogallery_custom_columns",10,2);

?>