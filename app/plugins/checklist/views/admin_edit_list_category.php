<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$list_cat['interval_data'] = json_decode($list_cat['interval_data'], true);
?>
<pre>
	<?php print_r($list_cat) ?>
</pre>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create(); ?>
		  		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-3">
		 <?php $form->input('name',array('type'=>'text','label'=>__('Category','checklist'),'value'=>$list_cat['name'])); ?>
		  		</div>
		  		<div class="col-lg-2 col-md-3 col-sm-6 col-xs-3">
		<?php $form->select('interval_type',array('label'=>__('Interval type','checklist'),'options'=>$cats_interval_types,'selected' => $list_cat['interval_type'] )); ?>
		  		</div>
		  		
		  		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-3">
		<?php $form->select('list_add_view', array('label'=>__('List add view','checklist'),'options' => $list_add_view,'selected' => $list_cat['list_add_view'])) ?>
		  		</div>
		  		<div class="col-lg-4 col-md-3 col-sm-6 col-xs-3">
		<?php $form->select('list_view', array('label'=>__('List data view','checklist'),'options' => $list_data_view,'selected' => $list_cat['list_view'])) ?>
		  		</div>
		  		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		  			<?php $form->textarea('info_01',array('label'=>__('Category info 1','checklist'),'attribute' => 'rows="3"', 'value'=>$list_cat['info_01']));?>
		  		</div>
		  		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		  			<?php $form->textarea('info_02',array('label'=>__('Category info 2','checklist'),'attribute' => 'rows="3"', 'value'=>$list_cat['info_02'])); ?>
		  		</div>
		  		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		  			<?php $form->textarea('info_03',array('label'=>__('Category info 3','checklist'),'attribute' => 'rows="3"', 'value'=>$list_cat['info_03'])); ?>
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
							  <input type="number" class="form-control counts" placeholder="count">
							</div>	
	  						</div>
	  					<input type="text" class="form-control add-interval" name="data[shifts][<?php echo $value['id'];?>]" value="<?php echo $list_cat['interval_data'][$value['id']]; ?>">
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
		  			$('.add-interval').each(function(){
		  					amsifySuggestags = new AmsifySuggestags($(this));
			  				amsifySuggestags._init();
			  				amsifySuggestags.addTag('');
		  			});
		  			var a = $('#input-interval_type option:selected').val();
		  			if(a == 1) {
		  					$('.minutes').val('');
		  					$('.minutes').closest('.input-group').removeClass('hide');
		  					$('.data-count').addClass('hide');
		  				} else {
		  					$('.minutes').val('');
		  					$('.data-count').removeClass('hide');
		  					$('.minutes').closest('.input-group').addClass('hide');
		  				}
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
</div>