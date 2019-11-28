<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$sub = $id;
?>
  <?php // print_r($user_roles) ?>
  <?php // print_r($pages_not_allowed) ?>
  <?php // print_r($plugins) ?>
  <?php if(!empty($_POST)) {
   // print_r($_POST);
  } ?>
<form method="post">
<input name="data[set]" value="<?php echo $id; ?>" class="hide" id="input-set-roles">
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 text-right">
      <button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo __('Save') ?></button>
      <div class="form-group"></div>
    </div>
  </div>
</div>
<div class="container-fluid settings-pages-roles">
  <div class="panel panel-default">
    <div class="panel-body">
  <div class="row">
    <div class="col-xs-12"></div>
    <div class="col-xs-12">
      <p>
        <?php echo __('Here you can configure which usergroups are allowed to view certain pages or plugins.');?><br>
        <?php echo __("Please select the pages you don't want the usergroups to see.");?>
      </p>
    </div>
    <div class="col-xs-3">
      <ul id="side-tabs" class="nav nav-pills nav-stacked select-roles">
      <?php foreach ($user_roles as $user): ?>
        <li class="<?php if($id == $user['role_level']) echo 'active';?>">
          <a href="#<?php echo str_replace(array('.',' '), '_', $user['role_name'])?>" data-toggle="tab" data-id="<?php echo $user['role_level'] ?>" aria-expanded="true"><?php echo $user['role_name'] ?></a></li>
      <?php 
      endforeach; 
      ?>
      </ul>
    </div>
    <div class="col-xs-9">
      <!-- Tab panes -->
      <div class="tab-content">
      <?php 
      $i = 1;
      foreach ($user_roles as $user ):  
      ?>
        <div class="tab-pane <?php if($id == $user['role_level']) echo 'active';?>" 
          id="<?php echo str_replace(array('.',' '), '_', $user['role_name']) ?>">
          <h3><?php echo $user['role_name'] ?></h3>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <p class="lead"><?php echo __('Main Application pages') ?></p>
          <div class="form-group">
            <ul>
            <?php foreach ($pages as $k => $val) { 
              $as = 0;
              $ie = 0;
               
              foreach ($val['pages'] as $a => $b) {
               if(is_array($b)) {
               
                 foreach ($b as $c) { 
                  
                   if(isset($pages_not_allowed[$user['role_level']]) && in_array($c['link'], $pages_not_allowed[$user['role_level']])) {
                      $as++;
                      $ie++;
                    } else {
                      $ie++;

                    } 
                 }
               }

              }
             
              if($as == $ie) {
                $pcc = 'all-checked';
                $icon = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
              } else {
                $pcc = '';
                $icon = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
              }
              

              ?>
              <li class="page-name main-set">
                <span class="<?php echo $pcc?>" data-toggle="tooltip" data-title="<?php echo __('Click to select or remove all'); ?>">
                  <?php echo $icon.' '. $val['page-name']; ?>
                </span> 
              
                <?php if(is_array($val['pages'])) { ?>
                <ul class="set-pages main-pages">
                  <?php foreach ($val['pages'] as $a => $b) { ?>
                    <?php if($a == 'admin') { ?>
                    <li class="set-pages-admin"><?php echo __('Admin pages'); ?>
                      <ul class="sub-admin">
                      <?php foreach ($val['pages']['admin'] as $c => $d) {
                        if(isset($pages_not_allowed[$user['role_level']]) && in_array($d['link'], $pages_not_allowed[$user['role_level']])) {
                          $checked = 'checked';
                          $picon = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                        } else {
                          $checked = '';
                          $picon = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                        }
                         $pid = str_replace('/', '-', $d['link']).str_replace(array('.0'), '', $user['role_level']).$a;
                        ?>
                        <li class="admin-page">
                          <div><input class="p-add-remove hide" id="<?php echo $pid; ?>" type="checkbox" name="data[page][<?php echo $user['role_level']; ?>][]" value="<?php echo $d['link']; ?>" <?php echo $checked; ?> > 
                            <label for="<?php echo $pid; ?>"><?php echo $picon .' '. $d['name']; ?></label>
                            </div>    
                        </li>
                      <?php } ?>
                        </ul>
                        </li>
                    <?php } else if ($a == 'widget'){ ?>
                      <li class="set-pages-widget"><?php echo __('Widgets'); ?>
                      <ul class="sub-widget">
                      <?php foreach ($val['pages']['widget'] as $c => $d) { 
                       
                        if(isset($pages_not_allowed[$user['role_level']]) && in_array($d['link'], $pages_not_allowed[$user['role_level']])) {
                          $checked = 'checked';
                           $picon = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                        } else {
                          $checked = '';
                           $picon = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                        }
                         $pid = str_replace('/', '-', $d['link']).str_replace(array('.0'), '', $user['role_level']).$a;
                        ?>
                        <li class="admin-page">
                          <div><input class="p-add-remove hide" id="<?php echo $pid; ?>" type="checkbox" name="data[page][<?php echo $user['role_level']; ?>][]" value="<?php echo $d['link']; ?>" <?php echo $checked; ?>> 
                            <label for="<?php echo $pid; ?>"><?php echo  $picon .' '. $d['name']; ?></label></div>    
                        </li>
                      <?php } ?>
                        </ul>
                        </li>
                    <?php } else if ($a == 'rest'){ ?>
                      <li class="set-pages-rest"><?php echo __('Restfull, Json or Ajax pages'); ?>
                      <ul class="sub-widget">
                      <?php foreach ($val['pages']['rest'] as $c => $d) { 
                       
                        if(isset($pages_not_allowed[$user['role_level']]) && in_array($d['link'], $pages_not_allowed[$user['role_level']])) {
                          $checked = 'checked';
                          $picon = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                        } else {
                          $checked = '';
                           $picon = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                        }
                         $pid = str_replace('/', '-', $d['link']).str_replace(array('.0'), '', $user['role_level']).$a;
                        ?>
                        <li class="admin-page">
                          <div><input class="p-add-remove hide" id="<?php echo $pid; ?>" type="checkbox" name="data[page][<?php echo $user['role_level']; ?>][]" value="<?php echo $d['link']; ?>" <?php echo $checked; ?>> 
                            <label for="<?php echo $pid; ?>"><?php echo  $picon .' '. $d['name']; ?></label></div>    
                        </li>
                      <?php } ?>
                        </ul>
                        </li>
                    <?php } ?>
                  <?php } ?>
                </ul>
                <?php } ?>

              </li>
          <?php } ?>
          </ul>
          <?php // echo $user['role_data'] ?>
          </div>
          </div>
           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <p class="lead"><?php echo __('Plugins') ?></p>
          <div class="form-group">
             <ul>
            <?php 
            if(!empty($plugins)) {
            foreach ($plugins as $k => $val) { ?>
                <?php 
                $as = 0;
                $ie = 0;

                if($val['status'] == 'disabled') { 
                $disabled = '<small class="text-danger">('. __('Plugin is disabled').')</small>';
                $class = 'bg-warning';
                 } else {
                $disabled = '';
                $class = '';
                } 
                foreach ($val['pages'] as $a => $b) { 

                  foreach ($b as $f) {
                    if(isset($pages_not_allowed[$user['role_level']]) && in_array($f['link'], $pages_not_allowed[$user['role_level']])) {
                      $as++;
                      $ie++;
                    } else {
                      $ie++;
                    }
                  }
                }

              if($as == $ie) {
                $pcc = 'all-checked';
                $icon = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
              } else {
                $pcc = '';
                $icon = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
              }

                 ?>
              <li class="plugin-name main-set <?php echo $class; ?>">
                <span class="<?php echo $pcc?>" data-toggle="tooltip" data-title="<?php echo __('Click to select or remove all'); ?>"> 
                  <?php echo $icon .' '. $val['plugin-name']; ?> 
                </span> <?php echo  $disabled; ?>
                <?php if(is_array($val['pages'])) { ?>
                <ul class="set-pages plugin-pages">
                  <?php foreach ($val['pages'] as $a => $b) { 


                    ?>
                    <?php if($a == 'admin') { ?>
                    <li class="set-pages-admin"><?php echo __('Admin pages'); ?>
                      <ul class="sub-admin">
                      <?php foreach ($val['pages']['admin'] as $c => $d) { 
                        $pid = str_replace('/', '-',  $d['link']).str_replace(array('.0'), '', $user['role_level']).$a;;
                        if(isset($pages_not_allowed[$user['role_level']]) && in_array($d['link'], $pages_not_allowed[$user['role_level']])) {
                          $checked = 'checked';
                          $picon = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                        } else {
                          $checked = '';
                          $picon = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                        }

                        ?>
                        <li class="admin-page">
                          <div><input class="p-add-remove hide" id="<?php echo $pid; ?>" type="checkbox" name="data[page][<?php echo $user['role_level']; ?>][]" value="<?php echo $d['link']; ?>" <?php echo $checked; ?>> 
                            <label for="<?php echo $pid; ?>"><?php echo $picon .' '. $d['name']; ?></label></div>    
                        </li>
                      <?php } ?>
                        </ul>
                        </li>
                    <?php } else if ($a == 'widget'){ ?>
                      <li class="set-pages-widget"><?php echo __('Widgets'); ?>
                      <ul class="sub-widget">
                      <?php foreach ($val['pages']['widget'] as $c => $d) { 
                        $pid = str_replace('/', '-',  $d['link']).str_replace(array('.0'), '', $user['role_level']).$a;;
                        if(isset($pages_not_allowed[$user['role_level']]) && in_array($d['link'], $pages_not_allowed[$user['role_level']])) {
                          $checked = 'checked';
                          $picon = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                        } else {
                          $checked = '';
                          $picon = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                        }

                        ?>
                        <li class="admin-page">
                          <div><input class="p-add-remove hide" id="<?php echo $pid; ?>" type="checkbox" name="data[page][<?php echo $user['role_level']; ?>][]" value="<?php echo $d['link']; ?>" <?php echo $checked; ?>> 
                            <label for="<?php echo $pid; ?>"><?php echo $picon .' '. $d['name']; ?></label></div>    
                        </li>
                      <?php } ?>
                        </ul>
                        </li>
                    <?php } else if ($a == 'rest'){ ?>
                      <li class="set-pages-rest"><?php echo __('Restfull, Json or Ajax pages'); ?>
                      <ul class="sub-widget">
                      <?php foreach ($val['pages']['rest'] as $c => $d) { 
                        $pid = str_replace('/', '-',  $d['link']).str_replace(array('.0'), '', $user['role_level']).$a;;
                        if(isset($pages_not_allowed[$user['role_level']]) && in_array($d['link'], $pages_not_allowed[$user['role_level']])) {
                          $checked = 'checked';
                          $picon = '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                        } else {
                          $checked = '';
                          $picon = '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                        }

                        ?>
                        <li class="admin-page">
                          <div><input class="p-add-remove hide" id="<?php echo $pid; ?>" type="checkbox" name="data[page][<?php echo $user['role_level']; ?>][]" value="<?php echo $d['link']; ?>" <?php echo $checked; ?>> 
                            <label for="<?php echo $pid; ?>"><?php echo $picon .' '. $d['name']; ?></label></div>    
                        </li>
                      <?php } ?>
                        </ul>
                        </li>
                    <?php } ?>
                  <?php } ?>
                </ul>
                <?php } ?>

              </li>
          <?php }} ?>
          </ul>
          <?php // echo $user['role_plugin_data'] ?>
          </div>
          </div>

        </div>
      <?php 
       $i++;
      endforeach; 
      ?>
      </div>
    </div>
     <div class="col-xs-12"><button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo __('Save') ?></button></div>
   </div>
</div>
</div>
</div>

</form>
<script type="text/javascript">
  $('.select-roles').on('click', 'a',function(){
    var i = $(this).attr('data-id');
    $('#input-set-roles').val(i);
  });
    $('.main-set').on('click','span', function(){
    var p = $(this).closest('.main-set');
      if ($(this).hasClass('all-checked')){
       $(this).removeClass('all-checked');
        p.find('input.p-add-remove').prop('checked',false);
        p.find('label i.fa').removeClass('fa-times text-danger');
        p.find('label i.fa').addClass('fa-check text-success');
        $(this).find('i.fa').removeClass('fa-times text-danger');
        $(this).find('i.fa').addClass('fa-check text-success');
       } else {
       $(this).addClass('all-checked');
       var a = p.find('input.p-add-remove');
        a.each(function(){
          if(!$(this).is(':checked')){
            p.find('input.p-add-remove').prop('checked',true);
          } 
        })
        p.find('label i.fa').addClass('fa-times text-danger');
        p.find('label i.fa').removeClass('fa-check text-success');
        $(this).find('i.fa').addClass('fa-times text-danger');
        $(this).find('i.fa').removeClass('fa-check text-success');
       }
    });

    $('.p-add-remove').on('click', function(){
      var c = $(this);
      var l = $(this).closest('li');
      var p = $(this).closest('.main-set');
      var a = p.find('input.p-add-remove');
      var i = 0;
      a.each(function(){
          if($(this).is(':checked')){
           i += 1;
          }
        })
      
      if($(this).is(':checked')){
          b = i;
          l.find('label i.fa').addClass('fa-times text-danger');
          l.find('label i.fa').removeClass('fa-check text-success');
        } else {
          b = i;
          l.find('label i.fa').removeClass('fa-times text-danger');
          l.find('label i.fa').addClass('fa-check text-success');
        }

        if(b ==  a.length) {
          p.find('span i.fa').addClass('fa-times text-danger');
          p.find('span i.fa').removeClass('fa-check text-success');
          p.find('span').addClass('all-checked');
        } else {
          p.find('span').removeClass('all-checked');
          p.find('span i.fa').removeClass('fa-times text-danger');
          p.find('span i.fa').addClass('fa-check text-success');
        }
    });
</script>