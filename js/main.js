
function triggerModalShow(id) {
	$('#' + id).on('show.bs.modal', function() {
		if(id == "addChannelModal") {
			$('#add-channel-authorize').on('click', function() {
				var channel = $('#add-channel-input').val();
				window.location.replace(window.location.origin + "/oauth2callback.php?ajax_channel_name=" + channel);
			});
		}
		
		if(id == "playlistModal") {
			$('#playlist-submit').on('click', function() {
				var videos = $('#playlist-video').val();
				var videoarr = videos.split(',');
				var title = $('#playlist-name').val();
				var description = $('#playlist-description').val();
				var pll = {
					title: title,
					description: description,
					videos: videoarr
				};
				
				if(title == null || title =="" || description == null || description =="" || videos == null || videos =="") {
					alert('Input Cannot Be Empty');
				}else {
					var checkedList = getAllCheckedbox();
					var json = {indexes:checkedList, type:'playlist', playlist:pll};
					$.post(window.location.origin + "/youtube_api.php", JSON.stringify(json), function(response){ 
						  $('#logging-playlistModal').empty();
						  $('#logging-playlistModal').append(response);
					});
				}
			});
		}	

		if(id == "subscribeModal") {
			$('#subscribe-submit').on('click', function() {
				var channelID = $('#subscribe-channel').val();
				if(channelID == null || channelID == "") {
					alert('Input Cannot Be Empty');
				}else {
					var checkedList = getAllCheckedbox();
					var json = {indexes:checkedList, type:'subscribe', channel:channelID};
					$.post(window.location.origin + "/youtube_api.php", JSON.stringify(json), function(response){ 
						  $('#logging-subscribeModal').empty();
						  $('#logging-subscribeModal').append(response);
					});
				}
			});
		}	
		
		if(id == "uploadVideoModal") {
			$('#upload-download').on('click', function() {
				var url = $('#upload-url').val();
				var name = $('#upload-name').val();
				if(url == null || url == "" || name == null || name == "") {
					alert('Input Cannot Be Empty');
				}else {
					var obj = {
						url: url,
						name: name
					}
					$.post(window.location.origin + "/upload_handle.php", JSON.stringify(obj), function(response){ 
						  if(response == 'ok') {
							  $('#upload-download').hide();
							  $('#upload-upload').show();
						  }else {
							  $('#upload-download').html("Download Failed");
						  }
						  $('#logging-uploadVideoModal').empty();
						  $('#logging-uploadVideoModal').append(response);
					});
					$('#upload-download').html("Downloading");
				}
			});
			
			$('#upload-upload').on('click', function() {
				var name = $('#upload-name').val();
				if(name == null || name == "") {
					alert('Input Cannot Be Empty');
				}else {
					var checkedList = getAllCheckedbox();
					var json = {indexes:checkedList, type:'upload', name: name};
					$.post(window.location.origin + "/youtube_api.php", JSON.stringify(json), function(response){ 
						  $('#logging-uploadVideoModal').empty();
						  $('#logging-uploadVideoModal').append(response);
					});
				}
			});
			
			
			$('#upload-upload').hide();
		}	
	});
}

function getAllCheckedbox() {
	var list = [];
	$('.tick-channel').each(function () {
		if($(this).is(':checked')) {
			var id = $(this).attr("id");
			id = id.replace(/\D/g,'');
			list.push(parseInt(id, 10));
		}
	});
	return list;
}

function triggerRemoveChannel() {
	$('.channel-list-close').on('click', function () {
		var id = $(this).attr("id");
		id = id.replace(/\D/g,'');
		var json = {
			id : id,
			type: 'remove-channel'
		}
		$.post(window.location.origin + "/youtube_api.php", JSON.stringify(json), function(response){ 
			if(response == 'ok') {
				location.reload(true);
			}
		});
	});
}