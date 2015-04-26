<?php
/**
 * Template Name: Judge Page
 *
 * The Judge Page template
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.1
 */

get_header(); ?>

	<div id="primary" class="site-content leftside">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile;  ?>

		</div>
	</div>
<?php get_sidebar('judge'); ?>
<?php get_footer(); ?>