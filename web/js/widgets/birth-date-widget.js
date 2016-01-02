(function($) {

	var $formElement;

	var methods = {
		init: function() {
			$formElement = $(this);

			$('select', $formElement).change(function() {

				var resultDate = $('select[data-role=yearSelector]', $formElement).val()
					+ '-' + $('select[data-role=monthSelector]', $formElement).val()
					+ '-' + $('select[data-role=daySelector]', $formElement).val();

				$('input[data-role=hiddenResultValue]', $formElement).val(resultDate);
				console.log(resultDate);
			});
		}
	};

	$.fn.birthDateWidget = function(method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		}
	}

})(jQuery);