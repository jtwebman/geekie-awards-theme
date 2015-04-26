jQuery(document).ready(function($){	
	if (typeof postid == "number") {
		getVideoGallery(postid, function(data) {
			jQuery('.video-gallary-video-thumbnail a').click(function(e){
				e.preventDefault();
				var url = jQuery(this).attr('href').split('/');
				var orderid = url[url.length-2];
				jQuery('#video-player-iframe').attr('src', data[orderid].embedurl);
				jQuery('#video-player-title').text(data[orderid].title);
				jQuery('#video-player-description').html(replaceURLWithHTMLLinks(data[orderid].description));
				
				var twitterlink = '<a href="https://twitter.com/share" class="twitter-share-button" data-url="' + data[orderid].url + '" data-text="' + data[orderid].title + '" data-via="TheGeekieAwards" data-hashtags="RUGeekie">Tweet</a>';
				var facebooklink = '<div class="fb-like" data-href="' + data[orderid].url + '" data-width="50" data-layout="button_count" data-show-faces="true" data-send="true"></div>';
				
				jQuery('#video-social').html(twitterlink + facebooklink);
				twttr.widgets.load();
				FB.XFBML.parse();
				jQuery('html, body').animate({
                        scrollTop: jQuery('#main').offset().top
                    }, 500);
			});
		});
	}
	
	!function(d,s,id) {
		var js; 
		var fjs=d.getElementsByTagName(s)[0];
		var p=/^http:/.test(d.location) ? 'http':'https';
		
		if(!d.getElementById(id)) {
			js=d.createElement(s);
			js.id=id;
			js.src=p+'://platform.twitter.com/widgets.js';
			fjs.parentNode.insertBefore(js,fjs);
		}
	}(document, 'script', 'twitter-wjs');
	
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=463268627059957";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
});

function replaceURLWithHTMLLinks(text) {
    var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
    return text.replace(exp,'<a href="$1" target="_blank">$1</a>'); 
}
