<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
// Theme information

$template['name'] = 'Homer Theme';
$template['description'] = 'This theme was bought and edited from wrapbootstrap.com to fit this applictaion';
$template['build'] = 'Requillo';
$template['build_uri'] = 'http://www.requillo.com/';
$template['created'] = '2018';
$template['updated'] = '2018';

// All stylesheets and javascript includes

$enqueue->app_style('assets/app/css/main.css?vers=2/*/**/*/');
$enqueue->app_style('assets/nestable/css/nestable.css');
$enqueue->app_style('assets/formbuilder/css/jquery.rateyo.min.css');
$enqueue->app_style('assets/formbuilder/css/formbuilder.css');
$enqueue->app_style('assets/export/css/tableexport.css?vers=1');
$enqueue->app_style('assets/confirm/css/jquery-confirm.min.css');
$enqueue->app_style('assets/iCheck/skins/flat/green.css');
$enqueue->app_style('assets/switchery/switchery.css');
$enqueue->app_style('assets/datatables.net-bs/css/dataTables.bootstrap.min.css');
$enqueue->app_style('assets/datatables.net-buttons-bs/css/buttons.bootstrap.min.css');
$enqueue->app_style('assets/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css');
$enqueue->app_style('assets/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');
$enqueue->app_style('assets/datatables.net-scroller-bs/css/scroller.bootstrap.min.css');
$enqueue->app_style('assets/scrollbar/css/jquery.scrollbar.css');
$enqueue->app_style('assets/bootstrap3/css/bootstrap.min.css');
$enqueue->app_style('assets/font-awesome/css/font-awesome.min.css');
$enqueue->app_style('assets/glyphicons/css/glyphicons.css');
$enqueue->app_style('assets/bootstrap-daterangepicker/daterangepicker.css');
$enqueue->app_style('assets/ResponsiveSlides/responsiveslides.css');
$enqueue->app_style('assets/ResponsiveSlides/themes/themes.css');

$enqueue->style('vendor/animate.css/animate.css');
$enqueue->style('assets/css/style.css');
$enqueue->style('assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css');
$enqueue->style('assets/fonts/pe-icon-7-stroke/css/helper.css');

$enqueue->app_script('assets/jquery/jquery.js');
$enqueue->app_script('assets/jquery-ui/js/jquery-ui.min.js');
$enqueue->app_script('assets/switchery/dist/switchery.min.js');
$enqueue->app_script('assets/bootstrap3/js/bootstrap.min.js');
$enqueue->app_script('assets/tinymce/tinymce.min.js'); 
$enqueue->app_script('assets/inputmask/inputmask.js'); 
$enqueue->app_script('assets/inputmask/inputmask.extensions.js'); 
$enqueue->app_script('assets/inputmask/jquery.inputmask.js'); 
$enqueue->app_script('assets/export/js/FileSaver.min.js'); 
$enqueue->app_script('assets/export/js/Blob.min.js'); 
$enqueue->app_script('assets/export/js/xls.core.min.js'); 
$enqueue->app_script('assets/export/js/tableexport.js'); 
$enqueue->app_script('assets/export/js/jspdf.min.js');
$enqueue->app_script('assets/Chart.js/dist/Chart.bundle.min.js');
$enqueue->app_script('assets/jscolor/jscolor.js');
$enqueue->app_script('assets/confirm/js/jquery-confirm.min.js');
$enqueue->app_script('assets/iCheck/icheck.min.js');
$enqueue->app_script('assets/linkify/linkify.js');
$enqueue->app_script('assets/datatables.net/js/jquery.dataTables.min.js');
$enqueue->app_script('assets/datatables.net-bs/js/dataTables.bootstrap.min.js');
$enqueue->app_script('assets/datatables.net-buttons/js/dataTables.buttons.min.js');
$enqueue->app_script('assets/datatables.net-buttons-bs/js/buttons.bootstrap.min.js');
$enqueue->app_script('assets/datatables.net-buttons/js/buttons.flash.min.js');
$enqueue->app_script('assets/datatables.net-buttons/js/buttons.html5.min.js');
$enqueue->app_script('assets/datatables.net-buttons/js/buttons.print.min.js');
$enqueue->app_script('assets/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js');
$enqueue->app_script('assets/datatables.net-keytable/js/dataTables.keyTable.min.js');
$enqueue->app_script('assets/datatables.net-responsive/js/dataTables.responsive.min.js');
$enqueue->app_script('assets/datatables.net-responsive-bs/js/responsive.bootstrap.js');
$enqueue->app_script('assets/datatables.net-scroller/js/dataTables.scroller.min.js');
$enqueue->app_script('assets/scrollbar/js/jquery.scrollbar.min.js');
$enqueue->app_script('assets/DateJS/build/date.js');
$enqueue->app_script('assets/moment/min/moment.min.js');
$enqueue->app_script('assets/bootstrap-daterangepicker/daterangepicker.js');
$enqueue->app_script('assets/ResponsiveSlides/responsiveslides.min.js');
$enqueue->app_script('assets/linkify/linkify.js');
$enqueue->app_script('assets/nestable/js/nestable.js');
$enqueue->script('vendor/slimScroll/jquery.slimscroll.min.js');
$enqueue->script('assets/js/main.js');
// Menu Icons
$nav->icon('pages','glyphicons glyphicons-more-items');
$nav->icon('users' ,'glyphicons glyphicons-parents');
$nav->icon('profile', array('m'=>'glyphicons glyphicons-old-man','f'=>'glyphicons glyphicons-woman'));
$nav->icon('settings','glyphicons glyphicons-settings');
$nav->icon('plugins','glyphicons glyphicons-electrical-plug');
$nav->icon('appearance','glyphicons glyphicons-magic');
$nav->icon('logout','glyphicons glyphicons-log-in');
$nav->default_icon('glyphicons glyphicons-puzzle-2');