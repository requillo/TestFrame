<?php 
$form->create('fuel'); ?>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-lg-12 col-md-12 text-right">
          <select name="data[site]" class="form-control-inline">
          <?php echo $form->options($SiteOptions, array('key' => $site['site_id'])); ?>
          </select>
          <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
          <span></span> <b class="caret"></b>
          <input type="hidden" name="data[site_date]" id="input-site_date">
          </div>
          <p></p>
        </div>
    </div>  
</div>
<?php $form->close();?>
<?php if(!empty($fuel_data_tanks)): 
$Thanks_ar = explode(',', $Thanks);
$ProductAlias_ar = explode(',', $ProductAlias);
$TankUllage_ar = explode(',', $TankUllage);
$TankTCVolume_ar = explode(',', $TankTCVolumeN);
$TankWaterVolume_ar = explode(',', $TankWaterVolume);
$TankTCVolumeCol_ar = explode(',', $TankTCVolumeCol);
$ct = count($Thanks_ar);
if($ct > 4) {
  if($ct % 4 == 0) {
    $r = 2;
  } else if ($ct % 3 == 0) {
    $r = 3;
  } else {
    $c2 = round($ct/3,2);
    $c3 = round($ct/4,2);
    $c2c = ceil($c2);
    $c3c = ceil($c3);
    $c2e = $c2c-$c2;
    $c3e = $c3c-$c3;
    
    if( $c2e < $c3e) {
      $r = 3;
    } else {
      $r = 2;
    }
  }
} else {
  $r = $ct;
}
?>

<div class="container-fluid">
  <div class="panel panel-default">
      <div class="panel-body fuel-company-data">
          <div class="row">
            <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
              
              <?php if($site['featured_image'] != '') {?>
              <div class="data-info-img"><img src="<?php echo get_protected_media($site['featured_image']) ?>"></div>
              <?php } ?>
              <div class="data-info-title text-success"><h3><?php echo __('Dealer information') ?></h3></div>
              <?php if($site['address'] != '') { ?>
              <div class="data-info"><label><i class="fa fa-map-signs"></i></label> <?php echo $site['address']?></div>
              <?php } ?>
              <?php if($site['district'] != '') { ?>
              <div class="data-info"><label><i class="fa fa-globe"></i></label> <?php echo $site['district']?></div>
              <?php } ?>
              <?php if($site['phone'] != '') { ?>
              <div class="data-info"><label><i class="fa fa-phone"></i></label> 
                <a href="tel:<?php echo $site['phone']?>">
                  <?php echo $site['phone']?>
                </a>
              </div>
              <?php } ?>
              <?php if($site['email'] != '') { ?>
              <div class="data-info"><label><i class="fa fa-envelope"></i></label> 
                <a href="mailto:<?php echo $site['phone']?>">
                  <?php echo $site['email']?>
                </a>
              </div>
              <?php } ?>
            </div>
            <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="fuel-inventory">
                  <div class="inl-elm"><span class="color-box" style="background: <?php echo $lowlow_color?>"></span> <?php echo __('Fuel below','fuel_inventory').' '.$lowlow_threshold.' %'; ?> </div>
                  <div class="inl-elm"><span class="color-box" style="background: <?php echo $low_color?>"></span> <?php echo __('Fuel below','fuel_inventory').' '.$low_threshold.' %'; ?> </div>
                  <div class="inl-elm"><span class="color-box" style="background: <?php echo $high_color?>"></span> <?php echo __('Fuel above','fuel_inventory').' '.$high_threshold.' %'; ?> </div>
                  <div class="inl-elm"><span class="color-box" style="background: <?php echo $normal_color?>"></span> <?php echo __('Normal Fuel','fuel_inventory');?> </div>
                  <div class="inl-elm"><span class="color-box" style="background: <?php echo $ullage_color ?>"></span> <?php echo __('Tank Ullage','fuel_inventory');?> </div>
                  <div class="inl-elm"><span class="color-box" style="background: <?php echo $water_color?>"></span> <?php echo __('Tank Water','fuel_inventory');?> </div>
                </div>                  
                </div>
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <div class="fl-tank-box">
                  <?php foreach ($Thanks_ar as $key => $value) { ?>
                   <div class="fl-tank-wrap fl-col-<?php echo $r; ?> fuel-tanks" style="border: 1px solid <?php echo str_replace('"', '', $TankTCVolumeCol_ar[$key]); ?>">
                     <div class="tank-title" style="background: <?php echo str_replace('"', '', $TankTCVolumeCol_ar[$key]); ?>"><?php echo str_replace("'", '', $value); ?></div>
                     <div class="tank-data"><label>Product</label> <span class="pull-right"><?php echo str_replace("'", '', $ProductAlias_ar[$key]); ?></span></div>
                     <div class="tank-data"><label>TankUllage</label> <span class="pull-right"><?php echo number_format(str_replace("'", '', $TankUllage_ar[$key]),3,'.',','); ?> ltr</span></div>
                     <div class="tank-data"><label>TankTCVolume</label> <span class="pull-right"><?php echo number_format(str_replace("'", '', $TankTCVolume_ar[$key]),3,'.',','); ?> ltr</span></div>
                     <div class="tank-data"><label>TankWaterVolume</label> <span class="pull-right"><?php echo number_format(str_replace("'", '', $TankWaterVolume_ar[$key]),3,'.',','); ?> ltr</span></div>
                  </div>
                  <?php } ?>
                </div>
                </div>
              </div>
            </div>
          </div>
      </div>
  </div> 
