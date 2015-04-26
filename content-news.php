<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="category-list">Posted In <?php echo get_the_term_list( get_the_ID(), 'awards_news_type', '', ', ', '' ); ?></div>
		</header><!-- .entry-header -->

		<div class="entry-content">
            <div style="position: relative;">
                <div class="post-elements-two">
                    <ul>
                      <?php if ( get_post_meta($post->ID, 'mp3', true) ) { ?> 
                      <li>
                      <a class="fancybox" href="#<?php the_ID(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/post-music.png" alt=""></a>
                      </li>
                      <div style="display: none;">
                        <div id="<?php the_ID(); ?>" style="overflow:auto;">
                        	<audio controls>
                                <source src="<?php echo get_post_meta($post->ID, "mp3", $single = true); ?>" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                      </div>
                      <?php } ?>            
                      
                      <?php if ( get_post_meta($post->ID, 'video', true) ) { ?>   
                      <li><a class="fancybox fancybox.iframe" href="<?php echo get_post_meta($post->ID, "video", $single = true); ?>" title="Watch Video!"><img src="<?php bloginfo('template_directory'); ?>/images/post-video.png" alt=""></a>
                      </li>
                      <?php } ?>          
                    </ul>
                  </div>
            	<figure class="featured"><?php the_post_thumbnail('medium', array('class' => 'post-thumbnail')); ?></figure>
            </div>
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post -->
