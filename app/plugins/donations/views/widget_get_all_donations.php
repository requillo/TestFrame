<?php 
$t_all_n = separate_decimal(number_format($totals['all']['amount'], 2, ',', '.'));
$t_prod_n = separate_decimal(number_format($totals['prod']['amount'], 2, ',', '.'));
$t_service_n = separate_decimal(number_format($totals['service']['amount'], 2, ',', '.'));
$t_cash_n = separate_decimal(number_format($totals['cash']['amount'], 2, ',', '.'));
?>
  <?php $form->create('get-data'); ?>
  <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
              <?php echo $form->options(array('all'=>__('All','donations'),'1' =>__('Approved','donations'),'0' =>__('Disapproved','donations'),'2' =>__('Pending','donations')),array('key' => $approval)); ?>
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
       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <p></p>
       </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="panel panel-default text-center">
            <div class="donations-title"><h3><?php echo $companies; ?></h3></div>
            <div class="panel-body">
            <?php echo date('F d, Y', strtotime($dates[0])) .' - '. date('F d, Y', strtotime($dates[1])); ?>
            </div>
          </div>
        </div>
</div>
<?php $form->close(); ?>

<!-- top tiles -->
<div class="top-donation-info">
  
  <div class="row">
  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-body">
      <div class="icon"><svg version="1.1" id="product-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 201.387 201.387" style="enable-background:new 0 0 201.387 201.387;" xml:space="preserve"><path d="M129.413,24.885C127.389,10.699,115.041,0,100.692,0C91.464,0,82.7,4.453,77.251,11.916c-1.113,1.522-0.78,3.657,0.742,4.77c1.517,1.109,3.657,0.78,4.768-0.744c4.171-5.707,10.873-9.115,17.93-9.115c10.974,0,20.415,8.178,21.963,19.021c0.244,1.703,1.705,2.932,3.376,2.932c0.159,0,0.323-0.012,0.486-0.034C128.382,28.479,129.679,26.75,129.413,24.885z"/><path d="M178.712,63.096l-10.24-17.067c-0.616-1.029-1.727-1.657-2.927-1.657h-9.813c-1.884,0-3.413,1.529-3.413,3.413s1.529,3.413,3.413,3.413h7.881l6.144,10.24H31.626l6.144-10.24h3.615c1.884,0,3.413-1.529,3.413-3.413s-1.529-3.413-3.413-3.413h-5.547c-1.2,0-2.311,0.628-2.927,1.657l-10.24,17.067c-0.633,1.056-0.648,2.369-0.043,3.439s1.739,1.732,2.97,1.732h150.187c1.231,0,2.364-0.662,2.97-1.732S179.345,64.15,178.712,63.096z"/><path d="M161.698,31.623c-0.478-0.771-1.241-1.318-2.123-1.524l-46.531-10.883c-0.881-0.207-1.809-0.053-2.579,0.423c-0.768,0.478-1.316,1.241-1.522,2.123l-3.509,15c-0.43,1.835,0.71,3.671,2.546,4.099c1.835,0.43,3.673-0.71,4.101-2.546l2.732-11.675l39.883,9.329l-6.267,26.795c-0.43,1.835,0.71,3.671,2.546,4.099c0.263,0.061,0.524,0.09,0.782,0.09c1.55,0,2.953-1.062,3.318-2.635l7.045-30.118C162.328,33.319,162.176,32.391,161.698,31.623z"/><path d="M102.497,39.692l-3.11-26.305c-0.106-0.899-0.565-1.72-1.277-2.28c-0.712-0.56-1.611-0.816-2.514-0.71l-57.09,6.748c-1.871,0.222-3.209,1.918-2.988,3.791l5.185,43.873c0.206,1.737,1.679,3.014,3.386,3.014c0.133,0,0.27-0.009,0.406-0.024c1.87-0.222,3.208-1.918,2.988-3.791l-4.785-40.486l50.311-5.946l2.708,22.915c0.222,1.872,1.91,3.202,3.791,2.99C101.379,43.261,102.717,41.564,102.497,39.692z"/><path d="M129.492,63.556l-6.775-28.174c-0.212-0.879-0.765-1.64-1.536-2.113c-0.771-0.469-1.696-0.616-2.581-0.406L63.613,46.087c-1.833,0.44-2.961,2.284-2.521,4.117l3.386,14.082c0.44,1.835,2.284,2.964,4.116,2.521c1.833-0.44,2.961-2.284,2.521-4.117l-2.589-10.764l48.35-11.626l5.977,24.854c0.375,1.565,1.775,2.615,3.316,2.615c0.265,0,0.533-0.031,0.802-0.096C128.804,67.232,129.932,65.389,129.492,63.556z"/><path d="M179.197,64.679c-0.094-1.814-1.592-3.238-3.41-3.238H25.6c-1.818,0-3.316,1.423-3.41,3.238l-6.827,133.12c-0.048,0.934,0.29,1.848,0.934,2.526c0.645,0.677,1.539,1.062,2.475,1.062h163.84c0.935,0,1.83-0.384,2.478-1.062c0.643-0.678,0.981-1.591,0.934-2.526L179.197,64.679z M22.364,194.56l6.477-126.293h143.701l6.477,126.293H22.364z"/><path d="M126.292,75.093c-5.647,0-10.24,4.593-10.24,10.24c0,5.647,4.593,10.24,10.24,10.24c5.647,0,10.24-4.593,10.24-10.24C136.532,79.686,131.939,75.093,126.292,75.093z M126.292,88.747c-1.883,0-3.413-1.531-3.413-3.413s1.531-3.413,3.413-3.413c1.882,0,3.413,1.531,3.413,3.413S128.174,88.747,126.292,88.747z"/><path d="M75.092,75.093c-5.647,0-10.24,4.593-10.24,10.24c0,5.647,4.593,10.24,10.24,10.24c5.647,0,10.24-4.593,10.24-10.24C85.332,79.686,80.739,75.093,75.092,75.093z M75.092,88.747c-1.882,0-3.413-1.531-3.413-3.413s1.531-3.413,3.413-3.413s3.413,1.531,3.413,3.413S76.974,88.747,75.092,88.747z"/><path d="M126.292,85.333h-0.263c-1.884,0-3.413,1.529-3.413,3.413c0,0.466,0.092,0.911,0.263,1.316v17.457c0,12.233-9.953,22.187-22.187,22.187s-22.187-9.953-22.187-22.187V88.747c0-1.884-1.529-3.413-3.413-3.413s-3.413,1.529-3.413,3.413v18.773c0,15.998,13.015,29.013,29.013,29.013s29.013-13.015,29.013-29.013V88.747C129.705,86.863,128.176,85.333,126.292,85.333z"/>
