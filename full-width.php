<?php
/**
 * Template Name: Full Width Page
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile;  ?>
			<div style="clear:both;"></div>
		</div>
	</div>
<?php get_footer(); ?>