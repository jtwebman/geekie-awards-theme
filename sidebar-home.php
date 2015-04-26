<?php
/**
 * The sidebar containing the home page all widgets right widget areas.
 *
 * If no active widgets in either sidebar, they will be hidden completely.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 3.0
 */
?>

<?php if ( is_active_sidebar( 'home-right-sidebar' ) ) : ?>
	<div id="secondary" class="rightside widget-area homepage">
		<?php dynamic_sidebar( 'home-right-sidebar' ); ?>
	</div>
<?php endif; ?>