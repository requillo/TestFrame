$('body').on('click', '.edit-data', function(e){
		e.preventDefault();
		var p = $(this).closest('tr, .tr');
		p.find('.hide').removeClass('hide');
		$(this).addClass('hide');
		p.find('.info, .del-btn').addClass('hide');
	});

	$('body').on('click', '.cancel-data', function(e){
		e.preventDefault();
		var p = $(this).closest('tr, .tr');
		$(this).addClass('hide');
		p.find('.hide').removeClass('hide');
		p.find('input, select, .the-edit, .cancel-data').addClass('hide');
	});
