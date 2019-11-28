	$(document).ready(function(){
		/*
		$(function(){
		    $.contextMenu({
		        selector: 'body', 
		        build: function($trigger, e) {
		            // this callback is executed every time the menu is to be shown
		            // its results are destroyed every time the menu is hidden
		            // e is the original contextmenu event, containing e.pageX and e.pageY (amongst other data)
		            return {
		            	build: function(trigger, e) {
		            		var id = trigger.attr('class');
		            	},
		                callback: function(key, options) {
		                    var m = "clicked: " + key;
		                    window.console && console.log(m);
		                   // alert(id);
		                },
		                items: {
		                    "edit": {name: "Edit", icon: "edit"},
		                    "cut": {name: "Cut", icon: "cut"},
		                    "copy": {name: "Copy", icon: "copy"},
		                    "paste": {name: "Paste", icon: "paste"},
		                    "delete": {name: "Delete", icon: "delete"},
		                    "sep1": "---------",
		                    "quit": {name: "Quit", icon: function($element, key, item){ return 'context-menu-icon context-menu-icon-quit'; }}
		                }
		            };
		        }
		    });
		});
		*/

		$('.char-edit').on('click', function(e){
			e.preventDefault();
			$(this).parent().addClass('hide');
			$(this).closest('.widget-block').find('.widget-input-data').removeClass('hide');
		});
		$('.char-save').on('click', function(e){
			e.preventDefault();
			u = $(this).attr('data-link');
			var fdata = {
				'data[id]' : $(this).attr('data-id'),
				'data[name]' : $(this).parent().find('.chars').val(),
				'data[value]' : $(this).parent().find('.price-input').val()
			}
			$.ajax({
		      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		      url     : u, // the url where we want to POST
		      data    : fdata, // our data object
		      dataType  : 'json', // what type of data do we expect back from the server
		      encode    : true
		    }).done(function(data) {
		      if(data.Key == 'Success') {
		        console.log(data);
		       location.reload();
		      } else {
		         alert('error');
		      }
		    }).fail(function(data) {
		      console.log(data);
		    });
		});

		$('.cat-update').on('click', function(e){
			e.preventDefault();
			u = $(this).attr('data-link');
			var fdata = {
				'data[id]' : $(this).attr('data-id'),
				'data[category_name]' : $(this).parent().find('.cat-input').val()
			}
			$.ajax({
		      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		      url     : u, // the url where we want to POST
		      data    : fdata, // our data object
		      dataType  : 'json', // what type of data do we expect back from the server
		      encode    : true
		    }).done(function(data) {
		      if(data.Key == 'Success') {
		        console.log(data);
		       location.reload();
		      } else {
		         alert('error');
		      }
		    }).fail(function(data) {
		      console.log(data);
		    });
		});

		$('.add-cat').on('click', function(e){
			e.preventDefault();
			u = $(this).attr('data-link');
			var fdata = {
				'data[category_name]' : $(this).parent().find('.add-cat-input').val()
			}
			$.ajax({
		      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		      url     : u, // the url where we want to POST
		      data    : fdata, // our data object
		      dataType  : 'json', // what type of data do we expect back from the server
		      encode    : true
		    }).done(function(data) {
		      if(data.Key == 'Success') {
		        console.log(data);
		       location.reload();
		      } else {
		         alert('error');
		      }
		    }).fail(function(data) {
		      console.log(data);
		    });
		});


		$('#rub-cal').multiDatesPicker({
			disabled: true,
			altField: '#altField-1',
			dayNamesShort: ['Zon', 'Maa', 'Din', 'Woe', 'Don', 'Vri', 'Zat'],
      		dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
      		monthNames: ['Januari','Februari','Maart','April','Mei','Juni','Juli','Augustus','September','October','November','December'],
     		monthNamesShort: ['Jan','Feb','Maa','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
			firstDay: 1
		});


$('body').on('click', '.list_cat', function(e){
		if($(this).hasClass('list_cat')) {
			$('.active-tab').removeClass('active-tab');
			$('.active').removeClass('active');
			var id = $(this).attr('ref');
			$('body').find(id).addClass('active-tab');
			$(this).addClass('active');
		}
	});

$('body').on('click', 'a.del-btn', function(e){
	
	e.preventDefault();
	e.stopImmediatePropagation();
	var rel = $(this).parent().attr('ref');
	var catdate = $(this).parent().attr('data-set-dates');
	$('body').find(rel).remove();
	$('body').find(catdate).remove();
	$(this).parent().remove();
	
	if($('.tab').length) {
		if($('.active-tab').length) {

		} else {
			$('.tab:first').addClass('active-tab');
		}

		if($('.active').length) {

		} else {
			$('.list_cat:first').addClass('active');
		}

	} else {
		var a = '<div class="no-work row">';
		a = a + '<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12"><div class="all-syms"><a class="sym" href="">&copy;</a><a class="sym" href="">&euro;</a><a class="sym" href="">&dollar;</a><a class="sym" href="">&pound;</a><a class="sym" href="">&yen;</a></div>';
		a = a + '<textarea name="content" class="text form-control" disabled></textarea></div>';
		a = a + '<div id="mdp-demo" class="col-lg-4 col-md-12 col-sm-12 col-xs-12"></div>';
		a = a + '</div>';
		$('.tabs').html(a);
		$('#mdp-demo').multiDatesPicker({
			disabled: true
		});
	}
});

	$('#rubriek').on('submit', function(){
		var error = 0;
		$('.error').removeClass('error');
		$('.errordate').removeClass('errordate');
		$('.required').each(function(){
   			if($(this).val() == '') {
   				error = 1;
   				$(this).addClass('error');
   				if($(this).closest('.tab')) {
   					var id = $(this).closest('.tab').attr('id');
   					if(id) {
   						$('.'+id).addClass('error');
   					}
   				}

   				if($(this).closest('.the-date')) {
   					var dd = $(this).closest('.the-date').find('.wrapdate');
   					if(dd) {
   						dd.addClass('errordate');
   					}
   				}

   			}

 		});
 		if(error == 1) {
 			return false;
 		}

	});
});