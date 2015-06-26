<div id="modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
				<h3 id="myModalLabel">Change <?php echo $table["itemLabel"] ?>'s information</h3>
			</div>
			<div class="modal-body">
				<div class="panel panel-default">
					<div class="panel-body">
						<!-- Form -->
						<?php $this->renderPartialView("AdminFormUpdate") ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="pull-left"><div data-form="form-edit" data-loading="1" class="loading"></div></div>
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal" aria-hidden="true">Close</button>
				<button type="button" data-click="__ajax('#form-edit')" class="btn btn-primary btn-sm">Save changes</button>
			</div>
		</div>
	</div>
</div>