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
?>
<div class="container-fluid">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
            <div class="profile_img">
              <div id="crop-avatar">
                <!-- Current avatar -->
                <?php if($Client['profile_picture'] != ''): ?>
                <img class="img-responsive avatar-view" src="<?php echo get_protected_media($Client['profile_picture']);?>" alt="" title="<?php echo $Client['l_name'] . ' ' . $Client['f_name'];?>">
                <?php else: ?>
                  <?php if($Client['gender'] == 1):?>
                <img class="img-responsive avatar-view" src="<?php echo URL .'app/plugins/clients/assets/img/profile-male.jpg';?>" alt="" title="<?php echo $Client['l_name'] . ' ' . $Client['f_name'];?>">   
                  <?php else: ?>
                <img class="img-responsive avatar-view" src="<?php echo URL .'app/plugins/clients/assets/img/profile-female.jpg';?>" alt="" title="<?php echo $Client['l_name'] . ' ' . $Client['f_name'];?>">
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            </div>
            <h3><?php echo $html->admin_link('<i class="fa fa-pencil"></i>','clients/edit/'.$Client['id'].'/',array('class'=>'no-print pull-right btn btn-success btn-xs')) ?></h3>
            <h3><?php echo $Client['l_name'] . ', ' . $Client['f_name'];?></h3>
            <?php if($Client['position'] != '' || $Client['company'] != '' ): ?>
            <ul class="list-unstyled user_data">
             <?php if($Client['company'] != '' ): ?>
              <li>
                <i class="fa fa-university"></i> <strong>
                <?php echo $html->admin_link($Client['company'],'clients/company/?c='.$Client['company']);?>
                </strong>
              </li>
               <?php endif; ?>
               <?php if($Client['position'] != '' ): ?>
              <li>
                <i class="fa fa-briefcase"></i> <strong><?php echo $Client['position'] ;?></strong>
              </li>
               <?php endif; ?>
            </ul>
            <?php endif; ?>
            <!-- start Personal information -->
            <h4><?php echo __('Personal information','clients') ?></h4>
            <ul class="list-unstyled user_data">
            <?php if($Client['country'] != ''): ?>
              <li>
                <p><strong><?php echo __('Country','clients') ?></strong></p>
                <div><?php echo $Client['country'] ?></div>
              </li>
            <?php endif; ?>
             <?php if($Client['district'] != ''): ?>
              <li>
                <p><strong><?php echo __('District','clients') ?></strong></p>
                <div><?php echo $Client['district'] ?></div>
              </li>
            <?php endif; ?>
            <?php if($Client['city'] != ''): ?>
              <li>
                <p><strong><?php echo __('City / Residential area','clients') ?></strong></p>
                <div><?php echo $Client['city'] ?></div>
              </li>
            <?php endif; ?>
            <?php if($Client['address'] != ''): ?>
              <li>
                <p><strong><?php echo __('Address','clients') ?></strong></p>
                <div><?php echo $Client['address'] ?></div>
              </li>
            <?php endif; ?>
            <?php if($Client['telephone'] != ''): ?>
              <li>
                <p><strong><?php echo __('Telephone','clients') ?></strong></p>
                <div><?php echo $Client['telephone'] ?></div>
              </li>
            <?php endif; ?>
             <?php if($Client['nationality'] != ''): ?> 
              <li>
                <p><strong><?php echo __('Nationality','clients') ?></strong></p>
                <div><?php echo $Client['nationality'] ?></div>
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
            <?php 
            $ef = 0;
            foreach ($Extra_fields as$value){
              if($value['meta']['value'] != '') {
                $ef++;
              }
            }
            if(!empty($Extra_fields) && $ef > 0): ?>
            <h4><?php echo __('Extra information','clients') ?></h4>
            <ul class="list-unstyled user_data">
               <?php foreach ($Extra_fields as $value) {
                if($value['meta']['value'] != '') {
                   echo '<li><p><strong>'. $value['name'] . '</strong></p>';
                   echo '<div>'. $value['meta']['value'] . '</div></li>';
                }
               } ?>
            <?php endif; ?>
            </ul>
            <!-- end of Personal information -->
            <?php widget('clients','memberships',$Client['id']);?>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="profile_title">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2><?php echo __('Passport','clients') ?> <?php echo $html->admin_link(__('Add Passport','clients'),'clients/add-passport/'.$Client['id'].'/',array('class' => 'btn btn-success btn-xs pull-right'));?></h2>
              </div>
            </div>
            <?php if(!empty($Passports)): ?>
             <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  
                  <div id="users-table" class="panel panel-default">
                    <div class="table-responsive">
                      <table id="all-users" class="table table-striped bulk_action">          
                      <thead>
                        <tr>
                        <th style="width: 35px"><i class="fa fa-pencil"></i></th>
                        <th><?php echo __('Passport #','clients') ?></th>
                        <th><?php echo __('Issued','clients') ?></th>
                        <th><?php echo __('Expire','clients') ?></th>
                        <th><?php echo __('Type','clients') ?></th>
                        <th class="text-right"><i class="fa fa-trash"></i></th>
                      </tr>
                      </thead>
                      <tbody>

                      <?php foreach ($Passports as $Passport) { ?>

                      <tr>
                       <td><?php echo $html->admin_link('<i class="fa fa-edit text-success"></i> ','clients/edit-passport/'.$Passport['id'].'/');?></td>
                        <td><?php 
                        if($Passport['copy_document'] !='') {
                          echo '<a href="'. get_protected_media($Passport['copy_document']) .'" target="_blank">'. $Passport['passport_number'] .'</a>';
                        } else { 
                          echo $Passport['passport_number'];
                        }
                        ?></td>
                        <td><?php echo date('d-m-Y', strtotime($Passport['start_date'])) ?></td>
                        <td><?php echo date('d-m-Y', strtotime($Passport['end_date'])) ?></td>
                        <td>
                          <?php echo $Passport_type[$Passport['passport_type']];?>
                        </td>
                        <td class="text-right"> 
                        <?php echo $html->admin_link('<i class="fa fa-close text-danger"></i>','clients/delete-passport/'.$Passport['id'].'/','confirm');?>
                        </td>
                      </tr> 

                       <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                        <th><i class="fa fa-pencil"></i></th>
                        <th><?php echo __('Passport #','clients') ?></th>
                        <th><?php echo __('Issued','clients') ?></th>
                        <th><?php echo __('Expire','clients') ?></th>
                        <th><?php echo __('Type','clients') ?></th>
                        <th class="text-right"><i class="fa fa-trash"></i></th>
                      </tr>
                      </tfoot>
                      </table>
                    </div>

                  </div>
                </div>
              </div>
            <?php else: ?>
              <div class="panel panel-default">
                <div class="panel-body"><?php echo __('No Passport information', 'clients') ?></div>
              </div>
            <?php endif; ?>
            <div class="profile_title">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2><?php echo __('Insurance','clients') ?> <?php echo $html->admin_link(__('Add Insurance','clients'),'clients/add-insurance/'.$Client['id'].'/',array('class' => 'btn btn-success btn-xs pull-right'));?></h2>
              </div>
            </div>
            <?php if(!empty($Insurance)): ?>
              <div class="panel panel-default">
                <div class="panel-body"></div>
              </div>
            <?php else: ?>
              <div class="panel panel-default">
                <div class="panel-body"><?php echo __('No Insurance information', 'clients') ?></div>
              </div>
            <?php endif; ?>
          <div class="profile_title">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2><?php echo __('Visas','clients') ?> <?php echo $html->admin_link(__('Add Visa','clients'),'clients/add-visa/'.$Client['id'].'/',array('class' => 'btn btn-success btn-xs pull-right'));?></h2>
              </div>
            </div>
            <?php if(!empty($Visas)): ?>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  
                  <div id="users-table" class="panel panel-default">
                    <div class="table-responsive">
                      <table id="all-users" class="table table-striped bulk_action">          
                      <thead>
                        <tr>
                        <th style="width: 35px"><i class="fa fa-pencil"></i></th>
                        <th><?php echo __('Visa','clients') ?></th>
                        <th><?php echo __('Issued','clients') ?></th>
                        <th><?php echo __('Expire','clients') ?></th>
                        <th class="text-right"><i class="fa fa-trash"></i></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($Visas as $Visa) { ?>
                      <tr>
                        <td><?php echo $html->admin_link('<i class="fa fa-edit text-success"></i>','clients/edit-visa/'.$Visa['id'].'/');?></td>
                        <td><?php 
                        if($Visa['copy_document'] !='') {
                          echo '<a href="'. get_protected_media($Visa['copy_document']) .'" target="_blank">'. $Visa['name'] .'</a>';
                        } else { 
                          echo $Visa['name'];
                        }
                        ?></td>
                        <td><?php echo date('d-m-Y', strtotime($Visa['start_date']));?></td>
                        <td><?php echo date('d-m-Y', strtotime($Visa['end_date']));?></td>
                        <td class="text-right">
                          <?php echo $html->admin_link('<i class="fa fa-close text-danger"></i>','clients/delete-visa/'.$Visa['id'].'/','confirm');?>
                        </td>
                      </tr> 

                       <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                        <th><i class="fa fa-pencil"></i></th>
                        <th><?php echo __('Visa','clients') ?></th>
                        <th><?php echo __('Issued','clients') ?></th>
                        <th><?php echo __('Expire','clients') ?></th>
                        <th class="text-right"><i class="fa fa-trash"></i></th>
                      </tr>
                      </tfoot>
                      </table>
                    </div>

                  </div>
                </div>
              </div>
            <?php else: ?>
              <div class="panel panel-default">
                <div class="panel-body"><?php echo __('No Visa information', 'clients') ?></div>
              </div>
            <?php endif; ?>

            <div class="profile_title">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2><?php echo __('Tickets','clients') ?> <?php echo $html->admin_link(__('Add Tickets','clients'),'clients/add-ticket/'.$Client['id'].'/',array('class' => 'btn btn-success btn-xs pull-right'));?></h2>
              </div>
            </div>
            <?php if(!empty($Tickets)): ?>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  
                  <div id="users-table" class="panel panel-default">
                    <div class="table-responsive">
                      <table id="all-users" class="table table-striped bulk_action">          
                      <thead>
                        <tr>
                        <th style="width: 35px"><i class="fa fa-pencil"></i></th>
                        <th><?php echo __('Ticket #','clients') ?></th>
                        <th><?php echo __('Departure','clients') ?></th>
                        <th><?php echo __('Return','clients') ?></th>
                        <th><?php echo __('Travel','clients') ?></th>
                        <th style="width: 80px"  class="text-right"><?php echo __('Price','clients') ?></th>
                        <th style="width: 80px"><?php echo __('Status','clients') ?></th>
                        <th style="width: 35px" class="text-right"><i class="fa fa-trash"></i></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($Tickets as $Ticket) { ?>
                      <tr>
                        <td><?php echo $html->admin_link('<i class="fa fa-edit text-success"></i>','clients/edit-ticket/'.$Ticket['id'].'/');?></td>
                        <td><?php 
                        if($Ticket['copy_document'] !='') {
                          echo '<a href="'. get_protected_media($Ticket['copy_document']) .'" target="_blank">'. $Ticket['ticket_number'] .'</a>';
                        } else { 
                          echo $Ticket['ticket_number'];
                        }
                        ?></td>
                         <td><?php echo date('d-m-Y', strtotime($Ticket['start_date'])) ?></td>
                        <td><?php echo date('d-m-Y', strtotime($Ticket['end_date'])) ?></td>
                        <td><?php echo $Travel_type[$Ticket['ticket_type']]; ?></td>
                         <td  class="text-right"><?php echo $Travel_currency[$Ticket['currency']]; ?> <?php echo $Ticket['amount']; ?></td>
                        <td><?php echo $Travel_status[$Ticket['travel_status']]; ?></td>
                        <td class="text-right">
                          <?php echo $html->admin_link('<i class="fa fa-close text-danger"></i>','clients/delete-ticket/'.$Ticket['id'].'/','confirm');?>
                        </td>
                      </tr>
                       <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                        <th><i class="fa fa-pencil"></i></th>
                        <th><?php echo __('Ticket #','clients') ?></th>
                         <th><?php echo __('Departure','clients') ?></th>
                        <th><?php echo __('Return','clients') ?></th>
                        <th><?php echo __('Travel','clients') ?></th>
                        <th  class="text-right"><?php echo __('Price','clients') ?></th>
                        <th><?php echo __('Status','clients') ?></th>
                        <th class="text-right"><i class="fa fa-trash"></i></th>
                      </tr>
                      </tfoot>
                      </table>
                    </div>

                  </div>
                </div>
              </div>
            <?php else: ?>
              <div class="panel panel-default">
                <div class="panel-body"><?php echo __('No Tickets information', 'clients') ?></div>
              </div>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  </div>
 </div>
</div>