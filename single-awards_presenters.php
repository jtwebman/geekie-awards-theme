<?php
/**
 * The Template for displaying all single preseter post.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */

get_header(); ?>
 
	<div id="primary" class="site-content leftside">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
            	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                        <?php 
						$credit = get_post_meta($post->ID, 'presenter_credit', true);
						if (isset($credit)) {
							echo '<h6>' . $credit . '</h6>';
						}
						?>
					</header>
                    <div class="socialbar">
                        <div class="socialshare">Share:</div>
                        <div class="twitter-share socialshare"><a href="https://twitter.com/share" class="twitter-share-button" data-via="TheGeekieAwards" data-related="Nedopak" data-url="<?php echo get_permalink() ?>" data-lang="en">Tweet</a></div>
                        <div class="fb-like socialshare" data-href="<?php echo get_permalink() ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
                        <div class="socialshare"><div class="g-plusone" data-size="medium" data-annotation="bubble" data-href="<?php echo get_permalink() ?>"></div></div>
                    </div>
                    <div class="entry-content">
                        <?php echo get_the_post_thumbnail(get_the_id(), 'judge-thumbnail', array( 'class' => 'presenter-page-thumbnail' )) ?>
                        <?php the_content(); ?>
                    </div>
              	</article>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_sidebar('presenter'); ?>
<?php get_footer(); ?>