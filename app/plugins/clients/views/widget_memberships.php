<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="profile_title">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <h2><?php echo $html->admin_link(__('<i class="fa fa-plus"></i>'),'clients/add-membership/'.$Client['id'].'/', array('class'=> 'btn btn-success btn-xs pull-right')) ?></h2>
  <h2><?php echo $title ?></h2>
  </div>
</div>
<?php if(!empty($Memberships)): ?>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      
      <div id="users-table" class="panel panel-default">
        <div class="table-responsive">
          <table id="all-memberships" class="table table-striped bulk_action">          
          <thead>
            <tr>
            <th style="width: 35px"><i class="fa fa-pencil"></i></th>
            <th><?php echo __('Membership','clients') ?></th>
            <th class="text-right"><i class="fa fa-trash"></i></th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($Memberships as $Membership) { ?>
          <tr>
            <td><?php echo $html->admin_link('<i class="fa fa-edit text-success"></i>','clients/edit-membership/'.$Membership['id'].'/');?></td>
            <td><a href="#" data-id="<?php echo $Membership['id'];?>" class="member"><?php echo $Membership['title'];?></a></td>
            <td class="text-right">
              <?php echo $html->admin_link('<i class="fa fa-close text-danger"></i>','clients/delete-membership/'.$Membership['id'].'/','confirm');?>
            </td>
          </tr> 

           <?php } ?>
          </tbody>
          <tfoot>
            <tr>
            <th><i class="fa fa-pencil"></i></th>
            <th><?php echo __('Membership') ?></th>
            <th class="text-right"><i class="fa fa-trash"></i></th>
          </tr>
          </tfoot>
          </table>
        </div>

      </div>
    </div>
     </div>
     <script type="text/javascript">
     $('#all-memberships').on('click','a.member', function(e){
        e.preventDefault();
        $('.membercard').remove();
        $('.full-load').remove();
        $('body').append('<div class="full-load">Loading</div>');
        var formdata = {'data[id]' : $(this).attr('data-id')}
         $.ajax({
          type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
          url     : 'api/json/clients/get-membership/', // the url where we want to POST
          data    : formdata, // our data object
          dataType  : 'json', // what type of data do we expect back from the server
          encode    : true
        }).done(function(data) {
          console.log(data);
           // alert(data.title);
          $('.full-load').remove();
           var member = '<div class="mem-overlay"></div>';
            member += '<div class="membercard"><div class="mem-title">'+data.title+'<span class="pull-right close-member"><i class="fa fa-close text-danger"></i></span></div>';
            member += '<div class="mem-name">'+data.client_name+'</div>';
            member += '<div class="mem-num"><?php echo __("Member #","clients")?>: '+data.member_number+'</div>';
            member += '<div class="mem-pass"><?php echo __("Password","clients")?>: '+data.password+'</div>';
            member += '</div>';
           $('body').append(member);
        }).fail(function(data) {
          data.message = 'FAIled';
          console.log(data);
        });
     });
       
     </script>
 
<?php else: ?>
  <div class="panel panel-default">
    <div class="panel-body"><?php echo __('No Membership information', 'clients') ?></div>
  </div>
<?php endif; ?>