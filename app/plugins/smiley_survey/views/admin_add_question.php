<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create('add-question'); ?>
		  		<div class="col-lg-7 col-md-8 col-sm-12 col-xs-12">
		  			<?php $form->input('question',array('type'=>'text','label'=>__('Question','smiley_survey'))); ?>
		  		</div>
		  		<div class="col-lg-5 col-md-4 col-sm-12 col-xs-12">
		  			<label for="company_id_select"><?php echo __('Company','smiley_survey'); ?></label>
		  			<select class="form-control" id="company_id_select" name="data[company_id]">
		  				<option value="0"><?php echo __('Choose a company','smiley_survey');?></option>
		  				<?php echo $form->options($company_options) ?>
		  			</select>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<label><?php echo __('Terminal','smiley_survey'); ?></label>
		  			<ul class="terminalWrap ui-sortable sortable-flex"></ul>
		  		</div>

		  		<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
		  			<?php $form->select('type',array('label' => __('Answer type','smiley_survey'), 'options' => $answer_types))?>
		  			<div class="pop-this list-group"></div>
		  		</div>
		  		<div class="col-lg-9 col-md-7 col-sm-12 col-xs-12 sidebar-check">
		  			<label for="company_id_select"><?php echo __('Answers','smiley_survey'); ?></label> <span class="text-message text-danger"></span>
		  			<ul id="sortable"></ul>
		  		</div>
		  		
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><button class="btn btn-success"><?php echo __('Save','smiley_survey'); ?></button></div>
		  		<?php $form->close(); ?>
		  	</div>
		</div>
	</div>
