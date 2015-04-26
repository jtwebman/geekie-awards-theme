<?php
class SubpageListWidget extends WP_Widget
{
  function SubpageListWidget()
  {    
  	$this->WP_Widget('SubpageListWidget', 'Subpage List Widget');
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'parent_page_id' => '' ) );
    $parent_page_id = $instance['parent_page_id'];
	
	$args = array(
		'sort_order' => 'ASC',
		'sort_column' => 'post_title',
		'hierarchical' => 1,
		'exclude' => '',
		'include' => '',
		'meta_key' => '',
		'meta_value' => '',
		'authors' => '',
		'child_of' => 0,
		'parent' => -1,
		'exclude_tree' => '',
		'number' => '',
		'offset' => 0,
		'post_type' => 'page',
		'post_status' => 'publish'
	); 
	$pages = get_pages($args); 
?>
  <p><label for="<?php echo $this->get_field_id('parent_page_id'); ?>">Parent Page: <select class="widefat" id="<?php echo $this->get_field_id('parent_page_id'); ?>" name="<?php echo $this->get_field_name('parent_page_id'); ?>">
<?php foreach ($pages as $page) { ?>
<option value="<?php echo $page->ID ?>"<?php echo ($parent_page_id == $page->ID ? "selected=\"selected\"" : "") ?>><?php echo $page->post_title?></option>
<?php } ?>
  </select></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['parent_page_id'] = $new_instance['parent_page_id'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $parent_page_id = empty($instance['parent_page_id']) ? 0 : $instance['parent_page_id'];
 
    $args = array(
		'sort_order' => 'ASC',
		'sort_column' => 'post_title',
		'hierarchical' => 1,
		'exclude' => '',
		'include' => '',
		'meta_key' => '',
		'meta_value' => '',
		'authors' => '',
		'child_of' => 0,
		'parent' => $parent_page_id,
		'exclude_tree' => '',
		'number' => '',
		'offset' => 0,
		'post_type' => 'page',
		'post_status' => 'publish'
	); 
	$pages = get_pages($args); 
	
	echo "<ul class=\"subpage-list-widget\">";
	
	$count = 1;
	foreach ($pages as $page) {
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id( $page->ID ) );
		$class = $count % 4 == 0 ? " class=\"last\"" : "";
		echo "<li" . $class . "><a href=\"" . get_permalink( $page->ID ) . "\"><img class=\"thumbnail\" src=\"" . $feat_image . "\" alt=\"" . $page->post_title . "\" border=\"0\" /></a><h6>" . $page->post_title . "</h6></li>";
		$count += 1;
	}
	
	echo "</ul><div style=\"clear: both;\"></div>";
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("SubpageListWidget");') );?>
