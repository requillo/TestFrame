<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

if(!empty($Visas)): ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
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
				  	<td><?php echo $Visa['end_date'] ?></td>
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
</div>
<?php else: ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class=" x_content">
				<?php 
				
					echo __('Sorry, nothing found!');
				
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
   <?php // echo $Paginate; ?>
    </div>
  </div>
</div>