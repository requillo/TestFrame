<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$form->create(['file-upload' => true]); ?>
<div class="container-fluid"> 
 

    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
       <?php $form->input('save',array('value' => __('Save','clients'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>       
       <?php $form->input('saveclose',array('value' => __('Save & Close','clients'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>    
       <?php $form->input('savenew',array('value' => __('Save & New','clients'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>
       <?php echo $html->admin_link(__('Cancel','clients'),'clients', array('class'=>'bclose btn btn-danger no-print')) ?>
      </div>
    </div>  
</div>

<div class="container-fluid"> 
<div class="panel panel-default">
<div class="panel-body">
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
      <?php $form->input('f_name',array('label' => __('First name','clients')))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
       <?php $form->input('l_name',array('label' => __('Last name','clients')))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('address',array('label' => __('Address','clients')))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('city',array('label' => __('City or Resendential area','clients')))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('district',array('label' => __('District','clients')))?>
      </div>
    </div>
     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label><?php echo __('Country','clients');?></label>
        <select name="data[country]" class="form-control"><?php echo country_options()?></select>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <label for="email" ><?php echo __('Telephone','clients');?></label>
      <div class="form-group">
        <?php $form->input('telephone')?>       
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <label for="email" ><?php echo __('E-mail address','clients');?></label>
      <div class="form-group">
        <?php $form->input('email')?>       
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label><?php echo __('Nationality','clients');?></label>
        <select name="data[nationality]" class="form-control"><?php echo country_options()?></select>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('id_number',array('label' => __('ID Number','clients')))?>
      </div>
    </div>
     <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
      <div class="form-group">
        <?php $form->input('company',array('label' => __('Company','clients')))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
      <div class="form-group">
        <?php $form->input('position',array('label' => __('Position','clients')))?>
      </div>
    </div>
     <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
     <div class="form-group">
    <?php $form->input('date_of_birth',array('label' => __('Date of birth','clients'), 'class' => 'date-of-birth form-control'))?>
    </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 hide">
    <input type="number" placeholder="Day" min="1" max="31" id="number">
    <input type="number" placeholder="Month" min="1" max="12" id="number">
    <input type="number" placeholder="Year" min="1917" max="2017" id="number">
    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
     <label><?php echo __('Gender');?></label>
      <div class="form-group">
       
    <div class="radio inl"><?php $form->input('gender',array('type'=>'radio','label'=> __('Male','clients'),'class'=>'flat','label-pos'=>'after','value'=>1,'attribute'=>'checked'))?></div>
    <div class="radio inl"><?php $form->input('gender',array('type'=>'radio','label'=> __('Female','clients'),'class'=>'flat','label-pos'=>'after','value'=>2))?></div>
      </div> 
    </div>
    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
      <div class="form-group">
        <?php $form->input('profile_picture',array('label' => '<i class="fa fa-upload" aria-hidden="true"></i> '. __('Upload Profile picture','clients') . ' <small class="text-warning">(max 5mb)</small>', 'type' => 'file'))?>
      </div>
    </div>
  </div>    
    
  </div>
  </div>
  
</div>
</div>
<?php if(!empty($New_fields)) { ?>
<div class="container-fluid"> 
<div class="panel panel-default">
<div class="panel-body">
  <div class="row">
 <?php 
   
      foreach ($New_fields as$value){
      ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="form-group">
       <label for="input-<?php echo $value['id'] ?>"><?php echo $value['name'] ?></label>
        <input min="0" type="<?php echo $value['value'] ?>" name="data[fieldname][<?php echo $value['id'] ?>]" class="form-control" id="input-<?php echo $value['id'] ?>" value="">
      </div>
    </div>
    <?php 
      }
      
  ?>
  </div>
</div>
</div>
</div>
<?php } ?>
</form>