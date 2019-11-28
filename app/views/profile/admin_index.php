<form method="post" class="no-enter">
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
      <?php $form->input('save',array('value' => __('Save'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>       
      <?php echo $html->admin_link('Cancel','/', array('class'=>'bclose btn btn-danger')) ?>
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
         <?php $form->input('email',array('value' => $User['email'], 'attribute' => 'disabled', 'no-wrap' => true))?>
        <span class="input-group-addon" id="checkmail"><i class="glyphicons glyphicons-ok text-success"></i></span>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <label for="username" ><?php echo __('Username');?></label>
      <div class="input-group">
        <?php $form->input('username',array('value' => $User['username'], 'attribute' => 'disabled' , 'no-wrap' => true))?>
        <span class="input-group-addon" id="checkuser"><i class="glyphicons glyphicons-ok text-success"></i></span>
      </div>
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <label for="password" ><?php echo __('Password');?></label>
      <div class="input-group">
        <?php $form->input('password',array('type' => 'password','placeholder' => '********','no-wrap' => true))?>
        <span class="input-group-addon" id="basic-addon1"><a href="#" class="show-hide sp"><i class="glyphicons glyphicons-eye-open"></i></a></span>
      </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label class="lab-mar" style="display: block"><?php echo __('Gender');?></label>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6"><input class="flat" type="radio" name="data[gender]" value="1" id="male" <?php if($User['gender'] == 1) echo 'checked';?>> <label for="male" ><?php echo __('Male');?></label></div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6"><input class="flat" type="radio" name="data[gender]" value="2" id="female" <?php if($User['gender'] == 2) echo 'checked';?>> <label for="female" ><?php echo __('Female');?></label></div>
      </div> 
    </div>

  </div>    
    
  </div>
  </div>
</div>
</form>
<script type="text/javascript">
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
