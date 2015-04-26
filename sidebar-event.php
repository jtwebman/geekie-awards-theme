<?php
/**
 * The sidebar containing the ticket page widget areas.
 *
 * If no active widgets in either sidebar, they will be hidden completely.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */
?>

<?php if ( is_active_sidebar( 'event-sidebar' ) ) : ?>
	<div id="secondary" class="rightside widget-area">
		<?php dynamic_sidebar( 'event-sidebar' ); ?>
	</div>
<?php endif; ?>