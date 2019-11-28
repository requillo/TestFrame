<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
       <?php echo $html->admin_link(__('Add Company'),'users/add-company', array('class'=>'btn btn-success')) ?>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
    </div>  
</div>

<div class="container-fluid"> 
 

    <div class="row">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div id="users-table" class="panel panel-default">
				<div class="table-responsive">
				  <table id="all-users" class="table table-striped bulk_action">				  
				  <thead>
				  	<tr>
				  	<th><?php echo __('Company Name') ?></th>
				  	<th><?php echo __('Address') ?></th>
				  	<th><?php echo __('Telephone') ?></th>
				  </tr>
				  </thead>
				  <tbody>
				  <?php foreach ($Companies as $Company) { ?>

				  <tr>
				  	<td><?php 
				  	echo $html->admin_link($Company['company_name'],'users/edit-company/'.$Company['id'].'/');
				  	?>	
				  	</td>
				  	<td><?php echo $Company['company_address'] ?></td>
				  	<td><?php echo $Company['company_telephone'] ?></td>
				  </tr>	

				   <?php } ?>
				  </tbody>
				  <tfoot>
				  	<tr>
				  	<th><?php echo __('Company Name') ?></th>
				  	<th><?php echo __('Address') ?></th>
				  	<th><?php echo __('Telephone') ?></th>
				  </tr>
				  </tfoot>
				  </table>
				</div>

			</div>
			</div>

    </div>  
</div>