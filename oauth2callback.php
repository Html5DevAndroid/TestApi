<?php
require_once 'connector.php';
require_once 'youtube-client.php';

session_start();

$client = create_google_client(basename(__FILE__));

if(isset($_GET['ajax_channel_name'])) {
	if($_GET['ajax_channel_name'] != null) {
		$_SESSION["channel_name"] = $_GET['ajax_channel_name'];
	}
}

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  add_json_channel($_SESSION["channel_name"], json_encode($client->getAccessToken()));
  unset($_SESSION["channel_name"]);
  $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/index.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}