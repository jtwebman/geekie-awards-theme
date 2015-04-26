<?php
/**
 * Template Name: Home Page
 *
 * The Home Page template
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */

get_header();
echo slideshow_ui();
echo ticker_ui();
?>
	<div id="primary" class="leftside site-content homepage">
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'home' ); ?>
			<?php endwhile;  ?>
            <div style="clear:both;"></div>
		</div>
	</div>
<?php get_sidebar('home'); ?>
<div style="clear:both;"></div>
<?php echo sponsors_carousel_ui(); ?>


<?php get_footer(); ?>