<?php
/*
 * This makes the news post types sidebar widget
*/


class NewsPostTypesWidget extends WP_Widget
{
  function NewsPostTypesWidget()
  {
    $widget_ops = array('classname' => 'news-post-types-widget', 'description' => 'Displays all the news post types as a category list.' );
    $this->WP_Widget('NewsPostTypesWidget', 'News Post Type List', $widget_ops);
  }

  function form($instance)
  {
    $defaults = array( 'title' => __('News Categories', 'thegeekieawards'), 'class' => 'widget_sub_categories');
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>

    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'thegeekieawards'); ?></label>
        <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
    </p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

  function widget($args, $instance)
  {
	extract($args);

	$title = apply_filters('widget_title', $instance['title'] );

	echo $before_widget;

	// Display the widget title
	if ( $title )
		echo $before_title . $title . $after_title;  

	$args = array( 'hide_empty' => false , 'orderby' => 'name', 'order' => 'ASC', 'parent' => 0 );
	$allterms = get_terms( array ('awards_news_type') , $args );

	$this->display_terms($allterms);

	echo $after_widget;
  }

  function display_terms($allterms) {
	if (!empty($allterms)) {
		echo '<ul>';
		foreach($allterms as $term) {
			echo '<li class="cat-item cat-item-' . $term->term_id . '"><a href="' . get_term_link($term) . '">' . $term->name . '</a></li>';

			$args = array( 'hide_empty' => false , 'orderby' => 'name', 'order' => 'ASC', 'parent' => $term->term_id);
			$terms = get_terms( array ('awards_news_type') , $args );

			$this->display_terms($terms);
		}
		echo '</ul>';
	}
  }

}

function register_news_widget() {
	register_widget( 'NewsPostTypesWidget' );
}

add_action( 'widgets_init', 'register_news_widget' );

?>
