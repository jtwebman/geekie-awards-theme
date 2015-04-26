<?php
/**
 * The sidebar containing the home page all widgets left widget areas.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 3.0
 */
?>
<div id="primary" class="leftside site-content homepage">
    <div id="content" role="main">
    	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
        	<div class="home-menu">
            	<?php wp_nav_menu( array( 'theme_location' => 'home', 'menu_class' => 'homenav') ); ?>
            </div>
            <?php if ( is_active_sidebar( 'home-left-sidebar' ) ) : ?>
                <?php dynamic_sidebar( 'home-left-sidebar' ); ?>
            <?php endif; ?>
            <div class="home-content">
				<?php the_content(); ?>
            </div>
        </article>
        
    </div>
</div>
