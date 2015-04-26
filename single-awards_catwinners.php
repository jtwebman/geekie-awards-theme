<?php
/**
 * The Template for displaying all single category winner posts.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 4.0
 */

get_header(); 
while ( have_posts() ) {
	the_post(); 
	$post_id = get_the_ID();

	$background = 'images/margin_bkgd2.jpg';
	$winner_background_id = get_post_meta( $post_id  , 'winner_background' , true );
	if ( !empty( $winner_background_id ) ) 
	{
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $winner_background_id  ), 'full' );
		$background = $image[0];
	}

	$header = '';
	$winner_header_id = get_post_meta( $post_id  , 'winner_header' , true );
	if ( !empty( $winner_header_id ) ) 
	{
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $winner_header_id  ), 'full' );
		$header = $image[0];
	}

	$winner_category_id = get_post_meta( $post_id  , 'winner_category' , true );
	$category_name = get_cat_name( $winner_category_id );

	$winner_year = get_post_meta( $post_id  , 'winner_year' , true );
	$winner_title = '';
	$winner_video = get_post_meta( $post_id  , 'winner_video' , true );

	$winner_subtitle = get_post_meta( $post_id  , 'winner_subtitle' , true );
	$imageFolder = get_template_directory_uri() . '/images/';
	?>
	<style >
		#main {
			background: #8a9aa7 url(<?php echo $background ?>) center top no-repeat fixed;
		}

		#sponsored-header {
			background: url(<?php echo $header ?>) no-repeat;
			background-size: cover;
		}

	</style>
	<div id="sponsored-header">
		<div id="flag-header">
			<table id="flag-table">
				<tr id="flag-table-top-row">
					<td rowspan="2" id="flag-left-header"></tb>
					<td><h1><?php echo get_the_title(); ?></h1></td>
					<td id="flag-right-header"></tb>
				</tr>
				<?php if (!empty($winner_subtitle)) { ?>
				<tr id="flag-table-bottom-row">
					<td colspan="2">
						<table id="subflag-table">
							<tr>
								<td><h2><?php echo $winner_subtitle; ?></h2></td>
								<td id="subflag-right-header"></td>
							</tr>
						</table>
					</td>
				</tr>
				<?php } ?>
			</table>
			<span id="subflag-left-header"></span><span id="flag-right-header"></span>
		</div>
	</div>
	<div class="site-content">
		<div class="top-content">
			<?php

			$args = array('nopaging' => 'true',
				'meta_key' => 'winner_category',
				'meta_value' => $post_id
			 );

			$loop = new WP_Query($args);
			while($loop->have_posts()) : $loop->the_post();	
				$winner_title = get_the_title( $post->ID );  ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php printf(__('%s %s Winner'), $winner_year, $category_name) ?></h1>
					</header>
					<div class="socialbar">
	                    <div class="socialshare">Share:</div>
	                    <div class="twitter-share socialshare"><a href="https://twitter.com/share" class="twitter-share-button" data-via="TheGeekieAwards" data-related="Nedopak" data-url="<?php echo get_permalink() ?>" data-lang="en">Tweet</a></div>
	                    <div class="fb-like socialshare" data-href="<?php echo get_permalink() ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
	                    <div class="socialshare"><div class="g-plusone" data-size="medium" data-annotation="bubble" data-href="<?php echo get_permalink() ?>"></div></div>
	                </div>
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
					</div>
					<div class="entry-content-text">
						<h1 class="entry-title"><?php echo $winner_title; ?></h1>
						<p><?php echo wp_trim_excerpt( '' ); ?></p>
	                    <a href="<?php echo get_permalink(); ?>" class="middle-button"><span class="middle-right"></span>More</a>
					</div>
				</article>

			<?php endwhile; 

			wp_reset_postdata(); ?>
		</div>
	</div>
	<div id="primary" class="site-content leftside">
		<div id="content" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if ( !empty( $winner_video ) ) { ?>
				<header class="entry-header">
					<h1 class="entry-title"><?php printf(__('%s Wins a %s Geekie'), $winner_title, $winner_year) ?></h1>
				</header>
				<p><?php echo wp_oembed_get($winner_video, array('width'=>650,'height'=>366)); ?></p>
				<?php } ?>

				<h2><?php echo $winner_year; ?> Nominees</h2>

				<?php
				$args = array('orderby' => 'rand', 
					'nopaging' => 'true',
					'meta_key' => 'nominated_category',
					'meta_value' => get_categorynominee_post_Id_from_categorywinner($post_id)
				 );

				$loop = new WP_Query($args);
				$count = 0;
				while($loop->have_posts()) : $loop->the_post();	$count++; ?>
					<article id="post-<?php the_ID(); ?>" <?php if ($count % 2 == 0) post_class('category-post-last'); else post_class('category-post'); ?>>
	                    <div style="position: relative;">
	                        <div class="post-elements">
	                            <ul>
	                              <?php if ( get_post_meta($post->ID, 'mp3', true) ) { ?> 
	                              <li>
	                              <a class="fancybox" href="#<?php the_ID(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/post-music.png" alt=""></a>
	                              </li>
	                              <div style="display: none;">
	                                <div id="<?php the_ID(); ?>" style="overflow:auto;">
	                                    <audio controls>
	                                        <source src="<?php echo get_post_meta(get_the_ID(), "mp3", $single = true); ?>" type="audio/mpeg">
	                                        Your browser does not support the audio element.
	                                    </audio>
	                                </div>
	                              </div>
	                              <?php } ?>            
	                              
	                              <?php if ( get_post_meta($post->ID, 'video', true) ) { ?>   
	                              <li><a class="fancybox fancybox.iframe" href="<?php echo get_post_meta(get_the_ID(), "video", $single = true); ?>" title="Watch Video!"><img src="<?php bloginfo('template_directory'); ?>/images/post-video.png" alt=""></a>
	                              </li>
	                              <?php } ?>          
	                            </ul>
	                          </div>
	                        <figure class="featured-small"><?php the_post_thumbnail('thumbnail', array('class' => 'category-thumbnail')); ?></figure>
	                    </div>
	                    <header class="entry-header">
	                        <h1 class="entry-title"><?php the_title(); ?></h1>
	                    </header><!-- .entry-header -->
	                    <div class="category-list">Posted In <?php echo get_the_category_list($separator = ','); ?></div>
	                    <div class="entry-summary">
	                        <?php the_excerpt(); ?>
	                    </div><!-- .entry-summary -->
	                    <a href="<?php echo get_permalink(); ?>" class="middle-button"><span class="middle-right"></span>More</a>
	                </article><!-- #post -->
	                <?php if ($count % 2 == 0) :?>
	                    <div style="clear:both;">&nbsp;</div>
	                <?php endif; ?>
				<?php endwhile;
				wp_reset_postdata(); ?>
				<div style="clear:both;">&nbsp;</div>

				<?php
				$honorargs = array(
					'meta_key' => 'honor_category',
					'meta_value' => $winner_category_id,
					'post_type' => 'awards_cathonors'
				 );

				$count = 0;

				$honorloop = new WP_Query($honorargs);

				if ( $honorloop->have_posts() ) { 
					foreach ( $honorloop->posts as $honorpost ) :
						$postargs = array(
							'orderby' => 'NAME', 
							'order' => 'ASC',
							'nopaging' => 'true',
							'meta_key' => 'category_honor',
							'meta_value' => $honorpost->ID
						 );
						$postloop = new WP_Query($postargs);
						foreach ( $postloop->posts as $post ) :
							if ($count == 0) {?>
								<header class="entry-header">
									<h1 class="entry-title"><?php printf(__('%s %s Category Honors'), $winner_year, $category_name) ?></h1>
								</header>
							<?php } ?>
							<div class="nominated-content">
								<h2><?php echo $honorpost->post_title; ?></h2>
					            <?php the_post_thumbnail('thumbnail', array('class' => 'nominated-post-thumbnail')); ?>
					            <h3><a href="<?php the_permalink(); ?>"><?php echo $post->post_title; ?></a></h3>
							</div>
							<?php if ($count++ % 2) { ?>
								<div style="clear:both;">&nbsp;</div>
							<?php } ?>
						<?php endforeach;
					endforeach;
				}
				?>
			</article>
		</div>
	</div>
<?php } ?>
<?php get_sidebar('catwinners'); ?>
<?php get_footer(); ?>