<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="controls"><span><?php echo __('With selected','smiley_survey') ?></span> 
        <select id="bulk-actions"> 
        <?php echo $form->options(array(__('Choose'), __('Link','smiley_survey'), __('remove from Company','smiley_survey'))); ?>
        </select>
        <span class="role-user hide"> <span><?php echo __('to') ?></span> 
          <select id="sites">
            <?php
            echo $form->options($Sites);
             ?>
          </select>
        </span>
        <small><button class="relation-update btn btn-success">Update</button></small> <span class="pload loadbtn"></span> <span class="output"></span>
      </div>
      <div id="users-table" class="panel panel-default">
        <div class="panel-body">
        <div class="table-responsive">
          <table id="all-users" class="table table-striped bulk_action">          
          <thead>
            <tr>
            <th style="width:35px"><input id="userselect" class="userselect check flat" type="checkbox" name="data[selectall]"></th>
            <th><?php echo __('Name','smiley_survey') ?></th>
           
            <th><?php echo __('Company','smiley_survey') ?></th>
            <th><?php echo __('Role','smiley_survey') ?></th>
            <th style="width:65px"><?php echo __('Status','smiley_survey') ?></th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($Users as $User) { ?>

          <tr>
            <td><input class="check flat" type="checkbox" name="data[user_id]" value="<?php echo $User['id']; ?>"></td>
            <td><?php 
            if($User['level'] > 90.0 && $User['fname'] == '' && $User['lname'] == '') {
              echo $html->admin_link('Admin user','users/edit/'.$User['id'].'/');
            } else {
              echo $html->admin_link($User['fname'] . ' ' . $User['lname'],'users/edit/'.$User['id'].'/');
            }
            ?></td>
            <td><?php 
            if(isset($User['company_name'])) {
              echo $User['company_name'] ;
            }
            ?></td>
            <td><?php echo $User['level-name'] ?></td>
            <td><?php if($User['status'] == 1) { echo '<i class="fa fa-check text-success"></i>';} else { echo '<i class="fa fa-lock text-danger"></i>';} ?></td>
          </tr> 

           <?php } ?>
          </tbody>
          <tfoot>
            <tr>
            <th><input id="userselect" class="userselect check flat" type="checkbox" name="selectall"></th>
            <th><?php echo __('Name','smiley_survey') ?></th>
            <th><?php echo __('Company','smiley_survey') ?></th>
            <th><?php echo __('Role','smiley_survey') ?></th>
            <th><?php echo __('Status','smiley_survey') ?></th>
          </tr>
          </tfoot>
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>

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

$('.relation-update').on('click', function(){
var bulk = $('#bulk-actions option:selected').val();
var userids = $("#all-users input.check:checked").map(function(){return $(this).val();}).get();
var site = '';
if(bulk == 1) {
  site = $('#sites option:selected').val();
}
var fdata = {
  'data[bulk]': bulk,
  'data[site]': site,
  'data[userids]': userids
}
$('#all-users').append(loader);
  $.getJSON( Jsapi+'smiley-survey/update-user-relation/', fdata , function( data ) {
      console.log(data);
    if(data.add == 'success'){
      var pathtopage = window.location.href;
      $('#users-table').load(pathtopage + ' #users-table .panel-body', function(){
        $('body').find('.loaderwrap').remove();
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
      });
    } else {
      $('body').find('.loaderwrap').remove();
    }
    
    });
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

</script>