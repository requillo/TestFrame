<?php // print_r($this->user); ?>
<form method="post" class="no-enter">
<div class="container-fluid"> 
 

    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
      <?php $form->input('save',array('value' => __('Save'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>       
      <?php $form->input('saveclose',array('value' => __('Save & Close'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>    
      <?php $form->input('savenew',array('value' => __('Save & New'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>
      <?php echo $html->admin_link('X','users', array('class'=>'bclose btn btn-danger')) ?>
      <?php $form->input('salt',array('type' => 'hidden', 'value' => $User['salt']))?>
      <?php $form->input('oemail',array('type' => 'hidden', 'value' => $User['email']))?>
      <?php $form->input('ouser',array('type' => 'hidden', 'value' => $User['username']))?>
      <?php $form->input('rest',array('type' => 'hidden', 'value' => url().'api/json/users/action'))?>
      </div>
    </div> 

 
</div>
<div class="loadmsg"></div>
<div class="container-fluid"> 
<div class="panel panel-default">
<div class="panel-body">
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
      <?php $form->input('fname',array('label' => __('First name'), 'value' => $User['fname'])) ?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <?php $form->input('lname',array('label' => __('Last name'), 'value' => $User['lname'])) ?>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <label for="email" ><?php echo __('E-mail address');?></label>
      <div class="input-group">
         <?php $form->input('email',array('value' => $User['email'], 'no-wrap' => true))?>
        <span class="input-group-addon" id="checkmail"><i class="glyphicons glyphicons-ok text-success"></i></span>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <label for="username" ><?php echo __('Username');?></label>
      <div class="input-group">
        <?php $form->input('username',array('value' => $User['username'], 'no-wrap' => true))?>
        <span class="input-group-addon" id="checkuser"><i class="glyphicons glyphicons-ok text-success"></i></span>
      </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
    <label for="password" ><?php echo __('Password');?></label>
      <div class="input-group">
        <?php $form->input('password',array('type' => 'password','placeholder' => '********', 'no-wrap' => true))?>
        <span class="input-group-addon" id="basic-addon1"><a href="#" class="show-hide sp"><i class="glyphicons glyphicons-eye-open"></i></a></span>
      </div>
      </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
      <div class="form-group">    
        <label for="company" ><?php echo __('Company');?></label>
        <select class="form-control" name="data[user_company]" id="company">
          <option><?php echo __('Choose company') ?></option>
         <?php
    foreach ($Companies as $Company) {
      if($User['company_id'] == $Company['id']) {
        $comp_sel = 'selected';
      } else {
        $comp_sel = '';
      }
      echo '<option value="'.$Company['id'].'" '.$comp_sel.'>'.$Company['company_name'].'</option>';
    }
    ?>
        </select>
      </div>      
    </div>
    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">    
        <label for="role" ><?php echo __('Role');?></label>
        <select class="form-control" name="data[role]" id="role">
         <?php
      		foreach ($User_roles as $role) {
      			if($role['role_level'] == $User['level']){
      				$select = 'selected';
      			} else {
      				$select = '';
      			}
      			echo '<option value="'.$role['role_level'].'" '.$select.'>'.$role['role_name'].'</option>';
      		}
		    ?>
        </select>
      </div>      
    </div>
    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">
      <div class="form-group">
        <div class="lab-mar"><?php echo __('Gender');?></div>
    <div class="radio"><input class="flat" type="radio" name="data[gender]" value="1" id="male" <?php if($User['gender'] == 1) echo 'checked';?>> <label for="male" ><?php echo __('Male');?></label></div>
    <div class="radio"><input class="flat" type="radio" name="data[gender]" value="2" id="female" <?php if($User['gender'] == 2) echo 'checked';?>> <label for="female" ><?php echo __('Female');?></label></div>
      </div> 
    </div>
    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">
      <div class="form-group">
        <div class="lab-mar"><?php echo __('Status');?></div>
        <div class="radio"><input class="flat" type="radio" name="data[status]" value="1" id="enable" <?php if($User['status'] == 1) echo 'checked';?>> <label for="enable" ><?php echo __('Enable');?></label></div>
        <div class="radio"><input class="flat" type="radio" name="data[status]" value="0" id="disable" <?php if($User['status'] == 0) echo 'checked';?>> <label for="disable" ><?php echo __('Disable');?></label></div>
      </div>
    </div> 
  </div>    
    
  </div>
  </div>
</div>
</form>
<script type="text/javascript">
  // Check if email exists
$('#input-email').on('change',function(){
    var f = $(this).closest('form');
    var u = f.find('#input-rest').val();
    var em = $(this).val();
    var oe = $('#input-oemail').val();
      if(em != ''){
         $('#checkmail').html('<i class="glyphicons glyphicons-refresh glyphicon-refresh-animate"></i>');
        var elm = $(this);
        var formdata = {
        'data[bulk]' : '',
        'data[todo]' : 'emailcheck',
        'data[email]' : em
      }
      $.ajax({
      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url     :  u, // the url where we want to POST
      data    : formdata, // our data object
      dataType  : 'json', // what type of data do we expect back from the server
      encode    : true
    }).done(function(data) {
      console.log(data);
      //$('.loadmsg').html(data.Key + ' - ' + oe);
      if(data.Key == 1) {
        $('#checkmail').html('<i class="glyphicons glyphicons-ok text-success"></i>');     
      } else if(data.Key == 2 && em != oe) {
        $('#checkmail').html('<i class="glyphicons glyphicons-alert text-danger"></i>');
      } else if(data.Key == 2 && em == oe) {
        $('#checkmail').html('<i class="glyphicons glyphicons-ok text-success"></i>');
      }
    }).fail(function(data) {
      console.log(data);
        // console.log(data);
    });
    } else {
      $('#checkmail').html('<i class="glyphicons glyphicons-alert text-danger"></i>');
    }
    });

$('#input-username').on('change',function(){
    var f = $(this).closest('form');
    var u = f.find('#input-rest').val();
    var us = $(this).val();
    var ou = $('#input-ouser').val();
      if(us != ''){
         $('#checkuser').html('<i class="glyphicons glyphicons-refresh glyphicon-refresh-animate"></i>');
        var elm = $(this);
        var formdata = {
        'data[bulk]' : '',
        'data[todo]' : 'userscheck',
        'data[user]' : us
      }
      $.ajax({
      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url     :  u, // the url where we want to POST
      data    : formdata, // our data object
      dataType  : 'json', // what type of data do we expect back from the server
      encode    : true
    }).done(function(data) {
      console.log(data);
      //$('.loadmsg').html(data.Key + ' - ' + ou);
      if(data.Key == 1) {
        $('#checkuser').html('<i class="glyphicons glyphicons-ok text-success"></i>');
        //f.submit();     
      } else if(data.Key == 2 && us != ou) {
        $('#checkuser').html('<i class="glyphicons glyphicons-alert text-danger"></i>');
      } else if(data.Key == 2 && us == ou) {
        $('#checkuser').html('<i class="glyphicons glyphicons-ok text-success"></i>');
         //f.submit();
      }
    }).fail(function(data) {
      console.log(data);
        // console.log(data);
    });
    } else {
      $('#checkuser').html('<i class="glyphicons glyphicons-alert text-danger"></i>');
    }
    });

// Show password
$('.show-hide').on('click',function(e){
      e.preventDefault();
      var p = $(this).closest('.input-group');
      var i = p.find('input');
      var ic = p.find('i'); // glyphicon-eye-close glyphicon-eye-open
      if($(this).hasClass('sp')) {
        $(this).addClass('hp');
        $(this).removeClass('sp');
        i.prop('type','text');
        ic.addClass('glyphicons-eye-close');
        ic.removeClass('glyphicons-eye-open');
      } else {
        $(this).addClass('sp');
        $(this).removeClass('hp');
        i.prop('type','password');
        ic.addClass('glyphicons-eye-open');
        ic.removeClass('glyphicons-eye-close');
      }
    });
</script>
