function chainSelect2(el) {
	var chain = el.data('chain');

	if(el.val() == 0) checkSelect(el.val(), $(chain));

	el.on("select2:select", function(e) {
		checkSelect($(this).val(), $(chain));
	});

	if($(chain).attr('data-chain'))
		chainSelect2($(chain));
}

function checkSelect(id, el) {
	var oldVal = el.val();
	el.empty();
	if(id == 0){
		if(el.data('chain')) checkSelect(0, $(el.data('chain')));
		el.prop('disabled', true);
	}
	else{
		$.ajax({
			url      : root + '/api/' + el.data('alias') + '/' + id,
			type     : 'GET',
			dataType : 'json',
			data     : {}
		})
		.done(function(results) {
			if(results.length > 0) {
				var model = el.parent('div').prev('label').text();
				el.append($('<option>', {
					value: "0",
					text: 'Pilih ' + model + '..'
				}));
				for(var i = 0; i < results.length; i++){
					el.append($('<option>', {
						value: results[i].id,
						text: results[i].name
					}));
				}
				el.prop('disabled', false);
				el.trigger('change').val(oldVal);
				if(el.data('chain')){
					checkSelect(0, $(el.data('chain')));
					el.unbind("select2:select").on("select2:select", function() {
						checkSelect(el.val(), $(el.data('chain')));
					});
				}
			}
			else {
				if(el.data('chain')){
					checkSelect(0, $(el.data('chain')));
				}
				el.prop('disabled', true);
			}
		})
		.fail(function() {
			console.log("Ajax error");
		});
	}
}