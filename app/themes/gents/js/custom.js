/**
 * Resize function without multiple trigger
 * 
 * Usage:
 * $(window).smartresize(function(){  
 *     // code here
 * });
 */
(function($,sr){
    // debouncing function from John Hann
    // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
    var debounce = function (func, threshold, execAsap) {
      var timeout;

        return function debounced () {
            var obj = this, args = arguments;
            function delayed () {
                if (!execAsap)
                    func.apply(obj, args); 
                timeout = null; 
            }

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 100); 
        };
    };

    // smartresize 
    jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
    $('[data-toggle="popover"]').popover();

})(jQuery,'smartresize');
/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var CURRENT_URL = window.location.href.split('#')[0].split('?')[0],
    $BODY = $('body'),
    $MENU_TOGGLE = $('#menu_toggle'),
    $SIDEBAR_MENU = $('.nav-md #sidebar-menu'),
    $SIDEBAR_FOOTER = $('.sidebar-footer'),
    $LEFT_COL = $('.left_col'),
    $RIGHT_COL = $('.right_col'),
    $NAV_MENU = $('.nav_menu'),
    $FOOTER = $('footer');

  
  
// Sidebar
function init_sidebar() {
// TODO: This is some kind of easy fix, maybe we can improve this
var setContentHeight = function () {
  // reset height
  var h =  window.innerHeight;
  var mh =  $NAV_MENU.outerHeight();
  var fh = $FOOTER.outerHeight();
  var th =  mh + fh;
  var gh = h - fh - 4;

  $RIGHT_COL.css('min-height',gh);

  var bodyHeight = $BODY.outerHeight(),
    footerHeight = $BODY.hasClass('footer_fixed') ? -10 : $FOOTER.height(),
    leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
    contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;

  // normalize content
  contentHeight -= $NAV_MENU.height() + footerHeight;

  // $RIGHT_COL.css('min-height', contentHeight);
};

  $('body').find('#sidebar-menu').on('click', 'a', function(ev) {
    // alert(12);
    console.log('clicked - sidebar_menu');
        var $li = $(this).parent();

        if ($li.is('.active')) {
            $li.removeClass('active active-sm');
            $('ul:first', $li).slideUp(function() {
                setContentHeight();
                $('#sidebar-menu .fa').addClass('fa-chevron-down');
                $('#sidebar-menu .fa').removeClass('fa-chevron-up');
            });
            $li.find('.fa').removeClass('fa-chevron-up');
            $li.find('.fa').addClass('fa-chevron-down');
        } else {
            // prevent closing menu if we are on child menu
            if (!$li.parent().is('.child_menu')) {
                $SIDEBAR_MENU.find('li').removeClass('active active-sm');
                $SIDEBAR_MENU.find('li ul').slideUp();
            } else {

              if ( $BODY.is( ".nav-sm" ) )
              {
                $SIDEBAR_MENU.find( "li" ).removeClass( "active active-sm" );
                $SIDEBAR_MENU.find( "li ul" ).slideUp();
              }
            }
            $li.addClass('active');
            $('ul:first', $li).slideDown(function() {
                setContentHeight();
               
            });
            $('#sidebar-menu .fa').addClass('fa-chevron-down');
            $('#sidebar-menu .fa').removeClass('fa-chevron-up');
            $li.find('.fa').removeClass('fa-chevron-down');
            $li.find('.fa').addClass('fa-chevron-up');
          }
    });

// toggle small or large menu 
$MENU_TOGGLE.on('click', function() {
    console.log('clicked - menu toggle');
    
    if ($BODY.hasClass('nav-md')) {
      $SIDEBAR_MENU.find('li.active ul').hide();
      $SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
    } else {
      $SIDEBAR_MENU.find('li.active-sm ul').show();
      $SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
    }

  $BODY.toggleClass('nav-md nav-sm');
  setContentHeight();
});

  // check active menu
  $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');
  $SIDEBAR_MENU.find('li.active').addClass('current-page');
  $SIDEBAR_MENU.find('li.active').parents('ul').slideDown(function() {
        setContentHeight();
    }).closest('.parent').addClass('active');
  $SIDEBAR_MENU.find('li.active ul').slideDown(function() {
        setContentHeight();
    });
  $SIDEBAR_MENU.find('a').filter(function () {
    return this.href == CURRENT_URL;
  }).parent('li').addClass('current-page').parents('ul').slideDown(function() {
    setContentHeight();
  }).parent().addClass('active');

  // recompute content when resizing
  $(window).smartresize(function(){  
    setContentHeight();
  });

  setContentHeight();

  // fixed sidebar
  if ($.fn.mCustomScrollbar) {
    $('.menu_fixed').mCustomScrollbar({
      autoHideScrollbar: true,
      theme: 'minimal',
      mouseWheel:{ preventDefault: true }
    });
  }
};
// /Sidebar

  var randNum = function() {
    return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
  };


