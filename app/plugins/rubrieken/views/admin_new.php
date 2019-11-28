<?php 
$form->create();
?>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
       <?php $form->input('save',array('value' => __('Save','clients'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>
       <?php // echo $html->admin_link(__('Cancel','clients'),'clients/view/'.$Client['id'].'/', array('class'=>'bclose btn btn-danger')) ?>
      </div>
    </div>  
</div>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  <div class="row">
			<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('f_name',['label'=>__('First name','rubrieken')]); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('l_name',['label'=>__('Last name','rubrieken')]); ?>
			</div>
			<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('telephone',['label'=>__('Telephone','rubrieken')]); ?>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('talli',['label'=>__('Talli','rubrieken')]); ?>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<select name="cats" class="form-control sel-max select_cat">
					<?php echo $form->options($Cats_options); ?>
				</select>
				<a href="#" class="btn btn-success add">Add</a>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="list_nav">
					<ul></ul>
				</div>
				<div class="tabs">
					<div class="no-work row">
					<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
					<div class="all-syms"><a class="sym" href="">&copy;</a><a class="sym" href="">&euro;</a><a class="sym" href="">&dollar;</a><a class="sym" href="">&pound;</a><a class="sym" href="">&yen;</a></div>
					<textarea class="form-control" name="content" class="text required" disabled></textarea>
					</div>
					<div id="rub-cal" class="col-lg-4 col-md-12 col-sm-12 col-xs-12"></div>
					</div>
				</div>
				<div class="category-date">
					
				</div>
			</div>
		  </div>
		</div>
	</div>
</div>
<script type="text/javascript">
	(function ($) {
    $.fn.extend({
        limiter: function () {
        	var elem = $(this).closest('.active-tab').find('.chars');
        	var price = $(this).closest('.active-tab').find('.price');
        	var pricet = $(this).closest('.active-tab').find('.pricet');
        	var tdates = $(this).closest('.active-tab').find('.tdates');
            $(this).on("keyup input change", function () {
            	var elem = $(this).closest('.active-tab').find('.chars');
        		var price = $(this).closest('.active-tab').find('.price');
        		var pricet = $(this).closest('.active-tab').find('.pricet');
        		var tdates = $(this).closest('.active-tab').find('.tdates');
                setCount(this, elem, price, tdates, pricet);
            });

            function setCount(src, elem, price, tdates, pricet) {
            	var td = tdates.val();
            	if(td == '') {
            		td = 'dasd';
            	}
            	td = td.split(',');
            	td = td.length;
            	
        		var chars = src.value.replace(/ /g,'');
            	chars = chars.replace(/(\r\n|\n|\r)/g,'').length;
                elem.html(chars);
                
                <?php 
                $i = 1;
                foreach ($price_chars as $value): ?>
                	<?php if($i == 1): 
                	$firstval = $value['value'];
                	?>
            	 if(chars <= <?php echo $value['name'] ;?>) {
            	 	var p = <?php echo $value['value'] ;?>;
            	 	var tp = p*td;
            	 	tp = tp.toFixed(2);
            	 	tp = tp.replace(".", ",");
        	 	price.html(tp);
        	 	pricet.html(p);
                	<?php else: ?>
                	} else if (chars <= <?php echo $value['name'] ;?>) {
                		var p = <?php echo $value['value'] ;?>;
                		var tp = p*td;
            	 		tp = tp.toFixed(2);
            	 		tp = tp.replace(".", ",");
                price.html(tp);
                pricet.html(p);

                	<?php endif; ?>
                <?php 
                $i++;
                endforeach; ?>
                }
            	
            }
            if($(this).length == 1) {
            	setCount($(this)[0], elem, price, tdates, pricet);
            }
            
        }
    });
})(jQuery);

$('.add').on('click', function(e){

	e.preventDefault();
	var p = $(this).parent();
	var c = p.find('.select_cat option:selected').val();
	var tc = p.find('.select_cat option:selected').text();
	var ch = $('.tabs').html();
	$('.active-tab').removeClass('active-tab');
	$('.active').removeClass('active');
	if($('.tab').length) {
		var l = $('.tab').last().attr("id");
		var id = l.split('-');
		var i = parseInt(id[1])+1;
		var cd = '<div id="r-set-date-'+i+'" class="row"><div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">'+tc+'</div><div class="setdate col-lg-9 col-md-12 col-sm-12 col-xs-12"></div></div>';
		var a = '<div class="tab active-tab row" id="tab-'+i+'">';
		a = a + '<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12"><div class="all-syms"><a class="sym" href="">&copy;</a><a class="sym" href="">&euro;</a><a class="sym" href="">&dollar;</a><a class="sym" href="">&pound;</a><a class="sym" href="">&yen;</a></div>';
		a = a + '<textarea name="data[content]['+i+']" class="text required form-control"></textarea></div>';
		a = a + '<div class="the-date col-lg-4 col-md-12 col-sm-12 col-xs-12"><div id="rub-cal-'+i+'" class="wrapdate">';
		a = a + '<input type="text" id="altField-'+i+'" name="data[dates]['+i+']" value="" style="" class="required tdates"></div>';
		a = a + '<input type="text" name="data[cat]['+i+']" value="'+c+'" style=""></div>';
		a = a + '<div class="show-chars-price col-lg-4 col-md-12 col-sm-12 col-xs-12"><div class="chars">0</div><div class="price"><?php echo $firstval ;?></div><div class="pricet"><?php echo $firstval ;?></div></div>';
		a = a + '</div>';
		$('.category-date').append(cd);
		$('.tabs').append(a);
		var lina = '<li class="list_cat active tab-'+i+'" ref="#tab-'+i+'" data-set-dates="#r-set-date-'+i+'">'+tc+' <a class="del-btn" href="#">Delete</a></li>';
		$('.list_nav ul').append(lina);
		var al = '#altField-'+i;
		$('#rub-cal-'+i).multiDatesPicker({
			minDate: 0,
			altField: al,
			dateFormat: 'dd-mm-yy',
			dayNamesShort: ['Zon', 'Maa', 'Din', 'Woe', 'Don', 'Vri', 'Zat'],
      		dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
      		monthNames: ['Januari','Februari','Maart','April','Mei','Juni','Juli','Augustus','September','October','November','December'],
     		monthNamesShort: ['Jan','Feb','Maa','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
			firstDay: 1,
			onSelect: function(){
				var dt = $('#rub-cal-'+i).multiDatesPicker('getDates');
				var p = $('#rub-cal-'+i).closest('.active-tab');
				var tp = p.find('.price');
				var s = parseFloat(p.find('.pricet').text());
				var ldt = dt.length;
				$('#r-set-date-'+i+ ' .setdate').text(dt);
				if(ldt == 0){
					var tsp = s*1;
					tsp = tsp.toFixed(2);
					tsp = tsp.replace(".", ",");
					tp.text(tsp);
				} else {
					var tsp = s*ldt;
					tsp = tsp.toFixed(2);
					tsp = tsp.replace(".", ",");
					tp.text(tsp);
				}
			}
		});
		
		$("#tab-"+i).find(".text").limiter();
	} else {
		var i = 1;
		var cd = '<div id="r-set-date-'+i+'" class="row"><div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">'+tc+'</div><div class="setdate col-lg-9 col-md-12 col-sm-12 col-xs-12"></div></div>';
		var a = '<div class="tab active-tab row" id="tab-'+i+'">';
		a = a + '<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12"><div class="all-syms"><a class="sym" href="">&copy;</a><a class="sym" href="">&euro;</a><a class="sym" href="">&dollar;</a><a class="sym" href="">&pound;</a><a class="sym" href="">&yen;</a></div>';
		a = a + '<textarea name="data[content]['+i+']" class="text required form-control"></textarea></div>';
		a = a + '<div class="the-date col-lg-4 col-md-12 col-sm-12 col-xs-12"><div id="rub-cal-'+i+'" class="wrapdate">';
		a = a + '<input type="text" id="altField-'+i+'" name="data[dates]['+i+']" value="" style="" class="required tdates"></div>';
		a = a + '<input type="text" name="data[cat]['+i+']" value="'+c+'" style=""></div>';
		a = a + '<div class="show-chars-price col-lg-4 col-md-12 col-sm-12 col-xs-12"><div class="chars">0</div><div class="price"><?php echo $firstval ;?></div><div class="pricet"><?php echo $firstval ;?></div></div>';
		a = a + '</div>';
		
		$('.category-date').html(cd);
		$('.tabs').html(a);
		var lina = '<li class="list_cat active tab-'+i+'" ref="#tab-'+i+'" data-set-dates="#r-set-date-'+i+'">'+tc+' <a class="del-btn" href="#">Delete</a></li>';
		$('.list_nav ul').html(lina);
		var al = '#altField-'+i;
		$('#rub-cal-'+i).multiDatesPicker({
			minDate: 0,
			altField: al,
			dateFormat: 'dd-mm-yy',
			dayNamesShort: ['Zon', 'Maa', 'Din', 'Woe', 'Don', 'Vri', 'Zat'],
      		dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
      		monthNames: ['Januari','Februari','Maart','April','Mei','Juni','Juli','Augustus','September','October','November','December'],
     		monthNamesShort: ['Jan','Feb','Maa','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
			firstDay: 1,
			onSelect: function(){
				var dt = $('#rub-cal-'+i).multiDatesPicker('getDates');
				var p = $('#rub-cal-'+i).closest('.active-tab');
				var tp = p.find('.price');
				var s = parseFloat(p.find('.pricet').text());
				var ldt = dt.length;
				$('#r-set-date-'+i+ ' .setdate').text(dt);
				if(ldt == 0){
					var tsp = s*1;
					tsp = tsp.toFixed(2);
					tsp = tsp.replace(".", ",");
					tp.text(tsp);
				} else {
					var tsp = s*ldt;
					tsp = tsp.toFixed(2);
					tsp = tsp.replace(".", ",")
					tp.text(tsp);
				}
				
			} 
		});
		
		$("#tab-"+i).find(".text").limiter();
	}
	
});

$('body').on('click', 'a.sym', function(e){
 e.preventDefault();
 var t = $(this).closest('.tab').find('.text').val();
 var s = $(this).text();
 $(this).closest('.tab').find('.text').val(t+s);
 $(this).closest('.tab').find('.text').focus();
 $(this).closest('.tab').find('.text').limiter();
 // $("body").find(".text").limiter();
}); 

</script>
<pre>
	<?php print_r($data); ?>
</pre>
<?php

$form->close();