var numberOfBoxes = 0;

jQuery(document).ready(function($){
	var file_frame;
	numberOfBoxes = jQuery('.admin-list-box').length;
	addEvents();
	
	jQuery('a#add-admin-list').click(function(e){
		e.preventDefault();
		var type = jQuery(this).attr('rel');
		if (type == 'video') {
			jQuery('#admin-list-end-marker').before(getVideoBoxHTML(++numberOfBoxes));
		}
		if (type == 'image') {
			
			
			if ( file_frame ) {
			  file_frame.open();
			  return;
			}
		 
			file_frame = wp.media.frames.file_frame = wp.media({
			  title: 'Select Images to Add',
			  button: { text: 'Add Images' },
			  multiple: true 
			});
		
			file_frame.on( 'select', function() {
				var attachments = file_frame.state().get('selection').forEach( function( attachment ) {
				  attachment = attachment.toJSON();
				  jQuery('#admin-list-end-marker').before(getImageBoxHTML(++numberOfBoxes, attachment.url, attachment.caption));
				});
				addEvents();
			});
			file_frame.open();
		}
		addEvents();
		resetOrder();
	});
});

function addEvents() {
	jQuery('input[id^="videourl"]').on('input paste', function(e) {
		var urlinput = this;

		jQuery('img[id="' + urlinput.name.replace( 'videourl' , 'loadingimg' ) + '"]').show();

		setTimeout(function () {
			getOpenDataRequest(urlinput.value, function(data) {
				if (!data.imageurl || !data.title || !data.desc || !data.width || !data.height || !data.embedurl) {
					jQuery('input[id="' + urlinput.name.replace( 'videourl' , 'videotitle' ) + '"]').val('');
					jQuery('textarea[id="' + urlinput.name.replace( 'videourl' , 'videodescription' ) + '"]').val('');
					jQuery('img[id="' + urlinput.name.replace( 'videourl' , 'list-thumbnail-image' ) + '"]').attr('src', globalinfo.themeurl + '/images/noimage.png' );
					jQuery('input[id="' + urlinput.name.replace( 'videourl' , 'videoimgurl' ) + '"]').val('');
					jQuery('input[id="' + urlinput.name.replace( 'videourl' , 'videoimgwidth' ) + '"]').val(0);
					jQuery('input[id="' + urlinput.name.replace( 'videourl' , 'videoimgheight' ) + '"]').val(0);
					jQuery('input[id="' + urlinput.name.replace( 'videourl' , 'embedurl' ) + '"]').val('');
				} else {
					jQuery('input[id="' + urlinput.name.replace( 'videourl' , 'videotitle' ) + '"]').val(data.title);
					jQuery('textarea[id="' + urlinput.name.replace( 'videourl' , 'videodescription' ) + '"]').val(data.desc);
					jQuery('img[id="' + urlinput.name.replace( 'videourl' , 'list-thumbnail-image' ) + '"]').attr('src', data.imageurl );
					jQuery('input[id="' + urlinput.name.replace( 'videourl' , 'videoimgurl' ) + '"]').val(data.imageurl);
					jQuery('input[id="' + urlinput.name.replace( 'videourl' , 'videoimgwidth' ) + '"]').val(data.width);
					jQuery('input[id="' + urlinput.name.replace( 'videourl' , 'videoimgheight' ) + '"]').val(data.height);
					jQuery('input[id="' + urlinput.name.replace( 'videourl' , 'embedurl' ) + '"]').val(data.embedurl);
				}
				jQuery('img[id="' + urlinput.name.replace( 'videourl' , 'loadingimg' ) + '"]').hide();
			});
		}, 500);
	});
	
	jQuery('a[name="admin-list-removebox"]').click(function(e){
		e.preventDefault();
		jQuery(this).parent().parent().remove();
		resetOrder();
	});
	
	jQuery('a[name="admin-list-upbox"]').click(function(e){
		e.preventDefault();
		var current = jQuery(this).parent().parent();
  		current.prev().before(current);
		resetOrder();
	});
	
	jQuery('a[name="admin-list-downbox"]').click(function(e){
		e.preventDefault();
		var current = jQuery(this).parent().parent();
		if (current.next().attr('id') != 'admin-list-end-marker') {
  			current.next().after(current);
			resetOrder();
		}
	});
}

function getNewVideoData() {
	
}

function resetOrder() {
	jQuery('.admin-list-box').each(function(i, val) {
		jQuery('input[id^="admin-list-order"]', this).val(i+1);
	});
}

