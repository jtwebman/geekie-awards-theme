<?php
/**
 * Template Name: Home Page Widgets Voting
 *
 * The Home Page template that uses all widget areas for voting
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 4.1
 */

get_header();
echo slideshow_ui();
echo ticker_ui();
get_sidebar('home-voting-left');
?>
<?php get_sidebar('home-right'); ?>
<div style="clear:both;"></div>
<?php echo sponsors_carousel_ui(); ?>
<?php get_footer(); ?>
