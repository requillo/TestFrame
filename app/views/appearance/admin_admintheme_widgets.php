<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <?php // print_r($saved_widgets); ?>
  <?php // print_r($main_widgets); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-danger">
        <div class="panel-body">
          <?php echo __('Please drag application or plugin widgets to the theme widget positions');?>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4 class="truncate"><?php echo __('Application & plugin widgets');?></h4></div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4 class="truncate"><?php echo __('Theme widget positions');?></h4></div>
    <?php if(!empty($main_widgets) || !empty($plugin_widgets)) { ?>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <?php foreach ($main_widgets as $key => $value) { ?>
    <div class="panel panel-default">
            <div class="panel-heading"><?php echo $value['main-name'] ?></div>
            <div class="panel-body">
              <div class="dd add-widg" id="<?php echo $value['name'] ?>">
                <ol class="dd-list" >
                <?php foreach ($value['widget'] as $val) { ?>
                <li class="dd-item pos-rel" data-widget="<?php echo $val['link'] ?>">
                  <div class="dd-handle truncate"><?php echo $val['name'] ?></div>
                  <i class="fa fa-close del-item text-danger"></i>
                </li>
                <?php } ?>
              </ol>
              </div>
            </div>
          </div>
    <?php } ?>
    <?php foreach ($plugin_widgets as $key => $value) { ?>
    <div class="panel panel-default">
            <div class="panel-heading"><?php echo $value['plugin-name'] ?></div>
            <div class="panel-body">
              <div class="dd add-widg" id="<?php echo $value['plugin'] ?>">
                <ol class="dd-list" >
                <?php 
                foreach ($value['widget'] as $val) { ?>
                <li class="dd-item pos-rel" data-widget="<?php echo $val['link'] ?>">
                  <div class="dd-handle truncate"><?php echo $val['name'] ?></div>
                  <i class="fa fa-close del-item text-danger"></i>
                </li>
                <?php } 
                ?>
              </ol>
              </div>
            </div>
          </div>
    <?php } ?>
    </div>
    <?php } ?>
  
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
      
        <?php
        if($have_theme_widgets){
        $i = 1;
         foreach ($widgets as $key => $value) { ?>
        
          <div class="panel panel-default">
            <div class="panel-heading"><?php if(isset($value['name'])) echo $value['name'] ?></div>
            <div class="panel-body">
              <div><?php if(isset($value['description'])) echo $value['description'] ;?></div>
              <div class="dd add-widgets" id="<?php echo $key; ?>">
                <?php  if(isset($saved_widgets[$key]) && !empty($saved_widgets[$key]))  { ?>
              <ol class="dd-list" >
                 <?php  foreach ($saved_widgets[$key] as $k => $v) { 
                  $f = explode('/', $v['widget']);
                  ?>
                <li class="dd-item pos-rel" data-widget="<?php echo $v['widget']; ?>">
                  <div class="dd-handle truncate"><?php echo ucfirst(str_replace('_', ' ', $f[1])); ?></div><i class="fa fa-close del-item text-danger"></i></li>
                <?php  } ?>
              </ol>
                <?php  } else { ?>
                <div class="dd-empty"></div>
                <?php  } ?>
              </div>
            </div>
          </div>
        
        <?php 
        $i++;
      } 
      } else {
      ?>

      <?php 
      if(!empty($saved_widgets)){
      foreach ($saved_widgets as $key => $value) { ?>
        
          <div class="panel panel-default">
            <div class="panel-heading"><?php echo $key ?></div>
            <div class="panel-body">
              <div class="dd add-widgets" id="<?php echo $key; ?>">
                <?php  if(isset($saved_widgets[$key]) && !empty($saved_widgets[$key]))  { ?>
              <ol class="dd-list" >
                 <?php  foreach ($saved_widgets[$key] as $k => $v) { 
                  $f = explode('/', $v['widget']);
                  ?>
                <li class="dd-item pos-rel" data-widget="<?php echo $v['widget']; ?>">
                  <div class="dd-handle truncate"><?php echo ucfirst(str_replace('_', ' ', $f[1])); ?></div><i class="fa fa-close del-item text-danger"></i></li>
                <?php  } ?>
              </ol>
                <?php  } else { ?>
                <div class="dd-empty"></div>
                <?php  } ?>
              </div>
            </div>
          </div>
        
        <?php 
      } 
    }
      ?>

      <?php } ?>
        <textarea id="nestable-output" class="hide"></textarea>
    </div>
  </div>
