(function(){

    var currentViewRow = {}, currentEditRow = {};
    var rows = [];
    var offlineData = {};

    $__$.angular.onScope(function(arr){
        var $scope = arr["$scope"];
        var $rootScope = arr["$rootScope"];
        var $element = arr["$element"];

        /*$scope.currentEditRow = currentEditRow;
        $scope.currentViewRow = currentViewRow;
        $scope.rows = rows;*/

        $scope.TableConfig = TableConfig;
        $.each(TableConfig.default,function(k,v){
            $scope[k] = v;
        });



        $scope.displayDatetime = function(datetime){
            var date = new Date(datetime*1000);
            return date.toDateString();
        }

        $scope.displayTimestamp = function(datetime){
            var date = new Date(datetime*1000);
            return date.toDateString();
        }

        $scope.parseInt = function(val)
        {
            return window.parseInt(val);
        }
        $scope._link_template = function(row,template){
            $.each(row,function(key,value){
                template = template.replace(new RegExp("%"+key,"g"),value);
            });
            return template;
        }


    });

    var loads = ["ngRoute","ngAnimate"];
    if(TableConfig.dragToReOrder)
        loads.push("ui");
    var app = angular.module('app',loads);
    $__$.angular.init(app);
    // URL
    app.config(function($routeProvider,$locationProvider){
        $routeProvider.when("/table",{
            controller : "TableController",
            templateUrl : "table.html"
        })
        .otherwise({
            redirectTo : "/table",
        });

        if(TableConfig.viewType=="page"){
            $routeProvider.when("/view/:id",{
                controller : "ViewController",
                templateUrl : "view.html"
            });
        }

        if(TableConfig.editType=="page"){
            $routeProvider.when("/edit/:id",{
                controller : "EditController",
                templateUrl : "edit.html"
            });
        }

        if(TableConfig.createType=="page"){
            $routeProvider .when("/create",{
                controller : "CreateController",
                templateUrl : "create.html"
            });
        }
    });

    if(TableConfig.viewType=="page"){
        app.controller("ViewController",["$scope","$routeParams",function($scope,$routeParams){
            kkk = $scope;
            var index = $routeParams.id;
            if(rows[index]==undefined)
            {
                location.replace(location.pathname);
                return;
            }
            $scope.currentViewRow = rows[index];
        }]);
    }
    if(TableConfig.editType=="page"){
        app.controller("EditController",["$scope","$routeParams",function($scope,$routeParams){
            var index = $routeParams.id;
            if(rows[index]==undefined)
            {
                location.replace(location.pathname);
                return;
            }
            $scope.currentEditRow = rows[index];

            $scope.$on("form-edit",function(e,data,$elem){
                location.hash = "/table?refresh=1";
            });
        }]);
    }
    if(TableConfig.createType=="page"){
        app.controller("CreateController",function($scope){
            $scope.$on("form-create",function(e,data,$elem){
                location.hash = "/table?refresh=1";
            });
        });
    }
    // Main
    app.controller("MainController",function($scope){
    });
    // Table
    app.controller('TableController',function($scope,$http,$routeParams) {
        ttt = $scope;
        var url = TableConfig.url;
        //$scope.rows = [];
        $scope.count = 0;
        $scope.pages = [];
        $scope.pageLast = 0;
        $scope.refreshCount = 0;
        $scope.loading = false;

        $scope.currentViewRow = {};
        $scope.currentEditRow = {};

        $scope.$on("form-edit",function(e,data,$elem){
            //console.log(data);
           $(".modal-backdrop").remove();
           if(TableConfig.editType=="page")
                return;
           $("#modal-edit").modal("hide");
            refreshTable();
        });

        $scope.$on("form-create",function(e,data,$elem){
            //console.log(data);
            $(".modal-backdrop").remove();
            if(TableConfig.createType=="page")
                return;
            $("#modal-create").modal("hide");
            refreshTable();
        });

        $scope.$on("form-delete",function(e,data,$elem){
            //console.log(data);
            $(".modal-backdrop").remove();
            refreshTable();
        });

        window.editClick = function(elem){
            var row = rows[$(elem).data("index")];
            $scope.currentEditRow = row;
            $scope.$apply();
            $modal = $("#modal-edit");
            $__$.updateHtml($modal);
            $modal.modal("show");
        };

        window.viewClick = function(elem){
             var row = rows[$(elem).data("index")];
            $scope.currentViewRow = row;
            $scope.$apply();
            $modal = $("#modal-view");
            $__$.updateHtml($modal);
            $modal.modal("show");
        };

        $scope.$watch("currentEditRow",function(){
            //$__$.updateHtml($("#modal-edit"));
        });

        $scope.refresh = function(){
            refreshTable();
        };
        $scope.changeOrder = function(orderBy)
        {
            if(orderBy==$scope.orderBy)
            {
                $scope.orderBy = orderBy;
                $scope.orderType = $scope.orderType=="desc" ? "asc" : "desc";
            }
            else
            {
                $scope.orderBy = orderBy;
                $scope.orderType = "desc";
            }
            refreshTable();
        };
        $scope.changePage = function(page)
        {
            $scope.page = page;
            refreshTable();
        };
        
        $scope.checkAll = function(){
            $.each($scope.rows,function(k,r){
                r.__checked = $scope.__checkedAll;
            });
        }
        $scope.doAction = function(obj){
            var ids = getSelected();
            if(!ids.length){
                $__$.alert("You must select at least 1 item!");
                return;
            }
            var url = TableConfig.url;
            var data = {
                id : ids
            };
            if(obj.type=="delete"){
                url += "?multiple=1&action=delete";
            } else{
                url += "?multiple=1&action=update";
                data["attrs"] = obj.attrs;
            }
            var callback = function(){
                $.ajax({
                    url : url,
                    type : "post",
                    data : data,
                    success : function(){
                        refreshTable();
                    }
                });
            };

            if(!obj.confirm)
                callback();
            else
                $__$.confirm(obj.confirm,{
                    callback : function(r){
                        //console.log(r);
                        if(r)
                            callback();
                    }
                });
        };

        //

        var getSelected = function(){
            var ids = [];
            $.each($scope.rows,function(k,r){
                if(!r.__checked)
                    return;
                ids.push(r.id);
            });
            return ids;
        }

        var refreshTableOffline = function(offlineData){
            var data = offlineData;
            $scope.rows = data.data;
            $scope.count = parseInt(data.count);
            $scope.pageLast = getPageLast();
            $scope.pages = getPages();
            if($scope.refreshCount==0 && $scope.page==0)
            {
                $scope.countAll = $scope.count;
            }
            $scope.refreshCount++;
        };

        var refreshTable = function(callback){
            $scope.loading = true;
            $http.get(getListUrl(url)).success(function(obj) {
               var data = obj.data;
               refreshTableOffline(data);
                callback && callback();
                $scope.loading = false;
                // global

                rows = data.data;
                offlineData = data;
            });
        };
        var getPageLast = function(){
            return Math.ceil($scope.count / $scope.per_page);
        };
        var getPages = function(){
            if(!$scope.count)
                return [];
            var pages = [];
            // do
            var pageLast = $scope.pageLast;
            var current = $scope.page;
            var leftSize = 2;
            var rightSize = 2;
            var leftSizeAllowed = current - 1;
            var rightSizeAllowed = pageLast - current;
            leftSize = Math.min(leftSize,leftSizeAllowed);
            rightSize = Math.min(rightSize,rightSizeAllowed);
            for(var i=current-leftSizeAllowed;i<current;i++)
            {
                pages.push({
                    num : i,
                    active : false
                });
            }
            pages.push({
                num : current,
                active : true
            });
            for(var i=current+1;i<=current+rightSizeAllowed;i++)
            {
                pages.push({
                    num : i,
                    active : false
                });
            }
            //
            return pages;
        };
        function encodeQueryData(data)
        {
           var ret = [];
           for (var d in data)
              ret.push(encodeURIComponent(d) + "=" + encodeURIComponent(data[d]));
           return ret.join("&");
        };
        var getListUrl = function(url){
            // order, page, per_page, search, search_advanced
            // default
            var order = $scope.orderBy + " " + $scope.orderType;
            var page = $scope.page;
            var per_page = $scope.per_page;
            var search = $scope.search;
            var search_advanced = $scope.search_advanced;
            // parse variable from table

            // return url
            var q = {
                order : order,
                page : page,
                per_page : per_page,
                search : search
            };
            $(".query-input").each(function(){
                var val = $.trim($(this).val());
                if(!val)
                    return;
                q[$(this).attr("name")] = val;
            });
            var query = encodeQueryData(q);
            if(TableConfig.conditionDynamic)
            {
                $.each(TableConfig.conditionDynamic,function(k,v){
                    query += "&"+k+"="+v;
                });
            }
            query += "&action=data";
            return url+"?"+query;

        };

        // drag to reorder
        if(TableConfig.dragToReOrder)
        {
            var urlOrder = TableConfig.url + "?action=reorder";
            $scope.orderUpdateable = false;
            $scope.sortableOptions = {
                axis: 'y',
                update: function(){
                    $scope.orderUpdateable = true;
                }
            };
            $scope.updateOrder = function(){
                var orders = [];
                $("#tableDraggable.table-draggable tr").each(function(k,v){
                    orders.push({
                        index : k,
                        id : $(v).attr("data-id")
                    });
                });
                console.log(orders);
                $.ajax({
                    type : "post",
                    url : urlOrder,
                    data : {
                        orders : orders
                    },
                    success : function(){
                        $scope.$apply(function(){
                            $scope.orderUpdateable = false;
                        });
                    }
                });
            };
        }

        // start
        if($routeParams.refresh || rows.length==0){
            refreshTable();
        }
        else
        {
            refreshTableOffline(offlineData);
            //$("#table")
        }
    });
})();