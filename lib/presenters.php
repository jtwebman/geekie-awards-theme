<?php

function create_presenter_post_types() {
		
	register_post_type( 'awards_presenters',
		array(
			'labels' => array(
				'name' => __( 'Special Guests' , 'thegeekieawards' ),
				'singular_name' => __( 'Special Guest' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Special Guest' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Special Guest' , 'thegeekieawards' ),
				'new_item' => __( 'New Special Guest' , 'thegeekieawards' ),
				'view_item' => __( 'View Special Guest' , 'thegeekieawards' ),
				'search_items' => __( 'Search Special Guests' , 'thegeekieawards' ),
				'not_found' => __( 'No special guests found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No special guests found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Special Guests for the awards show.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'guests' , 'with_front' => false),
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_presenters_metaboxes'
		)
	);

	register_taxonomy( 'awards_guest_type', 'awards_presenters',  
		array(
			'label' => __( 'Special Guest Types' , 'thegeekieawards' ),
			'labels' => array(
				'name' => __( 'Special Guest Types' , 'thegeekieawards' ),
				'singular_name' => __( 'Special Guest Type' , 'thegeekieawards' ),
				'menu_name' => __( 'Special Guest Type' , 'thegeekieawards' ),
				'all_items'  => __( 'Add New Special Guest Type' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Special Guest Type' , 'thegeekieawards' ),
				'view_item' => __( 'View Special Guest Type' , 'thegeekieawards' ),
				'update_item'  => __( 'Update Special Guest Type' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Special Guest Type' , 'thegeekieawards' ),
			),
			'show_tagcloud' => false,
			'hierarchical' 	=> true,
			'public' => true,
			'show_ui' => true,
			'query_var' => 'guesttype',
			'show_in_nav_menus' => true,
			'rewrite' => array('slug' => 'guest-types' , 'with_front' => false),
		)
	);
}
add_action( 'init', 'create_presenter_post_types' );

function add_presenters_metaboxes() {
	add_meta_box('presenter_credit_box', __( 'Special Guest Credits', 'thegeekieawards' ), 'add_presenter_credit', 'awards_presenters', 'normal', 'default');
	add_meta_box('presenter_orderby_box', __( 'Special Guest Featured Order', 'thegeekieawards' ), 'add_presenter_orderby_box', 'awards_presenters', 'normal', 'default');
}

function add_presenter_credit($post) {

	$credit = get_post_meta($post->ID, 'presenter_credit', true);

	echo '<textarea cols="80" rows="5" class="admin-input-full-width" name="presenter_credit" id="presenter_credit" autocomplete="off">' . $credit . '</textarea>';
}

function add_presenter_orderby_box($post) {
	$orderby = get_post_meta($post->ID, 'presenter_featured_orderby', true);
	
	echo '<select name="presenter_featured_orderby" id="presenter_featured_orderby">';
	$selected = $orderby == 999 ? " selected" : "";
	echo '<option value="999"' . $selected . '>Not Featured</option>'; 
	for ($i = 1;$i <= 100;$i++) 
	{ 
		$selected = $orderby == $i ? " selected" : "";
		echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>'; 
	}
		
    echo '</select>';
}

function save_presenter_metadata( $post_id ) {
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
 
	if ( isset( $_POST['presenter_credit'] ) ) {
        update_post_meta( $post_id, 'presenter_credit', strip_tags( $_POST['presenter_credit'] ) );
    }
	
	if ( isset( $_POST['presenter_featured_orderby'] ) ) {
        update_post_meta( $post_id, 'presenter_featured_orderby', strip_tags( $_POST['presenter_featured_orderby'] ) );
    }
}
add_action('save_post', 'save_presenter_metadata');

function presenters_shordcode($atts) {
	extract(shortcode_atts(array(
		'class' => 'presenter',
		'size' => '150',
		'showname' => 'true',
		'showtype' => 'true',
		'imageonly' => 'false',
		'showcredit' => 'false',
		'numtoshow' => '-1',
		'showmore' => 'false'
	), $atts));
	
	$html = '';

	$args = array('post_type' => 'awards_presenters',
		'meta_key' => 'presenter_featured_orderby',
		'orderby' => 'meta_value_num title',
        'order' => 'ASC',
		'posts_per_page' => $numtoshow,
	 );

	$loop = new WP_Query($args);
	if($loop->have_posts()) {
		while($loop->have_posts()) : $loop->the_post();		
			$feat_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_id() ) );
			if ( $showname == 'true' && $imageonly == 'true' ) {
				$html .=  '<div class="' . $class . '"><a href="' . get_permalink() . '"><img alt="' . get_the_title() . '" src="' . $feat_image . '" width="' . $size . '" height="' . $size . '" /><span>' . get_the_title() . ' Full Bio</span></a>';
			} else {
				$html .=  '<div class="' . $class . '"><a href="' . get_permalink() . '"><img alt="' . get_the_title() . '" src="' . $feat_image . '" width="' . $size . '" height="' . $size . '" /></a>';
			}
			if($imageonly == 'false') {
				if ($showname == 'true') {
					$html .= '<h4>' . get_the_title() . '</h4>';
				}
				if ( $showtype == 'true' ) {
					$guestType = strip_tags(get_the_term_list( $post->ID, 'awards_guest_type', '', ', ', '' ));
					$html .= '<h6>' . $guestType . '</h6>';
				}
				if ($showcredit == 'true') {
					$credit = get_post_meta( get_the_id(), 'presenter_credit', true);
				$html .= '<div class="presenter-credit">' . $credit . '</div>';
				}
			}
			$html .= '</div>';
		endwhile;
		if ($showmore == 'true') {
			$html .= '<div class="more-featured-presenter"><a href="/guests/"><img width="' . $size . '" height="' . $size . '" src="' . 
						get_template_directory_uri()  . '/images/btn_more_thumbnail.png" /></a></div>';
		}
	}

	wp_reset_postdata();
	return $html;
}
add_shortcode( 'presenters' , 'presenters_shordcode' );

function awards_presenters_columns($columns) {
	$columns[ 'presenter_featured_orderby' ] = __( 'Featured Order', 'thegeekieawards' );
	$columns[ 'presenter_image' ] = __( 'Image', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_presenters_columns', 'awards_presenters_columns' );

function presenters_custom_columns($column,$id) {
    switch ($column) {
    	case 'presenter_featured_orderby':
    		$orderby = get_post_meta($id, 'presenter_featured_orderby', true);
    		if ($orderby == 999) { echo 'Not Featured'; } else { echo $orderby; }
    		break;
        case 'presenter_image':
           echo the_post_thumbnail( 'thumbnail' ); 
           break;
        default:
            break;
    }
}
add_action("manage_posts_custom_column", "presenters_custom_columns",10,2);

function featured_presenters_shordcode($atts) {
	extract(shortcode_atts(array(
		'featuredimage' => get_template_directory_uri() . '/images/testFeaturedPresenter.jpg',
		'featuredurl' => '/',
		'featuredtitle' => 'Test 123',
		'featuredcredit' => 'test 456'
	), $atts));
	
	$html = '<div class="featured-presenters"><h1>Host & Presenters</h1><div class="featured-large featured-presenter-pad-right"><a href="' . $featuredurl . '"><img width="414" height="186" src="' . $featuredimage . '" /></a><h3>' . $featuredtitle . '</h3><p>' . get_excerpt_from_content_by_char_length($featuredcredit, 60) . '</p></div>';

	$args = array('post_type' => 'awards_presenters',
		'meta_key' => 'presenter_featured_orderby',
		'orderby' => 'meta_value_num',
        'order' => 'ASC',
		'posts_per_page' => -1
	 );

	$loop = new WP_Query($args);
	if($loop->have_posts()) {
		$count = 2;
		while($loop->have_posts()) : 
			$loop->the_post();
			$orderby = get_post_meta( get_the_id() , 'presenter_featured_orderby', true);
			if ($orderby != '') {
				$count++;
				$feat_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_id() ) );
				$credit = get_excerpt_from_content_by_char_length(get_post_meta( get_the_id() , 'presenter_credit', true), 30);
				$class = 'featured';
				if ($count % 3 != 0) $class .= ' featured-presenter-pad-right';
				$html .=  '<div class="' . $class . '"><a href="' . get_permalink() . '"><img alt="' . get_the_title() . '" src="' . $feat_image . '" width="186" height="186" /></a><h3>' . get_the_title() . '</h3><p>' . $credit . '</p>';
				$html .= '</div>';
			}
		endwhile;
	}
	wp_reset_postdata();
	$html .= '<div class="more-featured-presenter"><a href="/presenters"><img width="206" height="206" src="' . get_template_directory_uri()  . '/images/btn_more_thumbnail.png" /></a></div></div>';
	
	return $html;
}
add_shortcode( 'featured_presenters' , 'featured_presenters_shordcode' );


?>