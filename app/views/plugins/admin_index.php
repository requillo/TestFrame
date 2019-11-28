<?php 
#echo '<pre>';
#print_r($plugins);
#echo '</pre>';
// print_r($Serverd_names);
?>
<div class="container-fluid">
	<?php echo $html->admin_link(__('Add plugin'),'plugins/add','btn btn-success pull-right'); ?>
</div>

<div class="container-fluid">

			<div class="flex-box">
			<?php 

			$plugin['version'] = '';
			foreach ($plugins as $plugin): 
			if(isset($plugin['version']) && $plugin['version'] == $plugin['db-version']) {
				$update_vers = '';
				$installed = true;
				$vers = $plugin['version'];
				$do = 'active';


			} else if(isset($plugin['version']) && $plugin['active'] == '' && $plugin['db-version'] == '' ) {
				$update_vers = '';
				$installed = false;
				$vers = $plugin['version'];
				$do = 'install';


			} else {
				if(isset($plugin['version'])) {
				$update_vers = '<span class="text-success">'.__('update to version') . ' '. $plugin['version'].'</span>';
				$installed = true;
				$vers = $plugin['db-version'];
				$do = 'update';
				} else {
				$do = '';
				$vers = '';
				$installed = false;
				$update_vers = '';
				}
			}
			$pname = str_replace('_', '-', $plugin['domain']);

			if(in_array($pname, $Serverd_names)) {
				$message = '<div class="text-center text-danger">'.__('The plugin class name').' <strong>"'.$plugin['domain'].'"</strong> '.__('is reserved.') .'<br>';
				$message .= __('Please use another class name for the plugin.').'</div>';
				$update_vers = '<span class="text-danger">'.__('Error encountered!').'</span>';
				$allow = false;
				$do = '';
			} else {
				$message = '';
				$allow = true;
			}

			if($plugin['active'] == 1) {
				$checked = 'checked';
			} else {
				$checked = '';
			}

			if($plugin['active'] < 1 && $plugin['active'] != ''){
				$deleteclass = '';
			} else {
				$deleteclass = ' hide';
			}



			?>

			<div class="flexwrap fl-col-3">
			<?php $form->create(array('action'=> url().'api/json/plugins/action/'));?>
				
					<div class="flex-heading"><h2><?php echo __($plugin['name'],$plugin['domain'])?> <small class="pull-right"><?php echo $update_vers;?></small></h2></div>
					<div class="flex-body">
					
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 img">
						<img src="<?php echo $plugin['img']; ?>">							
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
						<div class="msg"></div>
						
						
						<div><?php echo __('Developed by') ?>
						 <a href="<?php echo $plugin['author_link']?>" target="_blank">
						 	<?php if(isset($plugin['author'])) echo $plugin['author']?>
						 	</a></div>
						<div><?php if(isset($plugin['desc'])) echo __($plugin['desc'],$plugin['domain'])?></div>												
						<div><?php echo __('Version') . ': <span class="version">'. $vers;?></span></div>
						

						<div class="hide">
							<?php $form->input('id', array('value'=>$plugin['id'])); ?>
							<?php $form->input('plugin', array('value'=>$plugin['domain'])); ?>
							<?php $form->input('version',array('value'=>$plugin['version']));?>
							<?php $form->input('active',array('value'=>$plugin['active']));?>
							<?php $form->input('do',array('value'=>$do));?>
						</div>							
						</div>
						
					</div>
					
						
					
					</div>
					<div class="flex-footer">
						<div class="btn-area text-right">
						
						<?php echo $html->admin_link(__('Delete'),'plugins/delete/'.$plugin['id'].'/',array('class'=>'delete-btn btn btn-danger pull-left'.$deleteclass)); ?>
						<div class="pull-right the-btns">
						<?php if($installed && $allow && $do == 'active'): ?>
						<span class="pload xpad"></span>
						<label class="lpad"><input type="checkbox" class="cl-plugin js-switch" <?php echo $checked ?>/></label>
						<?php elseif($installed && $allow && $do=='update'):?>
						<span class="pload xpad"></span>
						<label><input type="checkbox" class="cl-plugin js-switch" <?php echo $checked ?>/></label>
						<span class="ploadi xpad"></span>
						<button class="btn btn-warning"><?php echo __('Update')?></button>
						<?php elseif($allow && $do != ''):?>
						<span class="ploadi xpad"></span>
						<button class="btn btn-success"><?php echo __('Install')?></button>
						<?php else:?>
						<?php echo $message;?>	
						<?php endif;?>
						</div>
					</div>

					</div>
				<?php $form->close(); ?>
			</div>
			
			<?php endforeach ;?>
				
			</div>
	
		
		
</div>

<script type="text/javascript">
var loader = '<div class="loaderwrap inline"><div class="the-loader text-success"></div></div>';
	// Activate plugin    
