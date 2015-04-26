<?php
/*
 * This makes the judges side bar widget
*/
 
 
class JudgeWidget extends WP_Widget
{
  function JudgeWidget()
  {
    $widget_ops = array('classname' => 'JudgeWidget', 'description' => 'Displays all the judges images.' );
    $this->WP_Widget('JudgeWidget', 'Judge Images', $widget_ops);
  }
 
  function form($instance)
  {
    $defaults = array( 'title' => __('Judges', 'thegeekieawards'), 'class' => 'judge-side', 'size' => '90', 'showname' => false );  
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>  
    <p>  
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'thegeekieawards'); ?></label>  
        <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />  
    </p>  
    <p>  
        <label for="<?php echo $this->get_field_id( 'class' ); ?>"><?php _e('Class:', 'thegeekieawards'); ?></label>  
        <input id="<?php echo $this->get_field_id( 'class' ); ?>" name="<?php echo $this->get_field_name( 'class' ); ?>" value="<?php echo $instance['class']; ?>" style="width:100%;" />  
    </p>
    <p>  
        <label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e('Size:', 'thegeekieawards'); ?></label>  
        <input id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>" value="<?php echo $instance['size']; ?>" style="width:100%;" />  
    </p>
    <p>  
        <input class="checkbox" type="checkbox" <?php checked( $instance['showname'], true ); ?> id="<?php echo $this->get_field_id( 'showname' ); ?>" name="<?php echo $this->get_field_name( 'showname' ); ?>" />   
        <label for="<?php echo $this->get_field_id( 'showname' ); ?>"><?php _e('Show Name', 'thegeekieawards'); ?></label>  
    </p>  
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
	$instance['class'] = strip_tags($new_instance['class']);
	$instance['size'] = strip_tags($new_instance['size']);
	$instance['showname'] = $new_instance['showname'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
	extract($args);
	
	$title = apply_filters('widget_title', $instance['title'] );  
	$class = $instance['class'];
	$size = $instance['size'];
	$showname = $instance['showname'];
	
	echo $before_widget;  
	
	// Display the widget title   
	if ( $title )  
		echo $before_title . $title . $after_title;  
	 
	if (isset($class)) 
		$class = ' class="' . $class . '"';
	else
		$class = '';
	
	if (isset($size)) 
		$size = ' size="' . $size . '"';
	else
		$size = '';
		
	if (isset($showname)) 
		$showname = ' showname="' . $showname ? 'true' : 'false' . '"';
	else
		$showname = ' showname="false"';

	echo do_shortcode('[judges' . $class .$size . $showname .']'); 
	  
	echo $after_widget; 
  }
 
}

function register_judges_widget() {
	register_widget( 'JudgeWidget' ); 
}

add_action( 'widgets_init', 'register_judges_widget' );

?>