</svg></div>
      <div class="count"><?php echo $t_prod_n;?></div>
      <h3 class="text-blue">Products</h3>
      <p>Donations value in SRD.</p>
    </div>
    </div>
  </div>
  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-body">
      <div class="icon">
        <svg id="service-icon" viewBox="0 0 569 569.54905" xmlns="http://www.w3.org/2000/svg"><path d="m1.527344 52.246094 37.984375 66.46875c1.28125 2.246094 3.425781 3.871094 5.933593 4.5l35.4375 8.859375 121.542969 121.542969 13.429688-13.425782-123.445313-123.441406c-1.214844-1.21875-2.738281-2.082031-4.40625-2.5l-34.050781-8.542969-32.339844-56.625 27.726563-27.726562 56.648437 32.371093 8.546875 34.050782c.414063 1.671875 1.28125 3.199218 2.496094 4.414062l123.445312 123.445313 13.425782-13.429688-121.542969-121.542969-8.859375-35.417968c-.628906-2.511719-2.253906-4.660156-4.5-5.945313l-66.472656-37.980469c-3.707032-2.109374-8.371094-1.484374-11.394532 1.527344l-37.980468 37.984375c-3.0546878 3.003907-3.71875 7.675781-1.625 11.414063zm0 0"/><path d="m396.3125 187.144531-208.902344 208.90625-13.429687-13.429687 208.90625-208.902344zm0 0"/><path d="m150.847656 403.441406c-1.71875-2.859375-4.804687-4.605468-8.140625-4.605468h-56.972656c-3.332031 0-6.421875 1.746093-8.136719 4.605468l-28.488281 47.476563c-1.808594 3.007812-1.808594 6.769531 0 9.78125l28.488281 47.476562c1.714844 2.855469 4.804688 4.605469 8.136719 4.605469h56.972656c3.335938 0 6.421875-1.75 8.140625-4.605469l28.484375-47.476562c1.808594-3.011719 1.808594-6.773438 0-9.78125zm-13.511718 90.347656h-46.226563l-22.789063-37.980468 22.789063-37.984375h46.226563l22.789062 37.984375zm0 0"/><path d="m456.0625 227.914062c62.714844.210938 113.730469-50.460937 113.941406-113.175781.03125-9.546875-1.140625-19.054687-3.488281-28.308593-1.265625-5.089844-6.417969-8.1875-11.507813-6.921876-1.671874.417969-3.195312 1.28125-4.414062 2.496094l-59.109375 59.070313-46.898437-15.628907-15.640626-46.886718 59.109376-59.121094c3.707031-3.710938 3.703124-9.722656-.007813-13.429688-1.222656-1.222656-2.761719-2.089843-4.445313-2.503906-60.820312-15.402344-122.605468 21.414063-138.007812 82.230469-2.339844 9.226563-3.507812 18.710937-3.476562 28.230469.023437 7.476562.792968 14.929687 2.308593 22.25l-207.957031 207.953125c-7.320312-1.511719-14.773438-2.28125-22.246094-2.308594-62.933594 0-113.949218 51.015625-113.949218 113.949219 0 62.929687 51.015624 113.945312 113.949218 113.945312 62.929688 0 113.945313-51.015625 113.945313-113.945312-.023438-7.476563-.796875-14.929688-2.308594-22.25l49.785156-49.785156 21.773438 21.773437c3.710937 3.707031 9.71875 3.707031 13.429687 0l4.746094-4.75c4.164062-4.136719 10.894531-4.136719 15.058594 0 4.160156 4.148437 4.167968 10.882813.019531 15.042969-.003906.003906-.011719.011718-.019531.019531l-4.746094 4.746094c-3.707031 3.707031-3.707031 9.71875 0 13.425781l113.273438 113.273438c29.792968 30.066406 78.316406 30.285156 108.382812.492187 30.0625-29.792969 30.28125-78.320313.488281-108.382813-.160156-.164062-.324219-.328124-.488281-.492187l-113.273438-113.269531c-3.707031-3.707032-9.71875-3.707032-13.425781 0l-4.746093 4.746094c-4.167969 4.140624-10.894532 4.140624-15.0625 0-4.15625-4.148438-4.167969-10.882813-.019532-15.039063.007813-.007813.015625-.011719.019532-.019531l4.75-4.75c3.707031-3.707032 3.707031-9.71875 0-13.425782l-21.773438-21.773437 49.785156-49.785156c7.320313 1.511719 14.773438 2.285156 22.246094 2.308593zm37.308594 322.851563c-6.898438-.011719-13.738282-1.257813-20.195313-3.683594l74.160157-74.164062c11.191406 29.769531-3.867188 62.972656-33.636719 74.164062-6.496094 2.441407-13.382813 3.691407-20.328125 3.683594zm-107.574219-246.792969c-10.515625 12.542969-8.867187 31.238282 3.675781 41.75 11.023438 9.238282 27.089844 9.230469 38.101563-.027344l106.5625 106.65625c1.15625 1.160157 2.238281 2.382813 3.285156 3.625l-81.1875 81.1875c-1.246094-1.042968-2.46875-2.125-3.628906-3.285156l-106.644531-106.652344c10.515624-12.542968 8.867187-31.238281-3.675782-41.75-11.023437-9.242187-27.09375-9.230468-38.105468.023438l-15.191407-15.191406 81.613281-81.492188zm38.34375-95.503906-215.410156 215.367188c-2.363281 2.359374-3.3125 5.785156-2.507813 9.023437 13.027344 51.160156-17.886718 103.195313-69.050781 116.21875-51.160156 13.027344-103.195313-17.886719-116.222656-69.050781-13.023438-51.160156 17.890625-103.195313 69.054687-116.222656 15.476563-3.9375 31.691406-3.9375 47.167969 0 3.238281.792968 6.65625-.15625 9.023437-2.503907l215.359376-215.371093c2.359374-2.359376 3.308593-5.785157 2.496093-9.019532-12.9375-50.5625 17.5625-102.039062 68.125-114.980468 9.554688-2.441407 19.4375-3.378907 29.28125-2.765626l-50.089843 50.109376c-2.542969 2.539062-3.433594 6.300781-2.296876 9.710937l18.988282 56.976563c.949218 2.832031 3.175781 5.058593 6.011718 6l56.976563 18.992187c3.40625 1.136719 7.167969.25 9.710937-2.289063l50.089844-50.089843c.113282 1.8125.171875 3.605469.171875 5.390625.265625 52.175781-41.8125 94.6875-93.988281 94.957031-8.066406.039063-16.105469-.953125-23.917969-2.953125-3.238281-.808594-6.664062.136719-9.023437 2.496094h.050781zm0 0"/><path d="m491.273438 477.578125-13.429688 13.429687-94.953125-94.953124 13.425781-13.429688zm0 0"/></svg></div>
      <div class="count"><?php echo $t_service_n;?></div>
      <h3 class="text-orange">Services</h3>
      <p>Donations value in SRD.</p>
    </div>
    </div>
  </div>
  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-body">
      <div class="icon"><svg version="1.1" id="cash-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 481 481" style="enable-background:new 0 0 481 481;" xml:space="preserve"><path d="M256.7,301.9h-27.5c-10,0-18.1-8.1-18.1-18.1s8.1-18.1,18.1-18.1h48.4c6.6,0,12-5.4,12-12c0-6.6-5.4-12-12-12h-22.7V225c0-6.6-5.4-12-12-12s-12,5.4-12,12v16.7h-1.7c-23.2,0-42.1,18.9-42.1,42.1s18.9,42.1,42.1,42.1h27.5c10,0,18.1,8.1,18.1,18.1s-8.1,18.1-18.1,18.1h-49.3c-6.6,0-12,5.4-12,12c0,6.6,5.4,12,12,12H231v17.1c0,6.6,5.4,12,12,12c6.6,0,12-5.4,12-12v-17.1h2c0.1,0,0.2,0,0.3,0c23-0.3,41.5-19.1,41.5-42.1C298.8,320.8,279.9,301.9,256.7,301.9z"/><path d="M423.3,274.7c-12.6-29-30-57.1-52-83.4c-26.6-32-53.1-53.4-66.6-63.3l51-94.6c2.5-4.7,1.7-10.5-2.2-14.2C340.3,6.3,326.3,0,310.7,0c-14.3,0-27.4,5.4-38.8,10.2c-9,3.7-17.5,7.3-24.4,7.3c-2.1,0-3.9-0.3-5.7-1C218,7.8,199.7,2.4,182,2.4c-22.4,0-41.5,9-60.2,28.2c-3.9,4-4.5,10.3-1.4,15l55,83.1c-13.6,10.1-39.6,31.3-65.7,62.6c-21.9,26.3-39.4,54.4-52,83.4c-15.8,36.5-23.8,74.6-23.8,113.2c0,51.3,41.8,93.1,93.1,93.1h227c51.3,0,93.1-41.8,93.1-93.1C447.1,349.3,439.1,311.2,423.3,274.7z M146,40.6c11.6-10,22.7-14.4,36-14.4c14.2,0,30.2,4.8,51.5,12.7c4.4,1.6,9.1,2.4,13.9,2.4c11.7,0,22.9-4.6,33.6-9.1c10.3-4.3,20.1-8.4,29.6-8.4c4.6,0,11.1,0.8,19.3,6.6l-48,89.2h-83.6L146,40.6z M354,457H127c-38.1,0-69.1-31-69.1-69.1c0-64.1,23.5-124.9,69.7-180.7c29.2-35.3,58.9-57.2,67.9-63.6h89.8c9.1,6.3,38.7,28.3,67.9,63.6c46.3,55.8,69.7,116.5,69.7,180.7C423.1,426,392.1,457,354,457z"/>
