
<form method="post">
	<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-body">
  				<div class="row">
  				 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php if(!empty($Roles_below_options) && !empty($Roles_above_options)):?>
  				 <?php echo $form->input('new-user-role',array('label'=>__('New user role'))); ?>
           <input class="flat radsel" type="radio" name="data[role]" id="rabove" value="1"> <label for="rabove">Above</label> &nbsp;&nbsp;
           <input class="flat radsel" type="radio" name="data[role]" id="rbelow" value="2"> <label for="rbelow">Below</label>
           <select name="data[role_below]" class="form-control rbelow hide" id="selbelow">
             <?php foreach ($Roles_below_options as $item) {
               echo '<option value="'.$item['role_level'].'">'.$item['role_name'].'</option>';
             } ?>
           </select>
           <select name="data[role_above]" class="form-control rabove hide" id="selabove">
             <?php foreach ($Roles_above_options as $item) {
               echo '<option value="'.$item['role_level'].'">'.$item['role_name'].'</option>';
             } ?>
           </select>
  				 <?php echo $form->input('add',array('value' => __('Add'),'type'=>'submit','class'=> 'btn btn-success')) ?>
  				 <?php else: ?>
            <div class="lead text-danger"><?php echo __('Sorry, maximum roles reached!') ?></div>
            <div class="text-danger"><?php echo __("You can't add anymore roles") ?></div>
           <?php endif; ?>
           <div class="edit-role row hide">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><label><?php echo __('Edit role'); ?></label></div>
            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4"><a class="btn btn-success btn-block edit-btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo __('Edit'); ?></a></div>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-4"><input type="" name="rn" class="form-control the-rn"> <input type="" name="rn" class="form-control the-rl hide"></div>
            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4"><a class="btn btn-danger btn-block delete-btn"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo __('Delete'); ?></a></div>
             
           </div>
           </div>
  				 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="all-the-roles">
            <div id="rolesWrap">
              <?php echo $Roles; ?>
            </div>
  				 </div>
  				</div>
  			</div>
  		</div>
	</div>
</form>
<script type="text/javascript">
  var loader = '<div class="loaderwrap absolute overlay"><div class="the-loader s2 load-center text-white"></div></div>';
  $('.radsel').on('ifChanged', function(event){
    $('select').addClass('hide');
      if ($(this).prop('checked')==true){
        var d = $(this).attr('id');
        $('select.'+d).removeClass('hide');
       } 
    });

    $('body').on('click', '.role > li > a', function(e){
      e.preventDefault();
      var r = $(this).attr('data-level');
      var n = $(this).find('.level-name').text();
      $('.edit-role').removeClass('hide');
      $('.the-rn').val(n);
      $('.the-rl').val(r);
    }); 

     $('body').on('click', '.edit-role .edit-btn', function(e){
      e.preventDefault();
      $('#all-the-roles').append(loader);
      var p =  $(this).closest('.edit-role');
      var n = $('.the-rn').val();
      var i = $(this).attr('data-id');
      var r = $('.the-rl').val();
      p.addClass('hide');
      var fdata = {
        'data[role_level]': r,
        'data[role_name]': n
      }

      $.getJSON( Jsapi+'users/set-edit-roles/',fdata, function( data ) {
          if(data.edit == 'success'){
          var pathtopage = window.location.href;
              // alert(pathtopage);
              $('#all-the-roles').load(pathtopage + ' #rolesWrap', function(){
                $('body').find('.loaderwrap').remove();
              });
            } else {
              $('body').find('.loaderwrap').remove();
            }
      });
      
    }); 

     $('body').on('click', '.edit-role .delete-btn', function(e){
      e.preventDefault();
      $('#all-the-roles').append(loader);
      var p =  $(this).closest('.edit-role');
      var r = $('.the-rl').val();
      p.addClass('hide');
      var fdata = {
        'data[role_level]': r
      }

      $.getJSON( Jsapi+'users/set-delete-roles/',fdata, function( data ) {
          if(data.check == 'success'){
          var pathtopage = window.location.href;
              // alert(pathtopage);
              $('#all-the-roles').load(pathtopage + ' #rolesWrap', function(){
                $('body').find('.loaderwrap').remove();
              });
            } else {
              $('body').find('.loaderwrap').remove();
            }
      });
      
    });
</script>