// Panel toolbox
$(document).ready(function() {
    $('.collapse-link').on('click', function() {
        var $BOX_PANEL = $(this).closest('.x_panel'),
            $ICON = $(this).find('i'),
            $BOX_CONTENT = $BOX_PANEL.find('.x_content');
        
        // fix for some div with hardcoded fix class
        if ($BOX_PANEL.attr('style')) {
            $BOX_CONTENT.slideToggle(200, function(){
                $BOX_PANEL.removeAttr('style');
            });
        } else {
            $BOX_CONTENT.slideToggle(200); 
            $BOX_PANEL.css('height', 'auto');  
        }

        $ICON.toggleClass('fa-chevron-up fa-chevron-down');
    });

    $('.close-link').click(function () {
        var $BOX_PANEL = $(this).closest('.x_panel');

        $BOX_PANEL.remove();
    });
});
// /Panel toolbox

// Tooltip
$(document).ready(function() {

  $('#input-dateofbirth').daterangepicker({
          singleDatePicker: true,
          singleClasses: "picker_1"
        }, function(start, end, label) {
        });

    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });
    
});
// /Tooltip

// Progressbar
if ($(".progress .progress-bar")[0]) {
    $('.progress .progress-bar').progressbar();
}
// /Progressbar

// Switchery
if ($.isFunction(add_switch)) { 
 // check for styles
} else {
  function add_switch(id = null){
    if(id == null) {
      if ($(".js-switch")[0]) {
      var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
      elems.forEach(function (html) {
        var switchery = new Switchery(html, {
          color: '#26B99A'
        });
      });
    }
    } else {
      if ($(id)[0]) {
      var elems = Array.prototype.slice.call(document.querySelectorAll(id));
      elems.forEach(function (html) {
        var switchery = new Switchery(html, {
          color: '#26B99A'
        });
      });
    }
    }
    
  }

}


function add_icheck(id = null){
  if(id == null) {
    if ($("input.flat")[0]) {
      $(document).ready(function () {
        $('input.flat').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
      });
    }
  } else {
    if ($('body').find(id)[0]) {
      $(document).ready(function () {
         console.log('test');
        $('body').find(id).iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
      });
    }
  }
  
}

$(document).ready(function() {
  add_switch();  
});
// /Switchery


// iCheck
$(document).ready(function() {
    add_icheck();
});
// /iCheck

