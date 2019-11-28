
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$gender = '';
if(isset($Client['gender'])) {
  if($Client['gender'] == 1) {
    $gender = __('Male','clients');
  } else {
     $gender = __('Female','clients');
  }

  }

$form->create(); ?>
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="form-group">
      <h3><?php echo __('Company','clients');?></h3>
      <?php 
      $i = 1;
      foreach ($Insurance_companies as $key => $value):
      	if($i == 1){$ch = 'checked';} else {$ch = '';}
      	?>
       <?php $form->input('company',array( 'type' => 'radio' ,'label' => $value,'value' => $key, 'class' => 'flat clcomp', 'label-pos' => 'after','attribute' => $ch))?>
      <?php
      $i++; 
      endforeach;
      ?>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="form-group">
      <h3><?php echo __('Travel area','clients');?></h3>
      <?php 
      $i = 1;
      foreach ($Insurance_area as $key => $value):
      	if($i == 1){$ch = 'checked';} else {$ch = '';}
      	?>
       <?php $form->input('travel_area',array( 'type' => 'radio','label' => $value,'value' => $key, 'class' => 'flat tva', 'label-pos' => 'after','attribute' => $ch))?>
      <?php 
       $i++; 
      endforeach;
      ?>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h3>Contact informatie verzekeringnemer</h3>
      <div class="form-group">
       <label><?php echo $Client['l_name'] . ', ' . $Client['f_name'];?></label>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('ipnumber',array('label' => __('Ipnumber','clients')))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('number',array('label' => __('Number','clients')))?>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="form-group">

      <ul class="list-unstyled user_data">            
            <?php if($Client['address'] != ''): ?>
              <li>
                <p><strong><?php echo __('Address','clients') ?></strong></p>
                <div><?php echo $Client['address'];
               	if($Client['city'] != ''): 
               	echo ', '. $Client['city'];
            	endif; 
            	if($Client['district'] != ''): 
                echo ', '. $Client['district'];
            	endif; 
            	if($Client['country'] != ''): 
                echo ', '. $Client['country'];
            	endif; ?>
                </div>
              </li>
            <?php endif; ?>
            <?php if($Client['telephone'] != ''): ?>
              <li>
                <p><strong><?php echo __('Telephone','clients') ?></strong></p>
                <div><?php echo $Client['telephone'] ?></div>
              </li>
            <?php endif; ?>
             <?php if($Client['email'] != ''): ?> 
              <li>
                <p><strong><?php echo __('E-mail address','clients') ?></strong></p>
                <div><?php echo $Client['email'] ?></div>
              </li>
            <?php endif; ?>
             <?php if($Client['id_number'] != ''): ?>
              <li>
                <p><strong><?php echo __('ID number','clients') ?></strong></p>
                <div><?php echo $Client['id_number'] ?></div>
              </li>
            <?php endif; ?>
            <?php if($Client['date_of_birth'] != ''): ?>
              <li>
                <p><strong><?php echo __('Date of birth','clients') ?></strong></p>
                <div><?php echo $Client['date_of_birth'] ?></div>
              </li>
            <?php endif; ?>
             <?php if($Client['gender'] != ''): ?>
              <li>
                <p><strong><?php echo __('Gender','clients') ?></strong></p>
                <div><?php echo $gender;?></div>
              </li>
            <?php endif; ?>
            </ul>
       
      </div>
    </div>
    <div class="for-assuria clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 typeins">
    	<h3><?php echo __('Verzekering informatie','clients');?></h3>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 typeins">
      <div class="form-group group-euro the-groups">
       <?php $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['1'], 'value' => 1, 'class' => 'inty flat', 'label-pos' => 'after'))?>
       <?php $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['2'], 'value' => 2, 'class' => 'door inty flat', 'label-pos' => 'after'))?>
       <?php $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['3'], 'value' => 3, 'class' => 'inty flat', 'id' => 'ann1', 'label-pos' => 'after'))?> 
      </div>
      <div class="form-group group-carib the-groups hide">
       <?php $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['4'], 'value' => 4, 'class' => 'inty flat', 'label-pos' => 'after'))?>
       <?php $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['3'], 'value' => 3, 'class' => 'inty flat', 'id' => 'ann2', 'label-pos' => 'after'))?>
      </div>
      <div class="form-group group-rest the-groups hide">
       <?php $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['5'], 'value' => 5, 'class' => 'inty flat', 'label-pos' => 'after'))?>
       <?php $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['6'], 'value' => 6, 'class' => 'door inty flat', 'label-pos' => 'after'))?>
       <?php $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['3'], 'value' => 3, 'class' => 'inty flat', 'label-pos' => 'after'))?> 
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 typeins">
    <label><?php echo __('In combinatie met een','clients');?></label>
      <div class="form-group">
        <?php $form->input('combination',array( 'type' => 'checkbox','label' => __('ANNULERINGSVERZEKERING','clients'), 'class' => 'flat', 'label-pos' => 'after', 'value' => 1))?> 
      </div>
    </div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label><?php echo __('Final destination','clients');?></label>
        <select name="data[final_destination]" class="form-control"><?php echo country_options()?></select>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="form-group">
        
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('start_date',array('label' => __('Datum aanvang reis','clients'), 'class' => 'date-picker1 form-control'))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group enddate">
        <?php $form->input('end_date',array('label' => __('Datum terugreis','clients'), 'class' => 'date-picker1 form-control'))?>
      </div>
    </div>
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label><?php echo __('Doel van de reis','clients');?></label>
        <select name="data[travel_reason]" class="form-control"><?php echo $form->options($Travel_reason)?></select>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label><?php echo __('Land van herkomst','clients');?></label>
        <select name="data[country_of_origin]" class="form-control"><?php echo country_options($Client['country'])?></select>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label><?php echo __('Zal u gedurende uw reis Cuba aandoen?','clients');?></label>
        <span>&nbsp;</span> <span>&nbsp;</span> <span>&nbsp;</span>
       <?php $form->input('cuba',array( 'type' => 'radio','label' => __('Yes','clients'), 'class' => 'flat', 'label-pos' => 'after','value'=> '1','no-wrap' => true))?> <span>&nbsp;</span> <span>&nbsp;</span> <span>&nbsp;</span>
       <?php $form->input('cuba',array( 'type' => 'radio','label' => __('No','clients'), 'class' => 'flat', 'label-pos' => 'after','value'=> '2','attribute' => 'checked','no-wrap' => true))?>
      </div>
    </div>



  </div>    
    
  </div>
  </div>
  
</div>
</form>
<script type="text/javascript">
	$(document).ready(function() { 
    $('input.tva').on('ifChanged',function() {
	 if ($(this).prop('checked')==true){
	 	$('.the-groups').addClass('hide');
	 	if ($(this).val() == '1') {
           	$('.group-euro').removeClass('hide');
           	$('.inty').iCheck('uncheck');
        }
        else if ($(this).val() == '2') {
            $('.group-carib').removeClass('hide');
            $('.inty').iCheck('uncheck');
        } 
        else if ($(this).val() == '3') {
        	$('.group-rest').removeClass('hide');
        	$('.inty').iCheck('uncheck');
        }
	 }
        
    });

    $('input.clcomp').on('ifChanged',function() {
	 if ($(this).prop('checked')==true){
	 	if ($(this).val() == '2') {
           	$('.typeins').addClass('hide');
           	$('.inty').iCheck('uncheck');
        }
        else {
            $('.typeins').removeClass('hide');
            $('.inty').iCheck('uncheck');
        } 
	 }
        
    });

    $('input.door').on('ifChanged',function() {
	 if ($(this).prop('checked')==true){
	 	$('.enddate').addClass('hide');
	 } else {
	 	$('.enddate').removeClass('hide');
	 }
        
    });
});
</script>