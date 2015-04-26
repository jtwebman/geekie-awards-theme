<?php
/**
 * The template for displaying 2014 Tag pages.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */

get_header(); ?>


<section id="primary" class="site-content categories leftside">
    <div id="content">
        <?php if ( have_posts() ) : ?>
            <header class="archive-header">
                <h1 class="archive-title"><?php printf( __( 'Tag: %s', 'thegeekieawards' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>
                <hr />
            <?php if ( category_description() ) : // Show an optional category description ?>
                <div class="archive-meta"><?php echo category_description(); ?></div>
            <?php endif; ?>
            </header><!-- .archive-header -->
            <?php
            /* Start the Loop */
            $post_count = 0;
            while ( have_posts() ) : the_post();?>
                <article id="post-<?php the_ID(); ?>" <?php (++$post_count % 2 == 0) ? post_class('category-post-last') : post_class('category-post'); ?>>
                    <div style="position: relative;">
                        <div class="post-elements">
                            <ul>
                              <?php if ( get_post_meta($post->ID, 'mp3', true) ) { ?>
                              <li>
                              <a class="fancybox" href="#<?php the_ID(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/post-music.png" alt=""></a>
                              </li>
                              <div style="display: none;">
                                <div id="<?php the_ID(); ?>" style="overflow:auto;">
                                    <audio controls>
                                        <source src="<?php echo get_post_meta($post->ID, "mp3", $single = true); ?>" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                              </div>
                              <?php } ?>

                              <?php if ( get_post_meta($post->ID, 'video', true) ) { ?>
                              <li><a class="fancybox fancybox.iframe" href="<?php echo get_post_meta($post->ID, "video", $single = true); ?>" title="Watch Video!"><img src="<?php bloginfo('template_directory'); ?>/images/post-video.png" alt=""></a>
                              </li>
                              <?php } ?>
                            </ul>
                          </div>
                        <figure class="featured-small"><?php the_post_thumbnail('thumbnail', array('class' => 'category-thumbnail')); ?></figure>
                    </div>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header><!-- .entry-header -->
                    <div class="category-list">Posted In <?php echo get_the_category_list($separator = ','); ?></div>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div><!-- .entry-summary -->
                    <a href="<?php echo get_permalink(); ?>" class="middle-button"><span class="middle-right"></span>More</a>
                </article><!-- #post -->
                <?php if ($post_count % 2 == 0) :?>
                    <div style="clear:both;">&nbsp;</div>
                <?php endif; ?>
            <?php endwhile;
            /* Add empy div if post count is uneven */
            if (count($posts) % 2 != 0) : ?>
                <div class="grid_4">&nbsp;</div>
            <?php endif; ?>
        <?php else : ?>
            <?php get_template_part( 'content', 'none' ); ?>
        <?php endif; ?>
    </div><!-- #content -->
</section><!-- #primary -->

<?php get_sidebar('geekie'); ?>
<?php get_footer(); ?>
