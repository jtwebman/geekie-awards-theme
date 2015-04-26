<?php
/**
 * Template Name: Slider test Page
 *
 * The Home Page template
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */
?>
<?php
get_header();
$sliders = get_group('featured_slider');
?>
	<?php if(count($sliders)>0){ ?>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory') ?>/css/font-awesome.min.css">
	<div class="container_two">
		<div id="slides">
			<?php
				$i=1;
				foreach($sliders as $slider){						
			?>		
				<a href="<? echo($slider["featured_slider_link"][1]); ?>"><img src="<? echo($slider["featured_slider_image"][1]['original']); ?>" class="wp-post-image" alt="thegeekieawards_banner" style="margin-top:0px;"></a>
				<?php echo($i % 3 == 0 ? "<div style='clear:both;'>&nbsp;</div>" : ""); ?>
				<?php 
					$i+=1;
				} 
			?>
			<a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
			<a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>
		</div>
	</div>
	<br />
	<?php }else{ ?>
	<?php 	the_post_thumbnail('large', array('class' => 'featuredImage')); ?>
	<?php } ?>
	<div id="primary" class="leftside site-content">
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'home' ); ?>
			<?php endwhile;  ?>
		</div>
	</div>
<?php get_footer(); ?>