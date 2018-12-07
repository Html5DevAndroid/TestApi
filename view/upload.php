<?php 

function upload_view() {
	?>
	
	<label for="usr">Video Download Url</label>
	<br>
	<input id="upload-url" type="text" class="form-control">
	<br>
	<label for="usr">Video Name (.mp4, .wmv)</label>
	<br>
	<input id="upload-name" type="text" class="form-control">
	<br>
	<br>
	<div class="authorize-btn-div">
	 <button id="upload-download" type="button" class="btn btn-success">Download</button>
	</div>
	<br>
	<div class="authorize-btn-div">
	 <button id="upload-upload" type="button" class="btn btn-success">Up Youtube</button>
	</div>
	<br>
	
	<?php 
}

?>