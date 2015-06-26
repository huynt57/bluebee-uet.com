<div ng-core-controller ng-rendered>
	<div class="panel panel-primary">
		<div class="panel-heading">New <?php echo $table["itemLabel"] ?></div>
		<div class="panel-body">
			<?php $this->renderPartialView("AdminFormCreate") ?>
			<div class="row">
				<div class="col-lg-4">
					<div data-form="form-create" data-loading="1" class="loading"></div>
				</div>
				<div class="col-lg-8 text-right">
					<a href="#/table" class="btn btn-default btn-sm" aria-hidden="true">Close</a>
					<button type="button" data-click="__ajax('#form-create')" class="btn btn-primary btn-sm">Save changes</button>
				</div>
			</div>
		</div>
	</div>
</div>