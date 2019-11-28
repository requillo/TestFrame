<div class="container-fluid"> 
	<div>
		<form method="post" action="<?php echo url('api/json/intake-clients/get-intake-clients/') ?>">
			<input type="" name="data[f_name]">
			<button>Search</button>
		</form>
	</div>
</div>
<div class="container-fluid"> 
	<div class="x_panel">
		<div class="x_content">
		  <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div id="users-table" class="">
				<div class="table-responsive">
				  <table id="all-users" class="table table-striped bulk_action">				  
				  <thead>
				  	<tr>
				  	<th><?php echo __('Client information','intake_clients') ?></th>
				  	<th style="width: 60%; max-width: 550px !important" ><?php echo __('Intake information','intake_clients') ?></th>				  	
				  </tr>
				  </thead>
				  <tbody>
				  <?php foreach ($Intakes as $intake):?>

				  <tr>
				  	<td>
				  	<div><?php echo $html->admin_link($intake['client']['l_name'] . ' ' . $intake['client']['f_name'],'intake-clients/view-client/'.$intake['client']['id'].'/')   ?></div>
				  	<?php if( $intake['client']['company'] != ''): ?>
				  	<div><i class="fa fa-university" aria-hidden="true"></i> 
				  		<?php echo $html->admin_link($intake['client']['company'],'intake-clients/view-client/'.$intake['client']['id'].'/')   ?>
				  		</div>
				  	<?php endif; ?>
				  	<div><i class="fa fa-map-marker" aria-hidden="true"></i> 
				  		<?php echo $intake['client']['address']; ?></div>
				  	<div><i class="fa fa-phone-square" aria-hidden="true"></i> 
				  		<?php 
				  		$telephones = explode('/', $intake['client']['telephone']);
				  		$tels = count($telephones);
				  		$i = 1;
				  		foreach ($telephones as $value) { 
				  			if($tels > 1 && $i > 1) {
				  				echo '/';
				  			}
				  		?>
				  		<a href="tel:<?php echo $value ?>"> <?php echo $value; ?>cczxc</a>

				  		<?php 
				  		$i++;
				  		}
				  		
				  		?></a></div>
				  	<?php if( $intake['client']['email'] != ''): ?>
				  	<div><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $intake['client']['email']; ?></div>
				  	<?php endif; ?>
				  	</td>
				  	<td>
				  	<div>
<?php echo $html->admin_link('<i class="fa fa-hashtag" aria-hidden="true"></i> ' . $intake['admin_num'],'intake-clients/view/'.$intake['id'].'/')?>
				  	</div>
				  	<div><i class="fa fa-calendar-check-o" aria-hidden="true"></i> 
				  		<?php echo date('d M Y H:i:s', strtotime($intake['pub_date'])); ?>
				  	</div>
				  	<div><?php echo excerpt($intake['problem_text']); ?></div>
				  	<div>
				  		<?php if( $intake['type_name'] != ''): ?>
				  			<span class="table-inline"><?php echo $intake['type_name']; ?>: </span>
				  		<?php endif; ?>
				  		<?php if( $intake['brand_name'] != ''): ?>
				  			<span class="table-inline"><?php echo $intake['brand_name']; ?> </span>
				  		<?php endif; ?>
				  		<?php if( $intake['intake_model'] != ''): ?>
				  			<span class="table-inline"><?php echo $intake['intake_model']; ?></span>
				  		<?php endif; ?>
				  	</div>	
				  	</td>				  	
				  </tr>	
				   <?php endforeach;?>
				  </tbody>
				  <tfoot>
				  	<tr>
				  	<th><?php echo __('Client information','intake_clients') ?></th>
				  	<th><?php echo __('Intake information','intake_clients') ?></th>
				  </tr>
				  </tfoot>
				  </table>
				</div>
			</div>
				<!--<pre>
					<?php //print_r($Intakes); ?>
				</pre>-->
			</div>
			
		  </div>
		</div>
	</div>
</div>