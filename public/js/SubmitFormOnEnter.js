$(document).ready(function($) {
	$('input').one('keypress', function(event) {
		if (event.which == 13) {
			event.preventDefault();
			$(this).closest('form').submit();
		}
	});
});