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

				<?php get_template_part( 'content', 'news' ); ?>
                
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar('news'); ?>
<?php get_footer(); ?>