function getVideoBoxHTML(row) {
	var html = '<div class="admin-list-box"> \
				<div class="removelink"><a href="#" id="admin-list-removebox[{0}]" name="admin-list-removebox"><img src="' + globalinfo.themeurl + '/images/remove.gif" width="16" height="16" /></a></div> \
				<div class="uplink"><a href="#" id="admin-list-upbox[{0}]" name="admin-list-upbox"><img src="' + globalinfo.themeurl + '/images/up.png" width="16" height="16"></a></div> \
				<div class="downlink"><a href="#" id="admin-list-downbox[{0}]" name="admin-list-downbox"><img src="' + globalinfo.themeurl + '/images/down.png" width="16" height="16"></a></div> \
				<div class="admin-list-item"> \
					<div class="label">Video URL:</div> \
					<div class="field"><input type="textbox" id="videourl[{0}]" name="videourl[{0}]" value=""></div><img src="' + globalinfo.themeurl + '/images/loading.gif" width="40" height="40" id="loadingimg[{0}]" style="display:none;" /> \
				</div> \
				<div class="admin-list-item"> \
					<div class="label">Video Image:</div> \
					<img class="list-thumbnail-image" id="list-thumbnail-image[{0}]" src="' + globalinfo.themeurl + '/images/noimage.png"> \
					<input type="hidden" id="videoimgurl[{0}]" name="videoimgurl[{0}]" value=""> \
					<input type="hidden" id="videoimgwidth[{0}]" name="videoimgwidth[{0}]" value=""> \
					<input type="hidden" id="videoimgheight[{0}]" name="videoimgheight[{0}]" value=""> \
					<input type="hidden" id="embedurl[{0}]" name="embedurl[{0}]" value=""> \
					<input type="hidden" id="admin-list-order[{0}]" name="admin-list-order[{0}]" value="{0}"> \
				</div> \
				<div class="admin-list-item"> \
					<div class="label">Video Title:</div> \
					<div class="field"><input type="textbox" id="videotitle[{0}]" name="videotitle[{0}]" value=""></div> \
				</div> \
				<div class="admin-list-item videodescriptionfield"> \
					<div class="label">Video Description:</div> \
					<div class="field"><textarea id="videodescription[{0}]" name="videodescription[{0}]"></textarea></div> \
				</div> \
				<div class="admin-list-item"> \
					<div class="label">Featured:</div> \
					<div class="field"><input type="radio" id="admin-list-featured[{0}]" name="admin-list-featured" value="{0}"></div> \
				</div> \
				<div style="clear: both;"></div> \
			</div>';
			
	return html.replace(/\{0\}/ig, row);
}

function getImageBoxHTML(row, imageurl, caption) {
	var html = '<div class="admin-list-box"> \
				<div class="removelink"><a href="#" id="admin-list-removebox[{0}]" name="admin-list-removebox"><img src="' + globalinfo.themeurl + '/images/remove.gif" width="16" height="16" /></a></div> \
				<div class="uplink"><a href="#" id="admin-list-upbox[{0}]" name="admin-list-upbox"><img src="' + globalinfo.themeurl + '/images/up.png" width="16" height="16"></a></div> \
				<div class="downlink"><a href="#" id="admin-list-downbox[{0}]" name="admin-list-downbox"><img src="' + globalinfo.themeurl + '/images/down.png" width="16" height="16"></a></div> \
				<div class="admin-list-item"> \
					<div class="label">Image:</div> \
					<img class="list-thumbnail-image" id="list-thumbnail-image[{0}]" src="' + imageurl + '"> \
					<input type="hidden" id="admin-list-order[{0}]" name="admin-list-order[{0}]" value="{0}"> \
					<input type="hidden" id="imageurl[{0}]" name="imageurl[{0}]" value="' + imageurl + '"> \
					<input type="hidden" id="imagewidth[{0}]" name="imagewidth[{0}]" value="' + imageurl + '"> \
					<input type="hidden" id="imageheight[{0}]" name="imageheight[{0}]" value="' + imageurl + '"> \
				</div> \
				<div class="admin-list-item"> \
					<div class="label">Image Caption:</div> \
					<div class="field"><textarea id="imagecaption[{0}]" name="imagecaption[{0}]">' + caption + '</textarea></div> \
				</div> \
				<div class="admin-list-item"> \
					<div class="label">Featured:</div> \
					<div class="field"><input type="radio" id="admin-list-featured[{0}]" name="admin-list-featured" value="{0}"></div> \
				</div> \
				<div style="clear: both;"></div> \
			</div>';
			
	return html.replace(/\{0\}/ig, row);
}