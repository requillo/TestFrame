<?php 
if(count($langs) > 1) {
  $hide = '';
} else {
   $hide = 'hide';
}
?>
<div class="loadmsg"></div>
<?php $form->create(array('class' => 'no-enter')) ?>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="<?php echo $hide ?>" role="tabpanel" data-example-id="togglable-tabs">
        <ul id="myTab1" class="nav nav-tabs bar_tabs" role="tablist">
            <?php $i = 1;
            foreach ($langs as $key => $value) {
              if($key == $current_lang) {
                $active = 'active';
              } else {
                $active = '';
              }
                echo '<li role="presentation" class="'.$active.'"><a href="#send_html-'.$key.'" data-toggle="tab" aria-expanded="false">'.$key.'</a></li>';
                $i++;
            } ?>
          </ul>
      </div>
      </div>
  </div>
</div>
<div class="container-fluid"> 
<div class="panel panel-default">
<div class="panel-body">
  <div class="row">
    <div class="col-lg-8 col-md-7 col-sm-6 col-xs-12"> 
      <div id="myTabContent" class="tab-content">
      <?php $i = 1;
      foreach ($langs as $key => $value) { 
         if($key == $current_lang) {
            $active = 'active in';
          }  else {
            $active = '';
          }
          echo ' <div role="tabpanel" class="tab-pane '.$active.'" id="send_html-'.$key.'">'
        ?>
      <?php // $form->input('title',array('label' => __('Page title'), 'value' => $page['title'])) ?>
      <div class="lang-holder">
      <div class="form-group">
        <label for="input-title-<?php echo $key;?>"><?php echo __('Page title') ?></label>
      <input type="text" name="data[lang-title][<?php echo $key;?>]" class="form-control input-title" id="input-title-<?php echo $key;?>" value="">
      </div>
          <textarea name="data[lang-content][<?php echo $key;?>]" class="editor"></textarea>
        </div></div>
        <?php $i++;
      } ?>
    </div>
    </div>
    <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
     <?php if(!empty($Formsoptions)){?>
    <div class="panel panel-default">
      <div class="panel-heading"><h3><?php echo __('Forms') ?></h3></div>
      <div class="panel-body">
        <select name="data[form]" class="form-control">
          <?php echo $form->options($Formsoptions,array('key' => $page['forms'])); ?>
        </select>
      </div>
    </div>
     <?php } ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="form-group">
        <?php $form->submit(__('Save'),'btn btn-success') ?>
      </div>
    </div>
  </div>
  </div>
  </div>
</div>
</form>