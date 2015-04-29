<?php
/**
 * The Template for displaying all single judge post.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 4.0
 */

get_header();
while ( have_posts() ) {
	the_post();
	$post_id = get_the_ID();

	$background = 'images/margin_bkgd3.jpg';
	$nominee_background_id = get_post_meta( $post_id  , 'nominee_background' , true );
	if ( !empty( $nominee_background_id ) )
	{
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $nominee_background_id  ), 'full' );
		$background = $image[0];
	}

	$header = '';
	$nominee_header_id = get_post_meta( $post_id  , 'nominee_header' , true );
	if ( !empty( $nominee_background_id ) )
	{
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $nominee_header_id  ), 'full' );
		$header = $image[0];
	}

	$nominee_category_id = get_post_meta( $post_id  , 'nominee_category' , true );
	$category_name = get_cat_name( $nominee_category_id );

	$nominee_year = get_post_meta( $post_id  , 'nominee_year' , true );

	$nominee_subtitle = get_post_meta( $post_id  , 'nominee_subtitle' , true );
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
				<?php if (!empty($nominee_subtitle)) { ?>
				<tr id="flag-table-bottom-row">
					<td colspan="2">
						<table id="subflag-table">
							<tr>
								<td><h2><?php echo $nominee_subtitle; ?></h2></td>
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
	<div id="primary" class="site-content leftside">
		<div id="content" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php printf(__('%s %s Nominees'), $nominee_year, $category_name) ?></h1>
				</header>
				<div class="socialbar">
                    <div class="socialshare">Share:</div>
                    <div class="twitter-share socialshare"><a href="https://twitter.com/share" class="twitter-share-button" data-via="TheGeekieAwards" data-related="Nedopak" data-url="<?php echo get_permalink() ?>" data-lang="en">Tweet</a></div>
                    <div class="fb-like socialshare" data-href="<?php echo get_permalink() ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
                    <div class="socialshare"><div class="g-plusone" data-size="medium" data-annotation="bubble" data-href="<?php echo get_permalink() ?>"></div></div>
                </div>
				<?php

				$args = array('orderby' => 'rand',
					'nopaging' => 'true',
					'meta_key' => 'nominated_category',
					'meta_value' => $post_id
				 );

				$loop = new WP_Query($args);
				while($loop->have_posts()) : $loop->the_post();	?>
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
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php endwhile;

				wp_reset_postdata();

				$args = array('orderby' => 'rand',
					'order' => 'ASC',
					'nopaging' => 'true',
					'meta_query' => array(
				        'relation' => 'OR',
				        array(
				            'key' => 'nominated_category_top10',
				            'value' => $post_id,
				            'compare' => '='
				        ),

				        array(
				            'key' => 'nominated_category',
				            'value' => $post_id,
				            'compare' => '='
				        )
    				),
				 );

				$Top10_count = 0;

				$loop = new WP_Query($args);

				if ($loop->have_posts()) {

					while($loop->have_posts()) {
						$loop->the_post();
						$Top10_count++;
						$Top10[] = '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
					}
					wp_reset_postdata();
				}
				$nominee_top10_extra = get_post_meta( $post_id  , 'nominee_top10_extra' , true );

				foreach (explode( ',', $nominee_top10_extra ) as $value) {
					if ($Top10_count < 10) {
						$Top10_count++;
						$Top10[] = $value;
					}
				} ?>
				<div class="entry-content top-10">
					<h2><?php printf(__('%s Top 10 %s (in no order)'), $nominee_year, $category_name) ?></h2>
					<table>
						<tr>
				<?php for ($i = 1; $i <= 10; $i++) { ?>
							<td><?php echo $Top10[$i - 1]; ?></td>
						<?php echo (($i % 2 == 0) && $i < 10) ? '</tr><tr>' : ''; ?>
				<?php } ?>
						</tr>
					</table>
				</div>
				<div class="entry-content">
                    <?php the_content(); ?>
                </div>
			</article>
		</div>
	</div>
<?php } ?>
<?php get_sidebar('catnominees'); ?>
<?php get_footer(); ?>
