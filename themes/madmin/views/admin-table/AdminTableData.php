<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
	<div class="page-header pull-left">
		<div class="page-title">
			<?php echo $table["title"] ?>
		</div>
	</div>
	<div class="page-header pull-right">
		<div class="page-toolbar" style="margin-top:8px">
			<?php $this->renderAdditionalFiles("rightOfTitle"); ?>
			<!-- CREATE BUTTON -->
			<?php if($newAction = $table["actions"]["_new"]): ?>
				<?php if($newAction["type"]=="link"): ?>
					<a href="<?php echo $newAction["href"] ?>" class="btn btn-info btn-sm" target="_self"><i class="icon-plus"></i> New <?php echo $table["itemLabel"] ?></a>
				<?php else: ?>
					<?php if($table["createType"]=="popup"): ?>
						<a href="#modal-create" data-toggle="modal" class="btn btn-info btn-sm" target="_self"><i class="icon-plus"></i> New <?php echo $table["itemLabel"] ?></a>
						<?php $this->renderPartialView("AdminPopupCreate"); ?>
					<?php elseif($table["createType"]=="page"): ?>
						<a href="#/create" data-toggle="modal" class="btn btn-info btn-sm"><i class="icon-plus"></i> New <?php echo $table["itemLabel"] ?></a>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
			<!-- /CREATE BUTTON -->
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="row">
	<div class="<?php if(@$this->data["isPartial"]): ?>col-lg-12<?php else: ?>col-lg-12<?php endif; ?>">
		<?php $this->renderAdditionalFiles("beforeTable"); ?>
		<div id="theTable" ng-core-controller ng-rendered>
			<div class="loading-container" ng-if="loading">
				<div class="loading">
				</div>
			</div>
			<div class="panel panel-default" style="margin-top:15px">
				<div class="panel-body">
					<div class="row" style="margin-left:0px; margin-right:0px;">
						<div class="col-lg-6" style="padding-left:0px;">
							<label style="font-weight:normal">
								<select class="select-dropdown" ng-model="per_page" ng-change="refresh()" style="margin-right:5px;">
									<?php foreach($table["limit_values"] as $value): ?>
										<option value="<?php echo $value ?>"><?php echo $value ?></option>
									<?php endforeach; ?>
								</select>
								entries per page
							</label>
							<?php if(isset($table["actions"]["_checkbox"]) && ($checkbox = $table["actions"]["_checkbox"])): ?>
								<!-- Single button -->
								<div class="btn-group text-left">
									<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
									Action <span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu" style="left:auto; right:0px;">
										<?php foreach($checkbox as $action): ?>
											<li><a href="javascript:;" ng-click="doAction(<?php echo htmlspecialchars(json_encode($action),ENT_QUOTES)?>)"><?php echo $action["label"] ?></a></li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
						</div>
						<div class="col-lg-6 text-right" style="padding-right:0px;">
							<?php if($table["actions"]["_search"]): ?>
								<label>
									<span>Search: </span>
									<input type="text" id="search" class="form-control input-sm" placeholder="Search here..." ng-model="search" ng-enter="refresh()" style="display:inline-block; width:auto; margin-left:5px;" />
								</label>
							<?php endif; ?>
							<button type="button" class="btn btn-sm btn-default" ng-click="refresh()"><i class="icon-refresh"></i></button>
						</div>
					</div>
					<table class="table table-hover table-striped table-bordered table-advanced tablesorter" style="margin-top:15px;">
						<thead>
							<tr class="thetitle" role="row">
								<?php if(isset($table["actions"]["_checkbox"]) && $table["actions"]["_checkbox"]): ?>
									<th class="text-center" style="width:50px;"><input type="checkbox" ng-model="__checkedAll" ng-change="checkAll()" /></th>
								<?php endif; ?>
								<?php foreach($table["columns"] as $column): $field = $table["fields"][$column]; ?>
									<th data-field="<?php echo $column ?>" <?php if($field["orderable"]): ?> ng-click="changeOrder('<?php echo $column ?>')" ng-attr-class="orderable {{orderBy!='<?php echo $column ?>' && 'sorting' || orderType=='desc' && 'sorting_desc' || 'sorting_asc' }}"<?php endif; ?> <?php if($field["type"]=="_checkbox"): ?>style="width:100px;"<?php endif; ?>>
										<?php echo $table["fields"][$column]["label"] ?>
										<?php if($field["orderable"]): ?>
											<i ng-attr-class="pull-right orderable {{orderBy!='<?php echo $column ?>' && 'icon-sort' || orderType=='desc' && 'icon-sort-up' || 'icon-sort-down' }}"></i>
										<?php endif; ?>
									</th>
								<?php endforeach; ?>
								<th>
									Actions
								</th>
							</tr>
							<?php if($table["actions"]["_search_advanced"]): ?>
								<tr class="thefilter filters" role="row">
									<?php if(isset($table["actions"]["_checkbox"]) && $table["actions"]["_checkbox"]): ?>
										<td></td>
									<?php endif; ?>
									<?php 
										$temp_columns = array();
										foreach($table["actions"]["_search_advanced"] as $item){
											$temp_columns[$item] = $item;
										}
									?>
									<?php foreach($table["columns"] as $column): $field = $table["fields"][$column]; unset($temp_columns[$column]); ?>
										<td data-field="<?php echo $column ?>">
											<span class="filter_column filter_text">
												<?php if(in_array($column, $table["actions"]["_search_advanced"])): ?>
													<?php $this->renderPartialView("AdminAdvancedInput",array(
														"field" => $field,
														"column" => $column
													)); ?>
												<?php endif; ?>
											</span>
										</td>
									<?php endforeach; ?>
									<td>
										<?php if(false && count($temp_columns)): ?>
											<!-- Single button -->
											<div class="btn-group">
												<a href="#modal-filter" data-toggle="modal" class="btn btn-flat btn-rounded flat-white btn-sm">More</a>
												<!-- Modal Filter -->
												<div id="modal-filter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																<h3 id="myModalLabel">Filter</h3>
															</div>
															<div class="modal-body">
																<div class="panel panel-default">
																	<div class="panel-body form-horizontal">
																		<?php foreach($temp_columns as $column): $field = $table["fields"][$column]; ?>
																			<div class="form-group">
																				<label class="col-lg-3 control-label"><?php echo $field["label"] ?></label>
																				<div class="col-lg-9">
																					<?php $this->renderPartialView("AdminAdvancedInput",array(
																						"field" => $field,
																						"column" => $column
																					)) ?>
																				</div>
																			</div>
																		<?php endforeach; ?>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" ng-click="refresh()" class="btn btn-sm btn-primary" data-dismiss="modal" aria-hidden="true">Search</button>
																<button type="button" class="btn btn-sm" data-dismiss="modal" aria-hidden="true">Close</button>
															</div>
														</div>
													</div>
												</div>
												<!-- /Modal Filter -->
											</div>
										<?php endif; ?>
									</td>
								</tr>
							<?php endif; ?>
						</thead>
						<tbody id="tableDraggable" <?php if($table["dragToReOrder"]): ?>ui-sortable="sortableOptions" ng-model="rows" class="table-draggable"<?php endif; ?>>
							<tr ng-if="!rows.length && refreshCount > 0">
								<?php 
									$numCol = count($table["columns"]);
									if($table["hasAction"])
										$numCol++;
									if($table["actions"]["_checkbox"] && count($table["actions"]["_checkbox"]))
										$numCol++;
								?>
								<td colspan="<?php echo $numCol; ?>">
									<!-- NO ITEMS -->
									No <?php echo $table["itemLabel"] ?> found
								</td>
							</tr>
							<tr ng-if="rows.length" ng-repeat="row in rows" data-id="{{row.id}}" ng-rendered>
								<?php if(isset($table["actions"]["_checkbox"]) && $table["actions"]["_checkbox"]): ?>
									<td class="text-center" style="width:50px;"><input type="checkbox" ng-model="row.__checked" /></td>
								<?php endif; ?>
								<?php foreach($table["columns"] as $column): $field = $table["fields"][$column]; ?>
									<!-- DISPLAY FIELD -->
									<?php $this->renderPartial("ext.AdminTable.views.AdminFieldDisplay",array(
										"field" => $field,
										"column" => $column
									)) ?>
								<?php endforeach; ?>
								<td>
									<?php if($table["actions"]["_view"]): ?>
										<?php if($table["viewType"]=="popup"): ?>
											<button type="button" class="btn btn-sm btn-default"  onclick="window.viewClick(this)" data-index="{{$index}}" data-toggle="modal" rel="tooltip" title="View ">
												<i class="icon-info"></i>
											</button>
										<?php elseif($table["viewType"]=="page"): ?>
											<a ng-attr-href="#/view/{{$index}}" class="btn btn-sm btn-default" data-toggle="modal" rel="tooltip" title="View ">
												<i class="icon-info"></i>
											</a>
										<?php endif; ?>
									<?php endif; ?>
									<?php if($table["actions"]["_edit"]): ?>
										<?php if($table["editType"]=="popup"): ?>
											<button type="button" class="btn btn-sm btn-default" onclick="window.editClick(this)" data-index="{{$index}}" class="btn" data-toggle="modal" rel="tooltip" title="Edit ">
												<i class="icon-edit"></i>
											</button>
										<?php elseif($table["editType"]=="page"): ?>
											<a ng-attr-href="#/edit/{{$index}}" class="btn btn-sm btn-default" data-toggle="modal" rel="tooltip" title="Edit">
												<i class="icon-edit"></i>
											</a>
										<?php endif; ?>
									<?php endif; ?>
									<?php if($table["actions"]["_delete"]): ?>
										<?php $this->renderPartial("ext.AdminTable.views.AdminFormDelete",array(
											"table" => $table
										)); ?>
									<?php endif; ?>
									<?php if($table["actions"]["_link"]): ?>
										<a ng-attr-href="{{_link_template(row,'<?php echo $table["actions"]["_link"] ?>')}}" class="btn btn-sm btn-default">
											<i class="icon-eye-open"></i>
										</a>
									<?php endif; ?>
									<?php foreach($table["actions"]["_customButtons"] as $button): ?>
										<?php $this->renderPartial($button["content"],array(
											"table" => $table
										)) ?>
									<?php endforeach; ?>
								</td>
							</tr>
						</tbody>
					</table>
					<?php $this->renderPartialView("AdminPagination"); ?>
				</div>
			</div>
			<?php if(($editAction=$table["actions"]["_edit"]) && $table["editType"]=="popup"): ?>
				<?php
					$this->renderPartialView("AdminPopupUpdate"); 
				?>
			<?php endif; ?>
			<?php if(($editAction=$table["actions"]["_view"]) && $table["viewType"]=="popup"): ?>
				<?php $this->renderPartialView("AdminPopupView"); ?>
			<?php endif; ?>
		</div>
		<?php $this->renderAdditionalFiles("afterTable"); ?>
	</div>
</div>