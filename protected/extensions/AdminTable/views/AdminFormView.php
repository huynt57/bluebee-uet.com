<div class="form-horizontal form-bordered form-validate">
	<?php foreach($table["actions"]["_view"] as $column): $field = $table["fields"][$column]; ?>
		<div class="form-group">
			<label for="<?php echo $column ?>" class="control-label col-lg-3"><?php echo $field["label"] ?></label>
			<div class="col-lg-9">
				<div class="checkbox">
				<?php switch ($field["type"]) {
					case '_checkbox':
						# code...
						?>
							<button type="button" class="btn btn-info btn-sm {{parseInt(currentViewRow.<?php echo $column ?>) ? 'btn-primary' : 'btn-danger'}}"><i class="{{parseInt(currentViewRow.<?php echo $column ?>) ? 'icon-ok' : 'icon-remove'}}"></i></button>
						<?php
						break;
					case '_image':
						?>
							<img src="{{currentViewRow.<?php echo $column ?>}}" style="max-width:100%" />
						<?php
						break;
					case '_file':
						?>
							<a target="_blank" ng-attr-href="{{currentViewRow.<?php echo $column ?>}}"><i class="icon-download-alt"></i></a>
						<?php
						break;
					case '_document':
						?>
							<a target="_blank" ng-attr-href="{{currentViewRow.<?php echo $column ?>}}"><i class="icon-download-alt"></i></a>
						<?php
						break;
					case '_url':
						?>
							<a href="{{currentViewRow.<?php echo $column ?>}}" target="_blank">Go to link</a>
						<?php
						break;
					case "_dropdown":
						?>
							<span class="label label-info label-sm">{{TableConfig.fields.<?php echo $column ?>.list[currentViewRow.<?php echo $column ?>]}}</span>
						<?php
						break;
					case "_timestamp":
						?>
							{{displayTimestamp(currentViewRow.<?php echo $column ?>)}}
						<?php
						break;
					default:
						?>
							<span>{{currentViewRow.<?php echo $column ?>}}</span>
						<?php
						break;
				} ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>