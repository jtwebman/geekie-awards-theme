<?php

class CustomPostType {
	public $name;
	public $single_name;
	public $post_type_name;
	public $rewrite;
	public $is_public = true;
	public $has_archive = true;
	public $supports = array( 'title', 'editor', 'thumbnail' );
	public $hierarchical = false;
	public $exclude_from_search = false;
	public $publicly_queryable = true;
	public $menu_position = 25;
	public $menu_icon = NULL;
	public $capability_type = 'post';
	public $taxonomies = array();
	
	/* Class constructor */
	public function __construct( $name , $single_name , $rewrite )
	{
		if ( !isset( $name ) ) throw new Exception('You must pass in a name into CustomPostType.');
		if ( !isset( $single_name ) ) throw new Exception('You must pass in a single_name into CustomPostType.');
		if ( !is_array( $rewrite ) ) throw new Exception('You must pass in a rewrite array into CustomPostType.');
		
		$this->name = $name;
		$this->single_name = $single_name;
		$this->post_type_name = strtolower( str_replace( ' ', '_', $name ) );
		$this->rewrite = $rewrite;

		add_action( 'init', array( &$this, 'register_post_type' ) );
	}
	
	function register_post_type() {
		register_post_type( $this->post_type_name,
			array(
				'labels' => array(
					'name' => $this->name,
					'singular_name' => $this->single_name,
					'menu_name' => $this->name,
					'all_items' => $this->name,
					'add_new' => _x('Add New', $this->post_type_name ),
					'add_new_item' => str_replace('%1', $this->single_name , __( 'Add New %1' ) ), 
					'edit_item' => str_replace('%1', $this->single_name , __( 'Edit %1' ) ),
					'new_item' => str_replace('%1', $this->single_name , __( 'New %1' ) ),
					'view_item' => str_replace('%1', $this->single_name , __( 'View %1' ) ),
					'search_items' => str_replace('%1', $this->name , __( 'Search %1' ) ),
					'not_found' => str_replace('%1', $this->name , __( 'No %1 found.' ) ),
					'not_found_in_trash' => str_replace('%1', $this->name , __( 'No %1 found in Trash.' ) ),
				),
				'public' => $this->is_public,
				'has_archive' => $this->has_archive,
				'rewrite' => $this->rewrite,
				'supports' => $this->supports,
				'hierarchical' => $this->hierarchical,
				'exclude_from_search' => $this->exclude_from_search,
				'publicly_queryable' => $this->publicly_queryable,
				'menu_position' => $this->menu_position,
				'menu_icon' => $this->menu_icon,
				'capability_type' => $this->capability_type,
				'taxonomies' => $this->taxonomies,
				'register_meta_box_cb' => array( &$this, 'add_metaboxes' ),
			)
		);
	}
	
	function add_metaboxes() {
		
	}
}