<?php if(!empty($questions)){ ?>
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="results">
					<table id="datatable-questions" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th><?php echo __('Company','smiley_survey') ?></th>
								<th><?php echo __('Terminal','smiley_survey') ?></th>
								<th><?php echo __('Question','smiley_survey') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($questions as $question) { ?>
							<tr>
								<td><?php 
								$question['terminal_id'] = json_decode($question['terminal_id']);
								echo $company_options[$term_comp[$question['terminal_id'][0]]];?></td>
								<td><?php
								$i = 0;
								foreach ($question['terminal_id'] as $value) {
									if($i < 1) {
										echo $terminal_options[$value];
									} else {
										echo ', '. $terminal_options[$value];
									}
									$i++;
								}
								$question['terminal_id']
								?></td>
								<td><?php echo $html->admin_link($question['question'],'smiley-survey/view-question/'.$question['id'].'/') ;?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				</div>
		  	</div>
		</div>
	</div>
<?php } ?>
</div>
<div class="hide" id="text-pop">
	<label for="sm-text-answers"><?php echo __('Answer','smiley_survey') ?></label>
	<div class="input-group">
	<input id="sm-text-answers" type="text" class="form-control">
	<span class="input-group-btn">
	<a class="btn btn-default add-text-ans"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __('Add','smiley_survey') ?></a>
	</span>
	</div>
</div>
<script type="text/javascript">
if($('#datatable-questions').length) {
	$('#datatable-questions').DataTable();
}
$('#company_id_select').on('change', function(e) {
	var id = $(this).val();
	var fdata = {'data[company_id]': id };
if(id > 0) {
	$.getJSON( Jsapi+'smiley-survey/get-terminals/', fdata , function( data ) {
			console.log(data);
			$('.terminalWrap').html(data.options);
			add_icheck();
	    });
} else {
	$('.terminalWrap').html('');
}
	
});

$('#input-type').on('change',function(){
		var q = $(this).find('option:selected').val();
		$('.sidebar-check #sortable').html('');
		if(q == 1) {
			$.getJSON( Jsapi+'smiley-survey/get-emoticons/', function( data ) {
			console.log(data);
			var t = '';
			$.each(data, function( index, value ) {
			  // alert( index + ": " + value );
			  t += '<a class="list-group-item add-item" data-id="'+value.id+'" data-img="'+value.image_svg+'" data-text="'+value.emoticons+'">';
			  t += '<div class="handle"><img src="'+value.image_svg+'" class="small-ico">';
			  t += ' <span class="desc-txt">'+value.emoticons+'</span></div> <span class="ttr"><i class="fa fa-hand-o-up"></i> <i class="fa fa-window-close text-danger del-ans"></i></span></a>';
			});
			$('.pop-this').html(t);
	    });
		} else if(q == 2) {
			 var t = $('#text-pop').html();
			$('.pop-this').html(t);
		} else {
			$('.pop-this').text('');
		}
	});

$('body').on('click','.add-item',function(){
	$('.text-message').text('');
	var d = $(this).html();
	var id = $(this).attr('data-id');
	var im = $(this).attr('data-img');
	var t = $(this).attr('data-text');
	var ff = '<a class="btn btn-info btn-block add-feedback"><?php echo __('Add feedback','smiley_survey'); ?></a>';
	var fh = '<div class="feedback-msg text-danger"></div><div class="feedback-holder"></div>';
	var inp = '<input class="form-control hide" value="'+id+'" name="data[answers][id][]">';
	inp += '<input class="form-control the-answer" value="'+t+'" name="data[answers][description][]">'
	var count = $("#sortable li").length;
	if(count < 4) {
		$("#sortable").append('<li data-id="'+id+'" class="ui-state-default">'+d+inp+ff+fh+'</li>');
		$("#sortable").sortable("serialize", { key: "sort" });
	} else {
		$('.text-message').text('Can\'t add anymore');
	}
});

$('body').on('click','.add-text-ans',function(){
	$('.text-message').text('');
	var t = $(this).closest('.input-group').find('input').val();
	var c = t.replace(/\s/g,'');
	var inp = '<input class="form-control the-answer" value="'+t+'" name="data[answers][description][]">'
	var count = $("#sortable li").length;
	if(count < 4 && c != '') {
		$("#sortable").append('<li class="ui-state-default"><div class="handle"><span class="desc-txt">'+t+'</span></div>'+inp+'<span class="ttr"><i class="fa fa-window-close text-danger del-ans"></i></span></li>');
		$(this).closest('.input-group').find('input').val('');
	} else if(count < 4 && c == '') {
		$('.text-message').text('Can\'t add empty answer');
	} else {
		$('.text-message').text('Can\'t add anymore');
	}
});

$('body').find( "#sortable" ).sortable({handle: ".handle",});
$('body').find( "#sortable" ).disableSelection();

$('body').on('click','.del-ans',function(){
	$(this).closest('li').fadeOut( "slow", function() {
    $(this).remove();
  });
});

$('body').on('click','.remove-feedback',function(){
	$(this).closest('.input-holder').fadeOut( "slow", function() {
    $(this).remove();
  });
});

$('#add-question').on('submit', function(e){
	$('.form-error').removeClass('form-error');
	var error = false; 
	var a = $('#input-question').val();
	var b = $('input[name="data[terminal_id][]"]:checked').val();
	var c = $('#input-type').val();
	var d = $('.sidebar-check #sortable').text();
	if(a.replace(/\s/g,'') == '') {
		$('#input-question').addClass('form-error');
		error = true;
	}
	if(d.replace(/\s/g,'') == '') {
		$('.sidebar-check #sortable').addClass('form-error');
		error = true;
	}
	if(b == undefined) {
		$('.terminalWrap').addClass('form-error');
		error = true;
	}
	if(c == 0) {
		$('#input-type').addClass('form-error');
		error = true;
	}

if(error) {
	return false;
}

});

$('body').on('click','.add-feedback',function(){
	var a = $(this).closest('li');
	a.find('.feedback-msg').text('');
	var b = a.attr('data-id');
	var c = '<input class="form-control" name="data[answers][feedback_'+b+'][]" placeHolder="<?php echo __('Answer feedback') ?>">';
	var d = '<span class="remove-feedback"><i class="fa fa-window-close text-danger"></i></span>';
	var count = a.find('.feedback-holder .input-holder').length;
	if(count < 4 ) { 
		a.find('.feedback-holder').append('<div class="input-holder">'+c+d+'</div>');
	} else {
		a.find('.feedback-msg').text('<?php echo __("Can\'t add any feedback");?>');
	}
	
});
$('body').on('keyup','.the-answer', function(){
		var t = $(this).val();
		$(this).closest('li').find('.desc-txt').text(t);
	});
</script>