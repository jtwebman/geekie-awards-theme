<?php
/**
 * The template for displaying Archive pages.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */

get_header(); ?>


<section id="primary" class="site-content categories">
    <div id="content">
    	<div class="full-page-pad">
            <h1>Image Galleries</h1>
            <?php if ( have_posts() ) : ?>
                <?php
                /* Start the Loop */
                $post_count = 0;
                while ( have_posts() ) : the_post(); $post_count++ ?>
                    <article id="post-<?php the_ID(); ?>" <?php if ($post_count % 3 == 0) post_class('gallery-post-last'); else post_class('gallery-post'); ?>>
                        <?php $featuredimage = get_post_meta(get_the_ID(), 'imagegallery_featured', true); ?>
                        <a href="<?php echo get_permalink(); ?>"><img src="<?php echo $featuredimage['url']; ?>" width="320" height="240" class="gallery-featuredimage " /></a>
                        <header class="entry-header">
                            <h4 class="entry-title"><?php the_title(); ?></h4>
                        </header>
                    </article>
                    <?php if ($post_count % 3 == 0) :?>
                        <div style="clear:both;">&nbsp;</div>
                    <?php endif; ?>
                <?php endwhile;
                if (count($posts) % 3 != 0) : ?>
                    <div style="clear:both;">&nbsp;</div>
                <?php endif; 
                thegeekieawards_content_nav( 'nav-below' );?>
            <?php else : ?>
                <?php get_template_part( 'content', 'none' ); ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>