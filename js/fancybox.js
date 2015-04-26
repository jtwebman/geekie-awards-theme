jQuery(document).ready(function() {
	jQuery('.fancybox').fancybox({
		helpers : {
			media: true
		}
	});
 
	jQuery('.fancybox-autoSize').fancybox({
		autoSize : true,
		fitToView: false
 	});
	
	jQuery('a[rel^=lightbox]').fancybox();
});
