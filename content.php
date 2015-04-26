<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */
$categories = get_the_category();
$category_name = "";
if ($categories && sizeof($categories) > 0) {
	$category_name = $categories[0]->cat_name;
}
$twitter = get_post_meta($post->ID, 'twitter', true);
if (!isset($twitter ) || trim($twitter )==='') {
	$twitter = 'thegeekieawards';
}
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'thegeekieawards' ); ?>
		</div>
		<?php endif; ?>
		<header class="entry-header">
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="category-list">Posted In <?php echo get_the_category_list($separator = ','); ?></div>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'thegeekieawards' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
		</header><!-- .entry-header -->
		<div class="socialbar">
      <div class="socialshare">Share:</div>
			<div class="socialshare twitter-share "><a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo get_the_title() . ' just entered The Geekie Awards for Best ' . $category_name; ?>" data-via="<?php echo $twitter?>">Tweet</a></div>
      <div class="socialshare fb-like" data-href="<?php echo get_permalink() ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
      <div class="socialshare"><div class="g-plusone" data-size="medium" data-annotation="bubble" data-href="<?php echo get_permalink() ?>"></div></div>
			<div class="socialshare"><a href="//www.pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode(wp_get_attachment_url( get_post_thumbnail_id())); ?>&description=<?php echo get_the_title() . ' just entered The Geekie Awards for Best ' . $category_name; ?>" data-pin-do="buttonPin" data-pin-config="beside" data-pin-color="white"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_white_20.png" /></a></div>
			<div class="socialshare"><a href="http://bufferapp.com/add" class="buffer-add-button" data-text="<?php echo get_the_title() . ' just entered The Geekie Awards for Best ' . $category_name; ?>" data-url="<?php echo get_permalink() ?>" data-count="horizontal" data-via="<?php echo $twitter?>" data-picture="<?php echo wp_get_attachment_url( get_post_thumbnail_id(the_ID())); ?>" ></a></div>
    </div>
		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
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
		<?php endif; ?>
	</article><!-- #post -->
