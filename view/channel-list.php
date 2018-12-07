<?php
	function create_channel_row($channel, $id) {
		?>
		
		<div class="row">
			<div class="col-xs-4">
				<div class="custom-control custom-checkbox channel-row">
					<input id="tick<?php echo $id ?>" type="checkbox" class="custom-control-input tick-channel">
					<span style="display:inline-block; width: 15px;"></span>
					<p class="channel-p"><?php echo ($id+1) . '  &ensp;&ensp;  ' . $channel ?></p>
				</div>
			</div>
			<div class="col-xs-4">
			</div>
			<div class="col-xs-4">
				<button id="remove-channel-<?php echo $id ?>" type="button" class="close channel-list-close">&times;</button>
			</div>
		</div>
		
		<?php
	}
	
	function create_channel_frame($channels) {
		?> 
			<div class="container">
				<?php 
					for($i=0; $i<count($channels); $i++) {
						create_channel_row($channels[$i]->name, $i);	
					}
				?>
			</div>
		<?php
	}
 ?>