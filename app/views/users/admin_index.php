<?php
//echo '<pre>';
//print_r($Users);
// print_r($User_roles);
//echo '</pre>';

// echo $this->user['role_level'];

?>
<?php $form->create(array('action'=>url().'api/json/users/action'))?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="controls"><span><?php echo __('With selected') ?></span> 
				<select id="bulk-actions"> 
				<?php echo $form->options(array(__('Choose'), __('Edit roles'), __('Suspend'), __('Enable'), __('Delete'))); ?>
				</select>
				<span class="role-user hide"> <span><?php echo __('to') ?></span> 
					<select id="user-role">
						<?php

						foreach ($User_roles as $role) {
							echo '<option value="'.$role['role_level'].'">'.$role['role_name'].'</option>';
						}
						 ?>
					</select>
				</span>
				<small><button class="cl-user-action btn btn-success">Update</button></small> <span class="pload loadbtn"></span> <span class="output"></span>
			</div>
			<div id="users-table" class="panel panel-default">
				<div class="panel-body">
				<div class="table-responsive">
				  <table id="all-users" class="table table-striped bulk_action">				  
				  <thead>
				  	<tr>
				  	<th style="width:35px"><input id="userselect" class="userselect check flat" type="checkbox" name="data[selectall]"></th>
				  	<th><?php echo __('Name') ?></th>
				  	<th><?php echo __('E-mail') ?></th>
				  	<th><?php echo __('Username') ?></th>
				  	<th><?php echo __('Role') ?></th>
				  	<th><?php echo __('Status') ?></th>
				  </tr>
				  </thead>
				  <tbody>
				  <?php foreach ($Users as $User) { ?>

				  <tr>
				  	<td><input class="check flat" type="checkbox" name="data[user_id]" value="<?php echo $User['id']; ?>"></td>
				  	<td><?php 
				  	if($User['level'] == 100.0 && $User['fname'] == '' && $User['lname'] == '') {
				  		echo $html->admin_link('Admin user','users/edit/'.$User['id'].'/');
				  	} else {
				  		echo $html->admin_link($User['fname'] . ' ' . $User['lname'],'users/edit/'.$User['id'].'/');
				  	}
				  	?></td>
				  	<td><?php echo $User['email'] ?></td>
				  	<td><?php echo $User['username'] ?></td>
				  	<td><?php echo $User['level-name'] ?></td>
				  	<td><?php if($User['status'] == 1) { echo '<i class="fa fa-check text-success"></i>';} else { echo '<i class="fa fa-lock text-danger"></i>';} ?></td>
				  </tr>	

				   <?php } ?>
				  </tbody>
				  <tfoot>
				  	<tr>
				  	<th><input id="userselect" class="userselect check flat" type="checkbox" name="selectall"></th>
				  	<th><?php echo __('Name') ?></th>
				  	<th><?php echo __('E-mail') ?></th>
				  	<th><?php echo __('Username') ?></th>
				  	<th><?php echo __('Role') ?></th>
				  	<th><?php echo __('Status') ?></th>
				  </tr>
				  </tfoot>
				  </table>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $form->close() ?>

