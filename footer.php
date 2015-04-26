<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */
?>
		<div style="clear:both;"></div>
		</div>
	</div>
    <footer id="footer">
    	<div id="footerbar" class="container">
      	<div class="footer-left">
          <div class="footermenu">
            <?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'nav-footer') ); ?>
          </div>
          <div id="copyright">
            The Geekie Awards&reg; is a registered trademark of Nedopak Productions, LLC. All rights reserved.
          </div>
        </div>
				<div class="footer-right">
	        <div id="socialicons">
	        	<ul>
	            	<li><a href="mailto:rugeekie@gmail.com"><img src="<?php bloginfo('template_directory'); ?>/images/icon_email.png" width="32" height="32" alt="Facebook" /></a></li>
	                <li><a href="http://www.youtube.com/user/RUGeekie" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/icon_youtube.png" width="32" height="32" alt="Facebook" /></a></li>
	                <li><a href="https://plus.google.com/105456662264390204478/" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/icon_google.png" width="32" height="32" alt="Facebook" /></a></li>
	                <li><a href="https://twitter.com/TheGeekieAwards" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/icon_twitter.png" width="32" height="32" alt="Facebook" /></a></li>
	            	<li><a href="https://www.facebook.com/TheGeekieAwards" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/icon_facebook.png" width="32" height="32" alt="Facebook" /></a></li>
	            </ul>
	        </div>
					<div id="footer-hosting-by">
						Web Hosting by <a href="https://www.arcustech.com/">Arcustech.com</a>
					</div>
				</div>
      </div>
    </footer>
</div>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<div id="fb-root"></div>
<script>(function(d, s, id){var js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="https://connect.facebook.net/en_US/all.js#xfbml=1&appId=463268627059957";fjs.parentNode.insertBefore(js, fjs);}(document,'script','facebook-jssdk'));</script>
<?php wp_footer(); ?>
<script type="text/javascript">(function() {var po=document.createElement('script');po.type='text/javascript';po.async=true;po.src='https://apis.google.com/js/platform.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(po,s);})();</script>
<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
<script type="text/javascript" src="//d389zggrogs7qo.cloudfront.net/js/button.js"></script>
</body>
</html>
