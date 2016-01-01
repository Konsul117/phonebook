(function($) {

	var methods = {
		start: function() {
			var $field = $(this);
			methods.clear($field);
			$field.after('<div class="loading-indicator"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></div>');
			console.log('started');
		},
		stop: function() {
			methods.clear($(this));
			console.log('stopped');
		},
		clear: function($field) {
			$field.siblings('.loading-indicator').remove();
		}
	};

	$.fn.inputIndicator = function(method) {
		//methods[method]();
		if (methods[method]) {
			return methods[method].apply(this);
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		}
	}
})(jQuery);