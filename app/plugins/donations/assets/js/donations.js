var l = MainUrl;
var max = $('.main_link').val();
$(window).ready(function(){
 $('#input-extra_description').val('');
});
function turn_on_icheck()
{
	$('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
}
if($('.datatable-add-donation').length) {
	$('.datatable-add-donation').DataTable();

	$('.datatable-add-donation').on('draw.dt', function () {
    	turn_on_icheck();
	});
}
$('#input-first_name, #input-last_name, #input-id_number').on('keyup input', function(){
	var p = '';
	var fdata = {
		'data[first_name]' : $('#input-first_name').val(),
		'data[last_name]' : $('#input-last_name').val(),
		'data[id_number]' : $('#input-id_number').val()
	}
	$.ajax({
		url: l+'api/json/donations/get-persons',
		type: "POST",
		data: fdata,
		dataType: "json",
		encode : true
	}).done(function( data ) {
		if(data.similar != ''){
			$('.sim_results').html('<div class="row">'+data.similar+'</div>');
			$('#input-same').val(data.similar_ids);
			$('#input-per_sim').val(data.per_sim);
			$('#input-mix_name').val(data.mix_names);
			$('.overwrite, .similar-persons').removeClass('hide');
			$.each(data.person, function( index, value ) {
			 // alert( index + ": " + value.id );
			  p = p + '<tr>';
			  p = p + '<td><a href="'+l+'donations/edit-person/'+value.id+'/">'+value.first_name+' '+value.last_name+'</a></td>';
			  p = p + '<td>'+value.id_number+'</td>';
			  p = p + '</tr>';
			});
			$('.person-result').removeClass('hide');
			$('.person-result table tbody').html(p);
		} else {
			$('.sim_results').html(data.similar);
			$('#input-same').val(data.similar_ids);
			$('#input-per_sim').val(data.per_sim);
			$('#input-mix_name').val(data.mix_names);
			$('.overwrite, .similar-persons').addClass('hide');
			$('.overwrite').removeClass('alert alert-danger');
			$('.overwrite').addClass('alert alert-success');
			$('.person-result').addClass('hide');
		}
    	console.log(data);
	});
});
var ns = '';
$('input.sp_checker').on('ifChecked', function(event){
    ns = event.target.value; // alert value
});

$('input.sp_checker').on('ifUnchecked ', function(event){
    ns = ''; // alert value
});
var ofs = '';
$('input.owfs').on('ifChecked', function(event){
    ofs = event.target.value; // alert value
});

$('input.owfs').on('ifUnchecked ', function(event){
    ofs = ''; // alert value
});

var rfc = '';
$('body').on('ifChecked', 'input.res_found_check', function(event){
    rfc = event.target.value; // alert value
});

$('body').on('ifUnchecked', 'input.res_found_check', function(event){
    rfc = ''; // alert value
});


$('input.hasfd').on('ifClicked', function(event){
		var ti = this.checked;
	if(ti) {
		$('.foundation-add').removeClass('hide');
   		$('.foundation-add input').val('');
   	} else {
   		$('.foundation-add, .found_sim_head, .f_overwrite').addClass('hide');
   		$('.foundation-add input').val('');
   		$('.sim_foundation_results').html('');
   	}
		   
});

$('#donations').on('submit',function(){
	var sp = '';
	if ( $( "#input-same" ).length ) { 
		sp = $('#input-same').val();
	}
	var ps = $('#input-per_sim').val();
	var mn = $('#input-mix_name').val();
	var fs = $('#input-fsame').val();
	// alert(sp + '-' + ns + '-' + rfc);
	if(sp != '' && ns == ''){
		$('.overwrite').addClass('alert alert-danger');
		return false;
	} else if(fs != '' && ofs == '' && rfc == ''){
		$('.f_overwrite').addClass('alert alert-danger');
		return false;
	}
});

$('#input-foundation_name, #input-foundation_telephone, #input-foundation_address, #input-foundation_email').on('keyup input', function(){
	var p = '';
	var fdata = {
		'data[foundation_name]' : $('#input-foundation_name').val(),
		'data[foundation_telephone]' : $('#input-foundation_telephone').val(),
		'data[foundation_address]' : $('#input-foundation_address').val(),
		'data[foundation_email]' : $('#input-foundation_email').val()
	}
	$.ajax({
		url: l+'api/json/donations/get-foundations',
		type: "POST",
		data: fdata,
		dataType: "json",
		encode : true
	}).done(function( data ) {
		if(data.similar != ''){
			$('.sim_foundation_results').html(''+data.similar+'');
			$('#input-fsame').val(data.similar_ids);
			$('#input-fper_sim').val(data.per_sim);
			$('.f_overwrite, .found_sim_head, .sim_foundation_results').removeClass('hide');
			$('.nflat').iCheck({'checkboxClass': 'icheckbox_flat-blue'});
			$.each(data.foundation, function( index, value ) {
			 // alert( index + ": " + value.id );
				p = p + '<tr>';
			  	p = p + '<td><a href="'+l+'donations/edit-foundation/'+value.id+'/">'+value.foundation_name+'</a></td>';
			  	p = p + '<td>'+value.foundation_telephone+'</td>';
			  	p = p + '<td>'+value.foundation_address+'</td>';
			  	p = p + '<td>'+value.foundation_email+'</td>';
			  	p = p + '</tr>';
			  	$('.comp-result').removeClass('hide');
				$('.comp-result table tbody').html(p);
			});
		} else {
			$('.sim_foundation_results').html(data.similar);
			$('#input-fsame').val(data.similar_ids);
			$('#input-fper_sim').val(data.per_sim);
			$('.f_overwrite, .found_sim_head, .sim_foundation_results').addClass('hide');
			$('.comp-result').addClass('hide');
			// $('.overwrite, .sim_foundation_results').addClass('hide');
			// $('.overwrite').removeClass('alert alert-danger');
			// $('.overwrite').addClass('alert alert-success');
		}
    	console.log(data);
	});
});

$('.addasset').on('click', function(e){
	e.preventDefault();
	$('.form-error').removeClass('form-error');
	var i_d = $('#get_company').find('option:selected').val();
	var txtp = $('.text-price').val();
	var p = $(this).closest('.tab-pane');
	var desc = p.find('#input-desc').val();
	var price = p.find('#input-price').val();
	var item_code = p.find('#input-item_code').val();
	var unit = p.find('#input-unit').val();
	var type = p.find('#input-donation_types').val();
	var cd = desc.replace(/\s/g,'');
	var cp = price.replace(/\s/g,'');
	var ci = item_code.replace(/\s/g,'');
	var cu = unit.replace(/\s/g,'');
	if(cd == '') {
		p.find('#input-desc').addClass('form-error')
	}
	if(cp == '') {
		p.find('#input-price').addClass('form-error')
	}
	if(ci == '') {
		p.find('#input-item_code').addClass('form-error')
	}
	if(cd != '' && cp != '' && i_d >= 1 && ci != ''){
		
		var fdata = {
		'data[description]' : desc,
		'data[price]' : price,
		'data[item_number]' : item_code,
		'data[unit]' : unit,
		'data[company_id]' : i_d,
		'data[type]' : type
		}
		$.ajax({
		url: l+'api/json/donations/add-company-assets',
		type: "POST",
		data: fdata,
		dataType: "json",
		encode : true
		}).done(function( data ) {
    	console.log(data);
    	if(data.message == 'updated'){
    		/////////////////
    		var da = '<tr>';
    		da = da + '<td><a href="#" class="showass"><i class="fa fa-arrow-down" aria-hidden="true"></i></a></td>';
    		da = da + '<td class="p_desc">';
    		da = da + '<span class="desc-txt">'+desc+'</span>';
    		da = da + '<div class="inputwrap hide"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><input class="ass_desc form-control" value="'+desc+'"></div></div></div>';
    		da = da + '</td>';
    		da = da + '<td class="p_unit"><span class="unit-txt">'+unit+'  </span><div class="inputwrap hide"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><input class="ass_unit form-control" value="'+unit+'"></div></div></div></td>';
    		da = da + '<td class="p_price"><a href="#" data-id="'+data.id+'" class="delass pull-right text-danger"><i class="fa fa-trash" aria-hidden="true"></i></a> <span class="price-txt">'+price+'</span>';
    		da = da + '<div class="inputwrap hide"><div class="row"><div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"><input class="ass_price form-control" value="'+price+'"></div>';
    		da = da + '<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12"><a href="#" data-id="'+data.id+'" class="updass btn btn-success"><i class="fa fa-pencil" aria-hidden="true"></i> Update</a></div>';
    		da = da + '</div></div></td><tr>';

    		p.find('.results tbody').append(da);
    	}
    	p.find('#input-desc').val('');
    	p.find('#input-price').val('');
    	p.find('#input-unit').val('');
    	p.find('#input-item_code').val('');
	});

	}
});

$('body').on('click','.showass', function(e){
	e.preventDefault();
	var p = $(this).closest('tr');
	p.find('.inputwrap').toggleClass('hide');
});

function get_donation_assets(id){
	var txtp = $('.text-price').val();
	$('.results tbody').html('');
	$('.results span').html('');
	table2 = $('#datatable-ass-2').DataTable({"destroy": true});
	table2.clear();
	table3 = $('#datatable-ass-3').DataTable({"destroy": true});
	table3.clear();
	// Check for the id
	if(id >= 1){
		var fdata = {
		'data[company_id]' : id,
		}
		
		$.ajax({
		url: l+'api/json/donations/get-company-assets',
		type: "POST",
		data: fdata,
		dataType: "json",
		encode : true
		}).done(function( data ) {

		$.each(data,function(i,value){
			var da = '<tr>';
    		da = da + '<td><a href="#" class="showass"><i class="fa fa-arrow-down" aria-hidden="true"></i></a></td>';
    		da = da + '<td class="p_desc">';
    		da = da + '<span class="desc-txt">'+value['description']+'</span>';
    		da = da + '<div class="inputwrap hide"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><input class="ass_desc form-control" value="'+value['description']+'"></div></div></div>';
    		da = da + '</td>';
    		da = da + '<td class="p_unit"><span class="unit-txt">'+value['unit']+'  </span><div class="inputwrap hide"><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><input class="ass_unit form-control" value="'+value['unit']+'"></div></div></div></td>';
    		da = da + '<td class="p_price"><a href="#" data-id="'+value['id']+'" class="delass pull-right text-danger"><i class="fa fa-trash" aria-hidden="true"></i></a> <span class="price-txt">'+value['price']+'</span>';
    		da = da + '<div class="inputwrap hide"><div class="row"><div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"><input class="ass_price form-control" value="'+value['price']+'"></div>';
    		da = da + '<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12"><a href="#" data-id="'+value['id']+'" class="updass btn btn-success"><i class="fa fa-pencil" aria-hidden="true"></i> Update</a></div>';
    		da = da + '</div></div></td></tr>';
			$('#tabcontent-'+value['type']+' .results tbody').append(da);
			if(value['type'] == 2) {
				table2.row.add($(da));
				table2.draw();
			} else if(value['type'] == 3) {
				table3.row.add($(da));
				table3.draw();
			}
			
		});
    	console.log(data);
		});

	}

}

$('#get_company').on('change', function(){
	var i_d = $(this).find('option:selected').val();
	get_donation_assets(i_d);
	table2 = $('#datatable-ass-2').DataTable({"destroy": true});
	table2.clear();
	table3 = $('#datatable-ass-3').DataTable({"destroy": true});
	table3.clear();
});

$( document ).ajaxComplete(function( event, request, settings ) {
  	//$('#datatable-ass-2').DataTable({"destroy": true});
});

$('.add_items').on('submit',function(e){

		e.preventDefault();
		var formData = new FormData(this);
		var c = $('#get_company option:selected').val();
		var t = $(this).closest('.tab-pane').find('.type').val();
		var f = $(this).find('input[type=file]').val();
		var ext = f.split('.').pop().toLowerCase();
		formData.append("data[companies]", c);
		formData.append("data[type]", t);		
		if(c > 0 && ext == 'csv') {

			var p = $('.processing');
			p.removeClass('hide');
			$.ajax({
            url: l+'api/json/donations/import-company-assets',
            type: "POST",
            data: formData,
            cache: false,
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            complete: function(data){
            	p.addClass('hide');
            	get_donation_assets(c);
				table2 = $('#datatable-ass-2').DataTable({"destroy": true});
				table2.clear();
				table3 = $('#datatable-ass-3').DataTable({"destroy": true});
				table3.clear();
                console.log(data);
                $('#input-import_csv_2').val('');
                $('#input-import_csv_3').val('');
                $('body').find('.the-file').remove();
                if(data.responseText == 'no_csv') {
                	alert('Invalid file format');
                }
                }
            });
		} else {
			// alert('Problem');
		}
	});

$('body').on('click', '.updass ', function(e){
	e.preventDefault();
	var txtp = $('.text-price').val();
	var i = $(this).data('id');
	var p = $(this).closest('tr');
	var desc = p.find('.ass_desc').val();
	var price = p.find('.ass_price').val();
	var unit = p.find('.ass_unit').val();
	var fdata = {
		'data[id]' : i,
		'data[description]' : desc,
		'data[unit]' : unit,
		'data[price]' : price
		}
	$.ajax({
		url: l+'api/json/donations/update-company-assets',
		type: "POST",
		data: fdata,
		dataType: "json",
		encode : true
		}).done(function( data ) {
    		if(data.message == 'Updated'){ 
				p.find('.desc-txt').html(desc);
				p.find('.unit-txt').html(unit);
				p.find('.price-txt').html(price);
				p.find('.inputwrap').addClass('hide');
    		}
		
    	console.log(data);
		});
	
});

$('body').on('click', '.delass', function(e){
	e.preventDefault();
	var i_d = $('#get_company option:selected').val();
	var txtyes = $('.text-yes').val();
	var txtno = $('.text-no').val();
	var deltxt = $('.text-sure-del').val();
	var p = $(this).closest('tr');
	var tab = $(this).closest('table').DataTable({"destroy": true});
	var prod = p.find('.desc-txt').text();
	var i = $(this).data('id');
		$.confirm({
	    title: deltxt,
	    theme: 'modern',
	    content: prod,
	    autoClose: 'cancel|8000',
	    buttons: {
	        confirm: {
	            text: txtyes,
	            btnClass: 'btn-success',
	            keys: ['enter','delete'],
	            action: function(){
	            	$.getJSON( l+'api/json/donations/delete-company-assets/'+i, function( data ) {
	            		
	            		if(data.message == 'Deleted'){
	            			tab.row(p).remove().draw();
	            			// get_donation_assets(i_d);
	            		}
	            		
	            	});
	               
	            }
	        },
	        cancel: {
	            text:  txtno,
	            btnClass: 'btn-danger',
	            action: function(){
	                // $.alert('Not deleted');
	            }
	        }
	    }
		});
	});

$('body').on('ifToggled','.checkass', function(){
	var p = $(this).closest('.par-ass');
	var v = $(this).val();
	var price = p.find('.ass-price').val();
	var desc = p.find('.ass-desc').val();
	var a = p.find('.ass-amount').val();
	var ta = $('#input-extra_description').val();
	var res = $('.add-res-data');
	var resd = res.html();
	if(a <= 0 || a == ''){
		a = 1;
	}
	var totp = parseFloat(price)*parseFloat(a);
	totp = totp.toFixed(2);
	var mp = 0;
	var dt = v + '-' + a + '-' + price + ',';
	var d = '<tr id="res-'+v+'"><td><span class="amount-d">'+a+'</span></td><td><span>'+ desc + ' @ SRD '+ price +'</span></td><td><span class="totam">'+ totp + '</span></td><input type="hidden" value="'+dt+'"></tr>';
	var b = 0;
	var taa = $('body').find('.totam');
	var cp = $('.data-cash-amount').val();
	var cd = $('.data-cash').val();
	var pr = cp.replace(/\s/g,'');
	var de = cd.replace(/\s/g,'');
	var tta = $('.ass-tot-amount-dona');
	var ttai = $('#input_tot-amount');
	if(taa.length){
		taa.each(function(){
			b = b + parseFloat($( this ).text());
		});
	}

	if(pr != '' && de != ''){
		cp = parseFloat(cp);
	} else {
		cp = parseFloat(0);
	}
	
	// tta.text(ptta.toFixed(2));
	// ttai.val(ptta.toFixed(2));

	if( $(this).is(':checked')){
		res.append(d)
		$('#input-extra_description').val(ta+dt);
		ptta = parseFloat(b) + parseFloat(totp) + cp;
		if(isNaN(ptta)) {
			ptta = '';
		}
		tta.text(ptta.toFixed(2));
		ttai.val(ptta.toFixed(2));
	} else {
		ptta =   parseFloat(b) +  cp;
		ptta = ptta - totp;
		if(isNaN(ptta)) {
			ptta = '';
		}
		tta.text(ptta.toFixed(2));
		ttai.val(ptta.toFixed(2));
		ta = ta.replace(dt, "");
		$('#input-extra_description').val(ta);
		res.find("#res-"+v).remove();
	}
})

$('body').on('change keyup input','.ass-amount', function(){
	var ta = $('body').find('#input-extra_description').val();
	var p = $(this).closest('.par-ass');
	var v = p.find('.checkass').val();
	var price = p.find('.ass-price').val();
	var desc = p.find('.ass-desc').val();
	var a = $(this).val();
	if(a <= 0 || a == ''){
		a = 1;
	}
	var res = $('.add-res-data');
	var totp = parseFloat(price)*parseFloat(a);
	totp = totp.toFixed(2);
	var dt = v + '-' + a + '-' + price + ',';
	var odt = res.find('#res-'+v+' input').val();
	ta = ta.replace(odt, dt);
	
	res.find('#res-'+v+' .amount-d').text(a);
	res.find('#res-'+v+' .totam').text(totp);
	$('#input-extra_description').val(ta);
	res.find('#res-'+v+' input').val(dt);

	var b = 0;
	var taa = $('body').find('.totam');
	var cp = $('.data-cash-amount').val();
	var cd = $('.data-cash').val();
	var pr = cp.replace(/\s/g,'');
	var de = cd.replace(/\s/g,'');
	var tta = $('.ass-tot-amount-dona');
	var ttai = $('#input_tot-amount');
	if(taa.length){
		taa.each(function(){
			b = b + parseFloat($( this ).text());
		});
	}

	if(pr != '' && de != ''){
		cp = parseFloat(cp);
	} else {
		cp = parseFloat(0);
	}

	ptta =   parseFloat(b) +  cp;
		if(isNaN(ptta)) {
			ptta = '';
		}
		tta.text(ptta.toFixed(2));
		ttai.val(ptta.toFixed(2));
});

$('body').on('change keyup input','.data-cash, .data-cash-amount', function(){
	var p = $(this).closest('.tab-pane');
	var price = p.find('.data-cash-amount').val();
	var desc = p.find('.data-cash').val();
	var pr = price.replace(/\s/g,'');
	var de = desc.replace(/\s/g,'');
	var tta = $('.ass-tot-amount-dona');
	var ttai = $('#input_tot-amount');
	var v = 'cash';
	var res = $('.res-cash');
	var d = '<td></td><td></td><td></td>';
	var a = 0;
	var ta = $('body').find('.totam');
	if(ta.length){
		ta.each(function(){
			a = a + parseFloat($( this ).text());
		});
	}

	desc = desc.replace(/\n/g,"<br>");
	price = parseFloat(price);

	if(pr != '' & de != ''){
		res.removeClass('hide');
		d = '<td></td><td>'+ desc + '</td>';
		d = d + '<td><span class="res-price">'+price.toFixed(2)+'</span></td>';
		ptta = a + price;
		if(isNaN(ptta)) {
			ptta = '';
		}
		res.html(d);
		tta.text(ptta.toFixed(2));
		ttai.val(ptta.toFixed(2));
	} else {
		price = 0;
		ptta = a + price;
		if(isNaN(ptta)) {
			ptta = '';
		}
		res.addClass('hide');
		res.html(d);
		tta.text(ptta.toFixed(2));
		ttai.val(ptta.toFixed(2));
	}
	

});