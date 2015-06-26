/* --------------------------------------------------------------$__$.VN------------------------------------------------------------------------------------*/
/* [MOD=EVENT]------------------------------------------------------------------------------------------------------------------------------------------------*/
(function($){
	window.$__$ = {};
	window.fw = $__$;
	$__$.event = {};
	$__$.event.data = {};
	$__$.event.on = function(event,callback){
		if(!$__$.event.data[event])
			$__$.event.data[event] = [];
		$__$.event.data[event].push(callback);
	};
	$__$.event.trigger = function(event,data,isFilter,belongsToTinymce){
		if(!$__$.event.data[event])
		{
			if(isFilter)
				return data;
			else
				return false;
		}
		if(!data)
			data = null;
		var filter;
		if(isFilter)
		{
			(function($){
				filter = $("<div>").append(data);
			})(belongsToTinymce ? tinymce.activeEditor.getWin().jQuery : window.jQuery);
		}
		$.each($__$.event.data[event],function(k,callback){
			if(isFilter)
				callback(filter);
			else
				callback(data);
		});
		if(isFilter)
		{
			return filter.html();
		}
		else
		{
			return true;
		}
	}
	$__$.on = $__$.event.on;
	$__$.trigger = $__$.event.trigger;
})(jQuery);
/* [MOD=FORM]-------------------------------------------------------------------------------------------------------------------------------------------------*/
$(function(){
	// ajax
	$.formajax = function(element,options){
		/* [VARIABLE */
		var self = this;
		this.options = {};
		/* VARIABLE] */
		/* [PUBLIC */
		element.data("formajax",this);
		this.init = function(element,options){
			this.options = $.extend({},$.formajax.defaultOptions,options);
			if(this.options.type=="validate")
				return;
			element.on("form-sent",function(){
				$(this).helper("form-disabled",true);
			});
			element.on("form-load",function(){
				$(this).helper("form-disabled",false);
			});
		};

		this.prepare = function(){
			prepareEvent();
			prepareData();
		}

		this.check = function(){
			prepareEvent();
			prepareData();
			this.formvalid = true;
			switch(this.options.type)
			{
				case "ajax":
					this.submitAjax();
					break;
				case "iframe":
					this.submitIframe();
					break;
				case "validate":
					this.submitValidate();
					break;
			}
				
		};
		this.validate = function(){
			element.formvalidate();
			element.trigger("formvalidate-before-check");
			element.data("formvalidate").check();
			var errors = element.data("formvalidate").errors;
			if(errors.length)
			{
				this.options.onError(errors,element);
				this.formvalid = false;
				return false;
			}
			else
			{
				this.formvalid = true;
				this.options.onErrorValid(element);
				return true;
			}
		};
		this.submitValidate = function(){
			if(!self.formvalid)
				return;
			element.trigger("form-data-making");element.off("form-data-making");
			element.trigger("form-data-made");element.off("form-data-made");
			if(!this.validate())
			{
				element.off("form-sending form-sent form-load form-success");
				return;
			}
			else
			{
				element.attr("data-no-prevent","1");
				element.trigger("form-sending");element.off("form-sending");
				element.submit();
				element.trigger("form-sent");element.off("form-sent");	
			}
		};
		this.submitAjax = function(){
			if(!self.formvalid)
				return;
			element.trigger("form-data-making");element.off("form-data-making");
			var url = element.attr("action")==undefined?"":element.attr("action");
			var type = element.attr("method")==undefined?"get":element.attr("method");
			element.trigger("form-data-made");element.off("form-data-made");
			if(!this.validate())
			{
				element.off("form-sending form-sent form-load form-success");
				return;
			}
			else
			{
				var data = element.serializeArray();
				var ajaxObject = {
					url:url,
					type:type,
					data:data,
					success:function(data){
						element.trigger("form-load");element.off("form-load");
						$__$.handleJSON(data,function(data){
							var e = $.Event("form-success");
							e.msg = data;
							element.trigger(e);element.off(e);
						});
					}
				};
				element.data("ajaxObject",ajaxObject);
				element.trigger("form-sending");element.off("form-sending");
				$.ajax(element.data("ajaxObject"));
				element.trigger("form-sent");element.off("form-sent");	
			}
		};
		this.submitIframe = function(){
			var form = element;
			var target = $(form).attr("target");
			if(!target)
			{
				target = "iframe"+(new Date()).getTime();
				$(form).attr("target",target);
			}
			element.trigger("form-data-making");element.off("form-data-making");
			element.trigger("form-data-made");element.off("form-data-made");
			if(!this.validate())
			{
				element.off("form-sending form-sent form-load form-success");
				return;
			}
			else
			{
				var $iframe = $("<iframe hidden></iframe>").attr("name",target);
				var $exist = $("iframe[name='"+target+"']");
				if($exist.length)
					$exist.replaceWith($iframe);
				else
					$("body").append($iframe);
				$iframe.load(function(){
					element.trigger("form-load");element.off("form-load");
					var data = $iframe.contents().find("body").text();
					$__$.handleJSON(data,function(data){
						var e = $.Event("form-success");
						e.msg = data;
						element.trigger(e);element.off(e);
					});
				});
				element.trigger("form-sending");element.off("form-sending");
				element.submit();
				element.trigger("form-sent");element.off("form-sent");
			}
		};
		this.init(element,options);
		/* PUBLIC] */
		/* [PRIVATE */
		function prepareData(){
		};
		function prepareEvent(){
			var form = element;
			var attrs = {
				"loading" : function(self,attr){
					$(form).on("form-sent",function(){
						$(self).show().css("visibility","visible");
					});

					$(form).on("form-load",function(){
						$(self).hide().css("visibility","hidden");
					});
				},
				"send-content":function(self,attr){
					var contentBack = !$(this).attr("data-send-content-protect");
					var content;
					$(form).on("form-sent",function(){
						content = $(self).html();
						$(self).html(attr);
					});
					if(!contentBack)
						return;
					$(form).on("form-load",function(){
						$(self).html(content);
					});
				},
				"send-value":function(self,attr){
					$(form).on("form-sent",function(){
						$(self).val(attr);
					});
				},
				"send-classes":function(self,attr){
					/*var classes = "";
					$.each(attr.split(","),function(k,clss){
						if(k>0)classes += " ";
						classes += clss;
					});*/
					var classes = attr;
					$(form).on("form-sent",function(){
						$(self).addClass(classes);
					});
				},
				"send-removeClasses":function(self,attr){
					/*var classes = "";
					$.each(attr.split(","),function(k,clss){
						if(k>0)classes += " ";
						classes += clss;
					});*/
					var classes = attr;
					$(form).on("form-sent",function(){
						$(self).removeClass(classes);
					});
				},
				"send-disabled":function(self,attr){
					$(form).on("form-sent",function(){
						if(attr=="false")
							$(self).removeAttr("disabled");
						else
							$(self).attr("disabled","disabled");
					})
				},
				"send-event":function(self,attr){
					$(form).on("form-sent",function(){
						var obj = {
							elem:self
						};
						$__$.trigger("form-"+attr,obj);
					})
				},
				"sending-event":function(self,attr){
					$(form).on("form-sending",function(){
						var obj = {
							elem:self
						};
						$__$.trigger("form-"+attr,obj);
					})
				},
				"send-event-data":function(self,attr){
					$(form).on("form-data-making",function(){
						var obj = {
							elem:self
						};
						$__$.trigger("form-"+attr,obj);
					})
				},
				"load-content":function(self,attr){
					$(form).on("form-load",function(){
						$(self).html(attr);
					});
				},
				"load-value":function(self,attr){
					$(form).on("form-load",function(){
						$(self).val(attr);
					});
				},
				"load-classes":function(self,attr){
					/*var classes = "";
					$.each(attr.split(","),function(k,clss){
						if(k>0)classes += " ";
						classes += clss;
					});*/
					var classes = attr;
					$(form).on("form-load",function(){
						$(self).addClass(classes);
					});
				},
				"load-removeClasses":function(self,attr){
					/*var classes = "";
					$.each(attr.split(","),function(k,clss){
						if(k>0)classes += " ";
						classes += clss;
					});*/
					var classes = attr;
					$(form).on("form-load",function(){
						$(self).removeClass(classes);
					});
				},
				"load-disabled":function(self,attr){
					$(form).on("form-load",function(){
						if(attr=="false")
							$(self).removeAttr("disabled");
						else
							$(self).attr("disabled","disabled");
					})
				},
				"load-event":function(self,attr){
					$(form).on("form-load",function(e){
						var obj = {
							elem:self
						};
						$__$.trigger("form-"+attr,obj);
					})
				},
				"success-content":function(self,attr){
					$(form).on("form-success",function(){
						console.log(self);
						t = self;
						console.log(attr);
						$(self).html(attr);
					});
				},
				"success-value":function(self,attr){
					$(form).on("form-success",function(){
						$(self).val(attr);
					});
				},
				"success-classes":function(self,attr){
					var classes = "";
					$.each(attr.split(","),function(k,clss){
						if(k>0)classes += " ";
						classes += clss;
					});
					$(form).on("form-success",function(){
						$(self).addClass(classes);
					});
				},
				"success-removeClasses":function(self,attr){
					var classes = "";
					$.each(attr.split(","),function(k,clss){
						if(k>0)classes += " ";
						classes += clss;
					});
					$(form).on("form-success",function(){
						$(self).removeClass(classes);
					});
				},
				"success-disabled":function(self,attr){
					$(form).on("form-success",function(){
						if(attr=="false")
							$(self).removeAttr("disabled");
						else
							$(self).attr("disabled","disabled");
					})
				},
				"success-event":function(self,attr){
					$(form).on("form-success",function(e){
						var obj = {
							elem:self,
							data:e.msg
						};
						$__$.trigger("form-"+attr,obj);
					})
				}
			};
			$(form).filter("[data-prepare-events]").each(function(){
				var attr = $(this).attr("data-prepare-events");
				$__$.trigger("form-"+attr,{
					elem : this
				});
			});
			$.each(attrs,function(k,f){
				var attrName = "data-"+k;
				$(form).find("["+attrName+"]").andSelf("["+attrName+"]").each(function(){
					var attr = $(this).attr(attrName);
					f(this,attr);
				});
				$("[data-form='"+$(form).attr("id")+"']["+attrName+"]").each(function(){
					var attr = $(this).attr(attrName);
					f(this,attr);
				});
			});
		};
		/* PRIVATE] */
	};
	$.formajax.defaultOptions = {
		type:"ajax",
		onError:function(errors){
			$__$.alert(errors[0].message);
			errors[0].elem.focus();
		},
		onErrorValid:function(){
			
		}
	};
	$.fn.formajax = function(options){
		return this.each(function(){
			(new $.formajax($(this),options));
		});
	};
	// validate
	$.formvalidate = function(element,options){
		/* [VARIABLE */
		this.options = {};
		this.errors = [];
		var self = this;
		/* VARIABLE] */
		/* [PUBLIC */
		element.data("formvalidate",this);
		this.init = function(){
			this.options = $.extend({},$.formvalidate.defaultOptions,options);
		};
		
		this.check = function(){
			element.find("textarea:not(.no-convert-newline)").each(function(){
				if(!$(this).hasClass("tinymce-editor"))
				{
					// normal
					var value = $(this).val();
					$(this).data("value",value);
					value = value.replace(/\n/g,"<br/>");
					$(this).val(value);
				}
				else
				{
					var value = $(this).val();
					$(this).data("value",value);
					value = value.replace(/\n/g,"");
					//value = value.replace(/\'/g,"'");
					//value = value.replace(/\"/g,'"');
					//value = value.replace(/\\/g, '');
					$(this).val(value);
				}
			});
			element.find("[data-valid]").andSelf().filter("[data-valid]").not("[disabled]").each(function(){
				var elem = this;
				$(elem).data("formvalidate",{errors:[]});
				var validStr = $(this).attr("data-valid");
				if(!$.trim(validStr))
				{
					return;
				}
				var items = validStr.split("|");
				$.each(items,function(key,item){
					// 9630
					var type = $(elem)[0].nodeName.toLowerCase();
					var value = $(elem).val();
					if($(elem).attr("type")=="checkbox")
					{
						value = $(elem).is(":checked") ? value : false;
					}
					if($(elem).is("div"))
					{
						value = $(elem).html();
					}
					var filter = getFilter(item);
					var params = getParams(item);
					var message = getMessage(item);
					var param = params[0];
					var result;
					if(filter.substring(0,4)=="func")
					{
						result = window[filter.substring(5)](value,param,params,elem,type);
					}
					else
					{
						result = self.options.filters[filter].call(self,value,param,params,elem,type);
					}
					if(!result){
						var errorObj = {elem:elem,filter:filter,param:param,params:params};
						if(message)
						{
							errorObj.message = message;
						}
						else
						{
							if(self.options.humanStrings[filter])
								errorObj.message = self.options.humanStrings[filter](getLabel(elem),param,params);
							else
								errorObj.message = "";
						}
						self.errors.push(errorObj);
						$(elem).data("formvalidate").errors.push(errorObj);
					}
				});
			});
		};
		
		this.init(element,options);
		/* PUBLIC] */
		/* [PRIVATE */
		
		function getInput(name){
			return element.find('[name="'+name+'"]').val();
		}
		function getFilter(item){
			return item.match(/((?!\[).)*/g)[0];
		}
		function getParams(item){
			//var paramPaths = item.match(/\[.+\]/g);
			var paramPaths = item.match(/\[[^\[\}]+\]/g);
			if(!paramPaths)return [""];
			var params = [];
			$.each(paramPaths,function(key,item){
				params.push(item.substring(1,item.length-1));
			});
			return params;
		}
		function getMessage(item)
		{
			var arr = item.match(/(\{.+\}){1,}/g);
			if(arr && arr.length)
			{
				var message = arr[0];
				message = message.substring(1,message.length-1);
				if(message)
					return message;
				return false;
			}
			else
			{
				return false;
			}
		}
		function getLabel(elem){
			var label = $(elem).attr("data-label");
			if(!label)label = $(elem).attr("name");
			return label;
		}
		function getLabelByName(name){
			var label = element.find('[name="'+name+'"]').attr("data-label");
			if(!label) label = $(elem).attr("name");
			return label;
		}
		function getText(html)
		{
			return $.trim($("<div>").html(html).text());
		}
		/* PRIVATE] */
		this.getInput = getInput;
		this.getFilter = getFilter;
		this.getParams = getParams;
		this.getMessage = getMessage;
		this.getLabel = getLabel;
		this.getLabelByName = getLabelByName;
		this.getText = getText;
	};
	$.formvalidate.defaultOptions = {
		humanStrings : {
			"required":function(label,param,params){
				return label + " là bắt buộc";
			},
			"match_input":function(label,param,params){
				return label + " phải trùng với " + getLabelByName(error.param);
			},
			"unmatch_input":function(label,param,params){
				return label + " không được trùng với " + getLabelByName(param);
			},
			"match_value":function(label,param,params){
				return label + " phải có giá trị '"+param+"'";
			},
			"unmatch_value":function(label,param,params){
				return label + " không được có giá trị '"+param+"'";
			},
			"min_length":function(label,param,params){
				return label + " phải có độ dài tối thiểu là "+(param)+" ký tự";
			},
			"max_length":function(label,param,params){
				return label + " có độ dài không được vượt quá "+(param)+" ký tự";
			},
			"exact_length":function(label,param,params){
				return label + " phải có độ dài xác định là "+(param)+" ký tự";
			},
			"greater_than":function(label,param,params){
				return label + " phải lớn hơn "+param;
			},
			"less_than":function(label,param,params){
				return label + " không được vượt quá "+param;
			},
			"valid_email":function(label,param,params){
				return "Email không hợp lệ";
			},
			"valid_number":function(label,param,params){
				return label + " phải là một số";
			},
			"valid_illegalChar":function(label,param,params){
				return label + " bao gồm những ký tự không hợp lệ";
			},
			"valid_startLetter":function(label,param,params){
				return label + " phải bắt đầu bằng một chữ cái";
			}
		},
		filters : {
			"required":function(value,param,params,elem,type){
				if(params[0] && params[0]=="text")
				{
					value = this.getText(value);
				}
				return value.length;
			},
			"match_input":function(value,param,params){
				return value == this.getInput(param);
			},
			"unmatch_input":function(value,param,params){
				return value != this.getInput(param);
			},
			"match_value":function(value,param,params){
				return value == param;
			},
			"unmatch_value":function(value,param,params){
				return value != param;
			},
			"min_length":function(value,param,params){
				if(params[1] && params[1]=="text")
				{
					value = this.getText(value);
				}
				return value.length >= parseInt(param);
			},
			"max_length":function(value,param,params){
				if(params[1] && params[1]=="text")
				{
					value = this.getText(value);
				}
				return value.length <= parseInt(param);
			},
			"exact_length":function(value,param,params){
				if(params[1] && params[1]=="text")
				{
					value = this.getText(value);
				}
				return value.length == parseInt(param);
			},
			"greater_than":function(value,param,params){
				return !isNaN(valueNum = parseInt(value)) && valueNum > parseInt(param);
			},
			"less_than":function(value,param,params){
				return !isNaN(valueNum = parseInt(value)) && valueNum < parseInt(param);
			},
			"valid_email":function(value,param,params){
				return (/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/).test(value);
			},
			"valid_number":function(value,param,params){
				return /^[0-9]+$/.test(value);	
			},
			"valid_illegalChar":function(value,param,params){
				return !value.match(/\W/g);
			},
			"valid_startLetter":function(value,param,params){
				return !value || (/[A-z]/g).test(value[0]);
			},
			"trim":function(value,param,params,elem){
				$(elem)[0].value = $.trim($(elem)[0].value);
				return true;
			},
			"filter":function(value,param,params,elem,type){
				var value = $__$.trigger("html-filter",value,true);
				$(elem).val(value);
				return true;
			}
		}
	};
	$.fn.formvalidate = function(options){
		return this.each(function(){
			(new $.formvalidate($(this),options));
		});
	};
});
window.__ajax = function(form,e,error_callback,errorValid_callback){
	if(e)
	{
		e.stopPropagation();
		e.preventDefault();
	}
	var message = $(form).attr("data-confirm");
	var type = $(form).attr("data-type") ? $(form).attr("data-type") : "ajax";
	var do_submit = function(){
		$(form).formajax({
			type:type,
			onError:error_callback,
			onErrorValid:errorValid_callback
		});
		$(form).data("formajax").check();
	};
	if(message)
	{
		$__$.confirm(message,{
			callback:function(result){
				if(result){
					do_submit();
				}
			}
		});
	}
	else
	{
		do_submit();
	}
	return false;
};
window.__validate = function(form,e,error_callback,errorValid_callback){
	if($(form).data("no-prevent")=="1")
		return true;
	if(e)
	{
		e.stopPropagation();
		e.preventDefault();
	}
	var message = $(form).attr("data-confirm");
	var type = "validate";
	var do_submit = function(){
		$(form).formajax({
			type:type,
			onError:error_callback,
			onErrorValid:errorValid_callback
		});
		$(form).data("formajax").check();
	};
	if(message)
	{
		$__$.confirm(message,{
			callback:function(result){
				if(result){
					do_submit();
				}
			}
		});
	}
	else
	{
		do_submit();
	}
	return false;
};
window.__validateFromButton = function(form,e,error_callback){
	if(!error_callback)
	{
		error_callback = function(valid,errors){
			if(!valid)
				$__$.alert(errors[0].message);
		};
	}
	var do_submit = function(){
		$(form).formvalidate();
		var formvalidate = $(form).data("formvalidate");
		$(form).trigger("formvalidate-before-check");
		formvalidate.check();
		if(formvalidate.errors.length)
		{
			error_callback(formvalidate.errors);
		}
		else
		{
			$(form).formajax({
				type : "validate"
			});
			$(form).data("formajax").prepare();
			$(form).trigger("form-sending");
			$(form).trigger("form-sent");
			$(form).submit();
		}
	};
	var message = $(form).attr("data-confirm");
	if(message)
	{
		$__$.confirm(message,{
			callback:function(result){
				if(!result)
					return;
				do_submit();
			}
		});
	}
	else
	{
		do_submit();
	}
};
window.__confirm = function(form,e){
	var message = $(form).attr("data-confirm");
	if(message)
	{
		$__$.confirm(message,{
			callback:function(result){
				if(!result)
					return;
				$(form).submit();
			}
		});
	}
	else
	{
		$(form).submit();
	}
};
$__$.handleJSON = function(json,callback,callbackError)
{
	var data = $.parseJSON(json);
	if(parseInt(data.success)==0)
	{
		$__$.alert(data.message);
		callbackError && callbackError();
	}
	else
	{
		callback(data.data);
	}
};
/* [MOD=ALERT]------------------------------------------------------------------------------------------------------------------------------------------------*/
(function($){
	$__$.alert = function(message,options){
		var defaultOptions = {
			title:"$__$.vn",
			callback:function(){}
		};
		options = $.extend({},defaultOptions,options);
		alert(message);
		options.callback();
	};
	$__$.confirm = function(message,options){
		var defaultOptions = {
			title:"$__$.vn",
			callback:function(){}
		};
		options = $.extend({},defaultOptions,options);
		options.callback(confirm(message));
	};
})(jQuery);
/* [MOD=HELPER]-----------------------------------------------------------------------------------------------------------------------------------------------*/
(function($){
	$.newPlugin = function(name,methods){
		$.fn[name] = function(method){
			if ( methods[method] ) {
			  return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
			} else if ( typeof method === 'object' || ! method ) {
			  return methods.init.apply( this, arguments );
			} else {
			  $.error( 'Method ' +  method + ' does not exist on jQuery.'+name );
			}    
		}
	};
})(jQuery);
(function($){
	var methods = {
		"increase_one":function(options){
			var optionsDefault = {
				type:"html"
			};
			options = $.extend(optionsDefault,options);
			var index = parseInt($(this)[options.type]());
			$(this)[options.type](index+1);
		},
		"decrease_one":function(options){
			var optionsDefault = {
				type:"html"
			};
			options = $.extend(optionsDefault,options);
			var index = parseInt($(this)[options.type]());
			$(this)[options.type](index-1);
		},
		"placeholder":function(){
			$(this).each(function(){
				var i = 0;
				var placeholderRemove = function(div){
					$(div).removeClass("placeholder");
					$(div).data("placeholder",0);
					$(div).html("");
					$(div).focus();
				};
				var placeholderAdd = function(div){
					$(div).addClass("placeholder");
					$(div).data("placeholder",1);
					$(div).html($(div).attr("placeholder"));
				};
				if(!$(this).html())placeholderAdd(this);
				$(this).on("focus mousedown",function(){
					if($(this).data("placeholder")){
						placeholderRemove(this);
					}
				});
				$(this).on("blur",function(){
					var nodata = !$(this).data("placeholder") && !$(this).text() && !$(this).find("img,canvas").length;
					if(nodata){
						placeholderAdd(this);
					}
				});
			});
		},
		"form-disabled":function(disabled){
			var form = this;
			if(disabled) {
				$(this).addClass("waiting");
			}
			else {
				$(this).removeClass("waiting");
			}
			$(this).each(function(){
				$.each(this.elements,function(k,input){
					if(disabled) {
						if(!$(input).attr("disabled")) {
							//$(input).attr("disabled","disabled");
							$(input).data("be-disabled",1);
							if($(input).is("input,textarea"))
								$(input).attr("readonly","readonly");
							else
								$(input).attr("disabled","disabled");
						} 
					}
					else {
						if($(input).data("be-disabled")) {
							//$(input).removeAttr("disabled");
							$(input).removeData("be-disabled");
							if($(input).is("input,textarea"))
								$(input).removeAttr("readonly");
							else
								$(input).removeAttr("disabled");
						}
					}
				});
				$(this).find("div[contenteditable]").each(function(){
					if(disabled) {
						if($(this).attr("contenteditable")=="true") {
							$(this).attr("contenteditable","false");
							$(this).data("be-disabled",1);
						}
					}
					else {
						if($(this).data("be-disabled")) {
							$(this).attr("contenteditable","true");
							$(this).removeData("be-disabled");
						}
					}
				});
			});
		}
	};
	$.newPlugin("helper",methods);
})(jQuery);
(function($){
	$.fn.htmlPn = function(html){
		var $html = $(html);
		$__$.trigger("html-parsing",$html);
		$(this).html($html);
		$__$.trigger("html-appended",$html);
		return $(this);
	};
	$.fn.replaceWithPn = function(html){
		var $html = $(html);
		$__$.trigger("html-parsing",$html);
		$(this).replaceWith($html);
		$__$.trigger("html-appended",$html);
		return $(this);
	};
	$.fn.appendPn = function(html){
		var $html = $(html);
		$__$.trigger("html-parsing",$html);
		$(this).append($html);
		$__$.trigger("html-appended",$html);
		return $(this);
	};
	$.fn.prependPn = function(html){
		var $html = $(html);
		$__$.trigger("html-parsing",$html);
		$(this).prepend($html);
		$__$.trigger("html-appended",$html);
		return $(this);
	};
	$.insertBeforePn = function(html,$elem){
		var $html = $(html);
		$__$.trigger("html-parsing",$html);
		$html.insertBefore($elem);
		$__$.trigger("html-appended",$html);
		return $elem;
	};
	$.insertAfterPn = function(html,$elem){
		var $html = $(html);
		$__$.trigger("html-parsing",$html);
		$html.insertAfter($elem);
		$__$.trigger("html-appended",$html);
		return $elem;
	};
	$__$.updateHtml = function($element)
	{
		$__$.trigger("html-parsing",$element);
		$__$.trigger("html-appended",$element);
	}
})(jQuery);
/* [MOD=INIT]-------------------------------------------------------------------------------------------------------------------------------------------------*/
/*if(!Array.prototype.last) {
    Array.prototype.last = function() {
        return this[this.length - 1];
    }
}*/
$__$.on("init",function(){
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
		$.fx.off = true;
	}
});

