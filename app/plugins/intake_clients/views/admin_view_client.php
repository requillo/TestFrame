<?php if(!empty($Client)): ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading">
		<h2><?php echo __('Main information','intake_clients') ?> <?php echo $html->admin_link('<i class="fa fa-edit" aria-hidden="true"></i> ','intake-clients/edit-client/'.$Client['id'].'/')   ?></h2> 
		</div>
		<div class="panel-body">
		  <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('client_id',['value'=>$Client['id'], 'type' => 'hidden', 'no-wrap' => true]); ?>
				<?php
				echo '<b>'.__('First name','intake_clients') . '</b>: '.$Client['f_name'].'<br>';
				echo '<b>'.__('Last name','intake_clients') . '</b>: '.$Client['l_name'].'<br>';
				echo '<b>'.__('Address','intake_clients') . '</b>: '.$Client['address'].'<br>';
				echo '<b>'.__('Telephone','intake_clients') . '</b>: '.$Client['telephone'].'<br>';
				if($Client['email'] != '') {
					echo '<b>'.__('E-mail','intake_clients') . '</b>: '.$Client['email'].'<br>';
				}
				
				 ?>
			</div>
		  </div>
		</div>
	</div>
</div>
	<?php if(!empty($Intakes)): ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading"><h2><?php echo __('All client intakes','intake_clients') ?></h2></div>
		<div class="panel-body">
		  <div class="row">
			<div class="table-responsive">
				<table class="table table-striped bulk_action">
					<thead>
						<tr>
							<th style="max-width:30px;"><?php echo __('Intake number','intake_clients') ?></th>
							<th><?php echo __('Product type','intake_clients') ?></th>
							<th><?php echo __('Brand','intake_clients') ?></th>
							<th><?php echo __('Model','intake_clients') ?></th>
							<th><?php echo __('Problem','intake_clients') ?></th>
							<th><?php echo __('Date','intake_clients') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($Intakes as $Intake): ?>
							<tr>
							<td style="max-width:150px; min-width: 150px;"><?php echo $html->admin_link('<i class="fa fa-hashtag" aria-hidden="true"></i> ' . $Intake['admin_num'],'intake-clients/view/'.$Intake['id'].'/')   ?></td>
							<td style="min-width: 150px;"><?php echo $Intake['type_name']; ?></td>
							<td><?php echo $Intake['brand_name']; ?></td>
							<td><?php echo $Intake['intake_model']; ?></td>
							<td><?php echo excerpt($Intake['problem_text'],80); ?></td>
							<td style="min-width: 50px;"><?php echo date('d M Y', strtotime($Intake['pub_date'])) ; ?></td>
						</tr>
						<?php endforeach; ?>
						
						
					</tbody>
				</table>
	
			</div>
		  </div>
		</div>
	</div>
</div>
<!--<pre><?php print_r($Intakes) ?></pre>-->
	<?php endif;?>
<?php else : ?>

<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php echo __('No client information','intake_clients'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif;?>