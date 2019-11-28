<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->admin_part('header')?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="row">
          <?php // print_r($this->user) ?>
        
          <?php $this->admin_content();?>   
          </div>
        </div>
        <!-- /page content -->        
<?php $this->admin_part('footer')?>