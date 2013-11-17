jQuery(document).ready(function(){
	$('.update-action').click(function(){
		var parts = $(this).attr('id').split('_');
		var postId = parts[1];
		var old_status_id = $("#old_status_" + postId).val();
		var statusId = $("#status_" + postId).val();
		if (old_status_id  == statusId) {
			return;
		}

		postData = {
			action: 'updatePostStatus',
			postId: postId,
			statusId: statusId,
			nextNonce: PT_Ajax.nextNonce
		};
		$.post(PT_Ajax.ajaxUrl, postData, function(response) {
			if (response != 'ok') {
				console.log('status update failed');
			}
		});
	});
});
