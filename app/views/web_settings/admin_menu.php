<?php 
if(count($langs) > 1) {
  $hide = '';
} else {
   $hide = 'hide';
}
?>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="<?php echo $hide ?>" role="tabpanel" data-example-id="togglable-tabs">
        <ul class="nav nav-tabs bar_tabs get-edit-lang" role="tablist">
            <?php $i = 1;
            foreach ($langs as $key => $value) {
              if($key == $current_lang) {
                $active = 'active';
              } else {
                $active = '';
              }
                echo '<li role="presentation" class="'.$active.'"><a href="#send_html-'.$key.'" data-toggle="tab" aria-expanded="false" id="lang-'.$value.'">'.$key.'</a></li>';
                $i++;
            } ?>
          </ul>
      </div>
      </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
<div class="panel panel-default pagewidget">
	<div class="panel-heading">
		<h2><?php echo __('Pages'); ?></h2>
	</div>
<div class="panel-body">
	<ul class="all-pages list">
    <li>
    <label for="<?php echo $page_id;?>">
     <input type="checkbox" 
        class="flat" 
        id="page-o" 
        value="" 
        data-name="[:<?php echo rtrim(LANG_ALIAS,'/') ; ?>:]<?php echo __('Home'); ?>[::]" 
        data-type="Page" 
        data-typename="" 
        data-id="0" 
        > <?php echo __('Home (This is for the home page)'); ?>
                    </label>
                </li>
<?php 
        foreach ($Pages as $page) { 
        	$page_id = 'page-'. $page['id'];
        	?>
        	
        		<li>
        			<label for="<?php echo $page_id;?>">
        				<input type="checkbox" 
							class="flat" 
							id="<?php echo $page_id ; ?>" 
                            data-id="<?php echo $page['id'] ; ?>" 
							value="<?php echo $page['slug'] ; ?>" 
							data-name="<?php echo $page['title'] ; ?>" 
							data-type="Page" 
                            data-typename="" 
							> <?php echo language_content($page['title']) ; ?>
        			</label>
        		</li>
 <?php 	} ?>
 </ul> 
 <a class="btn btn-success" id="addpages">Add Pages</a>
</div>
</div>

<div class="panel panel-default pluginwidget">
	<div class="panel-heading">
		<h2><?php echo __('Plugins'); ?></h2>
	</div>
<div class="panel-body">
<div id="accordion">
<?php 
$i = 0;
foreach ($Plugins as $key => $value) { 
if(isset($value['pages'])){
	$pluginurl = strtolower(str_replace(' ', '-', $value['name']));
?>
<div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <a class="btn btn-block btn-primary text-left" data-toggle="collapse" data-target="#collapse-<?php echo $key; ?>" aria-controls="collapseOne">
          <?php echo $value['name'] ; ?>
        </a>
      </h5>
    </div>

    <div id="collapse-<?php echo $key; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
      	<ul class="all-plugin list">
        <?php 
        foreach ($value['pages'] as $val) { 
        	$plugid = 'plugin_page_id_'.$i;
        	if($val['name'] == 'Index') {
        		$plu_name = $value['name'];
        		$plu_name_label = $plu_name . ' ('.__('This is main plugin page').')';
                $val['url'] = '';
        	} else {
        		$plu_name = $val['name'];
        		$plu_name_label = $plu_name;
                $val['url'] = '/'.$val['url'];
        	}
        	?>
			
<?php 
// $form->input($plugid, array('type' => 'checkbox', 'label' => $val['name'], 'class' => 'flat', 'label-pos' => 'after', 'id' => $plugid, 'value' =>  $pluginurl.'/'. $val['url']));
?>

        		<li>
        			<label for="<?php echo $plugid;?>">
	<input type="checkbox" 
	name="<?php echo $plugid ; ?>" 
	class="flat" 
	id="<?php echo $plugid ; ?>" 
	value="<?php echo $pluginurl. $val['url'] ; ?>" 
	data-name="<?php echo $plu_name ; ?>" 
	data-type="Plugin" 
    data-typename="<?php echo $value['name'] ; ?>"
	>
	<?php echo $plu_name_label ; ?></label></li>

<?php
$i++; 
   }?>
</ul>
      </div>
    </div>
  </div>
	
<?php
	}
} 
?>
</div>
<a class="btn btn-success" id="appendnestable2">Add Plugin pages</a>
</div>
</div>
<div class="panel panel-default pluginwidget">
    <div class="panel-heading">
        <h2><?php echo __('Custom links'); ?></h2>
    </div>
