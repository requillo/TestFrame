
<h2 class="no-print">&nbsp;</h1>
<?php if(!empty($Intake)): ?>
<div class="container-fluid no-print"> 

					<a href="#" class="printMe btn btn-success pull-right"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
				
</div>
	
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="text-center"><img class="max-50" src="<?php echo get_media($applogo);?>"></div>
				<div class="text-center line-top">
					<span class="h-title">Paramaribo, Suriname</span>-<span class="h-title">Twee Kinderenweg 54</span>-<span class="h-title">Phone: 8559388/8562431</span>
				</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="the-title"><?php echo __('Intake #','intake_clients') . ' ' .$Intake['admin_num']; ?></div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<table class="intake table">
						<tr>
							<td><span class="tb-h"><?php echo __('Client information', 'intake_clients') ?></span> 
							<?php echo $html->admin_link(' <i class="fa fa-edit" aria-hidden="true"></i>','intake-clients/edit-client/'.$Intake['client_id'].'/','no-print');?>
						</td>
							<td class="text-right"><span class="tb-h"><?php echo __('Date', 'intake_clients') ?>:</span> <span class="tb-h" style="white-space: nowrap;"><?php echo date('d-m-Y',strtotime($Intake['pub_date'])); ?></span></td>
						</tr>
						<tr>
							<td colspan="2"><b><?php echo __('First name', 'intake_clients') ?>:</b> <span><?php echo $Intake['client_info']['f_name']; ?></span></td>
						</tr>
						<tr>
							<td colspan="2"><b><?php echo __('Last name', 'intake_clients') ?>:</b> <span><?php echo $Intake['client_info']['l_name']; ?></span></td>
						</tr>
						<tr>
							<td colspan="2"><b><?php echo __('Addresss', 'intake_clients') ?>:</b> <span><?php echo $Intake['client_info']['address']; ?></span></td>
						</tr>
						<tr>
							<td colspan="2"><b><?php echo __('Telephone', 'intake_clients') ?>:</b> <span><?php echo $Intake['client_info']['telephone']; ?></span></td>
						</tr>
						<?php if($Intake['client_info']['email'] != ''): ?>
						<tr>
							<td colspan="2"><b><?php echo __('E-mail', 'intake_clients') ?>:</b> <span><?php echo $Intake['client_info']['email']; ?></span></td>
						</tr>
					<?php endif; ?>
					</table>
					
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<table class="intake table">
						<tr>
							<td><span class="tb-h"><?php echo __('Product information', 'intake_clients') ?></span><?php echo $html->admin_link(' <i class="fa fa-edit" aria-hidden="true"></i>','intake-clients/edit/'.$Intake['id'].'/','no-print');?> 
							</td>
						</tr>
						<tr>
							<td><b><?php echo $Intake['type']; ?>:</b> 
								<span><?php echo $Intake['brand'] . ' ' . $Intake['intake_model']; ?></span></td>
						</tr>
						<tr>
							<td><div><b><?php echo __('Problem', 'intake_clients') ?></b></div> <span><?php echo $Intake['problem_text']; ?></span></td>
						</tr>
							<?php if($Intake['work_solving'] != ''):?>
						<tr>
							<td><div><b><?php echo __('Checkup', 'intake_clients') ?></b></div> <span><?php echo $Intake['work_solving']; ?></span></td>
						</tr>
							<?php endif;?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="intake-extra print">
	<div><span class="tb-h"><?php echo __('Comments', 'intake_clients') ?></span></div>
</div>
<div class="intake-footer print">
<div><?php echo get_user($Intake['user_id']); ?></div>
<div style="padding-bottom: 15px;">
	<div style="float: left;">Paraaf Technician:_____________________</div>
	<div style="float: right; padding-right: 20px;">Paraaf Klant:________________________</div>
	<div style="clear: both;"></div>
</div>
<div>
Diagnose en Intake kosten zijn SRD 32.50. Spullen dienen binnen een maand worden opgehaald door de klant nadat er contact is gemaakt met de klant.
</div>
</div>
<?php else: ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php echo __('Nothing to view','intake_clients'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>
<!--<pre><?php print_r($Intake); ?></pre>-->