<?php
require_once 'connector.php';
require_once 'youtube-client.php';

session_start();

$client = create_google_client();
$tokens = get_json_channel();

echo json_encode($tokens);

function send_log($name, $log) {
	echo '<p>' . $name . ' :<br> ' . $log . '<br><br></p>';
}