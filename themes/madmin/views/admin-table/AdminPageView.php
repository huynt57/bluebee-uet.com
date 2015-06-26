<div ng-core-controller ng-rendered>
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">
				<?php echo $table["itemLabel"] ?>'s detail
			</div>
		</div>
		<div class="page-header pull-right">
			<div class="page-toolbar" style="margin-top:8px">
				<a href="#/table" class="btn btn-success btn-sm" aria-hidden="true">Back</a>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			<div class="panel panel-default" style="margin-top:15px;">
				<div class="panel-body">
					<?php $this->renderPartialView("AdminFormView") ?>
				</div>
			</div>
		</div>
	</div>
</div>