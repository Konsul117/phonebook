(function($) {

	var $form;

	var $cityField;

	var $streetField;

	var methods = {
		init: function() {
			$form = $(this);

			$cityField = $('input[data-role=city_selector]', $form);
			$streetField = $('input[data-role=street_selector]', $form);

			$cityField.autocomplete({
				source: function(request, response) {

					//@TODO: добавить индикацию загрузки

					var text = $cityField.val();

					if (text.length <= 2) {
						response([]);
						return;
					}

					$cityField.inputIndicator('start');

					$.ajax({
						url:     baseUrl+'address/cities',
						method:  'post',
						data:    {query: text},
						success: function(data) {
							var result = [];
							$(data.data).each(function(id,el) {
								result.push({'id':el.id,'label':el.title, 'value':el.title});
							});
							response(result);

							$cityField.inputIndicator('stop');
						},
						error:   function() {
							$cityField.inputIndicator('stop');

							alert('Произошла внутренняя ошибка');
						}
					});
				},
				select: function(event, ui) {
					$('input#cityGuid', $form).val(ui.item.id);
				}
			});

			$streetField.autocomplete({
				source: function(request, response) {

					//@TODO: добавить индикацию загрузки

					var text = $streetField.val();

					if (text.length <= 2) {
						response([]);
						return;
					}

					$streetField.inputIndicator('start');

					$.ajax({
						url:     baseUrl+'address/streets',
						method:  'post',
						data:    {query: text, cityGuid: $('input#cityGuid', $form).val()},
						success: function(ajaxResult) {
							var result = [];

							var $streetHelpBlock = $streetField.siblings('.help-block').text('');

							if (ajaxResult.success === true) {
								$(ajaxResult.data).each(function(id,el) {
									result.push({'id':el.id,'label':el.title, 'value':el.title});
								});
							}
							else {
								if (ajaxResult.errors.length > 0) {
									$streetHelpBlock.text(ajaxResult.errors[0]);
								}
								else {
									$streetHelpBlock.text('Улицы не найдены');
								}
							}

							response(result);

							$streetField.inputIndicator('stop');
						},
						error:   function() {
							$streetField.inputIndicator('stop');

							alert('Произошла внутренняя ошибка');
						}
					});
				},
				select: function(event, ui) {
					$('input#streetGuid', $form).val(ui.item.id);
				}
			});
		}
	};

	$.fn.contactForm = function(method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		}
	}

})(jQuery);