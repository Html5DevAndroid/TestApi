<?php
require_once 'connector.php';
require_once 'youtube-client.php';

session_start();

$client = create_google_client();
 
$tokens = get_json_channel();

echo 'fuck';