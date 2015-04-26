<?php
/**
 * The sidebar containing the presenter page widget areas.
 *
 * If no active widgets in either sidebar, they will be hidden completely.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.1
 */
?>

<?php if ( is_active_sidebar( 'teammember-sidebar' ) ) : ?>
	<div id="secondary" class="widget-area rightside">
		<?php dynamic_sidebar( 'teammember-sidebar' ); ?>
	</div>
<?php endif; ?>