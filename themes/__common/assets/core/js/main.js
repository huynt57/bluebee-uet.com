$(function(){
	$__$.trigger("init");
	$__$.trigger("html-parsing",$("body"));
	$__$.trigger("html-appended",$("body"));
	setTimeout(function(){
		$__$.trigger("html-start-working");
	},200);
});
$__$.on("form-reload",function(){
	location.reload();
});
$.fn.outer = function(){
	return $("<div>").append($(this).clone(true)).html();
};
// function
/*(function(){
	if($__$.mobile)
		return;
	$__$.alertCallback = null;
	$__$.confirmCallback = null;
	$__$.alert = function(message,options){
		var defaultOptions = {
			title:"$__$.vn",
			callback:function(){}
		};
		options = $.extend({},defaultOptions,options);
		
		var $dialog = $("#dialogModal");
		$dialog.find(".modal-alert").show();
		$dialog.find(".modal-confirm").hide();
		$dialog.find(".modal-title").text(options.title);
		$dialog.find(".modal-message").text(message);
		if($("body").find(".modal-backdrop").length)
		{
			// modal is still displayed
			$dialog.one("hidden.bs.modal",function(){
				$dialog.modal("show");
			})
		}
		else
		{
			$dialog.modal("show");
		}
		$__$.alertCallback = options.callback;
	};
	$__$.confirm = function(message,options){
		var defaultOptions = {
			title:"$__$.vn",
			callback:function(){}
		};
		options = $.extend({},defaultOptions,options);
		
		var $dialog = $("#dialogModal");
		$dialog.find(".modal-alert").hide();
		$dialog.find(".modal-confirm").show();
		$dialog.find(".modal-title").text(options.title);
		$dialog.find(".modal-message").text(message);
		if($("body").find(".modal-backdrop").length)
		{
			// modal is still displayed
			$dialog.one("hidden.bs.modal",function(){
				$dialog.modal("show");
			})
		}
		else
		{
			$dialog.modal("show");
		}
	
		$__$.confirmCallback = options.callback;
	};
	window.dialog_ok = function()
	{
		$__$.alertCallback();	
	}
	window.dialog_yes = function()
	{
		$__$.confirmCallback(true);
	}
	window.dialog_no = function()
	{
		$__$.confirmCallback(false);
	}
})();
*/
// form error inline
(function(){
	window.formErrorInlineBootstrap = function(errors,$form){
		var text = '<div class="alert alert-info h5">\
					  <strong><i class="icon-bell-alt"></i> Lỗi!</strong> <span classs="h4">'+errors[0].message+'</span>\
					</div>';
		$form.find(".form-error").show().html(text);
	};
	window.formErrorInline = function(errors,$form){
		$form.find(".form-error").show().find(".error-content").html(errors[0].message);
	};
	window.formErrorInlineValid = function($form){
		$form.find(".form-error").hide();	
	};
})();
// filter
//
jQuery.fn.hideout = function(options){
	var self = this;
	var defaultOptions = {
		hide:function(){
			$(self).hide();
		}
	};
	options = $.extend({},defaultOptions,options);
	$(document).click(function(e){
		hideout_click(e);
	});
	var hideout_click = function(e)
	{
		var $target = $(e.target);
		if(!$target.parents().andSelf().filter(self).length)
		{
			options.hide();
		}
	}
};
//
$__$.prevent = function(e)
{
	e = e ? e : window.event;
	if(e)
	{
		e.stopPropagation();
		e.preventDefault();
	}
	return false;
}
//
jQuery.fn.hasAttr = function(attr)
{
	return $(this).attr(attr)!=undefined;
}

$__$.on("html-appended",function($html){
	$html.find("[data-toggle='tooltip']").andSelf().filter("[data-toggle='tooltip']").each(function(){
		$(this).attr("done-tooltip","1").tooltip();
	});
	$html.find("[data-toggle='popover']").andSelf().filter("[data-toggle='popover']").each(function(){
		$(this).attr("done-popover","1").popover();
	});
});

function show_error(errors)
{
	$("#formerror").html('\
		<div class="alert alert-warning">\
		  <button type="button" class="close" data-dismiss="alert">&times;</button>\
		  <strong>'+errors[0].message+'\
		</div>\
	');
	errors[0].elem.focus();
};

