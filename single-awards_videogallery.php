<?php
/**
 * The Template for displaying all single video gallary posts.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */

get_header(); ?>
	<div id="primary" class="site-content full-width">
		<div id="content" role="main">
        	<script type="text/javascript">postid = <?php the_ID(); ?> ;</script>
        	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="featured_area">
                    <ul id="menu-videocategories" class="menu">
                        <?php
                        $loop = new WP_Query(array('post_type' => 'awards_videogallery',
                            'orderby' => 'meta_value_num', 
                            'order' => 'asc',
                            'meta_key' => 'video_orderby', 
                            'nopaging' => true,
                         ));
                        if($loop->have_posts()) {
                            while($loop->have_posts()) : $loop->the_post();	?>
                            <li><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                            <?php
                            endwhile;
                        }
                        wp_reset_postdata();
                    ?>
                    </ul>
                    <?php while ( have_posts() ) : the_post(); 
                        $videos = get_post_meta(get_the_ID(), 'videogallery_videos', true);
                        $featuredVideo = get_post_meta(get_the_ID(), 'videogallery_featured', true);
						echo '<iframe width="980" height="552" src="' . $featuredVideo['embedurl'] . '" allowfullscreen="" id="video-player-iframe"></iframe>';
                        ?>
                    <h4 id="video-player-title"><?php echo $featuredVideo['title']; ?></h4>
                    <div id="video-social"><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $featuredVideo['url']; ?>" data-text="<?php echo $featuredVideo['title']; ?>" data-via="TheGeekieAwards" data-hashtags="RUGeekie">Tweet</a><div class="fb-like" data-href="<?php echo $featuredVideo['url']; ?>" data-width="50" data-layout="button_count" data-show-faces="true" data-send="true"></div></div>
                    <div style="clear:both;"></div>
                    <?php $reg_exUrl = "(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])i"; ?>
					<div id="video-player-description"><?php echo preg_replace($reg_exUrl, '<a href="$0" target="_blank">$0</a> ', $featuredVideo['description']); ?></div>
                </div>
                <h1 id="additional-videos">Additional Videos</h1>
                <div class="video-gallary">
					<?php $count = 0;
					foreach($videos as $video) { 
						$count++; ?>
						<div class="<?php if ($count % 3 == 0) { echo 'video-gallary-video-line-end'; } else  { echo 'video-gallary-video'; } ?>">
                        	<div class="video-gallary-video-thumbnail"><a href="<?php echo get_permalink() . $video['orderid']; ?>/"><img src="<?php echo $video['thumbnailurl']; ?>" alt="<?php echo $video['title']; ?>" class="video-gallary-video-img" /></a></div>
                        	<div class="video-gallary-title"><?php echo $video['title']; ?></div>
                        </div>
					<?php if ($count % 3 == 0) {
							echo '<div style="clear:both;"></div>';
						}
					} ?>
                </div>
                <?php endwhile; // end of the loop. ?>
			</article>
		</div><!-- #content -->
	</div><!-- #primary -->
    
<?php get_footer(); ?>