</svg></div>
      <div class="count"><?php echo $t_cash_n;?></div>
      <h3 class="text-green">Cash</h3>
      <p>Donations in SRD.</p>
    </div>
    </div>
  </div>
  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-body">
      <div class="icon"><svg version="1.1" id="total-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path d="M156,256c0,11.046,8.954,20,20,20h60v60c0,11.046,8.954,20,20,20s20-8.954,20-20v-60h60c11.046,0,20-8.954,20-20c0-11.046-8.954-20-20-20h-60v-60c0-11.046-8.954-20-20-20s-20,8.954-20,20v60h-60C164.954,236,156,244.954,156,256z"/><path class="fill-green" d="M160.406,61.8l25.869-10.716c10.204-4.228,15.051-15.927,10.823-26.132c-4.228-10.205-15.926-15.054-26.132-10.823l-25.869,10.716c-10.204,4.228-15.051,15.927-10.823,26.132C138.488,61.148,150.168,66.038,160.406,61.8z"/><path d="M256,0c-11.046,0-20,8.954-20,20s8.954,20,20,20c119.378,0,216,96.608,216,216c0,119.378-96.608,216-216,216c-119.378,0-216-96.608-216-216c0-11.046-8.954-20-20-20s-20,8.954-20,20c0,141.483,114.497,256,256,256c141.483,0,256-114.497,256-256C512,114.517,397.503,0,256,0z"/><path class="fill-orange" d="M93.366,113.165l19.799-19.799c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L65.081,84.88c-7.811,7.811-7.811,20.475,0,28.285C72.89,120.974,85.555,120.976,93.366,113.165z"/><path class="fill-blue" d="M24.952,197.099c10.227,4.236,21.914-0.642,26.132-10.823l10.716-25.87c4.228-10.205-0.619-21.904-10.823-26.132
        c-10.207-4.227-21.904,0.619-26.132,10.823l-10.716,25.869C9.901,181.172,14.748,192.871,24.952,197.099z"/>
