<?php
/**
 * The sidebar containing the news page widget areas.
 *
 * If no active widgets in either sidebar, they will be hidden completely.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 4.0
 */
?>
<?php
global $post; 
$post_id = $post->ID; 
$winner_sidebar = get_post_meta($post_id, 'winner_sidebar', true);
if ( is_active_sidebar( $winner_sidebar ) ) : ?>
	<div id="secondary" class="widget-area rightside">
		<?php dynamic_sidebar( $winner_sidebar   ); ?>
	</div>
<?php endif; ?>