$__$.attrToObject = function(elem)
{
	var obj = {};
	elem = $(elem).get(0);
	var attributes = $.map(elem.attributes, function(item) {
		return item.name;
	});
	$.each(attributes,function(k,v){
		var valid = typeof k == "string" || typeof k == "number";
		if(!valid)
			return;
		if(v.substring(0,5)=="data-")
		{
			obj[v.substring(5)] = $(elem).attr(v);
		}
	});
	return obj;
};

jQuery.fn.focusEnd = function(){
	var el = $(this).get(0);
    if (typeof el.selectionStart == "number") {
        el.selectionStart = el.selectionEnd = el.value.length;
    } else if (typeof el.createTextRange != "undefined") {
        el.focus();
        var range = el.createTextRange();
        range.collapse(false);
        range.select();
    }
    return $(this);
};

$__$.on("html-appended",function($html){
	$html.find(".href-focus").each(function(){
		$(this).on("click",function(){
			$($(this).data("href")).focus();
			return false;
		});
	});
	$html.find("[data-click]:not(.done)").each(function(){
		var expression = $(this).data("click");
		$(this).addClass("done").attr("onclick",expression);
	});
});

// select dropdown

(function(){

	$__$.registerJQueryPlugin("selectDropdown",function(){
		var $self = this;
		var $elem = this.$elem;
		var $options = this.$options;
		var $html;

		var optionVal, optionText;

		this.init = function(){
			var $select = $elem;
			var $options = $select.children("option");
			var val = $elem.val();
			var text = $.trim($options.filter(":selected").text());
			// html
			var html = '\
				<div class="dropdown" data-value="'+val+'" data-text="'+text+'" style="display:inline-block;">\
					<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">\
						<span class="select-text">'+text+'</span>\
						<span class="caret"></span>\
					</button>\
					<ul class="dropdown-menu" role="menu" style="left:auto">\
			';
			$options.each(function(){
				var optionVal = $(this).val();
				var optionText = $(this).text();
				html += '<li><a href="#" data-value="'+optionVal+'" data-text="'+optionText+'">'+optionText+'</a></li>';
			});
			html += '\
					</ul>\
				</div>\
			';
			//
			$elem.hide();
			$html = $(html);
			$html.insertAfter($elem);
			$html.find("ul li a").on("click",function(e){
				var value = $(this).data("value");
				$elem.val(value);
				$self.update();
				//$html.removeClass("open");
				//$html.children(".dropdown-toggle").dropdown("toggle");
				$elem.trigger("change");
				return $__$.prevent(e);
			});
			$html.children(".dropdown-toggle").dropdown();
			$self.update();
		};

		this.update = function(){
			var value = $elem.val();
			var $selectedOption = $html.find("ul li a[data-value='"+value+"']");
			optionVal = $selectedOption.data("value");
			optionText = $.trim($selectedOption.data("text"));
			$html.removeClass("open").attr({
				"data-value" : optionVal,
				"data-text" : optionText
			})
			$html.find(".select-text").text(optionText);
		};

		this.onInit = function(){
			this.init();
		}

		this.onUpdate = function(){
			this.update();
		}
	},{},"select-dropdown");

})();

// fix top

(function(){
	$.fn.elemFixedTop = function(options){
		var defaultOptions = {
			top : 0
		};
		options = $.extend({},defaultOptions,options);
		var self = this;
		var isOverflow = false;
		var originTop;
		var originWidth;
		var originHeight = $(self).get(0).offsetHeight;
		var minHeight = parseFloat($("body").css("min-height"));
		if(originHeight > minHeight)
			$("body").css("min-height",originHeight);
		$(this).parent().css("position","relative");
		$(window).scroll(function(){
			if(!$(self).is(":visible"))
				return;
			var top = originTop ? originTop : $(self).offset().top - parseFloat($(self).css('margin-top').replace(/auto/, 0)) - $(self).get(0).offsetHeight;
			//console.log(top);
			var overflow = $(window).scrollTop() > top;
			if((isOverflow && overflow) || (!isOverflow && !overflow))
				return;
			console.log("change");
			isOverflow = overflow;
			if(overflow)
			{
				if(!originTop)
				{
					originTop = top;
				}
				if(!originWidth)
				{
					originWidth = $(self).get(0).offsetWidth;
					$(self).css("width",originWidth);
				}
				$(self).addClass("elemFixedTopClass").css("top",options.top);
			}
			else
			{
				$(self).removeClass("elemFixedTopClass").css("top","auto");
			}
		});
	};
	
	$__$.on("html-appended",function($html){
		$html.find(".elem-fixed-top").each(function(){
			$(this).elemFixedTop($(this).data());
		});
	});

})();

