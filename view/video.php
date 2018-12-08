<?php 

function video_view() { 
	$videos = scandir("./video");
	array_splice($videos, 0, 2);
	?>
	
	<label for="usr">Tên Youtube Video</label>
	<br>
	<input id="video-name" type="text" class="form-control">
	<br>

	<?php 
	
	for($i=0; $i<count($videos); $i++) {		
		video_item($videos[$i]);
	}
}

function video_item($video) {
	?>
	
	<div class="channel-row">
		<button id="video-up" type="button" class="btn btn-warning">Up</button>
		<span style="display:inline-block; width: 50px;"></span>
		<p id="video-file" class="channel-p"><?php echo $video ?></p>
		<button id="remove-video-<?php echo $id ?>" type="button" class="close remove-video">&times;</button>
		<br>
	</div>
	
	<?php
}

?>
