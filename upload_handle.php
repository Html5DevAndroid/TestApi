<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = json_decode(file_get_contents('php://input'));
	
	set_time_limit(0);
	$f = file_put_contents("./video/".$content->name, fopen($content->url, 'r'));
	if ($f) echo 'ok';
	else echo 'error';
}

?>