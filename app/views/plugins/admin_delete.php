<?php 
//echo '<pre>';
//print_r($Plugin);
//echo '</pre>';

if($Plugin['relations'] != '') {
	$dbs = explode(',', $Plugin['relations']);
	$dbn = count($dbs);
	if($dbn > 1) {
		$dbt = __('Plugin database tables');
	} else {
		$dbt = __('Plugin database table');
	}
}
?>

<div class="container-fluid">
<?php $form->create(array('action'=> admin_url().'plugins/delete/'.$Plugin['id'].'/'));?>
			<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default">
			<div class="panel-heading"><?php echo __('Plugin Info')?></div>
			<div class="panel-body">
			<div><?php echo __('Plugin name').': '.$Plugin['name']?></div>
			<div><?php echo __('Plugin version').': '.$Plugin['version']?></div>
			<div><?php echo __('Plugin developer').': '.$Plugin['info']['author']?></div>
			<div><?php echo __('Plugin description').': '.__($Plugin['info']['desc'],$Plugin['plugin'])?></div>
			<?php if($Plugin['relations'] != ''): ?>

			<div><?php echo $dbt.': </br>'?></div>
			<?php foreach ($dbs as $db){
				$db = trim($db);
				echo '<strong>'.PRE.$db.' '.__('</strong><em>records(').$Plugin['rec'][$db].')</em><br>';
				}?>
			<p>
			<?php $form->input('full', array(
			'type'=>'checkbox', 
			'value' => 1, 
			'class' => 'check flat', 
			'label' => __('Check this to delete all related database tables'), 
			'label-pos' => 'after')); ?>
			</p>
			<?php endif; ?>
			<?php $form->input('id',array('type'=>'hidden', 'value'=>$Plugin['id']));?>
			<p></p>
			<?php $form->submit(__('Delete'),'btn-danger');	?>
			</div>
			</div>
			</div>
			</div>
<?php $form->close(); ?>
</div>