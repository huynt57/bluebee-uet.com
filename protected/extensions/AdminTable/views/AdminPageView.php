<div ng-core-controller ng-rendered>
	<div class="panel panel-primary">
		<div class="panel-heading"><?php echo $table["itemLabel"] ?>'s information</div>
		<div class="panel-body">
			<?php $this->renderPartialView("AdminFormView") ?>
			<div class="text-right">
				<a href="#/table" class="btn btn-default btn-sm" aria-hidden="true">Close</a>
			</div>
		</div>
	</div>
</div>