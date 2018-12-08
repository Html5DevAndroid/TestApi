<?php
require_once 'connector.php';
require_once 'youtube-client.php';

session_start();

$client = create_google_client();
 
$tokens = get_json_channel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = json_decode(file_get_contents('php://input'));
	
	if($content->type == 'playlist') {
		$arr = $content->indexes;
		if(count($arr) == 0) {
			echo 'No Channel Selected';
		}
		
		$pll = $content->playlist;
		
		for($i=0; $i<count($arr); $i++) {
			$token = $tokens[$arr[$i]];
			create_playlist($arr[$i], $token, $pll->title, $pll->description, $pll->videos);
		}
	}
	
	if($content->type == 'subscribe') {
		$arr = $content->indexes;
		if(count($arr) == 0) {
			echo 'No Channel Selected';
		}
		
		for($i=0; $i<count($arr); $i++) {
			$token = $tokens[$arr[$i]];
			subscribe($arr[$i], $token, $content->channel);
		}
	}
	
	if($content->type == 'upload') {
		$arr = $content->indexes;
		if(count($arr) == 0) {
			echo 'No Channel Selected';
		}
		
		for($i=0; $i<count($arr); $i++) {
			$token = $tokens[$arr[$i]];
			upload_video($arr[$i], $token, $content->name, $content->file);
		}
	}
	
	if($content->type == 'remove-channel') {
		delete_json_channel($content->id);
		die('ok');
	}
	
	if($content->type == 'remove-channel') {
		$videos = scandir("./video");
		array_splice($videos, 0, 2);
		if(unlink($video[$content->id])) {
			die('ok');
		}else {
			die('error');
		}
	}
}

function validate_token($stt, $token) {
	$client = $GLOBALS['client'];
	$client->setAccessToken((array) json_decode($token->code));
	if($client->isAccessTokenExpired()) {
		$refresh_token = $client->getRefreshToken();
		$client->refreshToken($refresh_token);
		$access_token = $client->getAccessToken();
		$access_token['refresh_token'] = $refresh_token;
		update_json_channel($stt, $token->name, json_encode($access_token));
	}
	
	return $client;
}

function create_playlist($stt, $token, $snippet, $description, $video_id) {
	$client = validate_token($stt, $token);
	
	try {
	
		$youtube = new Google_Service_YouTube($client);
		
		$playlistSnippet = new Google_Service_YouTube_PlaylistSnippet();
		$playlistSnippet->setTitle($snippet . '  ' . date("Y-m-d H:i:s") . ' part - ' . rand(1,1000));
		$playlistSnippet->setDescription($description);

		$playlistStatus = new Google_Service_YouTube_PlaylistStatus();
		$playlistStatus->setPrivacyStatus('public');

		$youTubePlaylist = new Google_Service_YouTube_Playlist();
		$youTubePlaylist->setSnippet($playlistSnippet);
		$youTubePlaylist->setStatus($playlistStatus);

		$playlistResponse = $youtube->playlists->insert('snippet,status',
			$youTubePlaylist, array());
		$playlistId = $playlistResponse['id'];

		for($i=0; $i<count($video_id); $i++) {
			$resourceId = new Google_Service_YouTube_ResourceId();
			$resourceId->setVideoId($video_id[$i]);
			$resourceId->setKind('youtube#video');
			
			$playlistItemSnippet = new Google_Service_YouTube_PlaylistItemSnippet();
			$playlistItemSnippet->setTitle($snippet);
			$playlistItemSnippet->setPlaylistId($playlistId);
			$playlistItemSnippet->setResourceId($resourceId);
			
			$playlistItem = new Google_Service_YouTube_PlaylistItem();
			$playlistItem->setSnippet($playlistItemSnippet);
			$playlistItemResponse = $youtube->playlistItems->insert(
			'snippet,contentDetails', $playlistItem, array());
		}
		
		send_log($token->name, 'Created a playlist at : ' . $playlistResponse['id']);
	
	} catch (Google_Service_Exception $e) {
        send_log($token->name, $e->getMessage());
	} catch (Google_Exception $e) {
        send_log($token->name, $e->getMessage());
	}

}

