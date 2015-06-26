// angular

(function(){
	$__$.on("angular-init",function(app){
		app.directive("ngCoreController",function($rootScope){
			return {
				link : function($scope,$element){
					$__$.angular.triggerScope({
						"$rootScope" : $rootScope,
						"$scope" : $scope,
						"$element" : $element
					});
				}
			}
		});
		app.directive("ngLocationManager",function($rootScope,$location){
			return {
				restrict : "A",
				link : function(){
					$__$.location = new function(){
						var $self = this;

						this.history = []; 
						this._currentIndex = -1;
						this.preventRemember = false;

						$rootScope.canBack = false;

						$rootScope.back = function(){
							$self.back();
						};

						$rootScope.next = function(){
							$self.next();
						};

						this.goto = function(path){
							location.hash = path;
							//$location.path(path).replace();
							//console.log("goto: " + path);
						};

						this.back = function(){
							if(!this.canBack())
								return;
							this.preventRemember = true;
							this.goto(this.history[--this._currentIndex]);
						};

						this.next = function(){
							if(!this.canNext())
								return;
							this.preventRemember = true;
							this.goto(this.history[++this._currentIndex]);
						};

						this.canBack = function(){
							return this.canIndex(this._currentIndex-1);
						};

						this.canNext = function(){
							return this.canIndex(this._currentIndex+1);
						};

						this.canIndex = function(index){
							return (index >= 0) && (index < this.history.length);
						};

						this.currentIndex = function(){
							return this._currentIndex;
						};

						this.clearHistory = function(){
							this.history = [];
							this._currentIndex = -1;
						};

						//

						$rootScope.$on('$locationChangeStart', function(e) {
							//console.log("$routeChangeStart.path: " + $location.path());
							if($self.preventRemember){
								// back or next
								return;
							}
							// user clicked in any link
							/*if($self._currentIndex==0){
								var prev = $self.history[0];
								$self.clearHistory();
								$self.history.push(prev);
							}*/
							$self.history.splice($self._currentIndex+1,$self.history.length-$self._currentIndex-1);
						});

						$rootScope.$on('$locationChangeSuccess', function(e) {
							//console.log("$routeChangeSuccess.path: " + $location.path());
							if($self.preventRemember || $location.search().prevent_remember)
							{
								//console.log("preventRemember");
								// back or next
								$self.preventRemember = false;
							}
							else
							{
								//$self.history.push($location.path());
								$self.history.push(location.hash);
								$self._currentIndex++;
							}
						});

						$rootScope.canBack = function(){
							var result = $self.canBack();
							//console.log(result ? "can go back" : "cannot go back");
							return result;
						};
					};
				}
			};
		});
		app.directive('ngBindHtmlUnsafe', function($compile){
		    return function( $scope, $element, $attrs ) {
		        var compile = function( newHTML ) { // Create re-useable compile function
		        	newHTML = '<div>'+newHTML+'</div>';
		            newHTML = $compile(newHTML)($scope);
		            if($element.get(0).moreThanOneTimeLoaded)
		            	$element.htmlPn(newHTML);
		            else
		            {
		            	$element.get(0).moreThanOneTimeLoaded = 1;
		            	$element.html(newHTML);
		            }
		        };
		        var htmlName = $attrs.ngBindHtmlUnsafe;
		        $scope.$watch(htmlName, function( newHTML ){
		            if(!newHTML) return;
		            compile(newHTML);   // Compile it
		        });
		    };
		}).directive("ngRendered",["$timeout",function($timeout){
			return {
				restrict : "A",
				scope : {
					"ngRendered" : "@"
				},
				link : function($scope,$element){
					$timeout(function(){
						$element.css("visibility","visible");
						$element.find(".angular-render").removeClass("angular-render");
						$__$.updateHtml($element);
						if($scope.ngRendered)
						{
							$scope.$parent.$eval($scope.ngRendered);
						}
						$scope.$emit("rendered");
					});
				}
			};
		}]).directive("ngSuccess",function(){
			var _index = 0;
			return {
				restrict : "A",
				link : function($scope, $element, $attrs){
					var success = $attrs.ngSuccess;
					var index = _index++;
					var attrName = "ng-success-id";
					$element.attr("data-success-event",success);
					$element.attr(attrName,index);
					$__$.on("form-"+success,function(obj){
						if($(obj.elem).attr(attrName)==index)
							$scope.$emit(success,obj.data,$element);
					});
				}
			};
		}).directive("ngClickConfirm",function(){
			var _index = 0;
			return {
				restrict : "A",
				link : function($scope, $element, $attrs){
					var callback = $attrs.ngClickConfirm;
					var confirmMessage = $attrs.ngConfirm ? $attrs.ngConfirm : "Are you sure";
					$element.click(function(e){
						e.preventDefault();
						e.stopPropagation();

						$__$.confirm(confirmMessage,{
							callback : function(result){
								if(result)
									$scope.$parent.$eval(callback);
							}
						})

						return false;
					});
				}
			};
		}).directive("ngDisplayTime",["$timeout",function($timeout){
			return {
				restrict : "A",
				link : function($scope,$element,$attrs){
					$timeout(function(){
						var timestamp = parseInt($element.text());
						var date = new Date(timestamp*1000);
						$element.attr("data-timestamp",timestamp);
						$element.text(date.toDateString());
					});
				}
			}
		}]);

		app.directive('ngEnter', function () {
		    return function (scope, element, attrs) {
		        element.bind("keydown keypress", function (event) {
		            if(event.which === 13) {
		                scope.$apply(function (){
		                    scope.$eval(attrs.ngEnter);
		                });

		                event.preventDefault();
		            }
		        });
		    };
		});
	});
	$__$.angular = {};
	$__$.angular.apply = function(objectOfScope,objectFromServer){
		$.each(objectFromServer,function(k,v){
			objectOfScope[k] = v;
		});
	};
	$__$.angular.hasInit = false;
	$__$.angular.init = function(app){
		$__$.angular.hasInit = true;
		$__$.trigger("angular-init",app);
		$__$.angular.app = app;
	};
	$__$.angular.dynamic = function(appName){
		angular.bootstrap($("[ng-app='"+appName+"']"),[appName]);
	};
	$__$.angular.data = {};
	$__$.angular.run = function(callback){
		if($__$.angular.hasInit)
			callback($__$.angular.app);
		else
			$__$.on("angular-init",function(app){
				callback(app);
			})
	};
	$__$.angular.onScope = function(callback){
		$__$.on("angular-scope",callback);
	};
	$__$.angular.triggerScope = function($scope){
		$__$.trigger("angular-scope",$scope);
	};
})();

