<form id="form-create" action="<?php echo $table["url"] ?>?action=insert" method="POST" onkeypress="return event.keyCode != 13;" class="form-horizontal form-bordered form-validate form-edit" ng-success="form-create" <?php if(isset($table["formUpload"]) && $table["formUpload"]): ?>enctype="multipart/form-data" data-type="iframe" <?php endif; ?>>
	<?php foreach($table["actions"]["_new"]["attr"] as $column): $field = $table["fields"][$column]; ?>
		<div class="form-group">
			<label for="<?php echo $column ?>" class="control-label col-lg-3"><?php echo $field["label"] ?></label>
			<div class="col-lg-9 text-left">
				<?php switch ($field["type"]) {
					case '_checkbox':
						# code...
						?>
							<input type="checkbox" class="input-sm" name="<?php echo $column ?>" value="1" />
						<?php
						break;
					case '_html':
						# code...
						?>
							<textarea class="form-control input-sm input-html" ng-tinymce name="<?php echo $column ?>"></textarea>
						<?php
						break;
					case '_dropdown':
						?>
							<select name="<?php echo $column ?>" class="form-control input-sm select-dropdown">
								<?php foreach($field["list"] as $value => $label): ?>
									<option value="<?php echo $value ?>"><?php echo $label ?></option>
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
							<textarea class="form-control input-sm" name="<?php echo $column ?>" rows="3"></textarea>
						<?php
						break;
					case "_password":
						?>
							<input type="password" class="form-control input-sm" name="<?php echo $column ?>" />
						<?php
						break;
					default:
						?>
							<input type="text" class="form-control input-sm" name="<?php echo $column ?>" />
						<?php
						break;
				} ?>
			</div>
		</div>
	<?php endforeach; ?>
</form>