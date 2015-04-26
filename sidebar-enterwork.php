<?php
/**
 * The sidebar containing the enter work page widget areas.
 *
 * If no active widgets in either sidebar, they will be hidden completely.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 3.0
 */
?>

<?php if ( is_active_sidebar( 'enterwork-sidebar' ) ) : ?>
	<div id="secondary" class="widget-area rightside">
		<?php dynamic_sidebar( 'enterwork-sidebar' ); ?>
	</div>
<?php endif; ?>