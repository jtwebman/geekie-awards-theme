<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>
    <div class="socialbar">
        <div class="socialshare">Share:</div>
        <div class="twitter-share socialshare"><a href="https://twitter.com/share" class="twitter-share-button" data-via="TheGeekieAwards" data-related="Nedopak" data-url="<?php echo get_permalink() ?>" data-lang="en">Tweet</a></div>
        <div class="fb-like socialshare" data-href="<?php echo get_permalink() ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
        <div class="socialshare"><div class="g-plusone" data-size="medium" data-annotation="bubble" data-href="<?php echo get_permalink() ?>"></div></div>
    </div>
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
</article>
