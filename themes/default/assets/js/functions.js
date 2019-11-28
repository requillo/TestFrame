$(document).ready(function(){
	
	$('.mobilemenu').on('click', function(e){
		e.preventDefault();
		p = $(this);
		c = p.find('a');
		b = $(this).closest('body');

		if(c.hasClass('open')){
			c.removeClass('open');
			$(this).closest('nav').removeClass('open');
			b.removeClass('hold');
		} else {
			c.addClass('open');
			$(this).closest('nav').addClass('open');
			b.addClass('hold');
		}
		
	});

	$('body').on('click','nav.open li a', function(e){
		p = $(this).closest('nav');
		b = $(this).closest('body');
		p.find('.menu-btn').removeClass('open');
		p.removeClass('open');
		b.removeClass('hold');
	});
});