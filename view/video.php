<?php 

function video_view() { 
	$videos = scandir("./video");
	array_splice($videos, 0, 2);
	?>
	
	<label for="usr">Tên Video Trên Youtube</label>
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
		<button id="<?php echo $video ?>" type="button" class="btn btn-warning video-up">Up</button>
		<span style="display:inline-block; width: 50px;"></span>
		<p class="channel-p"><?php echo $video ?></p>
		<br><br><br>
	</div>
	
	<?php
}

?>
