<?php
/**
 * Template Name: Video Page
 *
 * The Home Page template
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */

get_header(); ?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=380792352016078";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	<script type='text/javascript' src='http://test.thegeekieawards.com/wp-content/themes/TheGeekieAwards2/js/jquery-1.9.1.min.js?ver=3.5.1'></script>
	<script type="text/javascript">	 
		jQuery(document).ready(function(){			
			
			jQuery('ul#menu-videos li a').click(function(e) {
				e.preventDefault();
				window.scrollTo(0,330);
				jQuery("#main_holder").attr("src",jQuery(this).attr("rel"));
				jQuery("#main_holder").css("display","block");
				jQuery("#main_vid_trigger").css("display","none");
			});
			
			// work musclegroups function
			jQuery('ul#menu-videocategories a').click(videoClick);
			function videoClick(selected) {
				jQuery(this).css('outline', 'none');
				jQuery('ul#menu-videocategories .current').removeClass('current');
				jQuery(this).parent().addClass('current');			
					var vidVal = jQuery(this).attr("title").toLowerCase().replace(' ', '-');					
					if (vidVal == 'all-exercises') {					
						jQuery('ul#menu-videos li.hidden').fadeIn('normal').removeClass('hidden');
					} else {
						jQuery('ul#menu-videos li a').each(function() {						
							if (jQuery(this).attr("title").toLowerCase().indexOf(vidVal) == -1) {
								jQuery(this).parent().hide().addClass('hidden');
							} else {
								jQuery(this).parent().fadeIn('normal').removeClass('hidden');
							}
						});
					}
				return false;
		    }
		    jQuery('#main_vid_trigger').click(function(e) {
				e.preventDefault();
				jQuery("#main_holder").css("display","block");
				jQuery("#main_holder").attr("src",jQuery(this).attr("rel"));
				jQuery("#main_vid_trigger").css("display","none");
			});
		    
		});
	</script>
	<div id="primary" class="site-content">
		<div id="content" role="main">
			<div class="featured_area">
				<style>
					.featured_area{background:#383838;padding:0px 20px 50px 20px;}
						#main_holder{display:none;margin:0 auto;width:980px!important;height:510px!important;margin-bottom:20px;}
						#main_vid_trigger{display:block;margin-bottom:20px;}
					#menu-videocategories{margin:0px;}
					#menu-videocategories li{background:#01adef;list-style-type:none!important;float:left;padding:8px 15px 5px 15px;margin-top:20px;margin-left:0px;margin-right:10px;}
						#menu-videocategories li:hover{background:#ff007d;}
						#menu-videocategories li a{font-family: AlternateGothic2BT;text-transform: uppercase;font-size: 18px;font-weight: normal;color:#fff;}
					
					#menu-videos{}
					#menu-videos li{background:none;list-style-type:none!important;float:left;width: 260px;float: left;margin-right: 10px;}
						#menu-videos li.last{margin-right: 10px;}
						#menu-videos li img{background-color: #f3f3f3;padding: 10px;border: 1px solid #e4e4e4;width: 280px;height:155px;}
						
					.twitter-share-button,.fb-like{display:block;float:left;margin-top:5px;}
					.entry-title{margin-left:20px;color:#01adef;}
					h4{color:#fff;}
				</style>
				<ul id="menu-videocategories" class="menu">
				<?php
					//list terms in a given taxonomy (useful as a widget for twentyten)
					$taxonomy = 'videos_categories';
					$tax_terms = get_terms($taxonomy);
					foreach ($tax_terms as $tax_term) {
						echo '<li><a title="' . $tax_term->slug . '" href="#">' . $tax_term->name . '</a></li>';
					}
				?>
				</ul>
				<div style="clear:both;">&nbsp;</div>
				<!-- get featured video -->
				<?php
					$videos = new WP_Query('post_type=videos&posts_per_page=-1');
					while ($videos->have_posts()) : 
						$videos->the_post(); 
						$featured=get_post_meta( $videos->post->ID, "featured_video", true );
						$video_url=get_post_meta( $videos->post->ID, "video_url", true );
						$feat_image = wp_get_attachment_url( get_post_thumbnail_id( $videos->post->ID ) );
						$video_title;
						//check if vimeo or youtube
						
						if($featured){ 
							if (strpos($video_url,'vimeo') !== false) {
						   	 //has vimeo
							    $imgid = substr( $video_url, strrpos( $video_url, '/' )+1 );
							    $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $imgid . ".php"));
								$thumbnail=$hash[0]['thumbnail_medium']; 
								$video_title=$hash[0]['title']; 
							}else{
								//has youtube
								$imgid = substr( $video_url, strrpos( $video_url, '/' )+1 );		
								$arr = explode("?", $imgid, 2);
								$actualID = $arr[0];
																				
								$content = file_get_contents("http://youtube.com/get_video_info?video_id=".$actualID);
								parse_str($content, $ytarr);
								
								$video_title=$ytarr['title'];
							}
							
						?>
							<a id="main_vid_trigger" href="#" rel="<?php echo($video_url);?>"><img src="<?php echo($feat_image);?>"></a>
							<iframe id="main_holder" src="" frameborder="0" allowfullscreen></iframe>
							<h4><?php echo $video_title;?></h4>
							<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo($video_url);?>" data-text="<?php echo($videos->post->post_title);?>" data-via="TheGeekieAwards"></a>
							<div data-href="<?php echo($video_url);?>" class="fb-like" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false" data-colorscheme="light" data-action="like"></div>
				<?php
						}
					endwhile; wp_reset_query();
				?>					
			</div>
			
			<div style="clear:both;">&nbsp;</div>
			<?php get_template_part( 'content', 'page' ); ?>
			<ul id="menu-videos" class="menu">
			<?php 
				$post_count = 0;
				$videos = new WP_Query('post_type=videos&posts_per_page=-1&orderby=menu_order');
				while ($videos->have_posts()) : 
					$videos->the_post(); 
					$post->ID;
					$feat_image = wp_get_attachment_url( get_post_thumbnail_id( $videos->post->ID ) );
					$terms = get_the_terms( $videos->post->ID , 'videos_categories' );
					$output = array();
					foreach($terms as $term){
					  $output[] = $term->slug;
					}
					
					//get thumbnails
					$video_url=get_post_meta( $videos->post->ID, "video_url", true );
					//check if vimeo or youtube
					if (strpos($video_url,'vimeo') !== false) {
					    //has vimeo
					    $imgid = substr( $video_url, strrpos( $video_url, '/' )+1 );		
						$arr = explode("?", $imgid, 2);
						$actualID = $arr[0];
					    $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $actualID . ".php"));
						$thumbnail=$hash[0]['thumbnail_medium']; 
						$video_title=$hash[0]['title']; 
					}else{
						//has youtube
						$imgid = substr( $video_url, strrpos( $video_url, '/' )+1 );
						$arr = explode("?", $imgid, 2);
						$actualID = $arr[0];
						$thumbnail="http://img.youtube.com/vi/" . $actualID . "/0.jpg";
						
						
						$content = file_get_contents("http://youtube.com/get_video_info?video_id=".$actualID);
						parse_str($content, $ytarr);
						
						$video_title=$ytarr['title'];
					}					 
			?>
				
				<li id="" class="<?php echo(($post_count+1) % 3 == 0 ? "last" : ""); ?>">
					<a title="<?php echo implode(', ', $output); ?>" href="#main_holder" rel="<?php echo($video_url);?>">
						<img src="<?php echo($thumbnail);?>">
					</a>
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo($video_url);?>" data-text="<?php echo($video_title);?>" data-via="TheGeekieAwards"></a>
					<div data-href="<?php echo($video_url);?>" class="fb-like" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false" data-colorscheme="light" data-action="like"></div>
				</li>
				
			<?php 
				if (++$post_count % 3 == 0) :?>
	        <?php endif;
				endwhile; wp_reset_query();
			?>
			</ul>
		</div>
	</div>
<?php get_footer(); ?>