</div>

<div class="container-fluid"> 
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading"><h3><?php echo date('d M Y', strtotime($last_data['site_date'].' '.$last_data['site_time']))?></h3></div>
        <div class="panel-body">
          <div class="row">
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height: 400px;">
              <canvas id="c1"></canvas>
            </div>
          </div>
           
        </div>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading"><h3>Flow</h3></div>
        <div class="panel-body" style="height: 400px;">
          <canvas id="total_chart"></canvas>
        </div>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading"><h3>Sale</h3></div>
        <div class="panel-body" style="height: 400px;">
          <canvas id="sale_chart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<?php else: ?>

<div class="container-fluid"> 
  <div class="panel panel-danger">
    <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <?php 
            if($NoSite) {
              echo __("Please select a site","fuel_inventory"); 
            } else {
              echo __("Sorry, no data for","fuel_inventory").' '.$dates; 
            }
            ?>
          </div>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>
  <?php // print_r($fuel_data_tanks); ?>
<script type="text/javascript">




   function init_daterangepicker() {
      if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }
      var start = moment('<?php echo $startdate ?>');
      var end = moment('<?php echo $enddate ?>');
      console.log(start + ' - ' + end);

      function cb(start, end) {
          $('#reportrange span').html(start.format('MMMM DD, YYYY') + ' - ' + end.format('MMMM DD, YYYY'));
      }

      var optionSet1 = {
        startDate: moment('<?php echo $startdate ?>'),
        endDate: moment('<?php echo $enddate ?>'),
        minDate: moment().subtract(48, 'month').startOf('month'),
        maxDate: '<?php echo date('m/d/Y'); ?>', 
        dateLimit: {
        days: 366
        },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
       'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment()],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'This Year': [moment().startOf('year'), moment()],
        'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
        applyLabel: 'Submit',
        cancelLabel: 'Clear',
        fromLabel: 'From',
        toLabel: 'To',
        customRangeLabel: 'Custom',
        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        firstDay: 1
        }
      };
      cb(start,end);
      // $('#reportrange span').html('<?php echo $dates?>');
      $('#reportrange').daterangepicker(optionSet1, cb);
      $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        $('#reportrange span').html(picker.startDate.format('MMMM DD, YYYY') + " - " + picker.endDate.format('MMMM DD, YYYY'));
        $('#input-site_date').val(picker.startDate.format('YYYY-M-D') + "/" + picker.endDate.format('YYYY-M-D'));
        $('#fuel').submit();
      });
      $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        console.log("cancel event fired");
        $('#reportrange span').html('');
      });
    }
    init_daterangepicker();
