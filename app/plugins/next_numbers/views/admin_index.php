<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  <div class="row">
		  	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		  		<div class="form-group"><br>
				<label for="input-first_name">Order number</label> 
				<input type="number" name="next" class="form-control " id="next" value="">
				</div>
				<div class="form-group">
					<button class="btn btn-success btn-block add-number">Add</button>
				</div>
		  	</div>
		  	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		  		<div class="well well-sm text-center">
		  			<label>Order</label>
		  			<div class="bold em-2 order">187</div>
		  			<a href="#" class="btn btn-warning btn-block">Release</a>
				</div>
		  	</div>
		  </div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		</div>
	</div>
</div>
<script type="text/javascript">
	$('.add-number').on('click', function(){
		$('#next').removeClass('form-error');
		var n = $('#next').val();
		var err = 0;
		if(n.replace(/\s+/g, '') == '') {
			$('#next').addClass('form-error');
			err = 1;
		}
		var fdata = {
			'data[next]' : $('#next').val()
		}

		if(err == 0){
			$.ajax({
			url: Jsapi+'next-numbers/add',
			type: "POST",
			data: fdata,
			dataType: "json",
			encode : true
			}).done(function( data ) {
				console.log(data);
				$('#next').val('');
			})
		}
	});
</script>