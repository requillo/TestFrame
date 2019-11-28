<?php 
$form->create();
?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading"><h2><?php echo __('Character limit settings'); ?></h2></div>
		<div class="panel-body">
		  <div class="row">
		  <?php if(!empty($price_chars)): ?>
		  	<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
		  	<?php 
		  	$t = count($price_chars);
		  	$i = 1;
		  	if($t > 6 || $t == 1) {
			  		$l = ceil($t/3);
			  	} else {
			  		$l = round($t/3);
			  	}
		  	foreach($price_chars as $price_char): 
		  		echo '<div class="widget-block"><div class="widget-text-data"><span class="text-char-limit">Character limit '.$price_char['name'] . '</span> = <span class="text-price-limit">SRD ' .  number_format($price_char['value'],'2',',','') .'</span> <a href="#" class="pull-right char-edit"><i class="fa fa-edit"></i></a></div>';
		  		echo '<div class="widget-input-data hide">Chars <input class="chars" value="'.$price_char['name'] . '"> = SRD <input class="price-input" value="' .  $price_char['value'] .'"> <a data-id="'.$price_char['id'].'" data-link="'.url('api/json/rubrieken/update-char-limit/').'" class="pull-right char-save" href="#"><i class="fa fa-floppy-o" aria-hidden="true"></i></a></div></div>';
		  	if($i % $l == 0) { echo '</div><div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">';}
		  	$i++;
		  	endforeach;
		  	?>			
			</div>
			
			<?php else: ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('save',array('value' => __('Save','clients'),'type'=>'submit','class'=>'bsave btn btn-success pull-right','no-wrap' => true)) ?>
			</div>
			<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('start_price',['label'=>__('Start price','rubrieken'),'placeholder' => '7.5']); ?>
			</div>
			<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('start_limit',['label'=>__('Start limit','rubrieken'),'placeholder' => '99']); ?>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('price_increment',['label'=>__('Price Increment (%)','rubrieken'),'placeholder' => '50']); ?>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('limit_increment',['label'=>__('Limit Increment','rubrieken'),'placeholder' => '20']); ?>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('total',['label'=>__('Total','rubrieken'),'placeholder' => '15']); ?>
				<?php $form->input('add_limits',['class'=> 'hide', 'value' => '1']); ?>
			</div>
			<?php endif; ?>	
		  </div>
		</div>
	</div>
</div>

<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading"><h2><?php echo __('Rubrieken Categories'); ?></h2></div>
		<div class="panel-body">
		  <div class="row">
			  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			  	<input class="add-cat-input"> <a data-link="<?php echo url('api/json/rubrieken/add-category/') ?>" class="add-cat btn btn-success" href="#"><?php echo __('Add','rubrieken'); ?></a>
			  </div>
			  <?php if(!empty($Cats)): 
			  	$i = 1;
			  	$t = count($Cats);
			  	if($t > 6 || $t == 1) {
			  		$l = ceil($t/3);
			  	} else {
			  		$l = round($t/3);
			  	}
		  		
			  ?>
			  	<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12"> 
			  	<?php foreach($Cats as $Cat): 
		  		echo '<div class="widget-block"><div class="widget-text-data"><span class="text-char-limit">'.$Cat['category_name'] . '</span> <a href="#" class="pull-right char-edit"><i class="fa fa-edit"></i></a></div>';
		  		echo '<div class="widget-input-data hide"><input class="cat-input" value="'.$Cat['category_name'] . '" x-webkit-speech> <a class="text-danger" href="'.admin_url('rubrieken/delete-category/'.$Cat['id'].'/').'"><i class="fa fa-trash" aria-hidden="true"></i></a> <a data-id="'.$Cat['id'].'" data-link="'.url('api/json/rubrieken/update-category/').'" class="pull-right cat-update" href="#"><i class="fa fa-floppy-o" aria-hidden="true"></i></a></div></div>';
		  	if($i % $l == 0) { echo '</div><div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">';}
		  	$i++;
		  	endforeach; ?>
			  	 </div>
			  <?php endif; ?>
		  </div>
		</div>
	</div>
</div>

<!-- CSS Styles -->
<style>
  .speech {border: 1px solid #DDD; width: 300px; padding: 0; margin: 0}
  .speech input {border: 0; width: 240px; display: inline-block; height: 30px;}
  .speech img {float: right; width: 40px }
</style>

<!-- Search Form -->
<form id="labnol" method="get" action="https://www.google.com/search">
  <div class="speech">
    <input type="text" name="q" id="transcript" placeholder="Speak" />
    <img onclick="startDictation()" src="//i.imgur.com/cHidSVu.gif" />
  </div>
</form>

<script>
  function startDictation() {

    if (window.hasOwnProperty('webkitSpeechRecognition')) {

      var recognition = new webkitSpeechRecognition();

      recognition.continuous = false;
      recognition.interimResults = false;

      recognition.lang = "en-US";
      recognition.start();

      recognition.onresult = function(e) {
        document.getElementById('transcript').value
                                 = e.results[0][0].transcript;
        recognition.stop();
        document.getElementById('labnol').submit();
      };

      recognition.onerror = function(e) {
        recognition.stop();
      }

    }
  }
</script>

<?php

$form->close();