// START ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
<?php if(!empty($fuel_data_tanks)): ?>

<?php if(date('Y-m-d') == $last_data['site_date'] ){ 
  if($single_refresh > 0) { ?>
  setTimeout(function(){
  location.reload();
},<?php echo $single_refresh*60000; ?>);

<?php } }?>
var nnn = '<?php echo $last_data['site_date'];?>';
    var prodAlias = [<?php echo $ProductAlias ?>];
    var colors = [<?php echo $Colors_js ?>];
    var TankTCVolume = [<?php echo $TankTCVolumeN; ?>];
    var TankWaterVolume = [<?php echo $TankWaterVolume; ?>];
    var TankUllage = [<?php echo $TankUllage; ?>];

    var barChartData = {
      labels: [<?php echo $Thanks; ?>],
      datasets: [{
        label: 'TankTCVolume',
        backgroundColor: [<?php echo $TankTCVolumeCol; ?>],
        data: [<?php echo $TankTCVolume_perc; ?>]
        
        }, {
        label: 'TankWaterVolume',
        backgroundColor: "<?php echo $water_color; ?>",
        data: [<?php echo $TankWaterVolume_perc; ?>]
        }, {

        label: 'TankUllage',
        backgroundColor: "<?php echo $ullage_color; ?>",
        data: [<?php echo $TankUllage_perc; ?>]
        
      }]

    };
    window.onload = function() {
      var ctx = document.getElementById('c1').getContext('2d');
      window.myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
          maintainAspectRatio: false,
          title: {
            display: true,
            text: '<?php echo $site['dealer']; ?>',
            fontSize: 24,
            fontStyle: 'normal'
          },
           legend: {
              display: false,
              position: 'top',
            },
          tooltips: {
            mode: 'point', // nearest / index / point / label
            intersect: false,
            callbacks: {
                title: function(tooltipItem, data) {
                    //Return value for title
                    return  prodAlias[tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  console.log(data);
                    var tt = 0;
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
                    if(label == 'TankTCVolume') {
                      var dd = TankTCVolume[tooltipItem.index];
                    } else if(label == 'TankWaterVolume') {
                      var dd = TankWaterVolume[tooltipItem.index];
                    } else {
                      var dd = TankUllage[tooltipItem.index];
                    }
                    var valor = tooltipItem.yLabel;
                    window.tt = TankTCVolume[tooltipItem.index]+TankWaterVolume[tooltipItem.index]+TankUllage[tooltipItem.index];

                    label += ': '+dd + ' Liters ('+ valor.toFixed(2) +'%)';
                    return label;
                },
                footer: function() {
                return "Total Tank Volume: " +  window.tt.toFixed(3) + ' Liters';
              }
            }
          },
          responsive: true,
          scales: {
            xAxes: [{
              gridLines: {
                display: false
              },
              stacked: true,
              scaleLabel: {
               display: true,
               fontSize: 18,
               labelString: '<?php echo __('Total Tanks Data','fuel_inventory') .' '. date('d M Y H:i', strtotime($last_data['site_date'].' '.$last_data['site_time']))?>'
            }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: 100,// Your absolute max value
                callback: function (value) {
                  return (value).toFixed(0) + '%'; // convert it to percentage
                },
              },
              stacked: true,
              scaleLabel: {
              //  display: true,
               // labelString: 'Percentage'
            }
            }]
          }
        }
      
      });

