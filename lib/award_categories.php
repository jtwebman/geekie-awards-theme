<?php

function create_award_category_post_types() {

	register_post_type( 'awards_categories',
		array(
			'labels' => array(
				'name' => __( 'Award Categories' , 'thegeekieawards' ),
				'singular_name' => __( 'Award Category' , 'thegeekieawards' ),
				'add_new_item' => __( 'Add New Award Category' , 'thegeekieawards' ),
				'edit_item' => __( 'Edit Award Category' , 'thegeekieawards' ),
				'new_item' => __( 'New Award Category' , 'thegeekieawards' ),
				'view_item' => __( 'View Award Category' , 'thegeekieawards' ),
				'search_items' => __( 'Search Award Category' , 'thegeekieawards' ),
				'not_found' => __( 'No award categories found.' , 'thegeekieawards' ),
				'not_found_in_trash' => __( 'No award categories found in Trash.' , 'thegeekieawards' ),
			),
			'description' => __( 'Award categories pages for rules.' , 'thegeekieawards' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'award_categories' , 'with_front' => false),
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'register_meta_box_cb' => 'add_award_categories_metaboxes'
		)
	);

}
add_action( 'init', 'create_award_category_post_types' );

function add_award_categories_metaboxes() {
	add_meta_box('award_category_orderby_box', __( 'Award Category Order', 'thegeekieawards' ), 'award_category_orderby_box', 'awards_categories', 'normal', 'default');
}

function award_category_orderby_box($post) {
	$orderby = get_post_meta($post->ID, 'award_category_orderby', true);

	echo '<select name="award_category_orderby" id="award_category_orderby">';
	for ($i = 1;$i <= 100;$i++)
	{
		$selected = $orderby == $i ? " selected" : "";
		echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
	}
	echo '</select>';
}

function save_awards_category_metadata( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	if ( isset( $_POST['award_category_orderby'] ) ) {
    update_post_meta( $post_id, 'award_category_orderby', strip_tags( $_POST['award_category_orderby'] ) );
  }
}
add_action('save_post', 'save_awards_category_metadata');

function award_categories_shordcode($atts) {
	extract(shortcode_atts(array(
		'class' => 'award-category',
		'rowendclass' => 'award-category-end',
		'size' => '150',
    'numperrow' => '4'
	), $atts));

	$html = '';

  $args = array('post_type' => 'awards_categories',
    'meta_key' => 'award_category_orderby',
    'orderby' => 'meta_value_num title',
    'order' => 'ASC',
    'posts_per_page' => $numtoshow,
  );

	$loop = new WP_Query($args);
	if($loop->have_posts()) {
		$count = 0;
		while($loop->have_posts()) : $loop->the_post();
			$count++;
			$feat_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_id() ) );

			$useClass = $class;
			if (($count % $numperrow) == 0) $useClass = $rowendclass;

			$html .=  '<div class="' . $useClass . '"><a href="' . get_permalink() . '"><img alt="' . get_the_title() . '" src="' . $feat_image . '" width="' . $size . '" height="' . $size . '" /><div>' . get_the_title() . '</div></a></div>';
		endwhile;
	}

	wp_reset_postdata();
	$html .= '<div style="clear:both;"></div>';
	return $html;
}
add_shortcode( 'award_categories' , 'award_categories_shordcode' );

function award_categories_columns($columns) {
	$columns[ 'award_category_image' ] = __( 'Image', 'thegeekieawards' );
  $columns[ 'award_category_orderby' ] = __( 'Order', 'thegeekieawards' );
  return $columns;
}
add_filter( 'manage_edit-awards_categories_columns', 'award_categories_columns' );

function award_categories_custom_columns($column,$id) {
  switch ($column) {
    case 'award_category_orderby':
      echo get_post_meta($id, 'award_category_orderby', true);
      break;
    case 'award_category_image':
      echo the_post_thumbnail( 'thumbnail' );
      break;
    default:
      break;
  }
}
add_action("manage_posts_custom_column", "award_categories_custom_columns",10,2);

?>
