<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

if(!empty($Visas)): ?>
<div class="panel panel-default">
<div class="panel-heading"><h2><?php echo $title ?></h2><div class="clearfix"></div></div>
<div class="panel-body">
	<div id="users-table" class="panel panel-default">
		<div class="table-responsive">
		  <table id="all-users" class="table table-striped bulk_action">				  
		  <thead>
		  	<tr>
		  	<th><?php echo __('Client','clients') ?></th>
		  	<th><?php echo __('Visa','clients') ?></th>
		  	<th><?php echo __('Expire','clients') ?></th>
		  </tr>
		  </thead>
		  <tbody>
		  <?php foreach ($Visas as $Visa) { ?>

		  <tr>
		  	<td><?php echo $html->admin_link($Visa['client']['f_name'] . ' ' . $Visa['client']['l_name'],'clients/view/'.$Visa['client_id'].'/')   ?></td>
		  	<td><?php echo $Visa['name'] ?></td>
		  	<td><?php echo date('d-m-Y', strtotime($Visa['end_date']))?></td>
		  </tr>	

		   <?php } ?>
		  </tbody>
		  <tfoot>
		  	<tr>
		  	<th><?php echo __('Client','clients') ?></th>
		  	<th><?php echo __('Visa','clients') ?></th>
		  	<th><?php echo __('Expire','clients') ?></th>
		  </tr>
		  </tfoot>
		  </table>
		</div>
	</div>
</div>
</div>
<?php else: ?>
<div class="panel panel-default">
<div class="panel-heading"><h2>Visas to expire</h2><div class="clearfix"></div></div>
<div class="panel-body"></div>
</div>
<?php endif; ?>