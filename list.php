<?php

require_once 'youtube-client.php';

session_start();

$client = create_google_client();
$youtube = new Google_Service_YouTube($client);
$tokens = get_json_channel();

for($i=0; $i<count($tokens); $i++) {
	$token = $tokens[$i];
	$client->setAccessToken((array) json_decode($token->code));
	if($client->isAccessTokenExpired()) {
		$refresh_token = $client->getRefreshToken();
		$client->refreshToken($refresh_token);
		$access_token = $client->getAccessToken();
		$access_token['refresh_token'] = $refresh_token;
		update_json_channel($i, $token->name, json_encode($access_token));
	}
	
	$youtube = new Google_Service_YouTube($client);
	$channel = $youtube->channels->listChannels('snippet', array('mine' => true));
	echo json_encode($channel);
	echo '<br><br>'
} 
