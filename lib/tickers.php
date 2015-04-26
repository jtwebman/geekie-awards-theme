<?php

function create_tickers_post_types() {
		
	register_post_type( 'awards_tickers',
		array(
			'labels' => array(
				'name' => __( 'Tickers' , 'thegeekieawards' ),
				'singular_name' => __( 'Ticker' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Ticker' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Ticker' , 'thegeekieawards' ),
				'new_item' => __( 'New Ticker' , 'thegeekieawards' ),
				'view_item' => __( 'View Ticker' , 'thegeekieawards' ),
				'search_items' => __( 'Search Tickers' , 'thegeekieawards' ),
				'not_found' => __( 'No tickers found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No tickers found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Tickers for the awards show ticker bar.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'tickers' , 'with_front' => false),
			'supports' => array( 'title' ),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_ticker_metaboxes'
		)
	);

}
add_action( 'init', 'create_tickers_post_types' );

function add_ticker_metaboxes() {
	add_meta_box('ticker_url_box', __( 'Ticker URL', 'thegeekieawards' ), 'add_ticker_url_box', 'awards_tickers', 'normal', 'default');
	add_meta_box('ticker_orderby_box', __( 'Ticker Order', 'thegeekieawards' ), 'add_ticker_orderby_box', 'awards_tickers', 'normal', 'default');
}

function add_ticker_url_box($post) {

	$url = get_post_meta($post->ID, 'ticker_url', true);

	echo '<input type="text" class="admin-input-full-width" name="ticker_url" maxlength="255" value="' . $url . '" id="ticker_url" autocomplete="off">';
}

function add_ticker_orderby_box($post) {
	$orderby = get_post_meta($post->ID, 'ticker_orderby', true);
	
	echo '<select name="ticker_orderby" id="ticker_orderby">';
	for ($i = 1;$i < 101;$i++) 
	{ 
		$selected = $orderby == $i ? " selected" : "";
		echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>'; 
	}
		
    echo '</select>';
}

function save_ticker_metadata( $post_id ) {
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
 
 	if ( isset( $_POST['ticker_url'] ) ) {
        update_post_meta( $post_id, 'ticker_url', strip_tags( $_POST['ticker_url'] ) );
    }
	
	if ( isset( $_POST['ticker_orderby'] ) ) {
        update_post_meta( $post_id, 'ticker_orderby', strip_tags( $_POST['ticker_orderby'] ) );
    }
}
add_action('save_post', 'save_ticker_metadata');

function ticker_orderby_filter($orderby, &$query){
    global $wpdb;
    if (get_query_var("post_type") == "awards_tickers" && get_query_var("orderby") == "" ) {	
         return "CAST($wpdb->postmeta.meta_value  AS SIGNED) ASC";
    }
    return $orderby;
 }
add_filter( 'posts_orderby', 'ticker_orderby_filter', 10, 2);

function ticker_join_filter($join){
    global $wpdb, $wp_query;
    if (get_query_var("post_type") == "awards_tickers" && get_query_var("orderby") == "" ) {	
         $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'ticker_orderby'";
    }
    return $join;
 }
add_filter( 'posts_join', 'ticker_join_filter', 10, 1);

function awards_tickers_columns($columns) {
	$columns[ 'ticker_url' ] = __( 'URL', 'thegeekieawards' );
	$columns[ 'ticker_orderby' ] = __( 'Order By', 'thegeekieawards' );
    return $columns;
}
add_filter( 'manage_edit-awards_tickers_columns', 'awards_tickers_columns' );

function tickers_custom_columns($column,$id) {
    switch ($column) {
        case 'ticker_url':
			$url = get_post_meta($id, 'ticker_url', true); 
	   		echo '<a href="' . $url . '" target="_blank">' . $url . '</a>';
	   		break;
		case 'ticker_orderby':
           echo get_post_meta($id, 'ticker_orderby', true);
           break;
        default:
            break;
    }
}
add_action("manage_posts_custom_column", "tickers_custom_columns",10,2);

function ticker_ui() {
	$html = '<div id="ticker-container"><div id="ticker-sub"><a href="http://visitor.r20.constantcontact.com/manage/optin?v=001hVeN8HUUPDWOcTeArVM9MyiF1KjMkhHRfBWgxzDshBZv_cnG7Wxmg6GYMSDFk1PUjeeDvpwEBRpFE1_kDZ_Z4JMx4r6zrtA2hZ0RkvQl9YkrF0dL_Guy-y1CQYcFIJtyePy2qE3f7p3SJgrXT22daqNGgj14OPu_TYVUGzYCRZw="><img width="193" height="38" src="' . get_template_directory_uri() . '/images/ticker_subscribe.png" /></a></div><ul id="makeMeScrollable">';

	$args = array('post_type' => 'awards_tickers',
		'meta_key' => 'ticker_orderby',
		'orderby' => 'meta_value_num',
        'order' => 'ASC',
		'posts_per_page' => -1
	 );

	$myposts = get_posts($args);
	$has_one = false;
	
	foreach( $myposts as $post ) : 
		$has_one = true;
		$ticker_url = get_post_meta( $post->ID, 'ticker_url', true);
		$html .=  '<li class="ticker"><a href="' . $ticker_url . '"><div>' . $post->post_title . '</div></a></li>';
	endforeach;
	
	$html .= '</ul></div>';
	
	if ($has_one) 
		return $html;
	else 
		return '';
}

?>