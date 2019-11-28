<?php 
if(count($langs) > 1) {
  $hide = '';
} else {
   $hide = 'hide';
}
?>
<form method="post">

<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-8 col-md-6">
         <div class="<?php echo $hide ?>" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab1" class="nav nav-tabs bar_tabs" role="tablist">
        <?php $i = 1;
        foreach ($langs as $key => $value) {
          if($i == 1) {
            $active = 'active';
          } else {
            $active = '';
          }
            echo '<li role="presentation" class="'.$active.'"><a href="#send_html-'.$key.'" data-toggle="tab" aria-expanded="false">'.$key.'</a></li>';
            $i++;
        } ?>
      </ul></div>
       </div>
      <div class="col-lg-4 col-md-6 text-right">
       <?php $form->input('save',array('value' => __('Save configuration'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>
       <a class="btn btn-danger" href="<?php echo admin_url('web-forms/'); ?>"><?php echo __('Cancel'); ?></a>
      </div>
    </div>  
</div>
<div class="container-fluid"> 
  
      <div class="row">
        <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
          <div id="myTabContent" class="tab-content">
            <?php 
            $i = 1;
          foreach ($langs as $key => $value) {
            if($value == 'en_US') {
              $value = 'en_EN';
            }
              if($i == 1) {
            $active = 'active in';
          }  else {
            $active = '';
          }
           echo ' <div role="tabpanel" class="tab-pane '.$active.'" id="send_html-'.$key.'">'

            ?>

          <div class="panel panel-default">
            <div class="panel-heading">
              <h2><?php echo __('Send mail message'); ?></h2>
            </div>
            <div class="panel-body">
              <p class="app-desc">
                <div><?php echo __('Design layout and data of your mail. This is for the content of your mail. Use the following shortcodes to add form data to your message');?></div>
                <div><?php echo $Shortcodes; ?></div>
              </p>
        
       
          <?php
            echo ' 
            <textarea name="data[send_html]['.$key.']" class="full-editor">'.language_content($FormData['send_message'],$key).'</textarea>';
            
          ?>
            </div>
          </div>
           <div class="panel panel-default">
            <div class="panel-heading">
              <h2><?php echo __('Thank you message for the website'); ?></h2>
            </div>
            <div class="panel-body">
              <p class="app-desc">
                 <div><?php echo __('Design your thank you message for when people submit your form.'); ?></div>
                 <div><?php echo $Shortcodes; ?></div> 
              </p>
       
           <?php 
            echo '
            <div class="form-group"><label for="input_tk_title" class="main-form-label">'.__('Page title',NULL,$value).'</label>
            <input id="input_tk_title" name="data[tk_title]['.$key.']" class="form-control" type="text" value="'.language_content($FormData['thank_you_title'],$key).'"></div>';
            echo '<div class="form-group"><label for="input_tk_title" class="main-form-label">'.__('Message',NULL,$value).'</label>
            <textarea name="data[thank_you]['.$key.']" class="full-editor">'.language_content($FormData['thank_you_message'],$key).'</textarea></div>';
           
          ?>
             </div>
            </div></div>
            <?php  $i++; }  // end her?>
</div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h2><?php echo __('Send mail from'); ?></h2>
            </div>
            <div class="panel-body">
              <?php if($smtp){ ?>
          <label><?php echo __('Use SMTP'); ?></label> 
          <?php 
               if($FormData['use_smpt'] == 1) {
                $checked = 'checked';
               } else {
                $checked = '';
               }
               $form->input('use_smpt',array('type'=>'checkbox','class'=>'js-switch smtp-use', 'no-wrap' => true,'attribute'=>$checked)); 
               ?>
               <?php } ?>
          <?php $form->input('send_email_address',array('label' => __('E-mail address'),'value' => $FormData['send_email_address'])); ?>
          <?php if($smtp){ ?>
          <?php $form->input('send_email_pass',array('label' => __('E-mail password'),'value' => $FormData['send_email_pass'])); ?>
           <?php } ?>
          </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
              <h2><?php echo __('Send mail to'); ?></h2>
            </div>
            <div class="panel-body">
          <?php $form->input('mailto_address',array('label' => __('Mail to'),'lable' => __(''),'value' => $FormData['mailto_address'])); ?>
          <?php $form->input('cc_address',array('label' => __('CC'),'value' => $FormData['cc_address'])); ?>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2><?php echo __('Form preview'); ?>
            <a class="pull-right btn btn-success" href="<?php echo admin_url('forms/edit/'.$Id) ?>"><i class="fa fa-edit"></i> Edit</a>
            </h2>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                 <p class="app-desc"><?php echo __('This is a preview of your'); ?> <strong><?php echo $FormData['name'] ?></strong></p>
                  <p class="app-desc"><?php echo __('Use the shortcode to get the form data when you design your mail message or thank you message. e.g.'); ?> <strong><?php echo __(' {input-name}') ?></strong></p>
                <?php echo $TheForm; ?>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
</div>
</form>
<pre>
	<?php 
  $currentDomain = preg_replace('/www\./i', '', $_SERVER['SERVER_NAME']);
  echo $currentDomain . '<br><br>';
	$theform = language_content($FormData['inputs']);
	$theforminputs = json_decode($theform, true);

	// print_r($theforminputs); 
	?>
</pre>

<?php  ?>

<script type="text/javascript">
jQuery(function($) {

tinymce.init({
  selector: '.full-editor',
  height: 500,
  menubar: false,
  relative_urls: false,
  remove_script_host: false,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview anchor textcolor emoticons',
    'searchreplace visualblocks code fullscreen table ',
    'insertdatetime media table contextmenu paste code help wordcount'
  ],
  toolbar: 'undo redo |  formatselect | bold italic forecolor backcolor emoticons | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table  | removeformat | help',
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css']
});

tinymce.init({
  selector: '.minimal-editor',
  height: 500,
  menubar: false,
  relative_urls: false,
  remove_script_host: false,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview anchor textcolor emoticons',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code help wordcount'
  ],
  toolbar: ' formatselect | bold italic alignleft aligncenter alignright alignjustify | table ',
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css']
});

});
</script>