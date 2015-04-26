<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package TheGeekieAwards
 * @subpackage Theme
 * @since TheGeekieAwards 2.0
 */
?>

<?php if ( is_active_sidebar( 'main-sidebar' ) ) : ?>
	<div id="secondary" class="widget-area rightside">
		<?php dynamic_sidebar( 'main-sidebar' ); ?>
	</div>
<?php endif; ?>