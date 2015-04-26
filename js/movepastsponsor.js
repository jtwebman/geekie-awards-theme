jQuery(document).ready(function($){
	jQuery("a[class=move-to-past-sponsor]").click(function(){
		var data = $(this).data('params');
		jQuery.post(
			ajaxurl, 
			{
				'action': 'move_to_past_sponsor',
				'postid': data.postid
			}, 
			function(response){
				//alert(response);
				window.location=response;
			}
		);
	});
});