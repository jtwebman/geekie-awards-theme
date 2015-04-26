<?php
/**
 * The Template for displaying all single image gallary posts.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */

get_header(); ?>
	
    <div id="primary" class="site-content">
		<div id="content" role="main">
			<div class="full-page-pad">
			<?php while ( have_posts() ) { the_post(); ?>
            	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
					</header>
                    <div class="entry-content">
                        <?php 
						$images = get_post_meta($post->ID, 'imagegallery_images', true);
						$count = 0;
						if (!empty($images) ) {
							foreach($images as $image) { 
								$count++;?>
								<div class="<?php if ($count % 6 == 0) echo 'gallery-image-last'; else echo 'gallery-image'; ?>">
									<?php $featuredimage = get_post_meta(get_the_ID(), 'imagegallery_featured', true); ?>
                                    <a rel="lightbox" title="<?php echo $image['caption']; ?>" href="<?php echo $image['url']; ?>"><img alt="<?php echo $image['caption']; ?>" src="<?php echo $image['url']; ?>" /></a>
                    			</div>
                                <?php if ($count % 6 == 0) {?>
                                    <div style="clear:both;">&nbsp;</div>
                                <?php } 
							}
						} 
                        if (count($images) % 6 != 0) { ?>
                                <div style="clear:both;">&nbsp;</div>
                        <?php } ?>
                    </div>
              	</article>
			<?php } ?>
			</div>
		</div>
	</div>
    
<?php get_footer(); ?>