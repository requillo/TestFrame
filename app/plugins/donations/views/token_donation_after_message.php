
<?php // print_r($Donation); 
// print_r($_SERVER); exit;
?>

<?php if(!empty($Donation) && isset($Donation['hi_approval']) && $Donation['hi_approval'] != 0 ): 
if($Donation['approval'] == 1) {
	$alertcl = 'alert-success';
} else {
	$alertcl = 'alert-danger';
}
?>
<?php if($error == 1){ ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="alert alert-danger text-center">
				<h1>
					<div><?php echo __('This has already been','donations'); ?></div>
					<?php echo $Approval[$Donation['approval']]; ?> <?php echo __('by','donations'); ?> 
					<?php echo $Approvaluser['fname'] .' '.$Approvaluser['lname'] . ' ' . __('on', 'donations'); ?> 
					<?php echo date( "d F Y h:i a", strtotime( $Donation['hi_approval_updated'] ) ); ?>
				</h1>
			</div>
		</div>
	</div>
</div>

<?php }else{ ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="alert <?php echo $alertcl; ?> text-center">
				<h1>
					<?php echo $Approval[$Donation['approval']]; ?> <?php echo __('by','donations'); ?> 
					<?php echo $Approvaluser['fname'] .' '.$Approvaluser['lname'] . ' ' . __('on', 'donations'); ?> 
					<?php echo date( "d F Y h:i a", strtotime( $Donation['hi_approval_updated'] ) ); ?>
				</h1>
			</div>
		</div>
	</div>
</div>

<?php } ?>

<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>
		<?php
		if(isset($Donation['foundation-info'])) {
			echo __('Personal & Foundation information','donations') ;
		} else {
			echo __('Personal information','donations') ;	
		}
		?>
			</h3>
		</div>
		<div class="panel-body">
		  <div class="row">
		<?php if(!isset($Donation['foundation-info'])): ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div><i class="fa fa-user" aria-hidden="true"></i> <?php echo $Donation['person-info']['first_name'] . ' ' . $Donation['person-info']['last_name'];?></div>
			<div><i class="fa fa-id-card" aria-hidden="true"></i> <?php echo $Donation['person-info']['id_number'];?></div>
				<?php if($Donation['person-info']['person_telephone'] != ''){ ?>
			<div><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $Donation['person-info']['person_telephone'];?></div>
				<?php };?>
				<?php if($Donation['person-info']['person_email'] != ''){ ?>
			<div><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $Donation['person-info']['person_email'];?></div>
				<?php };?>
				<?php if($Donation['person-info']['person_address'] != ''){ ?>
			<div><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $Donation['person-info']['person_address'];?></div>
				<?php };?>
				<?php ;?>
			</div>
		<?php else: ?>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<div><i class="fa fa-user" aria-hidden="true"></i> <?php echo $Donation['person-info']['first_name'] . ' ' . $Donation['person-info']['last_name'];?></div>
				<div><i class="fa fa-id-card" aria-hidden="true"></i> <?php echo $Donation['person-info']['id_number'];?></div>
				<?php if($Donation['person-info']['person_telephone'] != ''){ ?>
				<div><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $Donation['person-info']['person_telephone'];?></div>
				<?php };?>
				<?php if($Donation['person-info']['person_email'] != ''){ ?>
				<div><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $Donation['person-info']['person_email'];?></div>
				<?php };?>
				<?php if($Donation['person-info']['person_address'] != ''){ ?>
				<div><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $Donation['person-info']['person_address'];?></div>
		<?php };?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<div><?php echo $Donation['foundation-info']['foundation_name'];?></div>
				<?php if($Donation['foundation-info']['foundation_address'] != ''){ ?>
				<div><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $Donation['foundation-info']['foundation_address'];?></div>
				<?php };?>
				<?php if($Donation['foundation-info']['foundation_telephone'] != ''){ ?>
				<div><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $Donation['foundation-info']['foundation_telephone'];?></div>
				<?php };?>
				<?php if($Donation['foundation-info']['foundation_email'] != ''){ ?>
				<div><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $Donation['foundation-info']['foundation_email'];?></div>
				<?php };?>
				
			</div>
		<?php endif; ?>
		  </div>
		</div>
	</div>
</div>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>
				<?php 
				echo __('Donation information','donations'); 
				if($Donation['error_msg'] != '') {
					echo ' <small class="text-danger inlblck">'.$Donation['error_msg'].'</small>';
				}
				?>
			</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<p class="title"><?php echo __('Subject','donations'); ?></p>
					<p><?php echo $Donation['title']; ?></p>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<p class="title"><?php echo __('Donation request information','donations'); ?></p>
					<p><?php echo nl2br($Donation['description']); ?></p>						
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<p class="title"><?php echo __('Donated company','donations'); ?></p>
					<p><?php echo $Donation['donated_company_info']['company_name']; ?></p>						
				</div>
				<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
					<p class="title"><?php echo __('Status','donations'); ?></p>
					<p><?php echo $Approval[$Donation['approval']]; ?></p>						
				</div>
				<div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
					<p class="title"><?php echo __('Reason for donating','donations'); ?></p>
					<p><?php echo $Donation['reason']; ?></p>						
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<p class="title"><?php echo __('Requested on','donations'); ?></p>
					<p><?php echo date("d M Y, H:i",strtotime($Donation['created'])); ?></p>						
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<p class="title"><?php echo __('Donated information','donations'); ?></p>
					<div class="table-responsive">
						<table class="table table-bordered bulk_action add-res-data">
							<thead>
								<tr class="headings">
								<th class="column-title" style="width: 15px;"><?php echo __('Quantity','donations'); ?></th>
								<th class="column-title"><?php echo __('Description','donations'); ?></th>
								<th class="column-title" style="width: 200px;"><?php echo __('Amount in SRD','donations'); ?></th>
								</tr>
							</thead>
							<tbody>
					<?php 
					if($Donation['description-data'][0][0]['amount'] != '') {
						foreach ($Donation['description-data'] as $value) {
							$i = 1;
							foreach ($value as $v) {
								if($i == 1) {
							echo '<tr><td></td><td><b>'. $Donation['donation_types'][$v['type']] . '</b></td><td></td></tr>';		
								}
							echo '<tr><td>'.$v['amount'] .'</td><td>'. $v['description'] . ' Price SRD '. $v['price'] . '</td><td class="text-right">' . $v['amount']*$v['price'] . '</td></tr>';
							$i++;
							}
						} 
					}

					if($Donation['cash_description'] != '' || $Donation['cash_amount'] != 0) {
						echo '<tr><td></td><td><b>'. __('Cash', 'donations') . '</b></td><td></td></tr>';
						echo '<tr><td></td><td>'. nl2br($Donation['cash_description']) . '</td><td class="text-right">'.$Donation['cash_amount'].'</td></tr>';
					}
					

					?>		</tbody>
							<tfoot>
								<tr><th></th><th><?php echo __('Total donation amount in SRD','donations'); ?></th><th class="text-right"><?php echo $Donation['amount']; ?></th></tr>
							</tfoot>
						</table>
					</div>	
				</div>

			</div>
		</div>
	</div>
</div>
<?php else: ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3><?php echo __('Nothing to view here'); ?></h3>
		</div>
	</div>
</div>

<?php endif; ?>