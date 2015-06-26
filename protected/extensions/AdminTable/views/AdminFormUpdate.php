<form id="form-edit" action="<?php echo $table["url"] ?>?action=update" onkeypress="return event.keyCode != 13;" method="POST" ng-success="form-edit" <?php if(isset($table["formUpload"]) && $table["formUpload"]): ?>enctype="multipart/form-data" data-type="iframe" <?php endif; ?> class="form-horizontal form-bordered form-validate form-edit">
	<input type="hidden" name="<?php echo $table["primary"] ?>" ng-attr-value="{{currentEditRow.<?php echo $table["primary"] ?>}}" />
	<?php foreach($table["actions"]["_edit"] as $column): $field = $table["fields"][$column]; ?>
		<div class="form-group">
			<label for="<?php echo $column ?>" class="control-label col-lg-3"><?php echo $field["label"] ?></label>
			<div class="col-lg-9">
				<?php switch ($field["type"]) {
					case '_checkbox':
						# code...
						?>
							<input type="checkbox" class="input-sm" name="<?php echo $column ?>" value="1" ng-checked="parseInt(currentEditRow.<?php echo $column ?>)" />
						<?php
						break;
					case '_html':
						# code...
						?>
							<textarea class="form-control input-sm input-html" ng-tinymce name="<?php echo $column ?>">{{currentEditRow.<?php echo $column ?>}}</textarea>
						<?php
						break;
					case '_dropdown':
						?>
							<select name="<?php echo $column ?>" class="form-control input-sm select-dropdown">
								<?php foreach($field["list"] as $value => $label): ?>
									<option value="<?php echo $value ?>" ng-selected="currentEditRow.<?php echo $column ?>=='<?php echo $value ?>'"><?php echo $label ?></option>
								<?php endforeach; ?>
							</select>
						<?php
						break;
					case "_image":
						?>
							<input type="file" class="form-control input-sm" name="<?php echo $field["modelFile"] ?>" accept="image/*" class="input-sm form-control" />
						<?php
						break;
					case "_document":
						?>
							<input type="file" class="form-control input-sm" name="<?php echo $field["modelFile"] ?>" accept="application/pdf" class="input-sm form-control" />
						<?php
						break;
					case "_file":
						?>
							<input type="file" class="form-control input-sm" name="<?php echo $field["modelFile"] ?>" class="input-sm form-control" />
						<?php
						break;
					case "_textarea":
						?>
							<textarea class="form-control input-sm" name="<?php echo $column ?>" class="input-sm form-control" rows="3">{{currentEditRow.<?php echo $column ?>}}</textarea>
						<?php
						break;
					case "_password":
						?>
							<input type="password" class="form-control input-sm" name="<?php echo $column ?>" class="input-sm form-control" />
						<?php
						break;
					default:
						?>
							<input type="text" class="form-control input-sm" name="<?php echo $column ?>" value="{{currentEditRow.<?php echo $column ?>}}" class="input-sm form-control" />
						<?php
						break;
				} ?>
			</div>
		</div>
	<?php endforeach; ?>
</form>