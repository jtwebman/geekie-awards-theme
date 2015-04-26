<?php
/*
 * This makes the judges side bar widget
*/
 
 
class PresenterWidget extends WP_Widget
{
  function PresenterWidget()
  {
    $widget_ops = array('classname' => 'PresenterWidget', 'description' => 'Displays all the special guest images.' );
    $this->WP_Widget('PresenterWidget', 'Special Guests', $widget_ops);
  }
 
  function form($instance)
  {
    $defaults = array( 'title' => __('Presenters', 'thegeekieawards'), 'class' => 'presenter-side', 'size' => '90', 'showname' => false );  
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
        <input class="checkbox" type="checkbox" <?php checked( $instance['imageonly'], 'on' ); ?> id="<?php echo $this->get_field_id( 'imageonly' ); ?>" name="<?php echo $this->get_field_name( 'imageonly' ); ?>" />   
        <label for="<?php echo $this->get_field_id( 'imageonly' ); ?>"><?php _e('Image Only', 'thegeekieawards'); ?></label>  
    </p>  
    <p>  
        <input class="checkbox" type="checkbox" <?php checked( $instance['showname'], 'on' ); ?> id="<?php echo $this->get_field_id( 'showname' ); ?>" name="<?php echo $this->get_field_name( 'showname' ); ?>" />   
        <label for="<?php echo $this->get_field_id( 'showname' ); ?>"><?php _e('Show Name', 'thegeekieawards'); ?></label>  
    </p>  
    <p>  
        <input class="checkbox" type="checkbox" <?php checked( $instance['showtype'], 'on' ); ?> id="<?php echo $this->get_field_id( 'showtype' ); ?>" name="<?php echo $this->get_field_name( 'showtype' ); ?>" />   
        <label for="<?php echo $this->get_field_id( 'showtype' ); ?>"><?php _e('Show Type', 'thegeekieawards'); ?></label>  
    </p>
    <p>  
        <input class="checkbox" type="checkbox" <?php checked( $instance['showcredit'], 'on' ); ?> id="<?php echo $this->get_field_id( 'showcredit' ); ?>" name="<?php echo $this->get_field_name( 'showcredit' ); ?>" />   
        <label for="<?php echo $this->get_field_id( 'showcredit' ); ?>"><?php _e('Show Credits', 'thegeekieawards'); ?></label>  
    </p>  
    <p>  
        <label for="<?php echo $this->get_field_id( 'numtoshow' ); ?>"><?php _e('Number to Show (-1 = all):', 'thegeekieawards'); ?></label>  
        <input id="<?php echo $this->get_field_id( 'numtoshow' ); ?>" name="<?php echo $this->get_field_name( 'numtoshow' ); ?>" value="<?php echo $instance['numtoshow']; ?>" style="width:100%;" />  
    </p>
    <p>  
        <input class="checkbox" type="checkbox" <?php checked( $instance['showmore'], 'on' ); ?> id="<?php echo $this->get_field_id( 'showmore' ); ?>" name="<?php echo $this->get_field_name( 'showmore' ); ?>" />   
        <label for="<?php echo $this->get_field_id( 'showmore' ); ?>"><?php _e('Show More Button', 'thegeekieawards'); ?></label>  
    </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
	$instance['class'] = strip_tags($new_instance['class']);
	$instance['size'] = strip_tags($new_instance['size']);
	$instance['imageonly'] = $new_instance['imageonly'];
	$instance['showname'] = $new_instance['showname'];
	$instance['showtype'] = $new_instance['showtype'];
	$instance['showcredit'] = $new_instance['showcredit'];
	$instance['numtoshow'] = strip_tags($new_instance['numtoshow']);
	$instance['showmore'] = $new_instance['showmore'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
	extract($args);
	
	$title = apply_filters('widget_title', $instance['title'] );  
	$class = $instance['class'];
	$size = $instance['size'];
	$imageonly = $instance['imageonly'];
	$showname = $instance['showname'];
	$showtype = $instance['showtype'];
	$showcredit = $instance['showcredit'];
	$numtoshow = $instance['numtoshow'];
	$showmore = $instance['showmore'];
	
	$shortcode = '[presenters';

	echo $before_widget;  
	
	// Display the widget title   
	if ( $title )  
		echo $before_title . $title . $after_title;  
	 
	if (isset($class)) 
		$shortcode .= ' class="' . $class . '"';
	
	if (isset($size)) 
		$shortcode .= ' size="' . $size . '"';

	if (isset($imageonly)) 
		$shortcode .= ' imageonly="' . ($imageonly ? 'true' : 'false') . '" ';
	else
		$shortcode .= ' imageonly="false"';
		
	if (isset($showname)) 
		$shortcode .= ' showname="' . ($showname ? 'true' : 'false') . '"';
	else
		$shortcode .= ' showname="false"';

	if (isset($showtype)) 
		$shortcode .= ' showtype="' . ($showtype ? 'true' : 'false') . '"';
	else
		$shortcode .= ' showtype="false"';

	if (isset($showcredit)) 
		$shortcode .= ' showcredit="' . ($showcredit ? 'true' : 'false') . '"';
	else
		$shortcode .= ' showcredit="false"';

	if (isset($numtoshow)) 
		$shortcode .= ' numtoshow="' . $numtoshow . '"';
	else
		$shortcode .= ' numtoshow="-1"';

	if (isset($showmore)) 
		$shortcode .= ' showmore="' . ($showmore ? 'true' : 'false') . '"';
	else
		$shortcode .= ' showmore="false"';

	$shortcode .= ']';

	echo do_shortcode($shortcode); 
	  
	echo $after_widget; 
  }
 
}

function register_presenters_widget() {
	register_widget( 'PresenterWidget' ); 
}

add_action( 'widgets_init', 'register_presenters_widget' );

?>