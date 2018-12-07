<?php 
require_once __DIR__.'/vendor/autoload.php';

function create_google_client($redirect_path = 'oauth2callback.php') {
	$client = new Google_Client();
	$client->setAuthConfig('client_secrets.json');
	$client->addScope("https://www.googleapis.com/auth/youtubepartner");
	$client->addScope("https://www.googleapis.com/auth/youtube.upload");
	$client->setAccessType('offline');
	$client->setApprovalPrompt('force');
	$client->setIncludeGrantedScopes(true);
		
	$client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/' . $redirect_path);
	
	return $client;
}
?>