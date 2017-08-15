
$(document).ready(function() {
	$('.data-table tbody').find('tr').hover(function() {
		$(this).addClass('hovered');
		addActionButtons(this);
	}, function() {
		$(this).removeClass('hovered');
		removeActionButtons(this);
	});	
});

function addActionButtons(el) {
	$(el).find('.action-buttons').css('display', 'block');
}

function removeActionButtons(el) {
	$(el).find('.action-buttons').css('display', 'none');	
}