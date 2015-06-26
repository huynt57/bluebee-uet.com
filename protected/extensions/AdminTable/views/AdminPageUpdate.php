<div ng-core-controller ng-rendered>
	<div class="panel panel-primary">
		<div class="panel-heading">Change <?php echo $table["itemLabel"] ?>'s information</div>
		<div class="panel-body">
			<?php $this->renderPartialView("AdminFormUpdate") ?>
			<div class="row">
				<div class="col-lg-4">
					<div data-form="form-edit" data-loading="1" class="loading"></div>
				</div>
				<div class="col-lg-8 text-right">
					<a href="#/table" class="btn btn-default btn-sm" aria-hidden="true">Close</a>
					<button type="button" data-click="__ajax('#form-edit')" class="btn btn-primary btn-sm">Save changes</button>
				</div>
			</div>
		</div>
	</div>
</div>