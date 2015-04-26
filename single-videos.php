<?php
/**
 * The Template for displaying all single judge post.
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
					</header>
                    <div class="entry-content">
                        <?php echo get_the_post_thumbnail(get_the_id(), 'video-thumbnail', array( 'class' => 'video-page-thumbnail' )) ?>
                        <?php the_content(); ?>
                    </div>
              	</article>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->
    
<?php get_sidebar('judge'); ?>
<?php get_footer(); ?>