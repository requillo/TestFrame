<?php if(!empty($Donation) && $has_permition == 'yes'): ?>
<?php // echo get_media($Donation['app_logo']); ?>
<?php // echo get_protected_token_media('donations-1qo2xvp8GdL4lC6kKuwa1505911728.png'); ?>
<div class="text-center"><img class="max-50" src="<?php echo get_media($Donation['app_logo']); ?>"></div>
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
				?>
			</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<?php if($Donation['error_msg'] != '') { ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="alert alert-danger"><?php echo $Donation['error_msg']?></div>
				</div>
				<?php } ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<p class="title"><?php echo __('Subject','donations'); ?></p>
					<p><?php echo $Donation['title']; ?></p>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<p class="title"><?php echo __('Donation request information','donations'); ?></p>
					<p><?php echo nl2br($Donation['description']); ?></p>
					<?php if($Donation['document'] != '') { ?>
					<p><a href="<?php echo get_protected_token_media($Donation['document']); ?>" target="_blank">
							<?php echo __('View document','donations') ?>
						</a></p>
				<?php } ?>						
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<p class="title"><?php echo __('Donating company','donations'); ?></p>
					<p><?php echo $Donation['donated_company_info']['company_name']; ?></p>						
				</div>
				<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
					<p class="title"><?php echo __('Status','donations'); ?></p>
					<p><?php echo $Approval[$Donation['approval']]; ?></p>						
				</div>
				<?php if(!empty($Donation['reason'])){ ?>
				<div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
					<p class="title"><?php echo __('Reason for donating','donations'); ?></p>
					<p><?php echo $Donation['reason']; ?></p>						
				</div>
				<?php } ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<p class="title"><?php echo __('Recurring dates','donations'); ?></p>
					<?php foreach ($Dates as $date) { ?>
					<p class="<?php echo $date['class']; ?>"><?php echo $date['recurring']; ?></p>
					<?php } ?>						
				</div>
				<?php if(isset($Approvaluser['fname'])){ 
				$txtcl = ($Donation['approval'] == 1) ? 'text-success' : 'text-danger';
				?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<p class="<?php echo $txtcl; ?>"><?php echo $Approval[$Donation['approval']]; ?> <?php echo __('by','donations'); ?> 
				<?php echo $Approvaluser['fname'] .' '.$Approvaluser['lname'] . ' ' . __('on', 'donations'); ?>
				<?php echo date( "d F Y H:i", strtotime( $Donation['hi_approval_updated'] ) ); ?></p>						
				</div>
				<?php }?>
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
<?php endif; ?>