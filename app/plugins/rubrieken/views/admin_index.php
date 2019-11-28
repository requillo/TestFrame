<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div id="users-table" class="panel panel-default">
				<div class="table-responsive">
				  <table id="all-users" class="table table-striped bulk_action">				  
				  <thead>
				  	<tr>
				  	<th style="width: 250px;"><?php echo __('Client information','rubrieken') ?></th>
				  	<th><?php echo __('Rubriek','rubrieken') ?></th>				  	
				  </tr>
				  </thead>
				  <tbody>
				  <?php foreach ($Rubrieken as $value):?>

				  <tr>
				  	<td>
				  	<div><?php echo $html->admin_link($value['l_name'] . ' ' . $value['f_name'],'clients/view/'.$value['id'].'/')   ?></div>
				  	<div><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo $value['telephone']; ?></div>
				  	<div><i class="fa fa-barcode" aria-hidden="true"></i> <?php echo $value['talli']; ?></div>
				  	<div><i class="fa fa-calendar-check-o" aria-hidden="true"></i> <?php echo $value['talli_year']; ?></div>
				  	</td>
				  	<td>
				  		<ul class="table-none-list">
				  		<?php foreach ($value['ads'] as $ads):?>
				  		<li>
				  		<div class="cuttext w60"><?php echo $ads['content']; ?></div>
				  		<div class="w40"><?php echo $ads['dates']; ?></div>
				  		</li>
				  		<?php endforeach;?>
				  		</ul>
				  	</td>				  	
				  </tr>	
				   <?php endforeach;?>
				  </tbody>
				  <tfoot>
				  	<tr>
				  	<th><?php echo __('Client information','rubrieken') ?></th>
				  	<th><?php echo __('Rubriek','rubrieken') ?></th>
				  </tr>
				  </tfoot>
				  </table>
				</div>

			</div>
				
				
				
				<pre>
					<?php print_r($Rubrieken); ?>
				</pre>
			</div>
			
		  </div>
		</div>
	</div>
</div>