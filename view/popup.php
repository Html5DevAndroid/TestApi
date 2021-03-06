<?php 

function create_popup($title, $body, $id) {
	?>
	
	<!-- Modal -->
	<div id="<?php echo $id ?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"><?php echo $title ?></h4>
		  </div>
		  <div class="modal-body">
			<?php echo $body(); ?>
			<br>
			<br>
			<div id="logging-<?php echo $id ?>"></div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	  </div>
	</div>
	
	<?php
}
?>