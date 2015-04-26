<?php
/**
 * The sidebar containing the geekie works widget areas.
 *
 * If no active widgets in either sidebar, they will be hidden completely.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.1.1
 */
?>

<?php if ( is_active_sidebar( 'geekie-sidebar' ) ) : ?>
	<div id="secondary" class="widget-area rightside">
		<?php dynamic_sidebar( 'geekie-sidebar' ); ?>
	</div>
<?php endif; ?>