function subscribe($stt, $token, $channel_id) {
	$client = validate_token($stt, $token);
	
	try {
    
		$youtube = new Google_Service_YouTube($client);
		
		$resourceId = new Google_Service_YouTube_ResourceId();
		$resourceId->setChannelId($channel_id);
		$resourceId->setKind('youtube#channel');

		// Create a snippet object and set its resource ID.
		$subscriptionSnippet = new Google_Service_YouTube_SubscriptionSnippet();
		$subscriptionSnippet->setResourceId($resourceId);

		// Create a subscription request that contains the snippet object.
		$subscription = new Google_Service_YouTube_Subscription();
		$subscription->setSnippet($subscriptionSnippet);

		// Execute the request and return an object containing information
		// about the new subscription.
		$subscriptionResponse = $youtube->subscriptions->insert('id,snippet',
			$subscription, array());

		send_log($token->name, 'Subscribed to channel : ' . $subscriptionResponse['id']);

	} catch (Google_Service_Exception $e) {
        send_log($token->name, $e->getMessage());
	} catch (Google_Exception $e) {
        send_log($token->name, $e->getMessage());
	}
}

function upload_video($stt, $token, $name, $file) {
	$client = validate_token($stt, $token);
	
	try {
    
		$youtube = new Google_Service_YouTube($client);
		
		// REPLACE this value with the path to the file you are uploading.
		$videoPath = './video/' . $file;

		// Create a snippet with title, description, tags and category ID
		// Create an asset resource and set its snippet metadata and type.
		// This example sets the video's title, description, keyword tags, and
		// video category.
		$snippet = new Google_Service_YouTube_VideoSnippet();
		$snippet->setTitle($name);
		$snippet->setDescription(date("Y-m-d H:i:s") . ' - ' . rand(1,1000));
		//$snippet->setTags(array("tag1", "tag2"));

		// Numeric video category. See
		// https://developers.google.com/youtube/v3/docs/videoCategories/list
		$snippet->setCategoryId("22");

		// Set the video's status to "public". Valid statuses are "public",
		// "private" and "unlisted".
		$status = new Google_Service_YouTube_VideoStatus();
		$status->privacyStatus = "public";

		// Associate the snippet and status objects with a new video resource.
		$video = new Google_Service_YouTube_Video();
		$video->setSnippet($snippet);
		$video->setStatus($status);

		// Specify the size of each chunk of data, in bytes. Set a higher value for
		// reliable connection as fewer chunks lead to faster uploads. Set a lower
		// value for better recovery on less reliable connections.
		$chunkSizeBytes = 1 * 1024 * 1024;

		// Setting the defer flag to true tells the client to return a request which can be called
		// with ->execute(); instead of making the API call immediately.
		$client->setDefer(true);

		// Create a request for the API's videos.insert method to create and upload the video.
		$insertRequest = $youtube->videos->insert("status,snippet", $video);

		// Create a MediaFileUpload object for resumable uploads.
		$media = new Google_Http_MediaFileUpload(
			$client,
			$insertRequest,
			'video/*',
			null,
			true,
			$chunkSizeBytes
		);
		$media->setFileSize(filesize($videoPath));


		// Read the media file and upload it chunk by chunk.
		$status = false;
		$handle = fopen($videoPath, "rb");
		while (!$status && !feof($handle)) {
		  $chunk = fread($handle, $chunkSizeBytes);
		  $status = $media->nextChunk($chunk);
		}

		fclose($handle);

		// If you want to make other calls after the file upload, set setDefer back to false
		$client->setDefer(false);
		
		send_log($token->name, 'uploaded video at : ' . $status['id']);

	} catch (Google_Service_Exception $e) {
        send_log($token->name, $e->getMessage());
	} catch (Google_Exception $e) {
        send_log($token->name, $e->getMessage());
	}
}

function send_log($name, $log) {
	echo '<p>' . $name . ' :<br> ' . $log . '<br><br></p>';
}