<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=1020">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js" type="text/javascript"></script>
<![endif]-->
</head>
<body <?php body_class(); ?>>
<div id="page">
	<div id="top-bar">
        <header id="header">
            <div id="top" class="container">
            	<!--<div id="buynowbtn">
                	<a href="http://www.brownpapertickets.com/event/398406" target="_blank">&nbsp;</a>
                </div>-->
                <div id="site-navigation">
                    <nav class="nav-wrap">
                        <div class="topmenu">
                            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav') ); ?>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
    </div>
	<div id="main">
    	<div class="container" id="maincontent">