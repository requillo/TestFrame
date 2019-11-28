<?php 
$pactive = 'active';
$cactive = '';
?>
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
						<li role="presentation" class="<?php echo $pactive;?>">
							<a href="#tabcontent-person" id="person-tab" data-toggle="tab" aria-expanded="true">
								<?php echo __('Persons','donations');?>
							</a>
						</li>
						<li role="presentation" class="<?php echo $cactive;?>">
							<a href="#tabcontent-company" id="company-tab" data-toggle="tab" aria-expanded="true">
								<?php echo __('Company etc.','donations');?>
							</a>
						</li>
					</ul>
				</div>
				<div id="myTabContent" class="tab-content">
					<div role="tabpanel" class="tab-pane fade <?php echo $pactive;?> in" id="tabcontent-person" aria-labelledby="person-tab">
						<?php $form->create(array('id'=>'add-blacklist-person', 'file-upload' => true, 'attribute' => 'autocomplete="off"', 'class' => 'no-enter')); ?>
						<?php $form->input('add_to_table',array('type'=>'hidden', 'no-wrap' => true, 'value' => 'person')); ?>
						<div class="row">
							<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
								<?php $form->input('first_name',array('label'=>__('First name','donations'))); ?>
							</div>
							<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
								<?php $form->input('last_name',array('label'=>__('Last name','donations'))); ?>
							</div>
							<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
								<?php $form->input('id_number',array('label'=>__('ID Number','donations'))); ?>
							</div>
							<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
								<?php $form->input('person_telephone',array('label'=>__('Telephone','donations'))); ?>
							</div>
							<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
								<?php $form->input('person_address',array('label'=>__('Address','donations'))); ?>
							</div>
							<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
								<?php $form->input('person_email',array('label'=>__('E-mail','donations'))); ?>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<?php $form->input('black_listed_reason',array('label'=>__('Blacklist reason','donations'))); ?>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<?php $form->submit(__('Add to Blacklist','donations'),'btn btn-success');?>
							</div>
						</div>
						<?php $form->close(); ?>
						<div class="person-result hide">
							<div class="alert alert-danger"><?php echo __('Please check below, we found results!'); ?></div>
							<table id="all-persons" class="table table-striped bulk_action">				  
							  <thead>
							  	<tr>
								  	<th><?php echo __('Name','donations') ?></th>
								  	<th><?php echo __('Id','donations') ?></th>
							  	</tr>
							  </thead>
							  <tbody>
							  	
							  </tbody>
							</table>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane fade <?php echo $cactive;?> in" id="tabcontent-company" aria-labelledby="company-tab">
						<?php $form->create(array('id'=>'add-blacklist-comp', 'file-upload' => true, 'attribute' => 'autocomplete="off"', 'class' => 'no-enter')); ?>
						<?php $form->input('add_to_table',array('type'=>'hidden', 'no-wrap' => true, 'value' => 'company')); ?>
						<div class="row">
							<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<?php $form->input('foundation_name',array('label'=>__('Name','donations'))); ?>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<?php $form->input('foundation_address',array('label'=>__('Address','donations'))); ?>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<?php $form->input('foundation_telephone',array('label'=>__('Telephone','donations'))); ?>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<?php $form->input('foundation_email',array('label'=>__('E-mail','donations'))); ?>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<?php $form->input('black_listed_reason',array('label'=>__('Blacklist reason','donations'))); ?>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<?php $form->submit(__('Add to Blacklist','donations'),'btn btn-success');?>
							</div>
						</div>
						<?php $form->close(); ?>
						<div class="comp-result hide">
							<div class="alert alert-danger"><?php echo __('Please check below, we found results!'); ?></div>
							<table id="all-companies" class="table table-striped bulk_action">				  
							  <thead>
							  	<tr>
								  	<th><?php echo __('Name','donations') ?></th>
								  	<th><?php echo __('Telephone','donations') ?></th>
								  	<th><?php echo __('Address','donations') ?></th>
								  	<th><?php echo __('E-mail','donations') ?></th>
							  	</tr>
							  </thead>
							  <tbody>
							  	
							  </tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>