<div class="panel-body">
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="custom_name"><?php echo __('Menu name'); ?></label>
        <input id="custom_name" class="form-control" placeholder="<?php echo __('Custom Link'); ?>">
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <p></p>
         <label for="custom_link"><?php echo __('Menu link'); ?></label>
        <input id="custom_link" class="form-control" placeholder="<?php echo __('eg:').URL.__('custom-link/'); ?>">
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p></p>
        <a class="btn btn-success" id="add_costum_link"><?php echo __('Add'); ?></a>
    </div>
</div>
</div>
</div>

</div>
<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row menu-create">
			<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"><?php echo $form->input('new_menu',array('placeholder' => __('Create new menu')))?></div>
			<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12"><a class="btn btn-success add-new-menu"><?php echo __('Create'); ?></a></div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php $mclass = ($Menu_options == '') ? 'hide' : ''; ?>
				<select name="select_menu" class="<?php echo $mclass ?> select_menu">
					<?php echo $Menu_options; ?>
				</select>
			</div>
			</div>		
<div class="dd" id="nestable">
    <?php echo $Menu_items; ?>
</div>
<textarea id="nestable-output"></textarea>
<a class="save-all-menu-items btn btn-success"><?php echo __('Save menu'); ?></a>
		</div>
	</div>
</div>
</div>
</div>

