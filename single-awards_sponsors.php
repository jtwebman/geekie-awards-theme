<?php
/**
 * The Template for displaying all single sponsor post.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */

get_header(); ?>
 
	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
            	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
     
					
                    
					<header class="entry-header">
						<?php the_title('<h1>', '</h1>'); ?>
					</header>
                    <?php
                    $url = get_post_meta( get_the_id(), '_sponsor_url', true);
                    if ( !is_string($url) ) {
                        $url = get_permalink();
                    }
                     ?>
                    <div class="entry-content">
                        <a href="<?php echo $url ?>" target="_blank"><?php echo get_the_post_thumbnail(get_the_id(), 'sponsor-thumbnail', array( 'class' => 'alignleft' )) ?></a>
                        <div class="sponsor_text">
                            <?php the_content(); ?>
                            <p><a href="<?php echo $url ?>" target="_blank"><strong><?php the_title() ?></strong></a></p>
                        </div>
                        <hr />
                    </div>
              	</article>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>