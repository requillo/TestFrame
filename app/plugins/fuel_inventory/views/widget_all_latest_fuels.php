
<?php // print_r($sites)?>
<div class="row fuel-inventory-widget-dash">
	<div class="animated zoomIn col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
	<div class="panel panel-default">
	<div class="panel-body"> 
		<div class="inl-elm"><?php echo __('Fuel below','fuel_inventory').' '.$lowlow_threshold.' %'; ?> <span class="color-box" style="background: <?php echo $lowlow_color?>"></span></div>
		<div class="inl-elm"><?php echo __('Fuel below','fuel_inventory').' '.$low_threshold.' %'; ?> <span class="color-box" style="background: <?php echo $low_color?>"></span></div>
		<div class="inl-elm"><?php echo __('Fuel above','fuel_inventory').' '.$high_threshold.' %'; ?> <span class="color-box" style="background: <?php echo $high_color?>"></span></div>
		<div class="inl-elm"><?php echo __('Normal Fuel','fuel_inventory');?> <span class="color-box" style="background: <?php echo $normal_color; ?>"></span></div>
		<div class="inl-elm"><?php echo __('Tank Ullage','fuel_inventory');?> <span class="color-box" style="background: <?php echo $ullage_color; ?>"></span></div>
		<div class="inl-elm"><?php echo __('Tank Water','fuel_inventory');?> <span class="color-box" style="background: <?php echo $water_color; ?>"></span></div>
	</div>
	</div>
	</div>
<?php foreach ($sites as $value) { ?>
<div class="animated zoomIn col-lg-6 col-md-6 col-sm-12 col-xs-12">
  <div class="panel panel-default">
    <div class="panel-heading"><a class="btn btn-block btn-success" href="<?php echo admin_url('fuel-inventory/site/'.$value['site_id'].'/') ?>"><?php echo $value['dealer'] ?></a></div>
    <div class="panel-body">
		<div class="row fuel-widget-modules">
		<?php 
		$t = count($value['tanks']);
		$d = round(12/$t);
		if($d < 3) {
			$d = 3;
		}
		foreach ($value['tanks'] as $val) { ?>
		<div class="col-lg-<?php echo $d ?> col-md-<?php echo $d ?> col-sm-<?php echo $d ?> col-xs-12">
      <div id="sd_<?php echo $value['site_id'].'_tank_'.$val['tank-name']['tank_id']; ?>" class="fuel-dash-module text-center" style="background: rgb(<?php echo $val['tank_data']['tank_tc_volume_color'] ?>)">
        <div class="widget-tank-title"><?php echo $val['tank-name']['tank'] ?></div>
        <div class="widget-product-title"><?php echo $val['product-name']['product_alias'] ?></div>
        <div class="widget-tcvol-perc"><?php echo $val['tank_data']['tank_tc_volume_perc'] ?>%</div>
      </div>
      <div>
        <canvas id="site_<?php echo $value['site_id'].'_tank_'.$val['tank-name']['tank_id']; ?>"></canvas>
      </div>
			
		</div>
		<?php } ?>
		</div>
		<div class="text-center fuel-widget-date"><?php echo date('d M Y H:i', strtotime($value['date'])); ?></div>
    </div>
  </div>
</div>
<?php } ?>
</div>
<script type="text/javascript">
<?php if($dash_refresh > 0) { ?>
setTimeout(function(){
  location.reload();
},<?php echo $dash_refresh*60000; ?>);
<?php } ?>
<?php foreach ($sites as $value) { ?>
	<?php foreach ($value['tanks'] as $val) { ?>

		if ($('#site_<?php echo $value['site_id'].'_tank_'.$val['tank-name']['tank_id']; ?>').length ){ 
        var ctx = document.getElementById("site_<?php echo $value['site_id'].'_tank_'.$val['tank-name']['tank_id']; ?>");
        var data = {
        labels: [
          "TCVolume",
          "Water",
          "Ullage"
        ],
        datasets: [{
          data: [<?php echo $val['tank_data']['tank_tc_volume_perc']?>, <?php echo $val['tank_data']['water_perc']?>, <?php echo $val['tank_data']['tank_ullage_perc']?>],
          backgroundColor: [
          "rgba(<?php echo $val['tank_data']['tank_tc_volume_color']?>,0.7)",
          "rgba(<?php echo $val['tank_data']['water_color']?>,0.7)",
          "rgba(<?php echo $val['tank_data']['tank_ullage_color']?>,0.7)"
          ],
          hoverBackgroundColor: [
          "rgba(<?php echo $val['tank_data']['tank_tc_volume_color']?>,1)",
          "rgba(<?php echo $val['tank_data']['water_color']?>,1)",
          "rgba(<?php echo $val['tank_data']['tank_ullage_color']?>,1)"
          ]

        }]
        };
        var doughnut_all = new Chart(ctx, {
        type: '<?php echo $chart_style ?>',
        tooltipFillColor: "rgba(51, 51, 51, 0.55)",
        data: data,
        options: {
          responsive: true,
          maintainAspectRatio: false,
          tooltips: {
            mode: 'point', // nearest / index / point / label
            intersect: false,
            callbacks: {
                title: function(tooltipItem, data) {
                    //Return value for title
                    return  '<?php echo $val['product-name']['product_alias']?>';
                },
                label: function(tooltipItem, data) {
                	console.log(data);
                	var label = data.labels[tooltipItem.index] || '';
                	var valor = data.datasets[0].data[tooltipItem.index];
                	label += ': '+ valor.toFixed(2) +'%';
                	return label;
                },
                footer: function() {
                return "";
              }
            }
          },
          title: {
            display: true,
            text: '<?php echo $val['tank-name']['tank']?>',
            fontSize: 12,
            fontStyle: 'normal'
          },
          legend: {
            display: false,
            position: 'top',
            fullWidth: false,
          }
          }
        });
      }

	<?php } ?>
<?php } ?>
</script>