<?php
/*
 * This makes the awards categories side bar widget
*/


class AwardCategoriesMenuWidget extends WP_Widget
{
  function AwardCategoriesMenuWidget()
  {
    $widget_ops = array('classname' => 'widget_nav_menu', 'description' => 'Displays a menu of category pages.' );
    $this->WP_Widget('AwardCategoriesMenuWidget', 'Award Categories', $widget_ops);
  }

  function form($instance)
  {
    $defaults = array( 'title' => __('Award Categories', 'thegeekieawards'), 'class' => 'menu');
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>

    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'thegeekieawards'); ?></label>
        <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'class' ); ?>"><?php _e('Class:', 'thegeekieawards'); ?></label>
        <input id="<?php echo $this->get_field_id( 'class' ); ?>" name="<?php echo $this->get_field_name( 'class' ); ?>" value="<?php echo $instance['class']; ?>" style="width:100%;" />
    </p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
  	$instance['class'] = strip_tags($new_instance['class']);
    return $instance;
  }

  function widget($args, $instance)
  {
  	extract($args);

  	$title = apply_filters('widget_title', $instance['title'] );
  	$class = $instance['class'];

    echo $before_widget;

  	if ( $title )
  		echo $before_title . $title . $after_title;

    echo '<div>';
  	echo '<ul class="' . $class . '">';

    $args = array('post_type' => 'awards_categories',
      'orderby' => 'title',
      'order' => 'ASC'
    );

  	$loop = new WP_Query($args);
  	if($loop->have_posts()) {
  		while($loop->have_posts()) : $loop->the_post();
  			echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
  		endwhile;
  	}

  	wp_reset_postdata();

    echo '</ul>';
    echo '</div>';

  	echo $after_widget;
  }

}

function register_award_categories_menu_widget() {
	register_widget( 'AwardCategoriesMenuWidget' );
}

add_action( 'widgets_init', 'register_award_categories_menu_widget' );

?>
