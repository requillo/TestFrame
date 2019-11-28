<?php
// echo phpinfo();
// echo LANG;
$i = 0; 
$i = $i + widget_isset('clients','expire-visas');
$i = $i + widget_isset('clients','expire-passports');
 if ($i == 2) {
	$cols = 'col-lg-6 col-md-6 col-sm-12 col-xs-12';
} else {
	$cols = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
}

?>
<div class="container-fluid">
	<div class="page-header">
		<h1><?php echo __('Dashboard') ?></h1>
	</div>
</div>
<div class="container-fluid">
	<?php if(widget_isset('donations','get_all_donations')): ?>
		<?php widget('donations','get_all_donations'); ?>
	<?php endif; ?>
	<?php if(widget_isset('fuel_inventory','all_latest_fuels')): ?>
		<?php widget('fuel_inventory','all_latest_fuels'); ?>
	<?php endif; ?>	
	<div class="row">
	<?php if(widget_isset('clients','expire-visas')): ?>
		<div class="<?php echo $cols; ?>">
			<?php widget('clients','expire-visas'); ?>
		</div>
	<?php endif; ?>

	<?php if(widget_isset('clients','expire-passports')): ?>
		<div class="<?php echo $cols; ?>">
			<?php widget('clients','expire-passports'); ?>
		</div>
	<?php endif; ?>
	
	</div>

	</div>
