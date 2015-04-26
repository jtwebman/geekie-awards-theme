<?php
/*
 * This makes the news post types sidebar widget
*/
 
 
class NewsPostFeaturedWidget extends WP_Widget
{
  function NewsPostFeaturedWidget()
  {
    $widget_ops = array('classname' => 'news-post-featured-widget', 'description' => 'Display the latest 4 featured news posts.' );
    $this->WP_Widget('NewsPostFeaturedWidget', 'Featured News Posts', $widget_ops);
  }
 
  function form($instance)
  {
    $defaults = array( 'title' => __('Featured News', 'thegeekieawards'), 'class' => 'widget_sub_categories');  
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
		
	$args = array( 'post_type' => 'awards_news',
		'orderby' => 'date', 
		'order' => 'DESC',
		'posts_per_page'  => 4, 
		'meta_key' => 'news_featured', 
		'meta_value' => true );
	$posts = get_posts( $args );
	
	$this->display_featured_news_posts($posts);
	  
	echo $after_widget; 
  }
  
  function display_featured_news_posts($posts) {
	if (!empty($posts)) {
		$count = 0;
		foreach($posts as $post) {
			$count++;
			$news_post_url = get_permalink( $post->ID );
			if ($count == 1) {
				$feat_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
				echo '<a href="' . $news_post_url . '"><div class="featured-image-new-post">';
				echo '<img width="300" src="' . $feat_image . '" />';
				echo '<h6>' . $post->post_title . '</h6>';
				echo '<p class="featured-date">' . get_the_date( 'n/j/Y', $post->ID  ) . '</d>';
				echo '<p class="featured-text">' . get_excerpt_from_content_by_char_length($post->post_content, 120) . '</d>';
				echo '</div></a>';
			} else {
				echo '<a href="' . $news_post_url . '"><div class="featured-new-post">';
				echo '<h6>' . $post->post_title . '</h6>';
				echo '<p class="featured-date">' . get_the_date( 'n/j/Y', $post->ID  ) . '</d>';
				echo '<p class="featured-text">' . get_excerpt_from_content_by_char_length($post->post_content, 40) . '</d>';
				echo '</div></a>';
			}
		}
		echo '<div class="more-new"><a href="/news/">&nbsp;</a></div><div style="clear:both"></div>';
	}
  }
 
}

function register_news_featured_widget() {
	register_widget( 'NewsPostFeaturedWidget' ); 
}

add_action( 'widgets_init', 'register_news_featured_widget' );

?>