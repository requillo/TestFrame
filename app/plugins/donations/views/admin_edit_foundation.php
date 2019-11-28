<?php 

if(!empty($Foundation)){

if($Foundation['black_listed'] == 0) {
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
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<?php $form->input('foundation_name',array('label'=>__('Name','donations'),'value' => $Foundation['foundation_name'])); ?>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<?php $form->input('foundation_telephone',array('label'=>__('Telephone','donations'),'value' => $Foundation['foundation_telephone'])); ?>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<?php $form->input('foundation_address',array('label'=>__('Address','donations'),'value' => $Foundation['foundation_address'])); ?>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<?php $form->input('foundation_email',array('label'=>__('E-mail','donations'),'value' => $Foundation['foundation_email'])); ?>
						</div>
						<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
						<div><label class=""><?php echo __('Blacklist','donations')?></label></div>
							<?php $form->input('black_listed',array('label'=>__('No','donations'),'value' => 0,'class' =>'flat','type'=>'radio','label-pos'=>'after','no-wrap'=>true,'attribute'=>$bln)); ?> 
							<?php $form->input('black_listed',array('label'=>__('Yes','donations'),'value' => 1,'class' =>'flat','type'=>'radio','label-pos'=>'after','no-wrap'=>true,'attribute'=>$bly)); ?>
						</div>
						<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
							<?php $form->input('black_listed_reason',array('label'=>__('Blacklist reason','donations'),'value' => $Foundation['black_listed_reason'])); ?>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<?php $form->submit(__('Save','donations'),'btn btn-success'); ?>
						</div>
					</div>
					<?php $form->close();?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>