<?php 
if(!isset($field["searchAdvancedType"]))
	$field["searchAdvancedType"] = $field["type"];
switch ($field["searchAdvancedType"]) {
	case '_checkbox':
		# code...
		?>
			<div class="text-left">
				<select class="query-input text_filter input-sm form-control select-dropdown" name="search_advanced[<?php echo $column ?>]" ng-model="search_advanced_<?php echo $column ?>" ng-change="refresh()">
					<option value="">All</option>
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>
			</div>
		<?php
		break;
	case '_dropdown':
		?>
			<div class="text-left">
				<select class="query-input text_filter form-control input-sm select-dropdown" name="search_advanced[<?php echo $column ?>]" ng-model="search_advanced_<?php echo $column ?>" ng-change="refresh()">
					<option value="">All</option>
					<?php foreach($field["list"] as $value => $label): ?>
						<option value="<?php echo $value ?>"><?php echo $label ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<?php
		break;
	case "_number_range":
		?>
			<div class="div-table">
				<div class="">
					<input type="text" class="query-input text_filter input-sm form-control" placeholder="from" name="search_advanced[<?php echo $column ?>][from]" ng-enter="refresh()" />
				</div>
				<div class="text-right">
					<input type="text" class="query-input text_filter input-sm form-control" placeholder="to" name="search_advanced[<?php echo $column ?>][to]" ng-enter="refresh()" />
				</div>
			</div>
		<?php
		break;
	case "_datetime":
		?>
			<div class="input-group date datepicker-filter input-group-sm mbs text_filter">
				<input type="text" class="query-input input-sm form-control input-date" placeholder="<?php echo $field["label"]; ?>" name="search_advanced[<?php echo $column ?>]" ng-enter="refresh()" />
				<span class="input-group-addon"><i class="icon-calendar"></i></span>
			</div>
		<?php
		break;
	case "_timestamp":
		?>
			<div class="input-group date datepicker-filter input-group-sm mbs text_filter">
				<input type="text" class="query-input input-sm form-control input-date" placeholder="<?php echo $field["label"]; ?>" name="search_advanced[<?php echo $column ?>]" ng-enter="refresh()" />
				<span class="input-group-addon"><i class="icon-calendar"></i></span>
			</div>
		<?php
		break;
	case "_timestamp_range":
		?>
			<div class="div-table">
				<div class="">
					<div class="input-group date datepicker-filter input-group-sm mbs text_filter">	
						<input type="text" data-format="yyyy-mm-dd" class="query-input input-sm form-control input-date" placeholder="from" name="search_advanced[<?php echo $column ?>][from]" ng-enter="refresh()" />
						<span class="input-group-addon"><i class="icon-calendar"></i></span>
					</div>
				</div>
				<div class="text-right">
					<div class="input-group date datepicker-filter input-group-sm mbs  text_filter">
						<input type="text" data-format="yyyy-mm-dd" class="query-input input-sm form-control input-date" placeholder="to" name="search_advanced[<?php echo $column ?>][to]" ng-enter="refresh()" />
						<span class="input-group-addon"><i class="icon-calendar"></i></span>
					</div>
				</div>
			</div>
		<?php
		break;
	case "_datetime_range":
		?>
			<div class="div-table">
				<div class="">
					<div class="input-group date datepicker-filter input-group-sm mbs text_filter">	
						<input type="text" data-format="yyyy-mm-dd" class="query-input input-sm form-control input-date" placeholder="from" name="search_advanced[<?php echo $column ?>][from]" ng-enter="refresh()" />
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</div>
				</div>
				<div class="text-right">
					<div class="input-group date datepicker-filter input-group-sm mbs text_filter">
						<input type="text" data-format="yyyy-mm-dd" class="query-input input-sm form-control input-date" placeholder="to" name="search_advanced[<?php echo $column ?>][to]" ng-enter="refresh()" />
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</div>
				</div>
			</div>
		<?php
		break;
	default:
		?>
			<input type="text" class="query-input input-sm form-control" placeholder="<?php echo $field["label"]; ?>" name="search_advanced[<?php echo $column ?>]" ng-enter="refresh()" />
		<?php
		break;
} ?>