<?php 

function video_view() { 
	$videos = scandir('./video'); 
	?>
	
	<label for="usr">Tên Youtube</label>
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
		<p class="channel-p"><?php echo $video ?></p>
		<span style="display:inline-block; width: 15px;"></span>
		<button type="button" class="btn btn-warning">Up</button>
		<br>
	</div>
	
	<?php
}

?>
