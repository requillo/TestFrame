<!--<pre>
<?php // print_r($Donations);?>
</pre>-->

<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 

$options = array(
	'person' => __('Person','donations'), 
	'foundation' => __('Foundation','donations'),
	'desc' => __('Description','donations')
);

if(isset($_GET['in'])) {
	$select['key'] = $_GET['in'];
} else {
	$select = '';
}

if(isset($_GET['search'])) {
	$key = $_GET['search'];
} else {
	$key = '';
}

?>

<?php if(!empty($Donations)): ?>
<div class="container-fluid">
	<form method="get" autocomplete="off">
    <div class="row">
      <div class="col-lg-7 col-md-7 col-sm-6 col-xs-5">
      	<input type="text" name="search" value="<?php echo $key;?>" class="form-control">
      	</div>
     
       <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
     
      	<select name="in" class="form-control">
      		<?php echo $form->options($options,$select); ?>
      	</select>
      	
      </div>
       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
      	<button class="btn btn-success"><?php echo __('Search','donations') ?></button>
      </div>
		</div>
    </form> 
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
			<div id="users-table" class="panel panel-default">
				<div class="table-responsive">
				  <table id="all-users" class="table table-striped bulk_action">				  
				  <thead>
				  	<tr>
				  	<th style="width: 250px"><?php echo __('Donatee','donations') ?></th>
				  	<th><?php echo __('Donated info','donations') ?></th>
				  	<th><?php echo __('Status','donations') ?></th>
				  </tr>
				  </thead>
				  <tbody>
				  <?php foreach ($Donations as $Donation) { ?>

				  <tr>
				  	<td>
				  		<?php echo $Donation['person-info']['first_name'] ?>
				  		<?php echo $Donation['person-info']['last_name'] ?>
				  		<div><?php if(!empty($Donation['foundation-info'])) echo $Donation['foundation-info']['foundation_name'] ?></div>
				  	</td>
				  	<td>
				  		<div><?php echo $html->admin_link($Donation['title'],'donations/view-donation/'.$Donation['id'].'/');?></div>
				  		<div><?php echo excerpt($Donation['description']);?></div>
				  		<div>
				  			<?php
				  			$types = '';
				  			if($Donation['cash_amount'] != 0) {
				  				$types .= __($Don_types[1],'donations') . ' - ' ;
				  			}
				  			if(!empty($Donation['don_types'])) {
				  				foreach ($Donation['don_types'] as $value) {
				  					$types .= __($value[0]['type_name'],'donations') . ' - ';
				  				}
				  			}
				  			echo rtrim($types,' - ') . ' '. __('valued at', 'donations') . ' SRD ' . $Donation['amount'];
				  			?>
				  		</div>
				  		<div>
				  			<?php echo __('Donor','donations').': '. $Donation['donated_company_name']; ?>
				  		</div>
				  		<div>
				  			<?php echo __('Date','donations').': '. date('d-m-Y H:i:s',strtotime($Donation['created'])); ?>
				  		</div>	
				  	</td>
				  	<td><a href="#" class="stat-change"><?php echo $Approval[$Donation['approval']] ?></a></td>
				  </tr>	

				   <?php } ?>
				  </tbody>
				  <tfoot>
				  	<tr>
				  	<th><?php echo __('Donatee','donations') ?></th>
				  	<th><?php echo __('Donated info','donations') ?></th>
				  	<th><?php echo __('Status','donations') ?></th>
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
				if(isset($_GET['search'])){
					echo __('Sorry, nothing found!','donations');
				}
				
				?>
				<div><?php echo $html->admin_link('<i class="fa fa-arrow-left"></i> '.__('Back','donations'), 'donations'); ?></div>
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