<?php 
$form->create();
?>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
       <?php $form->input('save',array('value' => __('Save'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>
      </div>
    </div>  
</div>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php echo $Data; ?>
			</div>
		</div>
	</div>
</div>

<?php
$form->close();