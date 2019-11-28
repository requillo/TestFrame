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
      <input type="text" name="data[lang-title][<?php echo $key;?>]" class="form-control input-title" id="input-title-<?php echo $key;?>" value="<?php echo language_content($page['title'],$key); ?>">
      </div>
      <div class="form-group show-page-link">
        <span class="link-desc"><?php echo __('Link');?>: </span><span class="page-main-link"><?php echo url();?></span><a class="slug-elm edit-slug"><?php echo $page['slug']; ?></a><span class="link-end-splitter">/</span> <a target="_blank" href="<?php echo url($page['slug']);?>" class="btn btn-primary btn-sm btn-level"><?php echo __('View')?></a>
      </div>
      <div class="form-group input-group-sm edit-page-link hide">
        <span class="link-desc"><?php echo __('Link');?>: </span><span class="page-main-link"><?php echo url();?></span><input class="form-control input-inline editslug" type="text" value="<?php echo $page['slug']; ?>"><span class="link-end-splitter">/</span> <a class="update-slug btn btn-primary btn-sm btn-level"><?php echo __('Update')?></a>
        <input class="form-control input-inline hide original-slug" type="text" value="<?php echo $page['slug']; ?>">
      </div>
          <textarea name="data[lang-content][<?php echo $key;?>]" class="editor"><?php echo language_content($page['content'],$key); ?></textarea>
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
<script type="text/javascript">
  var url = $('base').attr('href');
  $('.edit-slug').on('click', function(){
    $('.show-page-link').addClass('hide');
    $('.edit-page-link').removeClass('hide');

  });

  $('.update-slug').on('click', function(){
    var u = url + 'api/json/pages/check-slug/';
    // alert(u);
    var p = $(this).closest('.lang-holder');
    var se = p.find(".slug-elm");
    var si = p.find(".editslug");
    var os = p.find(".original-slug");
    var pt = p.find(".input-title");
    var fdata = {
      'data[id]' : '<?php echo $page['id']; ?>',
      'data[slug]' : si.val(),
      'data[title]' : pt.val(),
      'data[original]' : os.val()
    }
    $.ajax({
      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url     : u, // the url where we want to POST
      data    : fdata, // our data object
      dataType  : 'json', // what type of data do we expect back from the server
      encode    : true
    }).done(function(data) {
      $('.editslug').val(data.slug);
      $('.slug-elm').text(data.slug);
      $('.show-page-link').removeClass('hide');
      $('.edit-page-link').addClass('hide');
      console.log(data);
    }).fail(function(data) {
      console.log(data);
    });
  });


  
</script>