// animation

(function(){
	$__$.angular.run(function(app){
		app.animation(".main-view",function(){
			return {
				enter : function($element,done){
					var anim = null;
					var animSpeed = $__$.animationSpeed;
					var $firstChild = $element.children().length ? $element.children().eq(0) : null;
					if($firstChild!=null)
					{
						anim = $firstChild.attr("anim-enter");
						if(!anim)
							anim = $firstChild.attr("anim");
						if(!anim)
							anim = null;
						// speed

						var _animSpeed = $firstChild.attr("anim-speed-enter");
						if(!_animSpeed)
							_animSpeed = $firstChild.attr("anim-speed");
						if(_animSpeed)
							animSpeed = _animSpeed;
					}
					switch(anim)
					{
						case "slide":
							$firstChild.css("top",-$firstChild.height());
							$firstChild.animate({
								top : "0px"
							},animSpeed,function(){
								done();
							});
							break;
						case "fade":
							$element.hide();
							setTimeout(function(){
								$element.show();
								done();
							},animSpeed);
							break;
						default:
							done();
							break;
					}
				},
				leave : function($element,done){
					var anim = null;
					var animSpeed = 100;
					var $firstChild = $element.children().length ? $element.children().eq(0) : null;
					if($firstChild!=null)
					{
						anim = $firstChild.attr("anim-leave");
						if(!anim)
							anim = $firstChild.attr("anim");
						if(!anim)
							anim = null;// speed

						var _animSpeed = $firstChild.attr("anim-speed-leave");
						if(!_animSpeed)
							_animSpeed = $firstChild.attr("anim-speed");
						if(_animSpeed)
							animSpeed = _animSpeed;
					}
					switch(anim)
					{
						case "slide":
							$firstChild.animate({
								top : -$firstChild.height()
							},animSpeed,function(){
								done();
							});
							break;
						case "fade":
							$element.fadeOut(animSpeed,function(){
								done();
							});
							break;
						default:
							done();
							break;
					}
				}
			};
		});
	});
})();