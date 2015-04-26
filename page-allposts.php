<?php
/**
 * Template Name: All Entries Page
 *
 * The Judge Page template
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.1
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
        	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1>', '</h1>'); ?>
                </header>
                <div class="entry-content">
                <?php the_content(); ?>
                    <div class="wide">
                        <?php //for each category, show all posts
                        $cat_args=array(
                          'orderby' => 'name',
                          'order' => 'ASC'
                           );
                        $categories=get_categories($cat_args);
                          foreach($categories as $category) {
                            $args=array(
                              'showposts' => -1,
                              'category__in' => array($category->term_id),
                              'ignore_sticky_posts'=>1,
                              'orderby' => 'title',
                              'order' => 'ASC'
                            );
                            $posts=query_posts($args);
                              if ($posts) {
                                echo '<div class="dontsplit"><h2>' . $category->name . '</h2><p>';
                                foreach($posts as $post) {
                                  setup_postdata($post); ?>
                                  <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a><br />
                                  <?php
                                } // foreach($posts
                                echo '</p></div>';
                              } // if ($posts
                            } // foreach($categories
                        ?>
                    </div>
            	</div>
        	</article>
            <div style="clear:both;"></div>
		</div>
	</div>

<?php get_footer(); ?>