// New chart

        var line_chart = document.getElementById("total_chart");
        var line_all = new Chart(line_chart, {
        type: 'line',
        data: {
         labels: [<?php
        $n = count($fuel_data_tanks[0]['cat']);
        $e = 1;
        foreach ($fuel_data_tanks[0]['cat'] as $val) {
          if($e == $n) {
            echo "'".$val."'";
          } else {
            echo "'".$val."',";
          }
          $e++;
        }
      ?>],
          datasets: [<?php 
      $nt = count($fuel_data_tanks);
      $i = 1;
      $c = 0;
      foreach ($fuel_data_tanks as $key => $value) {
        $n = count($value['cat']);
        $e = 1;
        if($colors_array['value'] == 1) {
          echo "{"."\n"."label: '".$value['name'] ."', fill: false, borderColor: '".$value['product_color']."', "."\n"."data: [";
        } else {
          echo "{"."\n"."label: '".$value['name'] ."', fill: false, borderColor: colors[$c], "."\n"."data: [";
        }
        foreach ($value['volume'] as $val) {
          if($e == $n) {
            echo $val;
          } else {
            echo $val.', ';
          }
          $e++;
        }
        if($i == $nt) {
           echo ']}';
         } else {
           echo ']},';
         }
         $i++;
         $c++;
      } ?>]
        },
        options: {
          legend: {
              display: true,
              position: 'top',
              labels: {
                usePointStyle: true
              }
            },
           tooltips: {
            mode: 'nearest', // nearest / index / point / label
            intersect: false,
             callbacks: {
                label: function(tooltipItem, data) {
                    
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
                    var valor = tooltipItem.yLabel;
                    if (label) {
                        label += ': ';
                    }

                    label += valor + ' Liters';
                    return label;
                }
            }
          },
          title: {
            display: false,
            text: '<?php echo $fuel_data_tanks[0]['date']; ?>',
            fontSize: 24,
            fontStyle: 'normal'
          },
          maintainAspectRatio: false,
          scales: {
          yAxes: [{
             
            ticks: {
            beginAtZero: true,
            weight: 10,
            stacked: false
            }
            }],
          xAxes: [{
            scaleLabel: {
               display: true,
               fontSize: 18,
               labelString: '<?php echo $fuel_data_tanks[0]['date']; ?>'
            },
               display: true
           }]
          }
        }
        });

        var ctx = document.getElementById("sale_chart");
        var mainb = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [<?php
        $n = count($fuel_data_tanks[0]['cat']);
        $e = 1;
        foreach ($fuel_data_tanks[0]['cat'] as $val) {
          if($e == $n) {
            echo "'".$val."'";
          } else {
            echo "'".$val."',";
          }
          $e++;
        }
      ?>],
          datasets: [<?php 
      $nt = count($fuel_data_tanks);
      $i = 1;
      $c = 0;
      foreach ($fuel_data_tanks as $key => $value) {
        $n = count($value['cat']);
        $e = 1;
        if($colors_array['value'] == 1) {
          echo "{"."\n"."label: '".$value['name'] ."', backgroundColor: '".$value['product_color']."', "."\n"."data: [";
        } else {
          echo "{"."\n"."label: '".$value['name'] ."', backgroundColor: colors[$c], "."\n"."data: [";
        }
        
        foreach ($value['sale'] as $val) {
          if($e == $n) {
            echo $val;
          } else {
            echo $val.', ';
          }
          $e++;
        }
        if($i == $nt) {
           echo ']}';
         } else {
           echo ']},';
         }
         $i++;
         $c++;
      } ?>]
        },

        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: 'nearest', // nearest / index / point / label
            intersect: false,
             callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
                    var valor = tooltipItem.yLabel;
                    if (label) {
                        label += ': ';
                    }
                    label += valor + ' Liters';
                    return label;
                }
            }
          },
           legend: {
            display: true,
            position: 'top',
          },
          scales: {
          yAxes: [{
            ticks: {
            beginAtZero: true
            }
          }],
          xAxes: [{
            scaleLabel: {
               display: true,
               fontSize: 18,
               labelString: '<?php echo $fuel_data_tanks[0]['date']; ?>'
            },
               display: true
           }]
          }
        }
        });


    };
///////
   <?php endif; ?>
//
</script>