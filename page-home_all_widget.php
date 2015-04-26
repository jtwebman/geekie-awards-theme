<?php
/**
 * Template Name: Home Page All Widgets
 *
 * The Home Page template that uses all widget areas
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 3.0
 */

get_header();
echo slideshow_ui();
echo ticker_ui();
get_sidebar('home-left');
?>
<?php get_sidebar('home-right'); ?>
<div style="clear:both;"></div>
<?php echo sponsors_carousel_ui(); ?>
<?php get_footer(); ?>