</div>
<script type="text/javascript">
var updateOutput = function(e) {
console.log(e);
    var list = e.length ? e : $(e.target),
        output = list.data('output');
    if(window.JSON) {
       if(list.nestable('serialize')) {
        output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
      }
    } else {
        output.val('JSON browser support required.');
    }
};

var deletOutput = function(e) {
console.log(e);
    var list = e.length ? e : $(e.target),
        output = list.data('output');
    if(window.JSON) {
      if(list.nestable('serialize')) {
        output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        return window.JSON.stringify(list.nestable('serialize'));
      }
    } else {
        output.val('JSON browser support required.');
    }
};

var in_update = function(e) {
  // alert($(this).attr('id'));
  var i = $(this).attr('id');
  var p = $(this).closest('.panel-body');
  console.log(e);
    var list = e.length ? e : $(e.target),
        output = list.data('output');
    if(window.JSON) {
      var s = window.JSON.stringify(list.nestable('serialize'));
      output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
      var fdata = {
        'data[widget_id]' : i,
        'data[widget_data]': s
      }
      $.getJSON( Jsapi+"appearance/set-update-widgets/" , fdata, function( data ) {
      console.log(data);
      if(data.ok == 'success'){
        // location.reload();
      } 
    });
    } else {
        output.val('JSON browser support required.');
    }
};


    <?php if(!empty($main_widgets) || !empty($plugin_widgets)) { ?>
    
    <?php foreach ($main_widgets as $key => $value) { ?>
    $('#<?php echo $value['name'] ?>').nestable({
      group: 1,
      clone: true,
      insertable: false,
      maxDepth:1
    }).on('change', updateOutput);

    updateOutput($('#<?php echo $value['name'] ?>').data('output', $('#nestable-output')));

    <?php } ?>
    <?php foreach ($plugin_widgets as $key => $value) { ?>
    $('#<?php echo $value['plugin'] ?>').nestable({
      group: 1,
      clone: true,
      insertable: false,
      maxDepth:1
    }).on('change', updateOutput);

    updateOutput($('#<?php echo $value['plugin'] ?>').data('output', $('#nestable-output')));
              
    <?php } ?>
   
    <?php } ?>


 <?php 
 if($have_theme_widgets){
 foreach ($widgets as $key => $value) { ?>
   $('#<?php echo $key; ?>').nestable({
            group: 1,
            maxDepth:1
        }).on('change', in_update);
 updateOutput($('#<?php echo $key; ?>').data('output', $('#nestable-output')));
 <?php 
}
} else { ?>

 <?php 
if(!empty($saved_widgets)){
foreach ($saved_widgets as $key => $value) { ?>

  $('#<?php echo $key; ?>').nestable({
            group: 1,
            maxDepth:1
        }).on('change', in_update);
 updateOutput($('#<?php echo $key; ?>').data('output', $('#nestable-output')));

<?php } } } ?>

$(document).on('click','.del-item', function(){
  var p = $(this).closest('.add-widgets');
  var i = p.attr('id');
  $(this).closest('.dd-item').remove();
  var a = p.find('.dd-item');
  if(a.length < 1) {
    p.html('<div class="dd-empty"></div>');
  }
  var b = deletOutput($('#'+i).data('output', $('#nestable-output')));
  var fdata = {
        'data[widget_id]' : i,
        'data[widget_data]': b
      }
      $.getJSON( Jsapi+"appearance/set-update-widgets/" , fdata, function( data ) {
      console.log(data);
      if(data.ok == 'success'){
        // location.reload();
      } 
    });
});
</script>