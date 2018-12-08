<?php
require_once 'connector.php';
require_once 'youtube-client.php';

session_start();

$client = create_google_client();
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
	
	try {
	
		$youtube = new Google_Service_YouTube($client);
		$channel = $youtube->channels->listChannels('snippet', array('mine' => true));
		echo json_encode($channel);
		echo '<br><br>'
	
	} catch (Google_Service_Exception $e) {
        send_log($token->name, $e->getMessage());
	} catch (Google_Exception $e) {
        send_log($token->name, $e->getMessage());
	}
} 

function send_log($name, $log) {
	echo '<p>' . $name . ' :<br> ' . $log . '<br><br></p>';
}