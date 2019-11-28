<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

if(!empty($Clients)): ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
			<div id="users-table" class="panel panel-default">
				<div class="table-responsive">
				  <table id="all-users" class="table table-striped bulk_action">				  
				  <thead>
				  	<tr>
				  	<th><?php echo __('Name','clients') ?></th>
				  	<th><?php echo __('E-mail','clients') ?></th>
				  	<th><?php echo __('Telephone','clients') ?></th>
				  </tr>
				  </thead>
				  <tbody>
				  <?php foreach ($Clients as $Client) { ?>

				  <tr>
				  	<td><?php echo $html->admin_link($Client['l_name'] . ' ' . $Client['f_name'],'clients/view/'.$Client['id'].'/')   ?></td>
				  	<td><a href="mailto:<?php echo $Client['email'] ?>"><?php echo $Client['email'] ?></a></td>
				  	<td><?php echo $Client['telephone'] ?></td>
				  </tr>	

				   <?php } ?>
				  </tbody>
				  <tfoot>
				  	<tr>
				  	<th><?php echo __('Name','clients') ?></th>
				  	<th><?php echo __('E-mail','clients') ?></th>
				  	<th><?php echo __('Telephone','clients') ?></th>
				  </tr>
				  </tfoot>
				  </table>
				</div>

			</div>
		</div>
	</div>
</div>
<?php else: ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class=" x_content">
				<?php
					echo __('Sorry, nothing found!','clients');
				?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
   <?php echo $Paginate; ?>
    </div>
  </div>
</div>
