<?php
/**
 * Template Name: Share Page
 *
 * Same as default but with social media share buttons
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 3.0
 */

get_header(); ?>

	<div id="primary" class="site-content leftside">
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page-share' ); ?>
			<?php endwhile; // end of the loop. ?>
            <div style="clear:both;"></div>
		</div>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>