// facebook dynamic update

(function(){
	$__$.on("html-appended",function(){
		if(window.FB)
			FB.XFBML.parse();
	});
})();

(function(){
	$.fn.heightUntilBottom = function(options){
		var defaultOptions = {
			overflowAuto : true
		};
		options = $.extend({},defaultOptions,options);
		var offset = $(this).offset();
		if(!offset || !offset.top)
			return;
		var height = window.innerHeight - offset.top;
		//console.log($(this).offset().top);
		//console.log(height);
		if(isNaN(height))
			return;
		$(this).css("height",height);
		if(options.overflowAuto)
			$(this).css("overflow","auto");
	};
	$__$.on("html-appended",function($html){
		$html.find(".height-until-bottom").each(function(){
			$(this).heightUntilBottom($(this).data());
		});
	});
})();

// doSubmit

(function(){
	$__$.on("html-appended",function($html){
		$html.find(".do-submit").each(function(){
			var target = $(this).data("target");
			$(this).click(function(e){
				$(target).trigger("submit");
				return $__$.prevent(e);
			});
		});
	});
})();

// scroll

(function(){
	$.fn.scrollToMe = function(){
		$('html, body').scrollTop($(this).offset().top);
	};
})();

(function(){
	var arr = [];
	var humanize = function(timestamp,lang){
		var sPerMinute = 60;
		var sPerHour = sPerMinute * 60;
		var sPerDay = sPerHour * 24;
		var sPerMonth = sPerDay * 30;
		var sPerYear = sPerDay * 365;
		var current = (new Date).getTime()/1000;
		var d = window.d_timestamp ? window.d_timestamp : 0;
		var elapsed = current + d - timestamp; // num second

		switch(lang){
			case "vi":
				if (elapsed < sPerMinute) {
					return "vừa xong";
				}
				else if (elapsed < sPerHour) {
					 return Math.round(elapsed/sPerMinute) + ' phút trước';   
				}
				else if (elapsed < sPerDay ) {
					 return Math.round(elapsed/sPerHour ) + ' giờ trước';   
				}
				else if (elapsed < sPerMonth) {
					return 'khoảng ' + Math.round(elapsed/sPerDay) + ' ngày trước';   
				}
				else if (elapsed < sPerYear) {
					return 'khoảng ' + Math.round(elapsed/sPerMonth) + ' tháng trước';   
				}
				else {
					return 'khoảng ' + Math.round(elapsed/sPerYear ) + ' năm trước';   
				}
				break;
			default : // en
				if (elapsed < sPerMinute) {
					return "just now";
				}
				else if (elapsed < sPerHour) {
					var val = Math.round(elapsed/sPerMinute);
					return val + ' minute' + (val > 1 ? "s" : "") + " ago";
				}
				else if (elapsed < sPerDay ) {
					var val = Math.round(elapsed/sPerHour);
					return val + ' hour' + (val > 1 ? "s" : "") + " ago";
				}
				else if (elapsed < sPerMonth) {
					var val = Math.round(elapsed/sPerDay);
					return val + ' day' + (val > 1 ? "s" : "") + " ago";
				}
				else if (elapsed < sPerYear) {
					var val = Math.round(elapsed/sPerMonth);
					return val + ' month' + (val > 1 ? "s" : "") + " ago";
				}
				else {
					var val = Math.round(elapsed/sPerYear );
					return val + ' year' + (val > 1 ? "s" : "") + " ago"; 
				}
				break;
		}

		
	};

	$__$.registerJQueryPlugin("prettyTime",function(){
		var $self = this;
		var timestamp;
		$self.updateTimestamp = function(){
			timestamp = this.$elem.attr("timestamp") ? this.$elem.attr("timestamp") : this.$elem.text();
		};
		$self.updateTimestamp();
		timestamp = parseInt(timestamp);
		if(!timestamp)
			return;

		$self.onInit = function(){
			setInterval(function(){
				$self.updateText();
			}, $self.options.interval);
			$self.updateText();
		};

		$self.onUpdate = function(){
			$self.updateTimestamp();
		};

		$self.updateText = function(){
			$self.$elem.text(humanize(timestamp,$self.options.lang));
		}
	},{
		interval : 30000,
		lang : "en"
	},"time");
})();