<?php
/**
 * The Template for displaying all single posts for 2014.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 4.1
 */

get_header(); ?>

	<div id="primary" class="site-content leftside">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar('category2014'); ?>
<?php get_footer(); ?>
