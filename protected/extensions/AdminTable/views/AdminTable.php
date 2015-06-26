

<?php $this->renderAdditionalFiles("beginDocument"); ?>
<?php 
	$this->useAssetExtension("admin-table");
?>
<script>
	var $table = null;
	$(function(){
		window.$table = $("#theTable");
		$("#theTable table").addClass("dataTable");
	});
</script>
<div class="row">
	<div class="col-lg-6">
		<h4>
			<?php echo $table["title"] ?>
		</h4>
	</div>
	<div class="col-lg-6">
		<?php $this->renderAdditionalFiles("rightOfTitle"); ?>		
	</div>
</div>
<?php $this->renderAdditionalFiles("beforeTable"); ?>
<div ng-app="app" ng-controller="MainController" ng-core-controller ng-rendered>
	<div ng-view class="main-view" style="position:relative;"></div>
	<script type="text/ng-template" id="table.html">
		<?php $this->renderPartialView("AdminTableData"); ?>
	</script>
	<?php if(($table["actions"]["_edit"]) && $table["editType"]=="page"): ?>
		<script type="text/ng-template" id="edit.html">
			<?php $this->renderPartialView("AdminPageUpdate"); ?>
		</script>
	<?php endif; ?>
	<?php if(($table["actions"]["_view"]) && $table["viewType"]=="page"): ?>
		<script type="text/ng-template" id="view.html">
			<?php $this->renderPartialView("AdminPageView"); ?>
		</script>
	<?php endif; ?>
	<?php if($newAction = $table["actions"]["_new"]): ?>
		<div>
			<div class="text-right">
				<?php if($newAction["type"]=="link"): ?>
					<a href="<?php echo $newAction["href"] ?>" class="btn btn-danger btn-sm" style="margin-top:20px;" target="_self"><i class="icon-plus"></i> New <?php echo $table["itemLabel"] ?></a>
				<?php elseif($table["createType"]=="page"): ?>
					<a href="#/create" data-toggle="modal" class="btn btn-danger btn-sm" style="margin-top:20px;"><i class="icon-plus"></i> New <?php echo $table["itemLabel"] ?></a>
					<script type="text/ng-template" id="create.html">
						<?php $this->renderPartialView("AdminPageCreate") ?>
					</script>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
</div>
<?php $this->renderAdditionalFiles("afterTable"); ?>
<?php $this->renderAdditionalFiles("endDocument"); ?>
