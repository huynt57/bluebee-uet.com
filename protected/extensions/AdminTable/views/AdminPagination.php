<div class="row">
	<div class="dataTables_info col-lg-6" ng-if="page!=0 && rows.length">
		Showing <span>{{(page-1)*per_page+1}}</span> to <span>{{page*per_page < count ? page*per_page : count}}</span> of <span>{{count}}</span> entries
	</div>
	<div class="dataTables_info col-lg-6" ng-if="page==0">
		Showing all entries
	</div>
	<div class="dataTables_paginate col-lg-6 text-right" ng-if="page==0 && TableConfig.dragToReOrder && count==countAll">
		<button type="button" class="btn btn-info btn-sm" ng-click="updateOrder()" ng-disabled="!orderUpdateable">Apply Orders</button>
	</div>
	<div class="dataTables_paginate paging_full_numbers col-lg-6 text-right" ng-if="page!=0 && rows.length">
		<ul class="pagination pagination-sm">
			<li ng-attr-class="{{page==1 && 'disabled'}}">
				<a href="javascript:void(0);" ng-attr-class="first paginate_button {{page==1 && 'disabled'}}" role="button" ng-disabled="page==1" ng-click="page==1 || changePage(1)">First</a>
			</li>
			<li ng-attr-class="{{page-1<1 && 'disabled'}}">
				<a href="javascript:void(0);" ng-attr-class="previous paginate_button {{page-1<1 && 'disabled'}}" ng-disabled="page-1<1" ng-click="page-1<1 || changePage(page-1)">Previous</a>
			</li>
			<!-- pages -->
			<li ng-repeat="pageItem in pages" ng-attr-class="{{pageItem.active ? 'active' : ''}}" >
				<a href="javascript:void(0);" ng-click="changePage(pageItem.num)">{{pageItem.num}}</a>
			</li>
			<!-- /pages -->
			<li ng-attr-class="{{page+1>pageLast && 'disabled'}}">
				<a href="javascript:void(0);" ng-attr-class="next paginate_button {{page+1>pageLast && 'disabled' }}" ng-disabled="page+1>pageLast" ng-click="page+1>pageLast || changePage(page+1)">Next</a>
			</li>
			<li ng-attr-class="{{page==pageLast && 'disabled'}}">
				<a href="javascript:void(0);" ng-attr-class="last paginate_button {{page==pageLast && 'disabled' }}" ng-disabled="page==pageLast" ng-click="page==pageLast || changePage(pageLast)">Last</a>
			</li>
		</ul>
	</div>
</div>