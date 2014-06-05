$(document).ready(function() {
	$('.deleteCheckbox').click(function() { 
		var target = $(this).attr('ref');
		$('#'+target).toggle();
	})
});