<script type="text/javascript">
	var loader = '<div class="loaderwrap absolute overlay"><div class="the-loader s2 load-center text-white"></div></div>';
	var loader2 = '<div class="loaderwrap absolute overlay"><div class="the-loader load-center text-white"></div></div>';

	$('body').on('ifChanged', '.userselect', function(event){
      if ($(this).prop('checked')==true){
       $('.check').iCheck('check');
        
       } else {
       
       $('.check').iCheck('uncheck');
       }

    });

    // Users
    $('.cl-user-action').on('click',function(e){
      e.preventDefault();
      var p = $(this).closest('.controls');
      var f = $(this).closest('form');
      var u = f.prop('action');
      var role = '';
      var bulk = $('#bulk-actions option:selected').val();
      var userids = $("#all-users input.check:checked").map(function(){return $(this).val();}).get();
      if(bulk == 1) {
        role = $('#user-role option:selected').val();
      }

      if(bulk != '' && userids != ''){
      p.find('.pload').html('<i class="text-success glyphicons glyphicons-refresh glyphicon-refresh-animate"></i>');
      $('#all-users').append(loader);
      var formdata = {
      'data[todo]' : 'bulk_user_update',
      'data[bulk]' : bulk,
      'data[userids]' : userids,
      'data[role-edit]' : role
        }

      $.ajax({
      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url     : u, // the url where we want to POST
      data    : formdata, // our data object
      dataType  : 'json', // what type of data do we expect back from the server
      encode    : true
    }).done(function(data) {
      // console.log(data);
      if(data.Key == 'Success') {
        // console.log(data);
        // location.reload();
        p.find('.pload').html('');

        $('#users-table').load(document.URL +  ' #users-table .panel-body',function(){
        	$('#all-users').DataTable({
		     	"language": {
				    "decimal":        "",
				    "emptyTable":     "<?php echo __('No data available in table'); ?>",
				    "info":           "<?php echo __('Showing _START_ to _END_ of _TOTAL_ entries'); ?>",
				    "infoEmpty":      "<?php echo __('Showing 0 to 0 of 0 entries'); ?>",
				    "infoFiltered":   "<?php echo __('(filtered from _MAX_ total entries)'); ?>",
				    "infoPostFix":    "",
				    "thousands":      ",",
				    "lengthMenu":     "<?php echo __('Show _MENU_ entries'); ?>",
				    "loadingRecords": "<?php echo __('Loading...'); ?>",
				    "processing":     "<?php echo __('Processing...'); ?>",
				    "search":         "<?php echo __('Search:'); ?>",
				    "zeroRecords":    "<?php echo __('No matching records found'); ?>",
				    "paginate": {
				        "first":      "<i class='fa fa-angle-double-left'></i>",
				        "last":       "<i class='fa fa-angle-double-right'></i>",
				        "next":       "<i class='fa fa-angle-right'></i>",
				        "previous":   "<i class='fa fa-angle-left'></i>"
				    },
				}

		     });
            add_icheck();
            $('body').find('.loaderwrap').remove();
        });

      } else {
        // p.find('.msg').text(data.message);
      }
    }).fail(function(data) {
      console.log(data);
        // console.log(data);
    });
     }
});

// Users show/hide roles
     $('#bulk-actions').on('change', function(){
      if($(this).val() == 1) {
        $('.role-user').removeClass('hide');
      } else {
        $('.role-user').removeClass('hide');
        $('.role-user').addClass('hide');
      }

    });

     $('#all-users').DataTable({
     	"language": {
		    "decimal":        "",
		    "emptyTable":     "<?php echo __('No data available in table'); ?>",
		    "info":           "<?php echo __('Showing _START_ to _END_ of _TOTAL_ entries'); ?>",
		    "infoEmpty":      "<?php echo __('Showing 0 to 0 of 0 entries'); ?>",
		    "infoFiltered":   "<?php echo __('(filtered from _MAX_ total entries)'); ?>",
		    "infoPostFix":    "",
		    "thousands":      ",",
		    "lengthMenu":     "<?php echo __('Show _MENU_ entries'); ?>",
		    "loadingRecords": "<?php echo __('Loading...'); ?>",
		    "processing":     "<?php echo __('Processing...'); ?>",
		    "search":         "<?php echo __('Search:'); ?>",
		    "zeroRecords":    "<?php echo __('No matching records found'); ?>",
		    "paginate": {
		        "first":      "<i class='fa fa-angle-double-left'></i>",
		        "last":       "<i class='fa fa-angle-double-right'></i>",
		        "next":       "<i class='fa fa-angle-right'></i>",
		        "previous":   "<i class='fa fa-angle-left'></i>"
		    },
		}

     });
</script>