</svg></div>
      <div class="count"><?php echo $t_all_n;?></div>
      <h3 class="text-brown">Total</h3>
      <p>All donations in SRD.</p>
    </div>
    </div>
  </div>
</div>


</div>
<!-- top tiles -->
  <div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
  <div class="panel panel-default">
    <div class="panel-heading"><h3>Flow chart</h3></div>
    <div class="panel-body chart-height">
      <canvas id="line_all"></canvas>
    </div>
  </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
  <div class="panel panel-default">
    <div class="panel-heading"><h3>Bar chart</h3></div>
    <div class="panel-body chart-height">
      <canvas id="bar_all"></canvas>
    </div>
  </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
  <div class="panel panel-default">
    <div class="panel-heading"><h3>Doughnut</h3></div>
    <div class="panel-body chart-height">
      <canvas id="doughnut_all"></canvas>
    </div>
  </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
  <div class="panel panel-default">
    <div class="panel-heading"><h3>Vertical Bar</h3></div>
    <div class="panel-body chart-height">
      <canvas id="horizontalbar_all"></canvas>
    </div>
  </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
</div>

<?php // print_r($data); ?>
<?php // print_r($totals); ?>
<script type="text/javascript">


  <?php foreach ($data as $key => $value): ?>
   var <?php echo $key ?> = [
       <?php foreach ($value as $v){ ?>
         [<?php echo strtotime($v['date']).'000';?>, <?php echo $v['amount']?>],
       <?php } ?>
   ];

  <?php endforeach ?>



  function gd(year, month, day) {
    return new Date(year, month - 1, day).getTime();
  }

  var randNum = function() {
    return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
  };
  
    ////

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


    ////


      if ($('#line_all').length ){ 
        
        var ctx = document.getElementById("line_all");
        var line_all = new Chart(ctx, {
        type: 'line',
        data: {
          labels: [<?php echo $echart['dates']; ?>],
          datasets: [{
            pointRadius: 5,
            pointHoverRadius: 6,
            pointBackgroundColor: "rgba(52,152,219,0.7)",  
            label: 'Product',
            borderColor: "rgba(52,152,219,0.7)",
            backgroundColor: "rgba(52,152,219,0)",
            data: [<?php echo $echart['product']; ?>]
            }, {
            pointRadius: 5,
            pointHoverRadius: 6,
            pointBackgroundColor: "rgba(255,123,35,0.7)",
            label: 'Service',
            borderColor: "rgba(255,123,35,0.7)",
            backgroundColor: "rgba(255,123,35,0)",
            data: [<?php echo $echart['service']; ?>]
            }, {
            pointRadius: 5,
            pointHoverRadius: 6,
            pointBackgroundColor: "rgba(26,187,156,0.7)",
            label: 'Cash',
            borderColor: "rgba(26,187,156,0.7)",
            backgroundColor: "rgba(26,187,156,0)",
            data: [<?php echo $echart['cash']; ?>]
             }, {
            pointRadius: 5,
            pointHoverRadius: 6,
            pointBackgroundColor: "rgba(142,94,0,0.7)",
            label: 'Total',
            borderColor: "rgba(142,94,0,0.7)",
            backgroundColor: "rgba(142,94,0,0)",
            data: [<?php echo $echart['all']; ?>]
          }]
        },

        options: {
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
               display: true
           }]
          }
        }
        });
        
      }

      if ($('#bar_all').length ){ 
        
        var ctx = document.getElementById("bar_all");
        var mainb = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [<?php echo $echart['dates']; ?>],
          datasets: [{
            label: 'Product',
            borderColor: "rgba(52,152,219,0.7)",
            backgroundColor: "rgba(52,152,219,0.8)",
            data: [<?php echo $echart['product']; ?>]
            }, {
            label: 'Service',
            borderColor: "rgba(255,123,35,0.7)",
            backgroundColor: "rgba(255,123,35,0.8)",
            data: [<?php echo $echart['service']; ?>]
            }, {
            label: 'Cash',
            borderColor: "rgba(26,187,156,0.7)",
            backgroundColor: "rgba(26,187,156,0.8)",
            data: [<?php echo $echart['cash']; ?>]
             }, {
            label: 'Total',
            borderColor: "rgba(142,94,0,0.7)",
            backgroundColor: "rgba(142,94,0,0.8)",
            data: [<?php echo $echart['all']; ?>]
          }]
        },

        options: {
          maintainAspectRatio: false,
           legend: {
            display: true,
            position: 'top',
          },
          scales: {
          yAxes: [{
            ticks: {
            beginAtZero: true
            }
          }]
          }
        }
        });
        
      }

      if ($('#doughnut_all').length ){ 
        
        var ctx = document.getElementById("doughnut_all");
        var data = {
        labels: [
          "Products",
          "Services",
          "Cash"
        ],
        datasets: [{
          data: [<?php echo $totals['prod']['amount']?>, <?php echo $totals['service']['amount']?>, <?php echo $totals['cash']['amount']?>],
          backgroundColor: [
          "rgba(52,152,219,0.7)",
          "rgba(255,123,35,0.7)",
          "rgba(26,187,156,0.7)"
          ],
          hoverBackgroundColor: [
          "rgba(52,152,219,1)",
          "rgba(255,123,35,1)",
          "rgba(26,187,156,1)"
          ]

        }]
        };

        var doughnut_all = new Chart(ctx, {
        type: 'doughnut',
        tooltipFillColor: "rgba(51, 51, 51, 0.55)",
        data: data,
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: true,
            position: 'top',
            fullWidth: false,
          }
          }
        });
       
      }

      if ($('#horizontalbar_all').length ){ 
        
        var ctx = document.getElementById("horizontalbar_all");
        var data = {
        labels: [
          "Products",
          "Services",
          "Cash",
          "Total"
        ],
        datasets: [{
          label: 'Amount',
          data: [<?php echo $totals['prod']['amount']?>, <?php echo $totals['service']['amount']?>, <?php echo $totals['cash']['amount']?>, <?php echo $totals['all']['amount']?>],
          backgroundColor: [
          "rgba(52,152,219,0.7)",
          "rgba(255,123,35,0.7)",
          "rgba(26,187,156,0.7)",
          "rgba(142,94,0,0.7)"
          ],
          hoverBackgroundColor: [
          "rgba(52,152,219,1)",
          "rgba(255,123,35,1)",
          "rgba(26,187,156,1)",
          "rgba(142,94,0,0.7)"
          ]

        }]
        };

        var horizontalbar_all = new Chart(ctx, {
          type: 'horizontalBar',
          tooltipFillColor: "rgba(51, 51, 51, 0.55)",
          data: data
          ,
          options: {
            maintainAspectRatio: false,
            legend: {
              display: false,
              position: 'top',
            },
            scales: {
              xAxes: [{
              ticks: {
              beginAtZero: true
              }
              }]
            }
          }
        });
       
      } 

          </script>