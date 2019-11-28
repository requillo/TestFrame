
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
      	if($Insurance['company'] == $key){$ch = 'checked';} else {$ch = '';}
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
      	if($Insurance['travel_area'] == $key){$ch = 'checked';} else {$ch = '';}
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
        <?php $form->input('ipnumber',array('label' => __('Ipnumber','clients') , 'value' => $Insurance['ipnumber']))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('number',array('label' => __('Number','clients'), 'value' => $Insurance['number']))?>
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
       <?php 
       $ins1 = $ins2 = $ins3 = $ins4 = $ins5 = $ins6 = '';
       if($Insurance['insurance_type'] == 1) {
        $ins1 = 'checked';
       } else if($Insurance['insurance_type'] == 2) {
        $ins2 = 'checked';
       } else if($Insurance['insurance_type'] == 3) {
        $ins3 = 'checked';
       } else if($Insurance['insurance_type'] == 4) {
        $ins4 = 'checked';        
       } else if($Insurance['insurance_type'] == 5) {
        $ins5 = 'checked';        
       } else if($Insurance['insurance_type'] == 6) {
        $ins6 = 'checked';     
       } 
       $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['1'], 'value' => 1, 'class' => 'inty flat', 'label-pos' => 'after','attribute' => $ins1));
       ?>
       <?php 
       $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['2'], 'value' => 2, 'class' => 'door inty flat', 'label-pos' => 'after','attribute' => $ins2));
       ?>
       <?php 
       $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['3'], 'value' => 3, 'class' => 'inty flat', 'id' => 'ann1', 'label-pos' => 'after','attribute' => $ins3));
       ?> 
      </div>
      <div class="form-group group-carib the-groups hide">
       <?php 
       $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['4'], 'value' => 4, 'class' => 'inty flat', 'label-pos' => 'after','attribute' => $ins4));
       ?>
       <?php 
       $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['3'], 'value' => 3, 'class' => 'inty flat', 'id' => 'ann2', 'label-pos' => 'after','attribute' => $ins3));
       ?>
      </div>
      <div class="form-group group-rest the-groups hide">
       <?php 
       $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['5'], 'value' => 5, 'class' => 'inty flat', 'label-pos' => 'after','attribute' => $ins5));
       ?>
       <?php 
       $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['6'], 'value' => 6, 'class' => 'door inty flat', 'label-pos' => 'after','attribute' => $ins6));
       ?>
       <?php 
       $form->input('in_type',array( 'type' => 'radio','label' => $Insurance_type['3'], 'value' => 3, 'class' => 'inty flat', 'label-pos' => 'after','attribute' => $ins3));
       ?> 
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 typeins">
    <label><?php echo __('In combinatie met een','clients');?></label>
      <div class="form-group">
        <?php 
        if($Insurance['combination'] == 1) {
          $inscheck1 = 'checked';
        } else {
          $inscheck1 = '';
        }
        $form->input('combination',array( 'type' => 'checkbox','label' => __('ANNULERINGSVERZEKERING','clients'), 'class' => 'flat comb', 'label-pos' => 'after', 'value' => 1, 'attribute' => $inscheck1))?> 
      </div>
    </div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label><?php echo __('Final destination','clients');?></label>
        <select name="data[final_destination]" class="form-control"><?php echo country_options($Insurance['final_destination'])?></select>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="form-group">
        
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('start_date',array('label' => __('Datum aanvang reis','clients'), 'class' => 'date-picker1 form-control', 'value' => date('d-m-Y', strtotime($Insurance['start_date']))))?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group enddate">
        <?php $form->input('end_date',array('label' => __('Datum terugreis','clients'), 'class' => 'date-picker1 form-control', 'value' => date('d-m-Y', strtotime($Insurance['end_date']))))?>
      </div>
    </div>
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label><?php echo __('Doel van de reis','clients');?></label>
        <select name="data[travel_reason]" class="form-control"><?php echo $form->options($Travel_reason,$Insurance['travel_reason'])?></select>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label><?php echo __('Land van herkomst','clients');?></label>
        <select name="data[country_of_origin]" class="form-control"><?php echo country_options($Insurance['country_of_origin'])?></select>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label><?php echo __('Zal u gedurende uw reis Cuba aandoen?','clients');?></label>
        <span>&nbsp;</span> <span>&nbsp;</span> <span>&nbsp;</span>
      <?php if($Insurance['cuba'] == 1) {$n = ''; $y = 'checked';} else {$n = 'checked'; $y = '';} ?>
       <?php $form->input('cuba',array( 'type' => 'radio','label' => __('Yes','clients'), 'class' => 'flat', 'label-pos' => 'after','value'=> '1','no-wrap' => true, 'attribute' => $y))?> <span>&nbsp;</span> <span>&nbsp;</span> <span>&nbsp;</span>
       <?php $form->input('cuba',array( 'type' => 'radio','label' => __('No','clients'), 'class' => 'flat', 'label-pos' => 'after','value'=> '2','attribute' => $n,'no-wrap' => true))?>
      </div>
    </div>



  </div>    
    
  </div>
  </div>
  
</div>
</form>
<script type="text/javascript">
	$(document).ready(function() { 
    var clcomp = $("input.clcomp:checked").val();
    var tva = $("input.tva:checked").val();
    var door = $("input.door:checked").val();
    $('.the-groups').addClass('hide');
    if(clcomp == 2) {
      $('.typeins').addClass('hide');
    }
    if(door == 3 || door == 6) {
      $('.enddate').addClass('hide');
    }
    if(tva == 1) {
     $('.group-euro').removeClass('hide');
    } else if(tva == 2) {
      $('.group-carib').removeClass('hide');
    } else if(tva == 3) {
      $('.group-rest').removeClass('hide');
    }
    $('input.tva').on('ifChanged',function() {
	 if ($(this).prop('checked')==true){
	 	$('.the-groups').addClass('hide');
	 	if ($(this).val() == '1') {
           	$('.group-euro').removeClass('hide');
           	$('.inty').iCheck('uncheck');
            $('.comb').iCheck('uncheck');
        }
        else if ($(this).val() == '2') {
            $('.group-carib').removeClass('hide');
            $('.inty').iCheck('uncheck');
            $('.comb').iCheck('uncheck');
        } 
        else if ($(this).val() == '3') {
        	$('.group-rest').removeClass('hide');
        	$('.inty').iCheck('uncheck');
          $('.comb').iCheck('uncheck');
        }
	 }
        
    });

    $('input.clcomp').on('ifChanged',function() {
	   if ($(this).prop('checked')==true){
	 	   if ($(this).val() == '2') {
           	$('.typeins').addClass('hide');
           	$('.inty').iCheck('uncheck');
            $('.comb').iCheck('uncheck');

        }
        else {
            $('.typeins').removeClass('hide');
            $('.inty').iCheck('uncheck');
            $('.comb').iCheck('uncheck');
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