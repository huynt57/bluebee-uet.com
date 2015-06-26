<div id="modal-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
				<h3 id="myModalLabel">Create</h3>
			</div>
			<div class="modal-body">
				<div class="panel panel-default">
					<div class="panel-body">
						<?php $this->renderPartialView("AdminFormCreate") ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="pull-left"><div data-form="form-create" data-loading="1" class="loading"></div></div>
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal" aria-hidden="true">Close</button>
				<button type="button" data-click="__ajax('#form-create')" class="btn btn-primary btn-sm">Save changes</button>
			</div>
		</div>
	</div>
</div>