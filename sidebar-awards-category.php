<?php
/**
 * The sidebar containing the awards category sidebar widget areas.
 *
 * If no active widgets in either sidebar, they will be hidden completely.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 4.1
 */
?>

<?php if ( is_active_sidebar( 'awards-category-sidebar' ) ) : ?>
	<div id="secondary" class="widget-area rightside">
		<?php dynamic_sidebar( 'awards-category-sidebar' ); ?>
	</div>
<?php endif; ?>
