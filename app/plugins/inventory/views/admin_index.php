<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$lang = rtrim(LANG_ALIAS,'/');
?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  	<div id="all-cat-wrapper">
		  	<?php if(!empty($items)) {?>
		  	<table id="all-categories" class="table table-striped bulk_action">         
				<thead>
					<tr>
						<th class="col-lg-6"><?php echo __('Name','inventory') ?></th>
						<th style="width: 120px"><?php echo __('Inventory ','inventory') ?></th>
						<th class="col-lg-6">&nbsp;</th>
					</tr>
				</thead>
          		<tbody>
          			<?php foreach($items as $item){
          				$cl = '';
          				$msg = '';
          				$cat = '';
          				if($inv_d[$item['id']]['inventory'] <= $item['inventory_min']) {
          					$cl = 'danger';
          					$msg = $item['inventory_min_message'];
          				}

          				if($item['category'] != 0) {
          					$cat = '';
          				}

          			 ?>
          			<tr class="<?php echo $cl; ?>">
						<td>
							<label for=""><?php echo $item['name'] ?></label>	
						</td>
						<td>
							<span class="item-inventory"><?php echo $inv_d[$item['id']]['inventory'] ?></span>
						</td>
						<td>
							<?php echo $msg; ?>
						</td>
					</tr>
					<?php } ?>
          		</tbody>
          	</table>
			<?php } ?>
			</div>
		  	</div>
		</div>
	</div>
</div>
<pre>
	<?php print_r($items); ?>
</pre>