<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!empty($Passports)): ?>
<div class="panel panel-default">
<div class="panel-heading"><h2><?php echo $title ?></h2><div class="clearfix"></div></div>
<div class="panel-body">
	<div id="users-table" class="panel panel-default">
		<div class="table-responsive">
		  <table id="all-users" class="table table-striped bulk_action">				  
		  <thead>
		  	<tr>
		  	<th><?php echo __('Client','clients') ?></th>
		  	<th><?php echo __('Passport','clients') ?></th>
		  	<th><?php echo __('Expire','clients') ?></th>
		  </tr>
		  </thead>
		  <tbody>
		  <?php foreach ($Passports as $Passport) { ?>

		  <tr>
		  	<td><?php echo $html->admin_link($Passport['client']['f_name'] . ' ' . $Passport['client']['l_name'],'clients/view/'.$Passport['client_id'].'/') ?></td>
		  	<td><?php echo $Passport['passport_number'] ?></td>
		  	<td><?php echo date('d-m-Y', strtotime($Passport['end_date'])) ?></td>
		  </tr>	

		   <?php } ?>
		  </tbody>
		  <tfoot>
		  	<tr>
		  	<th><?php echo __('Client','clients') ?></th>
		  	<th><?php echo __('Passport','clients') ?></th>
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
<div class="panel-heading"><h2><?php $title ?></h2><div class="clearfix"></div></div>
<div class="panel-body"></div>
</div>
<?php endif; ?>