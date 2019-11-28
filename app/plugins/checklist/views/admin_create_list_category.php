<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--<pre>
	<?php print_r($list_cats) ?>
</pre>-->
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create(); ?>
		  		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-3">
		  			<?php $form->input('name',array('type'=>'text','label'=>__('Category','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-2 col-md-3 col-sm-6 col-xs-3">
		  			<?php $form->select('interval_type',array('label'=>__('Interval type','checklist'),'options'=>$cats_interval_types)); ?>
		  		</div>
		  		
		  		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-3">
		  			<?php $form->select('list_add_view', array('label'=>__('List add view','checklist'),'options' => $list_add_view)) ?>
		  		</div>
		  		<div class="col-lg-4 col-md-3 col-sm-6 col-xs-3">
		  			<?php $form->select('list_view', array('label'=>__('List data view','checklist'),'options' => $list_data_view)) ?>
		  		</div>
		  		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		  			<?php $form->textarea('info_01',array('label'=>__('Category info 1','checklist'),'attribute' => 'rows="3"'));?>
		  		</div>
		  		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		  			<?php $form->textarea('info_02',array('label'=>__('Category info 2','checklist'),'attribute' => 'rows="3"')); ?>
		  		</div>
		  		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		  			<?php $form->textarea('info_03',array('label'=>__('Category info 3','checklist'),'attribute' => 'rows="3"')); ?>
		  		</div>
		  			<?php // $form->input('interval_data',array('type'=>'text','label'=>__('Interval <?php if(count($shifts) > 0) { ?>
	  			<?php if(count($shifts) > 0) {
	  			$cols = 12/count($shifts); 
	  				?>
	  				<?php foreach ($shifts as $key => $value) { 
	  					// print_r($value);
	  					?>
	  					<div class="group-shift col-lg-<?php echo $cols ?> col-md-<?php echo $cols ?> col-sm-12 col-xs-12" id="shift-<?php echo $value['id']; ?>">
	  						<label><?php echo $value['name']; ?></label><br>
	  						<span><?php echo __('Shift start','checklist'); ?></span>: 
	  						<span class="shift_start"><?php echo date('H:s', strtotime($value['shift_start'])); ?></span> - 
	  						<span><?php echo __('Shift end','checklist'); ?></span>: 
	  						<span class="shift_end"><?php echo date('H:s', strtotime($value['shift_end'])); ?></span>
	  						<div class="input-group">
							  <span class="input-group-addon add-time-interval" id="basic-addon<?php echo $value['id']; ?>">
							  	<a href="#"><?php echo __('Interval','checklist'); ?></a>
							  </span>
							  <input type="number" class="form-control minutes" placeholder="minutes" aria-describedby="basic-addon<?php echo $value['id']; ?>">
							  <span class="input-group-addon"><?php echo __('Minutes','checklist'); ?></span>
							</div>
	  						<div class="data-count hide">
							<div class="row">
								<div class="col-lg-6 col-md-12 col-sm-6 col-xs-6">
									<div class="input-group">
									  <span class="input-group-addon">
									  	<a href="#"><?php echo __('Start','checklist'); ?></a>
									  </span>
									  <input type="time" class="form-control counts_start" value="<?php echo date('H:s', strtotime($value['shift_start'])); ?>" >
									</div>
								</div>
								<div class="col-lg-6 col-md-12 col-sm-6 col-xs-6">
									<div class="input-group">
									  <span class="input-group-addon">
									  	<a href="#"><?php echo __('End','checklist'); ?></a>
									  </span>
									  <input type="time" class="form-control counts_end" value="<?php echo date('H:s', strtotime($value['shift_end'])); ?>" >
									</div>
								</div>
							</div>
							<div class="input-group">
							  <span class="input-group-addon add-count-interval">
							  	<a href="#"><?php echo __('Add counts','checklist'); ?></a>
							  </span>
							  <input type="number" class="form-control counts" placeholder="count" >
							</div>	
	  						</div>
	  					<input type="text" class="form-control add-interval" name="data[shifts][<?php echo $value['id'];?>]">
	  					</div>
	  				<?php } ?>
	  			<?php } ?>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<button class="btn btn-success"><?php echo __('Save','checklist'); ?></button>
		  		</div>
		  		<?php $form->close(); ?>
		  		<script type="text/javascript">
		  			$('.add-time-interval').on('click', 'a', function(e){
		  				e.preventDefault();
		  				var p = $(this).closest('.group-shift');
		  				var a = p.find('.shift_start').text();
		  				var b = p.find('.shift_end').text();
		  				p.find('.add-interval').val('');
		  				var c = p.find('.minutes').val();
		  				if(c < 1) {
		  					return false;
		  				}
		  				amsifySuggestags = new AmsifySuggestags(p.find('.add-interval'));
		  				amsifySuggestags._init();
		  				amsifySuggestags.addTag(a);
		  				var d = a+',';
		  				var time = a.split(':');
		  				var time_end = b.split(':');
		  				time_end = parseInt(time_end[0], 10)+':'+parseInt(time_end[1], 10);
		  				var hours = time[0];
						var minutes = time[1];
		  				var interval = setInterval(function() {
		  				hours = parseInt(hours);
						minutes = parseInt(minutes);
						minutes = minutes + parseInt(c,10);
					
						if(minutes == 60) {
							hours++;
							minutes = 0;
						} else if(minutes > 60) {
							var h = minutes/60;
							if(h % 1 === 0) {
								hours = hours+h;
								minutes = 0;
							} else {
								hours++;
								minutes = minutes - 60; 
								if(minutes > 60) {
									hours++;
									minutes = minutes - 60;
									if(minutes > 60) {
										hours++;
										minutes = minutes - 60;
										if(minutes > 60) {
											hours++;
											minutes = minutes - 60; 
											if(minutes > 60) {
												hours++;
												minutes = minutes - 60; 
											}
										}

									} 
								} 
							}
							console.log(hours);
						}
						if(hours > 23) {
							hours = 0;
						}
						minutes = (minutes < 10) ? '0' + minutes : minutes;
						hours = (hours < 10) ? '0' + hours : hours;
						time2 = hours +':'+ minutes;
						if(b < a) { 
							if(time2 >= b && time2 < a) {
							d = d + b;
							amsifySuggestags.addTag(b);
							//p.find('.add-interval').val(d);
							clearInterval(interval);
							} else {
								amsifySuggestags.addTag(time2);
							}
						} else {
							if(time2 >= b) {
							d = d + b;
							amsifySuggestags.addTag(b);
							//p.find('.add-interval').val(d);
							clearInterval(interval);
							} else {
								amsifySuggestags.addTag(time2);
							}
						}
						d = d + time2 + ',';
		  				},5);
		  				
		  			});
		  			$('#input-interval_type').on('change',function(){
		  				var a = $('#input-interval_type option:selected').val();
		  				$('.add-interval').val('');
		  				// alert(a);
		  				$('.add-interval').each(function(){
		  					amsifySuggestags = new AmsifySuggestags($(this));
			  				amsifySuggestags._init();
			  				amsifySuggestags.addTag('');
		  				});
		  				
		  				if(a == 1) {
		  					$('.minutes').val('');
		  					$('.minutes').closest('.input-group').removeClass('hide');
		  					$('.data-count').addClass('hide');
		  				} else {
		  					$('.minutes').val('');
		  					$('.data-count').removeClass('hide');
		  					$('.minutes').closest('.input-group').addClass('hide');
		  				}
		  			});
		  			$('.add-count-interval').on('click', 'a', function(e){
		  				e.preventDefault();
		  				var p = $(this).closest('.group-shift');
		  				var a = p.find('.counts_start').val();
		  				var b = p.find('.counts_end').val();
		  				p.find('.add-interval').val('');
		  				var c = p.find('.counts').val();
		  				if(c < 1 || a == '' || b == '') {
		  					return false;
		  				}
		  				// alert(a+b+c);
		  				amsifySuggestags = new AmsifySuggestags(p.find('.add-interval'));
		  				amsifySuggestags._init();
		  				var d = c+'='+a+'-'+b;
		  				amsifySuggestags.addTag(d);
		  			});
		  		</script>
		  	</div>
		</div>
	</div>
<?php if(!empty($list_cats)){ ?>
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="results">
					<table id="datatable-checklist" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><?php echo __('List category','checklist') ?></th>
								<th class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><?php echo __('Interval type','checklist') ?></th>
								<th class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><?php echo __('List add view','checklist') ?></th>
								<th class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><?php echo __('List data view','checklist') ?></th>
								<th class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?php echo __('Category info 1','checklist') ?></th>
								<th class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?php echo __('Category info 3','checklist') ?></th>
								<th class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?php echo __('Category info 3','checklist') ?></th>
								<th class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><?php echo __('Action','checklist') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($list_cats as $list_cat) { ?>
							<tr>
								<td>
									<div class="txt-data">
										<a href="<?php echo admin_url('checklist/edit-list-category/'.$list_cat['id'].'/') ?>">
										<i class="fa fa-edit"></i> <?php echo $list_cat['name'] ?>
										</a>
										<div class="id-data hide"><?php echo $list_cat['id'] ?></div>
									</div>
									<div class="input-group edit hide">
									<span class="input-group-addon"><a class="show-edit" href=""><i class="fa fa-arrow-up"></i></a></span>
									<input type="text" class="cat-name form-control form-block" value="<?php echo $list_cat['name']; ?>" >
									</div>

								</td>
								<td>
									<div class="txt-data"><?php echo $cats_interval_types[$list_cat['interval_type']]; ?></div>
								</td>
								<td>
									<div class="txt-data"><?php echo $list_add_view[$list_cat['list_add_view']];?></div>
								</td>
								<td>
									<div class="txt-data"><?php echo $list_data_view[$list_cat['list_view']];?></div>
								</td>
								<td>
									<div class="txt-data"><?php echo nl2br($list_cat['info_01'], false) ?></div>
								</td>
								<td>
									<div class="txt-data"><?php echo nl2br($list_cat['info_02']) ?></div>
								</td>
								<td>
									<div class="txt-data"><?php echo nl2br($list_cat['info_03']) ?></div>
								</td>
								<td>
									<a href="#" class="edit-cat edit hide btn btn-success btn-block">
										<?php echo __('Edit','checklist'); ?>
									</a>
									<a href="#" class="remove-cat btn btn-danger btn-block txt-data">
										<?php echo __('Remove','checklist'); ?>
									</a>
								</td>
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
<pre>
	<?php// print_r($settings); ?>
</pre>
<script type="text/javascript">
	var loader = '<div class="loaderwrap absolute overlay"><div class="the-loader s2 load-center text-white"></div></div>';
	if($('#datatable-checklist').length) {
		$('#datatable-checklist').DataTable();
	}
	$('.show-edit').on('click', function(e){
		e.preventDefault();
		var p = $(this).closest('tr');
		p.find('.txt-data').toggleClass('hide');
		p.find('.edit').toggleClass('hide');
	});

	$('.remove-cat').on('click', function(e){
		var p = $(this).closest('tr');
		var a = p.find('.txt-data-s').text();
		var i = p.find('.id-data').text();
		var txt = "<?php echo __('Are you sure you want to delete category','checklist'); ?> <strong>"+ a +"</strong>";
		e.preventDefault();
		$('body').find('.results').append(loader);
		$.confirm({
	    title: '<span class="text-danger"><?php echo __('Warning','checklist'); ?> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>',
	    theme: 'modern',
	    content: txt,
	    autoClose: 'cancel|30000',
	    buttons: {
	        confirm: {
	            text: '<?php echo __('Remove','checklist'); ?>',
	            btnClass: 'btn-warning',
	            keys: ['enter'],
	            action: function(){
	            	$.getJSON( Jsapi+'checklist/delete-category-json/', {'data[id]': i} ,function( data ) {
	            	console.log(data);
	            	location.reload(true);
	            	});
	            }
	        },
	        cancel: {
	            text:  '<?php echo __('Cancel','checklist'); ?>',
	            btnClass: 'btn-success',
	            action: function(){
	                // $.alert('Not deleted');
	                $('body').find('.loaderwrap').remove();
	            }
	        }
	    }
		});

	});

	$('body').on('click', 'a.edit-cat', function(e){
		$('body').find('.results').append(loader);
		e.preventDefault();
		var p = $(this).closest('tr');
		var a = p.find('.cat-name').val(); 
		var b = p.find('.cat-info_01').val();
		var c = p.find('.cat-info_02').val();
		var d = p.find('.cat-info_03').val();
		var f = p.find('.id-data').text();
		var data = {
			'data[name]': a,
			'data[info_01]': b,
			'data[info_02]': c,
			'data[info_03]': d,
		};

		$.getJSON( Jsapi+'checklist/edit-category-json/'+f, data ,function( data ) {
			location.reload(true);
			console.log(data);
	});
	});
$('body').find('.times1').amsifySuggestags({
  type : 'bootstrap',
  defaultLabel:'Add data here', defaultTagClass: 'bg-success',
});
</script>