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
	
	<div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-1">
					<button id="<?php echo $video ?>" type="button" class="close remove-video">&times;</button>
				</div>
				<div class="col-xs-11 channel-row">
					<button id="<?php echo $video ?>" type="button" class="btn btn-warning video-up">Up</button>
					<span style="display:inline-block; width: 50px;"></span>
					<p id="video-file" class="channel-p"><?php echo $video ?></p>
				</div>
				<br>
			</div>
		</div>
	</div>
	
	<?php
}

?>
