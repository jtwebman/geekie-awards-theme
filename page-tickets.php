<?php
/**
 * Template Name: Ticket Page
 *
 * The Home Page template
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */

get_header();
$sliders = get_group('featured_slider');
?>
	<?php if(count($sliders)>0){ ?>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory') ?>/css/font-awesome.min.css">
	<div class="container_two">
		<div id="slides">
			<?php
				$i=1;
				foreach($sliders as $slider){						
			?>		
				<a href="<? echo($slider["featured_slider_link"][1]); ?>"><img src="<? echo($slider["featured_slider_image"][1]['original']); ?>" class="wp-post-image" alt="thegeekieawards_banner" style="margin-top:0px;"></a>
				<?php echo($i % 3 == 0 ? "<div style='clear:both;'>&nbsp;</div>" : ""); ?>
				<?php 
					$i+=1;
				} 
			?>
			<a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
			<a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>
		</div>
	</div>
	<br />
	<?php }else{ ?>
	<?php 	the_post_thumbnail('large', array('class' => 'featuredImage')); ?>
	<?php } ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {			
		<?php
			$ticket_options = get_group('ticket_options');
			$i=1;
			foreach($ticket_options as $option){	
		?>
			$(".view_photos_<?php echo($i);?>").on("click",function(){
				$.fancybox.open([
			<?php
				foreach($option["ticket_options_photos_map"] as $photo){	
					print("{ href:'" . $photo["original"] . "'},");
				}	
			?>
				], {
					helpers : {
						media : {},
						thumbs : {
							width: 75,
							height: 50
						}
					}
				});
			});
		<?php			
				$i+=1;
			} 
		?>				
		});
	</script>
	<div id="primary" class="leftside site-content">
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'home' ); ?>
				<?php
					$ticket_options = get_group('ticket_options');
					$i=1;
					foreach($ticket_options as $option){						
				?>
					<div class="option">
						<div class="option_left">
							<h4 style="float: right;"><? echo($option["ticket_options_cost"][1]); ?></h4>
							<h4><? echo($option["ticket_options_type"][1]); ?></h4>
							<? echo($option["ticket_options_info"][1]); ?>
							<p style="color:red;"><? echo($option["ticket_options_alert"][1]); ?></p>
						</div>
						<div class="option_right">							
							<? if($option["ticket_options_tickets_available"][1]=="1"){ ?>
								<a target="_blank" class="buy_tickets" href="<? echo($option["ticket_options_ticket_link"][1]); ?>">Buy Tickets</a>							
							<? }else{ ?>
								<a class="sold_out">Sold Out</a>
							<? } ?>
							<a href="javascript:none;" class="view_photos view_photos_<?php echo($i);?>">View Photos &amp; Map</a>
						</div>
					</div>
						<hr />
				<?php 
						$i+=1;
					} 
				?>
				<p><?php echo(get('note'));?></p>
			
			<?php endwhile;  ?>
            <div style="clear:both;"></div>
		</div>
	</div>

<?php get_sidebar('ticket'); ?>
<?php get_footer(); ?>