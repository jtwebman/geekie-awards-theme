<?php
/**
 * The Template for displaying all single judge post.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 4.0
 */

get_header(); 
while ( have_posts() ) {
	the_post(); 
	$post_id = get_the_ID();

	$background = 'images/margin_bkgd2.jpg';
	$industry_background_id = get_post_meta( $post_id  , 'industry_background' , true );
	if ( !empty( $industry_background_id ) ) 
	{
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $industry_background_id  ), 'full' );
		$background = $image[0];
	}

	$header = '';
	$industry_header_id = get_post_meta( $post_id  , 'industry_header' , true );
	if ( !empty( $industry_background_id ) ) 
	{
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $industry_header_id  ), 'full' );
		$header = $image[0];
	}

	$industry_year = get_post_meta( $post_id  , 'industry_year' , true );

	$industry_subtitle = get_post_meta( $post_id  , 'industry_subtitle' , true );
	$imageFolder = get_template_directory_uri() . '/images/';
	?>
	<style >
		#main {
			background: #8a9aa7 url(<?php echo $background ?>) center top no-repeat fixed;
		}

		#sponsored-header {
			background: url(<?php echo $header ?>) no-repeat;
			background-size: cover;
		}

	</style>
	<div id="sponsored-header">
		<div id="flag-header">
			<table id="flag-table">
				<tr id="flag-table-top-row">
					<td rowspan="2" id="flag-left-header"></tb>
					<td><h1><?php echo get_the_title(); ?></h1></td>
					<td id="flag-right-header"></tb>
				</tr>
				<?php if (!empty($industry_subtitle)) { ?>
				<tr id="flag-table-bottom-row">
					<td colspan="2">
						<table id="subflag-table">
							<tr>
								<td><h2><?php echo $industry_subtitle; ?></h2></td>
								<td id="subflag-right-header"></td>
							</tr>
						</table>
					</td>
				</tr>
				<?php } ?>
			</table>
			<span id="subflag-left-header"></span><span id="flag-right-header"></span>
		</div>
	</div>
	<div id="primary" class="site-content leftside">
		<div id="content" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php printf(__('%s %s'), $industry_year, 'INDUSTRY AWARD RECIPIENT') ?></h1>
				</header>
				<div class="socialbar">
                    <div class="socialshare">Share:</div>
                    <div class="twitter-share socialshare"><a href="https://twitter.com/share" class="twitter-share-button" data-via="TheGeekieAwards" data-related="Nedopak" data-url="<?php echo get_permalink() ?>" data-lang="en">Tweet</a></div>
                    <div class="fb-like socialshare" data-href="<?php echo get_permalink() ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
                    <div class="socialshare"><div class="g-plusone" data-size="medium" data-annotation="bubble" data-href="<?php echo get_permalink() ?>"></div></div>
                </div>
                <div class="entry-content">
                    <?php echo get_the_post_thumbnail(get_the_id(), 'full', array( 'class' => 'industry-page-thumbnail' )) ?>
                    <?php the_content(); ?>
                </div>
			</article>
		</div>
	</div>
<?php } ?>
<?php get_sidebar('industrypages'); ?>
<?php get_footer(); ?>