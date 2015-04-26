<?php
/**
 * Template Name: Quick Facts Page
 *
 * The Quick Facts Page template
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
			<?php endwhile;  ?>
			<div style="clear:both;"></div>
		</div>
	</div>

<?php get_sidebar('quickfacts'); ?>
<?php get_footer(); ?>