$(document).ready(function(){
	
	$('body').on('click','.add-client-field',function(e){
		e.preventDefault();
		var t = $(this);
      	var p = $(this).closest('tr');
      	var u = $(this).attr('data-rest');
      	var fn = p.find('#field_name').val();
      	var ft = p.find('#field_type option:selected').val();
      	var btntxt =  $(this).text();
      	$(this).html('<i class="glyphicons glyphicons-refresh glyphicon-refresh-animate"></i>');
      	var formdata = {
      	'data[name]' : fn,
      	'data[value]' : ft
    }
    $.ajax({
      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url     : u, // the url where we want to POST
      data    : formdata, // our data object
      dataType  : 'json', // what type of data do we expect back from the server
      encode    : true
    }).done(function(data) {
      if(data.Key == 'Success') {
        console.log(data);
        t.text(btntxt);
        $('.clients-fields').load(document.URL +  ' .clients-fields #clients-fields-wrap');
      } else {
         t.text(btntxt);
      }
    }).fail(function(data) {
      console.log(data);
    });
    
    });

  $('body').on('click','.close-member',function(e){
    e.preventDefault();
    $('.mem-overlay').remove();
    $(this).closest('.membercard').remove();

  });
  $('body').on('click','.mem-overlay',function(e){
    e.preventDefault();
    $('.mem-overlay').remove();
    $('.membercard').remove();
  });

////

$('#input-company').on('keyup',function(e){
 
  var key = e.keyCode;  
  var p = $(this).parent();
  var v = $(this).val();
  var $current = '';  
  if(v.length >= 2) {

    if (key == 13 || key == 37 || key == 39) {
// do nothing
    } else if(key == 40 || key == 38) {
      // return false;
          
        } else {
    $('#res-group').remove();

     var formdata = {'data[company]' : $('#input-company').val()}
      $.ajax({
      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url     :  'api/json/clients/companies/', // the url where we want to POST
      data    : formdata, // our data object
      dataType  : 'json', // what type of data do we expect back from the server
      encode    : true
    }).done(function(data) {
      console.log(data.val);
      p.append(data.val);

    }).fail(function(data) {
      // console.log(data);
    });

    
        }

    
  } else {
    $('body').find('#res-group').remove();
  }
  if(key == 40) {
    var $listItems = $('body').find('#res-group .opt');
    
    $selected = $listItems.filter('.selected-g');
    $listItems.removeClass('selected-g');
   if (!$selected.length || $selected.is(':last-child')) {
                $current = $listItems.eq(0);
            } else {
                $current = $selected.next();
            }
    $current.addClass('selected-g');
     //
    }

  if(key == 38) {
    var $listItems = $('body').find('#res-group .opt');
     $selected = $listItems.filter('.selected-g');
     $current = $selected.prev();
     $listItems.removeClass('selected-g');
     $current.addClass('selected-g');
     //
    }

  if(key == 13) {
    var $listItems = $('body').find('#res-group .opt');
    $selected = $listItems.filter('.selected-g');
    if($selected.length) {
    $(this).val($selected.text());
    $(this).parent().find('#res-group').remove();
    } else {
    $(this).parent().find('#res-group').remove();  
    }
    
    }

  });

$('body').on('mouseenter','.opt',function(){
  $('body').find('#res-group .opt').removeClass('selected-g');
  $(this).addClass('selected-g');
});

$('body').on('click','.opt',function(){
  $('#input-group').val($(this).text());
  $('body').find('#res-group').remove();
})


});