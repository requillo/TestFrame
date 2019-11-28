<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$form->create(['file-upload' => true]); ?>
<div class="container-fluid"> 
 

    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
       <?php $form->input('save',array('value' => __('Save','clients'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>       
       <?php $form->input('saveclose',array('value' => __('Save & Close','clients'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>    
       <?php $form->input('savenew',array('value' => __('Save & New','clients'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>
       <?php echo $html->admin_link(__('Cancel','clients'),'clients/view/'.$Client['id'].'/', array('class'=>'bclose btn btn-danger')) ?>
      </div>
    </div>  
</div>

<div class="container-fluid"> 
<div class="panel panel-default">
<div class="panel-body">
    <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
      <?php $form->input('f_name',array('label' => __('First name','clients'), 'value' => $Client['f_name']))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
       <?php $form->input('l_name',array('label' => __('Last name','clients'), 'value' => $Client['l_name']))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('address',array('label' => __('Address','clients'), 'value' => $Client['address']))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('city',array('label' => __('City or Resendential area','clients'), 'value' => $Client['city']))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('district',array('label' => __('District','clients'), 'value' => $Client['district']))?>
      </div>
    </div>
     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label><?php echo __('Country','clients');?></label>
        <select name="data[country]" class="form-control"><?php echo country_options($Client['country'])?></select>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <label for="email" ><?php echo __('Telephone','clients');?></label>
      <div class="form-group">
        <?php $form->input('telephone', array('value' => $Client['telephone']))?>       
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <label for="email" ><?php echo __('E-mail address','clients');?></label>
      <div class="form-group">
        <?php $form->input('email', array('value' => $Client['email']))?>       
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label><?php echo __('Nationality','clients');?></label>
        <select name="data[nationality]" class="form-control"><?php echo country_options($Client['nationality'])?></select>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('id_number',array('label' => __('ID Number','clients'), 'value' => $Client['id_number']))?>
      </div>
    </div>
     <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
      <div class="form-group">
        <?php $form->input('company',array('label' => __('Company','clients'), 'value' => $Client['company']))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
      <div class="form-group">
        <?php $form->input('position',array('label' => __('Position','clients'), 'value' => $Client['position']))?>
      </div>
    </div>
     <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
     <div class="form-group">
    <?php $form->input('date_of_birth',array('label' => __('Date of birth','clients'), 'class' => 'date-of-birth form-control', 'value' => $Client['date_of_birth']))?>
    </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 hide">
    <input type="number" placeholder="Day" min="1" max="31" id="number">
    <input type="number" placeholder="Month" min="1" max="12" id="number">
    <input type="number" placeholder="Year" min="1917" max="2017" id="number">
    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
     <label><?php echo __('Gender','clients');?></label>
      <div class="form-group">
       
    <?php
      $cmale = '';
      $cfem = '';
      if($Client['gender'] == 1) {
      $cmale = 'checked';
      } else {
      $cfem = 'checked'; 
      }
      ?>
    <div class="radio inl"><?php $form->input('gender',array('type'=>'radio','label'=> __('Male','clients'),'class'=>'flat','label-pos'=>'after','value'=>1,'attribute'=>$cmale))?></div>
    <div class="radio inl"><?php $form->input('gender',array('type'=>'radio','label'=> __('Female','clients'),'class'=>'flat','label-pos'=>'after','value'=>2,'attribute'=>$cfem))?></div>
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
<div class="container-fluid"> 
<div class="panel panel-default">
<div class="panel-body">
  <div class="row">
  <?php if(!empty($Extra_fields)) {
   
      foreach ($Extra_fields as $value){
      ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="form-group">
       <label for="input-<?php echo $value['id'] ?>"><?php echo $value['name'] ?></label>
        <input type="text" name="data[fieldname][<?php echo $value['id'] ?>]" class="form-control" id="input-<?php echo $value['id'] ?>" value="<?php if(isset($value['meta']['value'])) echo  $value['meta']['value'];?>">
      </div>
    </div>
    <?php 
      }
    
  } ?>
  </div>
</div>
</div>
</div>
</form>