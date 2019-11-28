<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$form->create()?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		 <div class="row form-horizontal ">
		 		<?php 
		 		foreach ($Main_settings as $setting) {
		 			$label = ucwords(str_replace('_', ' ', $setting['name']));
		 			$for = 'input-'.strtolower(str_replace(' ', '_', $setting['name']));
		 			echo '<label class="col-lg-3 col-md-6 col-sm-12 col-xm-12 text-left"';
		 			echo " for='$for'>" . __($label,'clients') . "</label>";
		 			echo '<div class="col-lg-9 col-md-6 col-sm-12 col-xm-12">';
		 			$form->input($setting['name'],array('value' => $setting['value']));
		 			echo '</div>';
		 		}
		 		?>
		 </div>
		</div>
	</div>
</div>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body clients-fields">
		<table id="clients-fields-wrap" class="table table-striped bulk_action">          
          <thead>
            <tr>
            <th><?php echo __('Input name','clients') ?></th>
            <th><?php echo __('Input type','clients') ?></th>
            <th><?php echo __('Action','clients') ?></th>
          </tr>
          <tr>
            <td><input id="field_name" values=""></td>
            <td>
	            <select id="field_type">
	            	<option value='text'><?php echo __('Text','clients') ?></option>
	            	<option value='number'><?php echo __('Number','clients') ?></option>
	            </select>
            </td>
            <td><a href="#" class="btn btn-success add-client-field" data-rest="api/json/clients/add_fields/"><?php echo __('Add','clients') ?></a></td>
          </tr>
          </thead>
          <tbody>
          <div class="results">
          <?php foreach ($Extra_settings as $setting) { ?>
          <tr>
            <td class="ff_name"><?php echo $setting['name'] ?></td>
            <td><?php echo $setting['value'] ?></td>
            <td><a href="#" class="btn btn-danger delete-client-field" data-rest="api/json/clients/remove_fields/" data-id="<?php echo $setting['id'] ?>"> <i class="fa fa-close"></i></a></td>
          </tr> 
           <?php } ?>
           </div>
          </tbody>
          <tfoot>
            <tr>
            <th><?php echo __('Input name','clients') ?></th>
            <th><?php echo __('Input type','clients') ?></th>
            <th><?php echo __('Action','clients') ?></th>
          </tr>
          </tfoot>
          </table>
		</div>
	</div>
</div>
<div class="container-fluid"> 
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php $form->submit(__('Save','clients'),'btn btn-success'); ?>
		</div>
	</div>
</div>
<?php $form->close()?>
<script type="text/javascript">
	$(document).ready(function(){

		$('body').on('click','.delete-client-field',function(e){
    	
		e.preventDefault();
		var t = $(this);
      	var p = $(this).closest('tr');
      	var u = $(this).attr('data-rest');
      	var id = $(this).attr('data-id');
      	var fn = p.find('.ff_name').text();
      	var btntxt =  $(this).html();
      	$(this).html('<i class="glyphicons glyphicons-refresh glyphicon-refresh-animate"></i>');
      	var formdata = {
      	'data[id]' : id
    }
    $.confirm({
                    title: '<?php echo __("Are you sure","clients");?>!',
                    content: '<?php echo __("This will delete the field:","clients");?> <strong>' + fn +'</strong>',
                    theme: 'material',
                    buttons: {
                        <?php echo __('Delete','clients');?>: {
                          btnClass: 'btn-warning',
                          action: function () {
                           $.ajax({
						      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
						      url     : u, // the url where we want to POST
						      data    : formdata, // our data object
						      dataType  : 'json', // what type of data do we expect back from the server
						      encode    : true
						    }).done(function(data) {
						      if(data.Key == 'Success') {
						        console.log(data);
						        t.html(btntxt);
						        $('.clients-fields').load(document.URL +  ' .clients-fields #clients-fields-wrap');
						      } else {
						         $(this).text('Warning');
						      }
						    }).fail(function(data) {
						      console.log(data);
						    });
                          }

                        },
                        
                        <?php echo __('Cancel','clients');?>: {
                          btnClass: 'btn-success',
                           action: function () {
                           	 t.html(btntxt);
                           }
                        }
                    }
                });
    
    });

	})
</script>