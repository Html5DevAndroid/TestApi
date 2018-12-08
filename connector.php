<?php

function get_json_channel() {
	$contents = get_content();
	
	return json_decode($contents);
}

function add_json_channel($name, $code) {
	$contents = get_content();
	$contents = json_decode($contents);
	
	$obj = new stdClass();
	$obj->name = $name;
	$obj->code = $code;
	$contents[] = $obj;
	
	put_content(json_encode($contents));
}

function update_json_channel($id, $name, $code) {
	$contents = get_content();
	$contents = json_decode($contents);
	
	$obj = new stdClass();
	$obj->name = $name;
	$obj->code = $code;
	$contents[$id] = $obj;
	
	put_content(json_encode($contents));
}

function delete_json_channel($id) {
	$contents = get_content();
	$contents = json_decode($contents);
	
	array_splice($contents, $id, 1);
	put_content(json_encode($contents));
}

function get_content() {
	return file_get_contents('https://api.myjson.com/bins/n7mim');
}

function put_content($data) {
	$url = 'https://api.myjson.com/bins/n7mim';

	$additional_headers = array(                                                                          
	   'Accept: application/json',
	   'Content-Type: application/json'
	);

	$ch = curl_init($url);                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, $additional_headers); 

	curl_exec ($ch);
}

?>