<script type="text/javascript">
	var main_url = $('base').prop('href');
    // Set Language array
    <?php $al = count($langs);
    $i = 1;
    echo 'var ml = {';
    foreach ($langs as $key => $value) {
        if($i == $al) {
            echo '"'.$key.'":'.'"'.$value.'"';
        } else {
            echo '"'.$key.'":'.'"'.$value.'",';
        }
       $i++;
    }
    echo '};'."\n";

     ?>
	var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if(window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            }
            else {
                output.val('JSON browser support required.');
            }
        };
	// $('#nestable').nestable();
	$('#nestable').nestable({
            group: 1
        }).on('change', updateOutput);
	
	 var nestablecount = 4;
    
    updateOutput($('#nestable').data('output', $('#nestable-output')));
    // add plugin pages
     $('#appendnestable2').click(function () {
     	$(document).find('.alertmsg').remove();
     	var dic = $(".pluginwidget input:checked").map(function(){
		  return $(this).val() + '<===>' + $(this).data('name') + '<===>' + $(this).data('type') + '<===>' + $(this).data('typename');
		}).toArray();
     	//alert(dic);
     	$.each(dic, function( index, value ) {
		  var frad = value.split('<===>');
		  // alert(frad[1]);
		  var mitem = '<li class="dd-item" data-link="' + frad[0] + '" data-name="'+frad[1]+'" data-type="'+frad[2]+'" data-original="'+frad[1]+'" data-typename="'+frad[3]+'"><div class="dd-handle dd3-handle"><i class="fa fa-arrows"></i></div>';
		  var mitemd = '<div class="dd3-content">'+frad[1]+'</div>';
		  mitemd = mitemd + '<div class="item-data hide">';
		  mitemd = mitemd + '<input type="text" class="new-menu-name" value="'+frad[1]+'">';
		  mitemd = mitemd + '<div class="original-menu-name menu-span"><?php echo __('Original name: '); ?><span>'+frad[1]+'</span></div>';
          mitemd = mitemd + '<div class="menu-span"><?php echo __('Type: '); ?><span>'+frad[2]+' ('+frad[3]+')</span></div>';
          mitemd = mitemd + '<div class="menu-span"><?php echo __('Link: '); ?><?php echo url(); ?>'+frad[0]+'/</span></div>';
		  mitemd = mitemd + '<a class="btn btn-success save-menu-item"><?php echo __('Save'); ?></a>';
		  mitemd = mitemd + '<a class="btn btn-danger del-menu-item pull-right"><?php echo __('Delete'); ?></a>';
		  mitemd = mitemd + '</div></li>';
		  $('#nestable > ol.outer').append(mitem+mitemd);
		  
		});
		 updateOutput($('#nestable').data('output', $('#nestable-output')));
		 $(this).closest('.panel-body').find('input.flat').iCheck('uncheck');
     });
     // add pages
     $('#addpages').click(function () {
     	$(document).find('.alertmsg').remove();
        var crlang = '<?php echo rtrim(LANG_ALIAS,'/') ; ?>';
        var delang = '<?php echo rtrim(DEFAULT_LANG_ALIAS,'/'); ?>';
        var hcl = true;
        var hdl = true;
     	var dic = $(".pagewidget input:checked").map(function(){
		  return $(this).val() + '<===>' + $(this).data('name') + '<===>' + $(this).data('type') + '<===>' + $(this).data('typename');
		}).toArray();
     	$.each(dic, function( index, value ) {
            // This is for bullshit language menu names fix
            var td = {};
            var frad = value.split('<===>');
            var lp = frad[1].split('[:');
            lp = lp.slice(1,-1);
            $.each(lp, function( index, value ) {
                tva = value.split(':]');
                td[tva[0]] = tva[1];
            });
            // End for bullshit language menu names fix
            // Get first
             $.each(lp, function( index, value ) {
                tva = value.split(':]');
                td[tva[0]] = tva[1];
            });
            // Check if current lang is in array
            if(td[crlang] === undefined) {
                hcl = false;
            }
            // Check if default lang is in array
            if(td[delang] === undefined) {
                delang = Object.keys(td)[0];
            }
            // alert(td[delang]);
            var mitem = '<li class="dd-item" data-link="' + frad[0] + '" data-name="'+frad[1]+'" data-type="'+frad[2]+'" data-original="'+frad[1]+'" data-typename="'+frad[3]+'"><div class="dd-handle dd3-handle"><i class="fa fa-arrows"></i></div>';
            var mitemd = '<div class="dd3-content">';

            if(hcl == true) {
                $.each(ml, function( index, value ) {
                    if(index == crlang) {
                        mitemd = mitemd + '<span class="menu-each-lang menu-lang-'+value+'">'+td[index]+'</span>';
                    } else {
                        if(td[index] === undefined) {
                            mitemd = mitemd + '<span class="menu-each-lang menu-lang-'+value+' hide">'+td[delang]+'</span>';
                        } else {
                            mitemd = mitemd + '<span class="menu-each-lang menu-lang-'+value+' hide">'+td[index]+'</span>';
                        }
                        
                    }
                });
            } else {
                var idn = 1;
                $.each(ml, function( index, value ) {
                    if(index == crlang) {
                        if(td[index] === undefined) {
                            mitemd = mitemd + '<span class="menu-each-lang menu-lang-'+value+'">'+td[delang]+'</span>';
                        } else {
                            mitemd = mitemd + '<span class="menu-each-lang menu-lang-'+value+'">'+td[index]+'</span>';
                        }
                    } else {
                        if(td[index] === undefined) {
                            mitemd = mitemd + '<span class="menu-each-lang menu-lang-'+value+' hide">'+td[delang]+'</span>';
                        } else {
                            mitemd = mitemd + '<span class="menu-each-lang menu-lang-'+value+' hide">'+td[index]+'</span>';
                        }
                    }
                    idn = idn + 1;
                });
            }
            mitemd = mitemd + '</div>';
            mitemd = mitemd + '<div class="item-data hide">';

            if(hcl == true) {
                $.each(ml, function( index, value ) {
                    if(index == crlang) {
                        mitemd = mitemd + '<input type="text" class="new-menu-name menu-input-lang-'+value+'" value="'+td[index]+'">';
                        mitemd = mitemd + '<div class="original-menu-name menu-span original-menu-lang-'+value+'"><?php echo __('Original name: '); ?><span>'+td[index]+'</span></div>';
                    } else {
                        if(td[index] === undefined) {
                            mitemd = mitemd + '<input type="text" class="new-menu-name menu-input-lang-'+value+' hide" value="'+td[delang]+'">';
                            mitemd = mitemd + '<div class="original-menu-name menu-span original-menu-lang-'+value+' hide"><?php echo __('Original name: '); ?><span>'+td[delang]+'</span></div>';
                        } else {
                            mitemd = mitemd + '<input type="text" class="new-menu-name menu-input-lang-'+value+' hide" value="'+td[index]+'">';
                            mitemd = mitemd + '<div class="original-menu-name menu-span original-menu-lang-'+value+' hide"><?php echo __('Original name: '); ?><span>'+td[index]+'</span></div>';
                        }
                        
                    }
                });
            } else {
                // var idn = 1;
                $.each(ml, function( index, value ) {
                    if(index == crlang) {
                        if(td[index] === undefined) {
                            mitemd = mitemd + '<input type="text" class="new-menu-name menu-input-lang-'+value+'" value="'+td[delang]+'">';
                            mitemd = mitemd + '<div class="original-menu-name menu-span original-menu-lang-'+value+'"><?php echo __('Original name: '); ?><span>'+td[delang]+'</span></div>';
                        } else {
                            mitemd = mitemd + '<input type="text" class="new-menu-name menu-input-lang-'+value+'" value="'+td[index]+'">';
                            mitemd = mitemd + '<div class="original-menu-name menu-span original-menu-lang-'+value+'"><?php echo __('Original name: '); ?><span>'+td[index]+'</span></div>';
                        }
                    } else {
                        if(td[index] === undefined) {
                            mitemd = mitemd + '<input type="text" class="new-menu-name menu-input-lang-'+value+' hide" value="'+td[delang]+'">';
                            mitemd = mitemd + '<div class="original-menu-name menu-span original-menu-lang-'+value+' hide"><?php echo __('Original name: '); ?><span>'+td[delang]+'</span></div>';
                        } else {
                            mitemd = mitemd + '<input type="text" class="new-menu-name menu-input-lang-'+value+' hide" value="'+td[index]+'">';
                            mitemd = mitemd + '<div class="original-menu-name menu-span original-menu-lang-'+value+' hide"><?php echo __('Original name: '); ?><span>'+td[index]+'</span></div>';
                        }
                    }
                    // idn = idn + 1;
                });
            }
            mitemd = mitemd + '<div class="menu-span"><?php echo __('Type: '); ?><span>'+frad[2]+'</span></div>';
            mitemd = mitemd + '<div class="menu-span"><?php echo __('Link: '); ?><?php echo url(); ?>'+frad[0]+'/</span></div>';
            mitemd = mitemd + '<a class="btn btn-success save-menu-item"><?php echo __('Save'); ?></a>';
            mitemd = mitemd + '<a class="btn btn-danger del-menu-item pull-right"><?php echo __('Delete'); ?></a>';
            mitemd = mitemd + '</div></li>';
            $('#nestable > ol.outer').append(mitem+mitemd);
		  
		});
		 updateOutput($('#nestable').data('output', $('#nestable-output')));
		 $(this).closest('.panel-body').find('input.flat').iCheck('uncheck');
     });
     // add custom link
     $('#add_costum_link').click(function () {
        $(document).find('.alertmsg').remove();
            var nm = $('#custom_name').val();
            nm = $.trim(nm);
            var lk = $('#custom_link').val();
            lk = $.trim(lk);
            var cnm = nm.replace(/\s/g,'');
            var clk = lk.replace(/\s/g,'');
            if(cnm != '' && clk != '') {
                var mitem = '<li class="dd-item" data-link="' + lk + '" data-name="'+nm+'" data-type="<?php echo __('Custom') ?>" data-original="'+nm+'" data-typename=""><div class="dd-handle dd3-handle"><i class="fa fa-arrows"></i></div>';
                var mitemd = '<div class="dd3-content">'+nm+'</div>';
                mitemd = mitemd + '<div class="item-data hide">';
                mitemd = mitemd + '<input type="text" class="new-menu-name" value="'+nm+'">';
                mitemd = mitemd + '<div class="original-menu-name menu-span"><?php echo __('Original name: '); ?><span>'+nm+'</span></div>';
                mitemd = mitemd + '<div class="menu-span"><?php echo __('Type: '); ?><span><?php echo __('Custom') ?></span></div>';
                mitemd = mitemd + '<div class="menu-span"><?php echo __('Link: '); ?>'+lk+'</span></div>';
                mitemd = mitemd + '<a class="btn btn-success save-menu-item"><?php echo __('Save'); ?></a>';
                mitemd = mitemd + '<a class="btn btn-danger del-menu-item pull-right"><?php echo __('Delete'); ?></a>';
                mitemd = mitemd + '</div></li>';
                $('#nestable > ol.outer').append(mitem+mitemd);
                updateOutput($('#nestable').data('output', $('#nestable-output')));
                $('#custom_name').val('');
                $('#custom_link').val('');
                $(this).closest('.panel-body').find('input.flat').iCheck('uncheck');

            } else {
                $('#custom_name').val('');
                $('#custom_link').val('');
            }
            // alert(frad[1]);
            
     });

     $(document).on('click','.dd3-content', function(){
     	$(document).find('.alertmsg').remove();
     	$(this).parent().find('.item-data').first().toggleClass('hide');
     });
     $('.get-edit-lang').on('click','a', function(){
        var lng = this.id;
        $('.menu-each-lang, .new-menu-name, .original-menu-name').addClass('hide');
        $('.menu-'+lng+', .menu-input-'+lng+', .original-menu-'+lng+'').removeClass('hide');
        
     });
     $(document).on('click','.save-menu-item', function(){
        var p = $(this).parent();
        var cl = $(this).closest('.dd-item');
        var itn = '';
         $.each(ml, function( index, value ) {
            var nd = p.find('.menu-input-lang-'+value).first().val();
            cl.find('.dd3-content .menu-lang-'+value).first().text(nd);
            itn = itn + '[:'+index+':]'+ nd;
         })
        itn = itn + '[::]';
        $(this).closest('.dd-item').data('name',itn);
        $(this).closest('.dd-item').find('.item-data').first().toggleClass('hide');
     	updateOutput($('#nestable').data('output', $('#nestable-output')));
     });
     $(document).on('click','.del-menu-item', function(){
     	$(document).find('.alertmsg').remove();
     	$(this).closest('.dd-item').remove();
     	updateOutput($('#nestable').data('output', $('#nestable-output')));
     });

     $('.add-new-menu').on('click', function(){
     	$(document).find('.alertmsg').remove();
     	var mn = $('#input-new_menu').val();
     	var ul = main_url+'api/json/web-settings/add-menu-option/';
     	var fdata = {
     		'data[meta_str]' : mn
     	}
     	$.ajax({
     		url: ul,
			type: "POST",
			data: fdata,
			dataType: "json",
			encode : true
     	}).done(function(data){
     		if(data.message == 'success'){
     			$('select.select_menu').removeClass('hide');
     			$("select.select_menu option").removeAttr('selected');
     			$('#input-new_menu').val('');
     			$('select.select_menu').append('<option value="'+data.id+'" selected>'+mn+'</option>');
     			$('#nestable .outer').html('');
     			$('#nestable-output').val('');
     		}
     		console.log(data);
     	});

     });
     $('.select_menu').on('change', function(){
     	$(document).find('.alertmsg').remove();
     	var mit = $('.select_menu option:selected').val();
     	var fdata = {
     		'data[menu_id]' : mit
     	}
     	var ul = main_url+'api/json/web-settings/get-menu-items/';
     	$.ajax({
     		url: ul,
			type: "POST",
			data: fdata,
			dataType: "json",
			encode : true
     	}).done(function(data){
     		if(data.message == 'success'){
     			$('#nestable').html(data.items);
     		}
     		updateOutput($('#nestable').data('output', $('#nestable-output')));
     		console.log(data);
     	});
     });

     $('.save-all-menu-items').on('click', function(){
     	$(document).find('.alertmsg').remove();
     	var mit = $('.select_menu option:selected').val();
     	var mstr = $('#nestable-output').val();
     	var fdata = {
     		'data[menu_id]' : mit,
     		'data[menu_str]' : mstr

     	}
     	var ul = main_url+'api/json/web-settings/add-menu-items/';
     	$.ajax({
     		url: ul,
			type: "POST",
			data: fdata,
			dataType: "json",
			encode : true
     	}).done(function(data){
     		if(data.message == 'success'){
     			var dr = '<div class="msg alertmsg"><div class="inner-msg the-msg"><?php echo __('Menu saved'); ?></div></div>';
     			$(".right_col > .row > div").first().after( dr );
     		}
     		console.log(data);
     	});
     });
     
</script>