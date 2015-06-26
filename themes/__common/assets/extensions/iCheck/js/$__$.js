$__$.on("html-appended",function($html){
	var selector = "[type='checkbox']:not(.icheck-done)";
	var doneClass = "icheck-done";
	$html.find(selector).andSelf().filter(selector).each(function(){
		var $self = $(this);
		$self.addClass(doneClass);
		$self.iCheck({
		    checkboxClass: 'icheckbox_minimal-grey',
		    increaseArea: '20%' // optional
		});
	});
});