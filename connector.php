<?php

$username = 'root';
$pass = '';
$db = 'test_db_for_youtube_api';

$conn = new mysqli('localhost', $username, $pass, $db) or die("Cannot Connect");

function add_token($code, $name) {
	$conn = $GLOBALS['conn'];
	$query = 'INSERT INTO authen_code (code, name) VALUES ("'.mysqli_real_escape_string($conn, $code).'", "'.$name.'")';
	if($conn->query($query) === TRUE) {
		
	}else {
		echo $conn->error.$query;
	};
}

function update_token($code, $id) {
	$conn = $GLOBALS['conn'];
	$query = 'UPDATE authen_code SET code="'.mysqli_real_escape_string($conn, $code).'" WHERE id='.$id;
	if($conn->query($query) === TRUE) {
		
	}else {
		echo $conn->error.$query;
	};
}

function get_token() {
	$conn = $GLOBALS['conn'];
	$query = 'SELECT * FROM authen_code';
	
	$result = $conn->query($query);
	
	if ($result->num_rows > 0) {
		 $arr = array();
		 while($row = $result->fetch_assoc()) {
			 $object = new stdClass();
			 $code = $row['code'];
			 $code = (array) json_decode($code);
			 
			 $object->token = $code;
			 $object->id = $row['id'];
			 $object->name = $row['name'];
			 
			 $arr[] = $object;
		 }
		 		 
		 return $arr;
	} else{
		return null;
	}
}

function get_json_channel() {
	$contents = file_get_contents("./json/channels.json");
	
	return json_decode($contents);
}

function add_json_channel($name, $code) {
	$contents = file_get_contents("./json/channels.json");
	$contents = json_decode($contents);
	
	$obj = new stdClass();
	$obj->name = $name;
	$obj->code = $code;
	$contents[] = $obj;
	
	file_put_contents('./json/channels.json', json_encode($contents));
}

function update_json_channel($id, $name, $code) {
	$contents = file_get_contents("./json/channels.json");
	$contents = json_decode($contents);
	
	$obj = new stdClass();
	$obj->name = $name;
	$obj->code = $code;
	$contents[$id] = $obj;
	
	file_put_contents('./json/channels.json', json_encode($contents));
}

function delete_json_channel($id) {
	$contents = file_get_contents("./json/channels.json");
	$contents = json_decode($contents);
	
	array_splice($contents, $id, 1);
	file_put_contents('./json/channels.json', json_encode($contents));
}

?>