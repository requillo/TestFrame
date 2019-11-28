<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
// Theme information

$template['name'] = 'Default Theme';
$template['description'] = 'This is the default theme, when you install the application this theme is used';
$template['build'] = 'Requillo';
$template['build_uri'] = 'http://www.requillo.com/';
$template['created'] = '2018';
$template['updated'] = '2018';

// All stylesheets and javascript includes
$enqueue->app_style('assets/app/css/main.css?vers=2');
$enqueue->app_style('assets/nestable/css/nestable.css');
$enqueue->app_style('assets/formbuilder/css/jquery.rateyo.min.css');
$enqueue->app_style('assets/formbuilder/css/formbuilder.css');
$enqueue->app_style('assets/export/css/tableexport.css?vers=1');
$enqueue->app_style('assets/confirm/css/jquery-confirm.min.css');
$enqueue->app_style('assets/iCheck/skins/flat/blue.css');
$enqueue->app_style('assets/switchery/switchery.css');
$enqueue->app_style('assets/datatables.net-bs/css/dataTables.bootstrap.min.css');
$enqueue->app_style('assets/datatables.net-buttons-bs/css/buttons.bootstrap.min.css');
$enqueue->app_style('assets/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css');
$enqueue->app_style('assets/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');
$enqueue->app_style('assets/datatables.net-scroller-bs/css/scroller.bootstrap.min.css');
$enqueue->app_style('assets/bootstrap3/css/bootstrap.min.css');
$enqueue->app_style('assets/font-awesome/css/font-awesome.min.css');
$enqueue->app_style('assets/glyphicons/css/glyphicons.css');
$enqueue->app_style('assets/bootstrap-daterangepicker/daterangepicker.css');
$enqueue->app_style('assets/ResponsiveSlides/responsiveslides.css');
$enqueue->app_style('assets/amsify-suggestags/css/amsify.suggestags.css');
$enqueue->app_style('assets/ResponsiveSlides/themes/themes.css');

$enqueue->style('vendors/nprogress/nprogress.css');
$enqueue->style('vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css');
$enqueue->style('vendors/confirm/css/jquery-confirm.min.css');
$enqueue->style('vendors/select2/dist/css/select2.min.css');
$enqueue->style('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');
$enqueue->style('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css');
$enqueue->style('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css');
$enqueue->style('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');
$enqueue->style('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css');
$enqueue->style('css/custom.min.css?vers=23');

$enqueue->script('vendors/jquery/dist/jquery.min.js');
$enqueue->app_script('assets/jquery-ui/js/jquery-ui.min.js'); 
$enqueue->app_script('assets/jquery-ui/js/jquery.ui.touch-punch.min.js');
$enqueue->script('vendors/select2/dist/js/select2.full.min.js');
$enqueue->script('vendors/bootstrap/dist/js/bootstrap.min.js');
$enqueue->script('vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js');
$enqueue->script('vendors/fastclick/lib/fastclick.js');
$enqueue->script('vendors/nprogress/nprogress.js');
$enqueue->script('vendors/Chart.js/dist/Chart.min.js');
$enqueue->script('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js');
$enqueue->script('vendors/skycons/skycons.js');
$enqueue->script('vendors/switchery/dist/switchery.min.js');
$enqueue->script('vendors/DateJS/build/date.js');
$enqueue->script('vendors/bootstrap-daterangepicker/daterangepicker.js');
$enqueue->script('vendors/moment/min/moment.min.js');
$enqueue->script('vendors/bootstrap-daterangepicker/daterangepicker.js');
$enqueue->script('vendors/confirm/js/jquery-confirm.min.js');
// Tables
$enqueue->script('vendors/datatables.net/js/jquery.dataTables.min.js');
$enqueue->script('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js');
$enqueue->script('vendors/datatables.net-buttons/js/dataTables.buttons.min.js');
$enqueue->script('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js');
$enqueue->script('vendors/datatables.net-buttons/js/buttons.flash.min.js');
$enqueue->script('vendors/datatables.net-buttons/js/buttons.html5.min.js');
$enqueue->script('vendors/datatables.net-buttons/js/buttons.print.min.js');
$enqueue->script('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js');
$enqueue->script('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js');
$enqueue->script('vendors/datatables.net-responsive/js/dataTables.responsive.min.js');
$enqueue->script('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js');
$enqueue->script('vendors/datatables.net-scroller/js/dataTables.scroller.min.js');
$enqueue->script('vendors/jszip/dist/jszip.min.js');
$enqueue->script('vendors/pdfmake/build/pdfmake.min.js');
$enqueue->script('vendors/pdfmake/build/vfs_fonts.js');

$enqueue->app_script('assets/tinymce/tinymce.min.js'); // 
$enqueue->app_script('assets/inputmask/inputmask.js'); // 
$enqueue->app_script('assets/inputmask/inputmask.extensions.js'); // 
$enqueue->app_script('assets/inputmask/jquery.inputmask.js'); //
$enqueue->app_script('assets/export/js/FileSaver.min.js'); //
$enqueue->app_script('assets/export/js/Blob.min.js'); //
$enqueue->app_script('assets/export/js/xls.core.min.js'); //
$enqueue->app_script('assets/export/js/tableexport.js'); //jspdf.min.js
$enqueue->app_script('assets/export/js/jspdf.min.js');
$enqueue->app_script('assets/Chart.js/dist/Chart.bundle.min.js');
$enqueue->app_script('assets/jscolor/jscolor.js');
$enqueue->app_script('assets/iCheck/icheck.min.js');
$enqueue->app_script('assets/nestable/js/nestable.js');
$enqueue->app_script('assets/ResponsiveSlides/responsiveslides.min.js');
$enqueue->app_script('assets/amsify-suggestags/js/jquery.amsify.suggestags.js');
$enqueue->app_script('assets/linkify/linkify.js');
$enqueue->script('js/print.js?vers=14');
$enqueue->script('js/custom.js?vers=16','footer');

// Menu Icons
$nav->icon('dashboard','glyphicons glyphicons-dashboard');
$nav->icon('pages','glyphicons glyphicons-more-items');
$nav->icon('users' ,'glyphicons glyphicons-parents');
$nav->icon('profile', array('m'=>'glyphicons glyphicons-old-man','f'=>'glyphicons glyphicons-woman'));
$nav->icon('settings','glyphicons glyphicons-settings');
$nav->icon('web-settings','glyphicons glyphicons-display');
$nav->icon('plugins','glyphicons glyphicons-electrical-plug');
$nav->icon('appearance','glyphicons glyphicons-magic');
$nav->icon('forms','glyphicon glyphicon-list-alt');
$nav->icon('logout','glyphicons glyphicons-log-in');
$nav->default_icon('glyphicons glyphicons-puzzle-2');