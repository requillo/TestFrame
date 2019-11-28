<?php // print_r($Donation); ?>
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
				<?php 

				if(!empty($donation_info_check)): 
				if($donation_info_check['within_years'] == 1) {
					$yr = __('year','donations');
				} else {
					$yr = __('years','donations');
				}

				if($donation_info_check['within_months'] == 1) {
					$mth = __('month','donations');
				} else {
					$mth = __('months','donations');
				}

				if($donation_info_check['tot_request_years'] > $donation_info_check['limit_years']) {
					$req_ytxt = __('Requests exceeded limit','donations');
					$req_ycl = 'text-danger';
				} else if($donation_info_check['tot_request_years'] == $donation_info_check['limit_years']){
					$req_ytxt = __('Requests are equal to limit','donations');
					$req_ycl = 'text-info';
				} else {
					$req_ytxt = __('Requests are within limit','donations');
					$req_ycl = 'text-success';
				}

				if($donation_info_check['tot_request_months'] > $donation_info_check['limit_months']) {
					$req_mtxt = __('Requests exceeded limit','donations');
					$req_mcl = 'text-danger';
				} else if($donation_info_check['tot_request_months'] == $donation_info_check['limit_months']){
					$req_mtxt = __('Requests are equal to limit','donations');
					$req_mcl = 'text-info';
				} else {
					$req_mtxt = __('Requests are within limit','donations');
					$req_mcl = 'text-success';
				}

				if($donation_info_check['amount'] > $donation_info_check['max_amount']) {
					$req_atxt = __('Request exceeded max amount','donations');
					$req_acl = 'text-danger';
				} else if($donation_info_check['amount'] == $donation_info_check['max_amount']){
					$req_atxt = __('Request is equal to max amount','donations');
					$req_acl = 'text-info';
				} else {
					$req_atxt = __('Request is within max amount','donations');
					$req_acl = 'text-success';
				}

				if($donation_info_check['within_months'] == 1) {
					$n_month = '';
				} else {
					$n_month = $donation_info_check['within_months'];
				}

				?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="alert alert-warning">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<h4><?php echo __('Requests within').' '.$donation_info_check['within_years']. ' '.$yr; ?></h4>
								<div><cite><?php echo __('Approved donations'); ?></cite>: <?php echo $donation_info_check['tot_request_years_approved']; ?></div>
								<div><cite><?php echo __('Pending donations'); ?></cite>: <?php echo $donation_info_check['tot_request_years_pending']; ?></div>
								<div><cite><?php echo __('Total donation requests'); ?></cite>: <?php echo $donation_info_check['tot_request_years']; ?> [<cite><?php echo __('Limit'); ?></cite> <?php echo $donation_info_check['limit_years']; ?>]</div>
								<div class="<?php echo $req_ycl; ?>"><strong><?php echo $req_ytxt; ?></strong></div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<h4><?php echo __('Requests past').' '.$n_month. ' '.$mth; ?></h4>
								<div><cite><?php echo __('Approved donations'); ?></cite>: <?php echo $donation_info_check['tot_request_months_approved']; ?></div>
								<div><cite><?php echo __('Pending donations'); ?></cite>: <?php echo $donation_info_check['tot_request_months_pending']; ?></div>
								<div><cite><?php echo __('Total donations'); ?></cite>: <?php echo $donation_info_check['tot_request_months']; ?> [<cite><?php echo __('Limit'); ?></cite> <?php echo $donation_info_check['limit_months']; ?>]</div>
								<div class="<?php echo $req_mcl; ?>"><strong><?php echo $req_mtxt; ?></strong></div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<h4><?php echo __('Requested amount'); ?></h4>
								<div><cite><?php echo __('Maximum donation'); ?></cite>: SRD <?php echo $donation_info_check['max_amount']; ?></div>
								<?php 
								if($donation_info_check['amount'] > $donation_info_check['max_amount']) {
									$ccl = 'text-danger';
								} else {
									$ccl = 'text-success';
								}
								?>
								<div class="<?php echo $ccl;?>"><strong><cite><?php echo __('Requested'); ?></cite>: SRD 
									<?php echo $donation_info_check['amount']; ?>
								</strong></div>
								<div class="<?php echo $req_acl; ?>"><strong><?php echo $req_atxt; ?></strong></div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<h4><?php echo __('Approved donations'); ?></h4>
								<?php foreach ($check_donations_approved as $value) {
									if($value['id'] != $_GET['request']) {
										echo '<div class="well">'.'<a href="'.token_link($_GET['action'],$value['id'],$_GET['user']).'" target="_blank">';
										echo '<div>' . $value['title'] . '</div>';
										echo '<div><cite>'.__('Donation amount','donations') . ': SRD ' . $value['amount'] . '</cite></div>';
										echo '<div><cite>'.__('Donor','donations') .': ' . get_company($value['donated_company']) . '</cite></div>';
										echo '<div><cite>'.__('Requested','donations') .': ' .date('d F Y',$value['created_timestamp']) . '</cite></div>';
										echo '</a></div>';
									}
								} ?>
								
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<h4><?php echo __('Pending donations'); ?></h4>
								<?php foreach ($check_donations_pending as $value) {
									if($value['id'] != $_GET['request']) {
										echo '<div class="well">'.'<a href="'.token_link($_GET['action'],$value['id'],$_GET['user']).'" target="_blank">';
										echo '<div>' . $value['title'] . '</div>';
										echo '<div><cite>'.__('Donation amount','donations') . ': SRD ' . $value['amount'] . '</cite></div>';
										echo '<div><cite>'.__('Donor','donations') .': ' . get_company($value['donated_company']) . '</cite></div>';
										echo '<div><cite>'.__('Requested','donations') .': ' .date('d F Y',$value['created_timestamp']) . '</cite></div>';
										echo '</a></div>';
									}
								} ?>
								
							</div>
							<!--<div>
							<pre>
								<?php print_r($check_donations_approved); ?>
							</pre>
							</div>-->
						</div>
					</div>
				</div>
				<?php endif; ?>
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

<?php if($Donation['approval'] == 2){ ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
			<a class="btn btn-success btn-lg" href="<?php echo $Donation['approve_link']; ?>"><?php echo __('Approve', 'donations'); ?></a>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
			<a class="btn btn-danger btn-lg" href="<?php echo $Donation['disapprove_link']; ?>"><?php echo __('Disapprove', 'donations'); ?></a>
		</div>
	</div>
</div>
<h1>&nbsp;</h1>

<?php } ?>

<?php endif; ?>