// Plugins
$(document).ready(function() {
// Content editor
// $('#summernote').summernote();
tinymce.init({
   selector: '.editor',
  height: 500,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
});

// Print button
$('.printMe').click(function(e){
  e.preventDefault();
     window.print();
});
$('.printSpecial').click(function(e){
  e.preventDefault();
  var tid = $(this).attr('data-print');
  var name = '<h3 class="print for-print">'+$('.client-name').text() + '</h3>';
  $("#"+tid).prepend(name);
  $("#"+tid).printThis();
    //  window.print();
});
// File upload
$('input[type=file]').on('change', function(e){
  // $('.the-file').remove();
  var pa = $(this).closest('.form-group');
  var target = e.target || e.srcElement;

  var b = $(this).parent();
  var s = $(this).val();
  b.find('.the-file').remove();
  p = s.split('\\');
  n = p.pop();
  var fs = 0;
  if(target.value.length) {
    fs = this.files[0].size;
    // fs = (fs/1048576).toFixed(4);
     var fSExt = new Array('bytes', 'kb', 'mb', 'gb'),
        i=0;while(fs>900){fs/=1024;i++;}
      var exactSize = (Math.round(fs*100)/100)+' '+fSExt[i];
  }
  
  console.log(e);
  if (fs == 0) {
    pa.find('.the-file').remove();
  } else {
    b.append('<div class="text-success the-file"><small>'+n+'</small> <small class="text-danger">'+exactSize+'</small><div>');
  }
  
});

$('.no-enter input').on('keydown',function(e){
   var key = e.keyCode;
   if(e.keyCode == 13) {
      e.preventDefault();
      return false;
    }

})

$('#input-group').on('keyup',function(e){
 
  var key = e.keyCode;  
  var p = $(this).parent();
  var v = $(this).val();
  var $current = '';  
  if(v.length >= 2) {

    if (key == 13 || key == 37 || key == 39) {
// do nothing
    } else if(key == 40 || key == 38) {
      // return false;
          
        } else {
    $('#res-group').remove();

     var formdata = {'data[group]' : $('#input-group').val()}
      $.ajax({
      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url     :  'http://localhost/eowyn/api/json/users/groups/', // the url where we want to POST
      data    : formdata, // our data object
      dataType  : 'json', // what type of data do we expect back from the server
      encode    : true
    }).done(function(data) {
      p.append(data.val);

    }).fail(function(data) {
      // console.log(data);
    });

    
        }

    
  } else {
    $('body').find('#res-group').remove();
  }
  if(key == 40) {
    var $listItems = $('body').find('#res-group .opt');
    
    $selected = $listItems.filter('.selected-g');
    $listItems.removeClass('selected-g');
   if (!$selected.length || $selected.is(':last-child')) {
                $current = $listItems.eq(0);
            } else {
                $current = $selected.next();
            }
    $current.addClass('selected-g');
     //
    }

  if(key == 38) {
    var $listItems = $('body').find('#res-group .opt');
     $selected = $listItems.filter('.selected-g');
     $current = $selected.prev();
     $listItems.removeClass('selected-g');
     $current.addClass('selected-g');
     //
    }

  if(key == 13) {
    var $listItems = $('body').find('#res-group .opt');
    $selected = $listItems.filter('.selected-g');
    if($selected.length) {
    $(this).val($selected.text());
    $(this).parent().find('#res-group').remove();
    } else {
    $(this).parent().find('#res-group').remove();  
    }
    
    }

  });

$('body').on('mouseenter','.opt',function(){
  $('body').find('#res-group .opt').removeClass('selected-g');
  $(this).addClass('selected-g');
});

$('body').on('click','.opt',function(){
  var $in = $(this).closest('.form-group').find('input');
  var $id = $(this).attr('data-id');
  $in.val($(this).text());
  if($id) {
    var url = window.location.href;
    window.location.href = url+$id+'/';
  }
  $('body').find('#res-group').remove();
})
$('#settingsform #myTab').on('click', 'a', function(){
  var a = $(this).attr('href');
  var b =  $('#input-tabs').val();
  $('#input-tabs').val(a);
  if(a != b) {
     $('#input-side-tabs').val('');
   }
});
$('#settingsform #side-tabs').on('click', 'a', function(){
  var a = $(this).attr('href');
  $('#input-side-tabs').val(a);
});
// Date picker
$('.date-picker1').daterangepicker({
          singleDatePicker: true,
          autoApply: true,
          showDropdowns: true,
          locale: {
            format: 'DD-MM-YYYY'
            },
          singleClasses: "picker_2"
});

$('.date-picker2').daterangepicker({
          singleDatePicker: true,
          autoApply: true,
          showDropdowns: true,
          locale: {
            format: 'DD-MM-YYYY'
            },
          singleClasses: "picker_2"
});

// Return today's date and time
var currentTime = new Date()
// returns the year (four digits)
var year = currentTime.getFullYear()
var min_date = "1/1/" + (year-100);
var max_date = "31/12/" + year;

$('.date-of-birth').daterangepicker({
          singleDatePicker: true,
          autoApply: true,
          showDropdowns: true,
          minDate: min_date,
          maxDate: max_date,
          locale: {
            format: 'DD-MM-YYYY'
            },
          singleClasses: "picker_2"
});

});
// Plugin date-of-birth

// Table
$('table input').on('ifChecked', function () {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('table input').on('ifUnchecked', function () {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});

var checkState = '';

$('.bulk_action input').on('ifChecked', function () {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('.bulk_action input').on('ifUnchecked', function () {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});
$('.bulk_action input#check-all').on('ifChecked', function () {
    checkState = 'all';
    countChecked();
});
$('.bulk_action input#check-all').on('ifUnchecked', function () {
    checkState = 'none';
    countChecked();
});

function countChecked() {
    if (checkState === 'all') {
        $(".bulk_action input[name='table_records']").iCheck('check');
    }
    if (checkState === 'none') {
        $(".bulk_action input[name='table_records']").iCheck('uncheck');
    }

    var checkCount = $(".bulk_action input[name='table_records']:checked").length;

    if (checkCount) {
        $('.column-title').hide();
        $('.bulk-actions').show();
        $('.action-cnt').html(checkCount + ' Records Selected');
    } else {
        $('.column-title').show();
        $('.bulk-actions').hide();
    }
}

// NProgress
if (typeof NProgress != 'undefined') {
    $(document).ready(function () {
        NProgress.start();
    });

    $(window).load(function () {
        NProgress.done();
    });
} 
  $(document).ready(function() {
    init_sidebar();   
  }); 
  

