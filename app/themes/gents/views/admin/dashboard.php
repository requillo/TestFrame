<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
	<div class="page-header">
		<h1><?php echo __('Dashboard','gents') ?></h1>
	</div>
</div>
<div class="container-fluid">
	<?php get_admin_widgets('dashboard'); ?>
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
