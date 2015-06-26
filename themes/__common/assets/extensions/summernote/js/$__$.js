(function(){
	$__$.registerJQueryPlugin("inputHTMLEditor",function(){
		var $self = this;
		$self.onInit = function(){
			$self.options.onChange = function(contents, $editable) {
				$self.$elem.val(contents).trigger("change");
			};
			$self.options.onCreateLink = function (url) {
				if($self.options.urlAbsolute){
				    if (url.indexOf('http://') !== 0 && url.indexOf('#') !== 0) {
				        url = 'http://' + url;
				    }
				}
			    return url;
			};
			
			$self.$elem.summernote($self.options);
			$self.update();
		};

		$self.onUpdate = function(){
			$self.update();
		};

		$self.update = function(){
			$self.$elem.code($self.$elem.val());
		}
	},{
		height : 200,
	},"input-html");
})();