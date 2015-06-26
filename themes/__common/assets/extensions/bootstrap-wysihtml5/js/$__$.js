(function(){
	$__$.registerJQueryPlugin("input-wysihtml5",function(){
		var $self = this;
		$self.onInit = function(){
			$self.$elem.wysihtml5($self.options);
		};

		$self.onUpdate = function(){

		};
	},{
		height : 200
	},"input-html");
})();