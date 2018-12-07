<?php 
	require_once  './view/popup.php';
	require_once  './view/add-channel.php';
	require_once  './view/channel-list.php';
	require_once  './view/playlist.php';
	require_once  './view/subscription.php';
	require_once  './view/upload.php';
	require_once  'connector.php';
?>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="./css/home.css">
	<script src="./js/main.js"></script>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">
		<div class="row add-channel">
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addChannelModal">Add Channel</button>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadVideoModal">Upload Video</button>
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#playlistModal">Create Playlist</button>
			<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#subscribeModal">Subscribe Channel</button>
			<?php 
				create_popup('Add A New Channel', 'add_channel_view', 'addChannelModal');
				create_popup('Subscribe A Channel', 'subscribe_view', 'subscribeModal');
				create_popup('Create A Playlist', 'playlist_view', 'playlistModal');
				create_popup('Upload A Video', 'upload_view', 'uploadVideoModal');
			?>
		</div>
		
		<div class="row channel-frame">
			<?php
				$tokens = get_json_channel();
				if($tokens) {
					create_channel_frame($tokens);
				}
			?>
		</div>
	</div>
	
	<script>
		$( document ).ready(function() {
			triggerModalShow('addChannelModal');
			triggerModalShow('playlistModal');
			triggerModalShow('subscribeModal');
			triggerModalShow('uploadVideoModal');
			
			triggerRemoveChannel();
		});
	</script>
</body>
</html>