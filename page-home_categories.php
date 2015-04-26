<?php
/**
 * Template Name: Home Page Categories
 *
 * The Home Page template that uses when showing awards categories
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 4.1
 */

get_header();
echo slideshow_ui();
echo ticker_ui();
?>
<div id="primary" class="leftside site-content homepage">
  <div id="content" role="main">
  	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <header class="entry-header">
          <h1 class="entry-title"><?php the_title(); ?></h1>
      </header>
    	<div class="home-menu">
      	<?php wp_nav_menu( array( 'theme_location' => 'homecategory', 'menu_class' => 'homenav') ); ?>
      </div>
      <div style="clear:both;"></div>
      <div class="home-content">
				<?php the_content(); ?>
      </div>
    </article>
  </div>
</div>

<?php get_sidebar('home-right'); ?>
<div style="clear:both;"></div>
<?php echo sponsors_carousel_ui(); ?>
<?php get_footer(); ?>
