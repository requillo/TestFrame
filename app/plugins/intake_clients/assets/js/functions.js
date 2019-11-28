$('#input-other-client').on('ifChanged',function() {
	 if ($(this).prop('checked')==true){
	 	$('#this-client').addClass('hide');
	 	$('#other-client').removeClass('hide');
	 } else {
	 	$('#this-client').removeClass('hide');
	 	$('#other-client').addClass('hide');
	 }    
});