jQuery(document).ready(function() {
  jQuery('#slideshowslider').flexslider({
    animation: "fade",
	directionNav: false
  }).flexsliderManualDirectionControls();
  jQuery('#sponsorcarousel').flexslider({
    animation: "slide",
	animationLoop: true,
    itemWidth: 240,
    itemMargin: 0,
	controlNav: false,
	move: 4,
	slideshow: false,
	directionNav: false
  }).flexsliderManualDirectionControls();
});