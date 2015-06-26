/*$(function(){
	$(".spinner").each(function(){
		var obj = {
            spin : function(){
                $(this).trigger("change")
            },
            change : function(){
                $(this).trigger("change")
            }
        };
        if($(this).data("max")!=undefined)
        	obj.max = parseInt($(this).data("max"));
        if($(this).data("min")!=undefined)
        	obj.min = parseInt($(this).data("min"));
        $(this).spinner(obj);
        $(this).keyup(function(){
           $(this).trigger("change");
        });
        $(this).keydown(function(e){
            var keyCode = e.which ? e.which : e.keyCode;
            var valid = (keyCode >= 48 && keyCode <=57) || keyCode==8;
            if(!valid)
            {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        });
    });
});*/

$__$.registerJQueryPlugin("inputNumber",function(){
    var $self = this;
    this.onInit = function(){
        $self.$elem.spinner($self.options);
        $self.$elem.keyup(function(){
           $(this).trigger("change");
        });
        $self.$elem.keydown(function(e){
            var keyCode = e.which ? e.which : e.keyCode;
            var valid = (keyCode >= 48 && keyCode <=57) || keyCode==8;
            if(!valid)
            {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        });
    };

    this.onUpdate = function(){

    };
},{
    min : 0,
    spin : function(){
        $(this).trigger("change")
    },
    change : function(){
        $(this).trigger("change")
    }
},"spinner");