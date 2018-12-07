<?php 

function playlist_view() {
	?>
	
	<label for="usr">Playlist Name</label>
	<br>
	<input id="playlist-name" type="text" class="form-control">
	<br>
	<label for="usr">Playlist Description</label>
	<br>
	<input id="playlist-description" type="text" class="form-control">
	<br>
	<label for="usr">Video Id</label>
	<br>
	<input id="playlist-video" type="text" class="form-control">
	<br>
	<div class="authorize-btn-div">
	 <button id="playlist-submit" type="button" class="btn btn-success">Create</button>
	</div>
	<br>
	
	<?php 
}

?>