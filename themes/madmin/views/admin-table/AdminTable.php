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
	<?php if($table["actions"]["_new"] && $table["createType"]=="page"): ?>
		<script type="text/ng-template" id="create.html">
			<?php $this->renderPartialView("AdminPageCreate") ?>
		</script>
	<?php endif; ?>
</div>
<?php $this->renderAdditionalFiles("endDocument"); ?>
