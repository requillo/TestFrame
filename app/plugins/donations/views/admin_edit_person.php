<?php 

if(!empty($Person)) {

if($Person['black_listed'] == 0) {
	$bln = 'checked';
	$bly = '';
} else {
	$bln = '';
	$bly = 'checked';
}

?>
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<?php $form->create(array('id'=>'add-blacklist-person', 'file-upload' => true, 'attribute' => 'autocomplete="off"', 'class' => 'no-enter')); ?>
					<div class="row">
						<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
							<?php $form->input('first_name',array('label'=>__('First name','donations'),'value' => $Person['first_name'])); ?>
						</div>
						<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
							<?php $form->input('last_name',array('label'=>__('Last name','donations'),'value' => $Person['last_name'])); ?>
						</div>
						<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
							<?php $form->input('id_number',array('label'=>__('ID Number','donations'),'value' => $Person['id_number'])); ?>
						</div>
						<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
							<?php $form->input('person_telephone',array('label'=>__('Telephone','donations'),'value' => $Person['person_telephone'])); ?>
						</div>
						<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
							<?php $form->input('person_address',array('label'=>__('Address','donations'),'value' => $Person['person_address'])); ?>
						</div>
						<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
							<?php $form->input('person_email',array('label'=>__('E-mail','donations'),'value' => $Person['person_email'])); ?>
						</div>
						<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
							<div><label class=""><?php echo __('Blacklist','donations')?></label></div>
							<?php $form->input('black_listed',array('label'=>__('No','donations'),'value' => 0,'class' =>'flat','type'=>'radio','label-pos'=>'after','no-wrap'=>true,'attribute'=>$bln)); ?> 
							<?php $form->input('black_listed',array('label'=>__('Yes','donations'),'value' => 1,'class' =>'flat','type'=>'radio','label-pos'=>'after','no-wrap'=>true,'attribute'=>$bly)); ?>
						</div>
						<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
							<?php $form->input('black_listed_reason',array('label'=>__('Blacklist reason','donations'),'value' => $Person['black_listed_reason'])); ?>
						</div>
						<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
							<?php $form->submit(__('Save','donations'),'btn btn-success'); ?>
						</div>
					</div>
					<?php $form->close();?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php } else {?>

<?php } ?>