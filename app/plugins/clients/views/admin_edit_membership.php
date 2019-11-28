<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$form->create(); ?>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
       <?php $form->submit(__('Update'),'btn btn-success');?>
       <?php echo $html->admin_link(__('Cancel'),'clients/view/'.$Client['id'].'/', array('class'=>'bclose btn btn-danger')) ?>
      </div>
    </div>  
</div>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-body">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<?php $form->input('title',array('label' => __('Membership Name','clients'), 'value' => $Membership['title']))?>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<?php $form->input('member_number',array('label' => __('Member number','clients'), 'value' => $Membership['member_number']))?>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<?php $form->input('password',array('label' => __('Password','clients'), 'value' => $Membership['password']))?>
		</div>
	</div>
</div>
</div>
</div>
<?php $form->close(); ?>