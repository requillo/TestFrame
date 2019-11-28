<?php
// echo '<pre>';
// print_r($pages);
// print_r($User_roles);
// echo '</pre>';

// echo $this->user['role_level'];

?>

<?php $form->create()?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div id="users-table" class="panel panel-default">
				<div class="table-responsive">
				  <table id="all-users" class="table table-striped bulk_action">				  
				  <thead>
				  	<tr>
				  	<th style="width:35px"><input id="userselect" class="userselect check flat" type="checkbox" name="data[selectall]"></th>
				  	<th><?php echo __('Page') ?></th>
				  	<th><?php echo __('Created') ?></th>
				  	<th><?php echo __('Published') ?></th>
				  
				  </tr>
				  </thead>
				  <tbody>
				  <?php foreach ($pages as $page) { ?>

				  <?php 
				  	if($homepage == $page['id']) {
				  		$ishome = ' '.__('(Home page)');
				  	} else {
				  		$ishome = '';
				  	}
				  ?>

				  <tr>
				  	<td><input class="check flat" type="checkbox" name="data[user_id]" value="<?php echo $page['id']; ?>"></td>
				  	<td><?php echo $html->admin_link(language_content($page['title']) . $ishome ,'pages/edit/' . $page['id'].'/')   ?></td>
				  	<td><?php echo $page['created'] ?></td>
				  	<td><?php echo $page['status'] ?></td>
				  	
				  </tr>	

				   <?php } ?>
				  </tbody>
				  <tfoot>
				  	<tr>
				  	<th><input id="userselect" class="userselect check flat" type="checkbox" name="selectall"></th>
				  	<th><?php echo __('Page') ?></th>
				  	<th><?php echo __('Created') ?></th>
				  	<th><?php echo __('Published') ?></th>
				  </tr>
				  </tfoot>
				  </table>
				</div>

			</div>
		</div>
	</div>
</div>
<?php $form->close() ?>