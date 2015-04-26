/* Javascript funvtion to make Open Data Protocol requests to external page */
function getOpenDataRequest(url, callBack) {
	var data = {
		action: 'open_data_protocol_request',
		url: url
	};
	return jQuery.getJSON(ajax_scripts.ajaxurl, data, callBack);
}

function getVideoGallery(postid, callBack) {
	var data = {
		action: 'get_video_gallery',
		postid: postid
	};
	return jQuery.getJSON(ajax_scripts.ajaxurl, data, callBack);
}