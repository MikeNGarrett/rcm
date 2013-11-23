jQuery(document).ready(function(){
	$('#update-status').click(function(){

		var oldStatus = $("#old-status");
		var statusId = $("#status").val();
		var caseId = $("#case-id").val();
		var systemMsg = $("#update-status-msg");
		var loader = $("#update-status-loader");


		if (oldStatus.val() == statusId) {
			return;
		}

		postData = {
			action: 'updatePostStatus',
			postId: caseId,
			statusId: statusId,
			nextNonce: PT_Ajax.nextNonce
		};
		loader.show();
		systemMsg.hide();
		$.post(PT_Ajax.ajaxUrl, postData, function(response) {
			// response = '';
			loader.hide();
			systemMsg.show();
			if (response != 'ok') {
				systemMsg.removeClass().addClass("errorMsg").html("Failed updating the status of the case!");
				return;
			}
			oldStatus.val(statusId);
			systemMsg.removeClass().addClass("successMsg").html("Successfully updated status!");
		});
	});
});
