<button type="button" class="btn btn-default btn-sm" ng-attr-data-click="__ajax('#form-delete-{{row.<?php echo $table["primary"] ?>}}')" rel="tooltip" title="Delete">
	<i class="icon-trash"></i>
</button>
<form ng-attr-id="form-delete-{{row.<?php echo $table["primary"] ?>}}" class="hidden" action="<?php echo $table["url"] ?>?action=delete" method="post" ng-success="form-delete"  data-confirm="<?php echo $table["confirmDeleteMessage"] ?>" ?>
	<input type="hidden" name="<?php echo $table["primary"] ?>" ng-attr-value="{{row.<?php echo $table["primary"] ?>}}" />
</form>