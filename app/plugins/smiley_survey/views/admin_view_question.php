<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body question-view">
		  	<div class="row">
		  		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		  			<?php if( count($question['terminals']) == 1) { ?>
		  			<h3><?php echo __('Terminal','smiley_survey'); ?></h3>
		  			<ul class="list-group">
		  			<?php foreach ($question['terminals'] as $key => $value) { ?>
		  			<li class="list-group-item">
		  				<?php echo $value['terminal'] ?>
		  			</li>
		  			<?php } ?>
		  			</ul>
		  			<?php } else { ?>
		  				<h3><?php echo __('Terminals','smiley_survey'); ?></h3>
		  			<ul class="list-group">
		  			<?php foreach ($question['terminals'] as $key => $value) { ?>
		  			<li class="list-group-item">
		  				<?php echo $value['terminal'] ?>
		  			</li>
		  			<?php } ?>
		  			</ul>
		  			<?php } ?>
		  		</div>
		  		<div class="col-lg-7 col-md-4 col-sm-12 col-xs-12">
		  			
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sidebar-check text-center">
		  			<ul id="sortable">
		  				<?php foreach ($question['answers'] as $key => $value) { ?>
			  			<li class="ui-state-default">
			  				<?php if(isset($value['icon'])) { ?>
			  					<div class="image-ico"><img src="<?php echo get_media($value['icon']);?>"></div>
			  				<?php } ?>
			  				<h4><?php echo $value['description'] ?></h4>
			  				<?php if(isset($value['feedback'])) { ?>
			  					<ul class="list-group">
			  						<?php foreach ($value['feedback'] as $ke => $val) { ?>
			  							<li class="list-group-item">
			  								<?php echo $val['feedback'] ?>
			  							</li>
			  						<?php } ?>
			  					</ul>
			  				<?php } ?>
			  			</li>
			  			<?php } ?>
		  			</ul>
		  		</div>

		  		<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
		  			
		  		</div>
		  		<div class="col-lg-9 col-md-7 col-sm-12 col-xs-12 sidebar-check">
		  			
		  		</div>
		  		
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<pre>
		  				<?php // print_r($question); ?>
		  			</pre>
		  		</div>
		  	</div>
		</div>
	</div>
</div>