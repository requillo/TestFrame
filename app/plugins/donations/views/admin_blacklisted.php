<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 

$options = array(
	'person' => __('Person','donations'), 
	'foundation' => __('Foundation','donations'),
	'desc' => __('Description','donations')
);

if(isset($_GET['in'])) {
	$select['key'] = $_GET['in'];
} else {
	$select = '';
}

if(isset($_GET['search'])) {
	$key = $_GET['search'];
} else {
	$key = '';
}

?>

<?php  if(isset($persons)) { ?>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12"><a class="btn btn-success" href="<?php echo admin_url('donations/blacklisted/'); ?>"><?php echo __('Go back','donations');?></a></div>
    </div>
</div>
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div id="users-table" class="panel panel-default">
						<div class="table-responsive">
							<table id="all-users" class="table table-striped bulk_action">				  
								<thead>
									<tr>
										<th><?php echo __('Person','donations');?></th>
										<th><?php echo __('Created','donations');?></th>
										<th><?php echo __('Edited','donations') ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($persons as $person){ ?>
									<tr>
										<td><a href="<?php echo admin_url('donations/edit-person/'.$person['id'].'/'); ?>"><?php echo $person['first_name'] . ' ' . $person['last_name'] ?></a></td>
										<td><?php echo date('d F Y', strtotime($person['created'])); ?></td>
										<td><?php echo date('d F Y', strtotime($person['updated'])); ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>					
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12">
					<?php
					if(isset($Paginate)) {
						echo $Paginate;
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php  } else if(isset($foundations)) { ?>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12"><a class="btn btn-success" href="<?php echo admin_url('donations/blacklisted/'); ?>"><?php echo __('Go back','donations');?></a></div>
    </div>
</div>

<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div id="users-table" class="panel panel-default">
						<div class="table-responsive">
							<table id="all-users" class="table table-striped bulk_action">				  
								<thead>
									<tr>
										<th><?php echo __('Person','donations') ?></th>
										<th><?php echo __('Created','donations') ?></th>
										<th><?php echo __('Edited','donations') ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($foundations as $foundation){ ?>
									<tr>
										<td><a href="<?php echo admin_url('donations/edit-foundation/'.$foundation['id'].'/'); ?>"><?php echo $foundation['foundation_name']; ?></a></td>
										<td><?php echo date('d F Y', strtotime($foundation['created'])); ?></td>
										<td><?php echo date('d F Y', strtotime($foundation['updated'])); ?></td>
									</tr>
									<?php } ?>
									
								</tbody>
							</table>
						</div>
					</div>					
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12">
					<?php
					if(isset($Paginate)) {
						echo $Paginate;
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php  } else { ?>

<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12">
					<a class="btn btn-success btn-large" href="<?php echo admin_url('donations/blacklisted/persons/'); ?>"><?php echo __('Persons','donations'); ?></a>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<a class="btn btn-success btn-full" href="<?php echo admin_url('donations/blacklisted/foundations/'); ?>"><?php echo __('Companies','donations'); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php  } ?>