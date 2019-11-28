
<div class="container-fluid">
	<?php $form->create('get-data'); ?>
		<div class="row">
  			<div class="col-lg-12 col-md-12">
          <div class="pull-left">
            <label style="display: block;"><?php echo __('Companies', 'donations') ?></label>
    				<select name="data[comp]" class="form-control-inline">
              <option value="all">All</option>
  	  				<?php echo $Company_options; ?>
    				</select>
          </div>
          <div class="pull-left">
            <label style="display: block;"><?php echo __('Status', 'donations') ?></label>
            <select name="data[approval]" class="form-control-inline">
              <?php echo $form->options(array('all'=>__('All','donations'),1=>__('Approved','donations'),0=>__('Disapproved','donations'),2=>__('Pending','donations'))); ?>
            </select>
          </div>
          <div class="pull-left">
            <label style="display: block;"><?php echo __('Date range', 'donations') ?></label>
    				<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
    				<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
    				<span></span> <b class="caret"></b>
            <input type="hidden" name="data[dates]" id="input-site_date">
    				</div>
          </div>
          
  			</div>
        <div class="col-lg-12 col-md-12">
          <p></p>
        </div>
    </div>  
    
<?php $form->close(); ?>

</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
			<div id="users-table" class="panel panel-default">
				<div class="table-responsive" id="customers">
					<table id="all-donations" class="table table-striped table-bordered">				  
					  <thead>
					  	<tr>
					  		<th COLSPAN=9></th>
					  	</tr>
					  	<tr>
						  	<th><?php echo __('Date of Request','donations') ?></th>
						  	<th><?php echo __('Type of the donation ','donations') ?></th>
						  	<th><?php echo __('Item description','donations') ?></th>
						  	<th><?php echo __('Amount','donations') ?></th>
						  	<th><?php echo __('Reason/Purpose','donations') ?></th>
						  	<th><?php echo __('Donor','donations') ?></th>
						  	<th><?php echo __('Requested by','donations') ?></th>
						  	<th><?php echo __('Status','donations') ?></th>
						  	<th><?php echo __('Hi Approval','donations') ?></th>
                <th><?php echo __('Hi Approval date','donations') ?></th>
					  	</tr>
					  </thead>
					  <tbody>
					  	<?php 
              if(!empty($data)) {
              foreach ($data as $value) { 
                ?>
					  	<tr>
						  	<td><?php echo date('n/j/Y', strtotime($value['created']));  ?></td>
						  	<td><?php echo $value['donation_types'] ?></td>
						  	<td><?php echo $value['donation_description'] ?></td>
						  	<td><?php echo $value['amount'] ?></td>
						  	<td><a target="_blank" href="<?php echo admin_url('donations/view-donation/'.$value['id']); ?>"><?php echo $value['title'] ?></a></td>
						  	<td><?php echo $value['donated_company']['company_name'] ?></td>
						  	<td>
                <?php 
                echo $value['person_id']['full_name'] ;
                if(isset($value['foundation_id']['foundation_name'])) {
                echo '<span class="hide">, </span><br>'."\r\n".$value['foundation_id']['foundation_name'];
                }
                ?>
                </td>
                <td><?php echo $approval[$value['approval']]; ?></td>
                <td>
                  <?php
                  if(isset($value['hi_approval_user']['id'])) {
                     echo $value['hi_approval_user']['fname'].' '.$value['hi_approval_user']['lname'];
                  } 
                  
                  ?>
                </td>
                <td>
                  <?php
                  if($value['hi_approval_updated'] != NULL) {
                    echo date('m/d/Y', strtotime($value['hi_approval_updated']));
                  } 
                 
                  ?>
                </td>
					  	</tr>
					  		
					  	<?php }

            } else { ?>

            <tr>
                <th COLSPAN=10>Sorry, No data</th>
              </tr>

          <?php   } ?>
					  	
					  </tbody>
				</table>
				</div>
			</div>
      <div id="editor"></div>
		</div>
	</div>
</div>

<script>
// TableExport.prototype.rowDel = "\r";
$("table").tableExport({formats: ["xlsx","csv"], position: "top", trimWhitespace: true});
// $('body').find('caption').append('<button class="btn btn-default p-pdf">Print to pdf</button>');

var doc = new jsPDF('p', 'pt', 'letter');
var specialElementHandlers = {
        // element with id of "bypass" - jQuery style selector
        '#bypassme': function (element, renderer) {
            // true = "handled elsewhere, bypass text extraction"
            return true
        }
    };

function demoFromHTML() {
    var pdf = new jsPDF('p', 'pt', 'letter');
    // source can be HTML-formatted string, or a reference
    // to an actual DOM element from which the text will be scraped.
    source = $('#customers')[0];

    // we support special element handlers. Register them with jQuery-style 
    // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
    // There is no support for any other type of selectors 
    // (class, of compound) at this time.
    specialElementHandlers = {
        // element with id of "bypass" - jQuery style selector
        '#bypassme': function (element, renderer) {
            // true = "handled elsewhere, bypass text extraction"
            return true
        }
    };
    margins = {
        top: 80,
        bottom: 60,
        left: 40,
        width: 522
    };
    // all coords and widths are in jsPDF instance's declared units
    // 'inches' in this case
    pdf.fromHTML(
    source, // HTML string or DOM elem ref.
    margins.left, // x coord
    margins.top, { // y coord
        'width': margins.width, // max width of content on PDF
        'elementHandlers': specialElementHandlers
    },

    function (dispose) {
        // dispose: object with X, Y of the last line add to the PDF 
        //          this allow the insertion of new lines after html
        pdf.save('Test.pdf');
    }, margins);
}

$('body').on('click','.p-pdf',function () {   
    demoFromHTML();
});


// $("table").DataTable();

 function init_daterangepicker() {
      if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }
      var start = moment('<?php echo $dates[0]; ?>');
      var end = moment('<?php echo $dates[1]; ?>');
      console.log(start + ' - ' + end);

      function cb(start, end) {
          $('#reportrange span').html(start.format('MMMM DD, YYYY') + ' - ' + end.format('MMMM DD, YYYY'));
      }

      var optionSet1 = {
        startDate: moment('<?php echo $dates[0]; ?>'),
        endDate: moment('<?php echo $dates[1]; ?>'),
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
        cancelLabel: 'Cancel',
        fromLabel: 'From',
        toLabel: 'To',
        customRangeLabel: 'Custom',
        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        firstDay: 1
        }
      };
      cb(start,end);
      // $('#reportrange span').html('<?php // echo $dates?>');
      $('#reportrange').daterangepicker(optionSet1, cb);
      $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        $('#reportrange span').html(picker.startDate.format('MMMM DD, YYYY') + " - " + picker.endDate.format('MMMM DD, YYYY'));
        $('#input-site_date').val(picker.startDate.format('YYYY-M-D') + "=" + picker.endDate.format('YYYY-M-D'));
        $('#get-data').submit();
      });
      $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        console.log("cancel event fired");
        // $('#reportrange span').html('');
      });
    }
    init_daterangepicker();

</script>


<?php // print_r($cat_data); ?>

<?php // print_r($data); ?>