window.mobilecheck = function() {
var check = false;
(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
return check; 
};
$__$.mobile = mobilecheck();
//
$__$.loadScript = function(src,document,callback){
	if(!document)
		document = window.document;
	var s, r, t;
	  r = false;
	  s = document.createElement('script');
	  s.type = 'text/javascript';
	  s.src = src;
	  s.onload = s.onreadystatechange = function() {
	    //console.log( this.readyState ); //uncomment this line to see which ready states are called.
	    if ( !r && (!this.readyState || this.readyState == 'complete') )
	    {
	      r = true;
	      callback();
	    }
	  };
	  //t = document.getElementsByTagName('meta')[0];
	  //t.parentNode.insertBefore(s, t);
	  t = document.getElementsByTagName("head")[0];
	  t.appendChild(s);
}

$__$.registerJQueryPlugin = function(name,theClass,defaultOptions,autoLoadHtmlClass){
	theClass.defaultOptions = defaultOptions;
	$.fn[name] = function(options){
		var $self = $(this);
		var obj = {};
		obj.$elem = $self;
		obj.options = $.extend({},theClass.defaultOptions,$self.data(),options);
		theClass.call(obj);
		$self.data()[name] = obj;
		obj.onInit && obj.onInit();
		return obj;
	};
	if(autoLoadHtmlClass){
		$__$.on("html-appended",function($html){
			var loadClass = autoLoadHtmlClass;
			var doneClass = loadClass + "-done";
			$html.find("."+loadClass+":not(."+doneClass+")").each(function(){
				$(this).addClass(doneClass);
				$(this)[name]();
			});
			$html.find("."+loadClass+"."+doneClass).each(function(){
				var obj = $(this).data()[name];
				obj.onUpdate && obj.onUpdate();
			});
		});
	}
};