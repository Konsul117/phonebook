$(document).ready(function() {

	$('input[data-role=phone-field]').inputmask({mask: '+7 (999) 999-9999'});

	$('input[data-role=email-field]').inputmask({
		mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
		greedy: false,
		onBeforePaste: function (pastedValue) {
			pastedValue = pastedValue.toLowerCase();
			return pastedValue.replace("mailto:", "");
		},
		definitions: {
			'*': {
				validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
				cardinality: 1,
				casing: "lower"
			}
		}
	});

	$('input[data-role=date-field]').datepicker({
		dateFormat: 'dd.mm.yy',
		maxDate: new Date()
	});

});