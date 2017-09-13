$(document).ready(function() {
	$('.table-data tbody').find('tr').hover(function() {
		// $(this).addClass('hovered');
		addActionButtons(this);
	}, function() {
		// $(this).removeClass('hovered');
		removeActionButtons(this);
	});	
});

function addActionButtons(el) {
	$(el).find('.action-buttons').css('display', 'inline-flex');
}

function removeActionButtons(el) {
	$(el).find('.action-buttons').css('display', 'none');	
}