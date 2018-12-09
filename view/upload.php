<?php 

function upload_view() {
	?>
	
	<label for="usr">Video Download Url (Not Watch Url)</label>
	<br>
	<input id="upload-url" type="text" class="form-control">
	<br>
	<label for="usr">Tên File (.mp4, .wmv) ? Không Reload cho đến khi down xong</label>
	<br>
	<input id="upload-name" type="text" class="form-control">
	<br>
	<br>
	<div class="authorize-btn-div">
	 <button id="upload-download" type="button" class="btn btn-success">Download</button>
	</div>
	<br>
	
	<?php 
}

?>