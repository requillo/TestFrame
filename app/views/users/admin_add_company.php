<form method="post">
<div class="container-fluid"> 
 

    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
       <?php $form->input('save',array('value' => __('Save'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>       
       <?php $form->input('savenew',array('value' => __('Save & New'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>
       <?php echo $html->admin_link('X','users/companies', array('class'=>'bclose btn btn-danger')) ?>
      </div>
    </div>  
</div>

<div class="container-fluid"> 
<div class="panel panel-default">
<div class="panel-body">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="form-group">
      <?php $form->input('company_name',array('label' => __('Company name'))) ?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
       <?php $form->input('company_address',array('label' => __('Address'))) ?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
       <?php $form->input('company_telephone',array('label' => __('Telephone'))) ?>
      </div>
    </div>
  </div>    
    
  </div>
  </div>
</div>
</form>