$('.flexwrap .text-right').on('click','span.switchery',function(){
      var p = $(this).closest('.flexwrap');
      var f = $(this).closest('form');
      var u = f.prop('action');
      var id = p.find('#input-id').val();
      var ac = p.find('#input-active').val();
      var d = p.find('#input-do').val();
      var myVar = '';
      
      p.find('.msg-text').remove();
      
      p.find('.text-right').prepend('<div class="phold"></div>');
      p.find('.pload').html(loader);
      var formdata = {
      'data[id]' : id,
      'data[active]' : ac,
      'data[do]' : 'active'
    }
    $.ajax({
      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url     : u, // the url where we want to POST
      data    : formdata, // our data object
      dataType  : 'json', // what type of data do we expect back from the server
      encode    : true
    }).done(function(data) {
      if(data.Key == 'Success') {
        console.log(data);
        
        if(data.Active == 1) {
            p.find('.msg').append('<div class="msg-text alert alert-success"></div>');
            p.find('.msg-text').text(data.Message);
            p.find('.delete-btn').addClass('hide');  
        } else {
            p.find('.msg').append('<div class="msg-text alert alert-danger"></div>');
            p.find('.msg-text').text(data.Message);
            p.find('.delete-btn').removeClass('hide');  
        }
        p.find('#input-active').val(data.Active);
        p.find('.pload').html('');
        var pathtopage = window.location.href;
        $('#main_admin_menu').load(pathtopage +  ' #main_admin_menu .main-nav');
        p.find('.phold').remove();
        /*var myVar = setTimeout(function() { 
          p.find('.msg').removeClass('success').text('');
          console.log(data);
        }, 3000);*/
      } else {
        p.find('.msg').append('<div class="msg-text alert alert-danger"></div>');
        p.find('.msg-text').text(data.Message);
        /*var myVar = setTimeout(function() { 
          p.find('.msg').removeClass('failed').text('');
          console.log(data);
        }, 3000);*/

      }
    }).fail(function(data) {
      console.log(data);
    });
    
    });

// Install plugin
$('.flexwrap .text-right').on('click','button',function(e){
    e.preventDefault();
    var p = $(this).closest('.flexwrap');
    var f = $(this).closest('form');
    var u = f.prop('action');
    var id = p.find('#input-id').val();
    var pl = p.find('#input-plugin').val();
    var ve = p.find('#input-version').val();
    var d = p.find('#input-do').val();
    var a = p.find('.delete-btn').prop('href');
    p.find('.msg-text').remove();
    p.find('.text-right').prepend('<div class="phold"></div>');
    p.find('.ploadi').html(loader);
    var formdata = {
      'data[id]' : id,
      'data[plugin]' : pl,
      'data[version]' : ve,
      'data[do]' : d
    }
    $.ajax({
      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url     : u, // the url where we want to POST
      data    : formdata, // our data object
      dataType  : 'json', // what type of data do we expect back from the server
      encode    : true
    }).done(function(data) {
     
      if(data.Key == 'Success') {
        console.log(data);
        p.find('.msg').append('<div class="msg-text alert alert-success"></div>');
        p.find('.msg-text').text(data.Message);
        p.find('#input-active').val('0');
        p.find('#input-id').val(data.Id);
        p.find('#input-do').val('active');
        p.find('.text-right .the-btns').html('<span class="pload xpad"></span> <label class="lpad"><input type="checkbox" class="cl-plugin js-switch"/></label>');
        var s = p.find('.js-switch');
        var elems = Array.prototype.slice.call(p.find('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#26B99A'
            });
        });
        p.find('.ploadi').html('');
        $('#mainmenu').load(document.URL +  ' #mainmenu');
        p.find('.phold').remove();
        p.find('.delete-btn').removeClass('hide').prop('href',a+data.Id+'/');
        /*setTimeout(function() { 
          p.find('.msg').removeClass('success').text('');
          console.log(data);
        }, 3000);*/
      } else if(data.Key == 'Update Success'){
        var cac = p.find('#input-active').val();
        var lab = '';
        if(cac == 0) {
            lab = '<input type="checkbox" class="cl-plugin js-switch"/>';
        } else {
            lab = '<input type="checkbox" class="cl-plugin js-switch" checked/>';
        }
        p.find('.msg').append('<div class="msg-text alert alert-success"></div>');
        p.find('.msg-text').text(data.Message);
        p.find('#input-do').val('active');
        p.find('.text-right .the-btns').html('<span class="pload xpad"></span> <label class="lpad">'+lab+'</label>');
        p.find('.panel-heading small').html('');
        p.find('.version').text(ve);
        var elems = Array.prototype.slice.call(p.find('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#26B99A'
            });
        });
        p.find('.ploadi').html('');
        p.find('.phold').remove();
        /*setTimeout(function() { 
          p.find('.msg').removeClass('success').text('');
          console.log(data);
        }, 3000);*/
      } else {
        p.find('.msg').append('<div class="msg-text alert alert-danger"></div>');
        p.find('.msg-text').text(data.Message);
        /*setTimeout(function() { 
          p.find('.msg').removeClass('failed').text('');
          console.log(data);
        }, 3000);*/
      }
    }).fail(function(data) {
      console.log(data);
    });

    });
// Remove message
    $('.flexwrap .msg').on('click','.msg-text',function(){
        $(this).fadeOut(800,function(){
            $(this).remove();
        });
    });
</script>