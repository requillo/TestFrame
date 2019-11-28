/*
 *
 *   Right - Responsive Admin Template
 *   v 0.3.0
 *   http://adminbootstrap.com
 *
 */

function add_switch(){
  if ($(".js-switch")[0]) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#ed4949'
            });
        });
    }
}

function add_icheck(){
  if ($("input.flat")[0]) {
        $(document).ready(function () {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });
    }
}

$(document).ready(function() {
	quickmenu($('.quickmenu__item.active'));

	$('body').on('click', '.quickmenu__item', function() {
		quickmenu($(this))
	});

	function quickmenu(item) {
		var menu = $('.sidebar__menu');
		menu.removeClass('active').eq(item.index()).addClass('active');
		$('.quickmenu__item').removeClass('active');
		item.addClass('active');
		menu.eq(0).css('margin-left', '-'+item.index()*200+'px');
	}

	$('.sidebar li').on('click', function(e) {
		// e.stopPropagation();
		var second_nav = $(this).find('.collapse').first();
		if (second_nav.length) {
			second_nav.collapse('toggle');
			$(this).toggleClass('opened');
		}
	});

$('body').find('.main-nav').on('click', '.parent > a', function(ev) {
    // alert(12);
   // console.log('clicked - sidebar_menu');
        var $li = $(this).parent();

        if ($li.is('.closed_submenu')) {
        	$li.removeClass('closed_submenu');
        	$li.addClass('opened_submenu');
            $li.find('.submenu').slideToggle( "slow" );
            $li.find('span.fa').addClass('fa-chevron-up');
            $li.find('span.fa').removeClass('fa-chevron-down');
        } else if($li.is('.opened_submenu')) {
        	$li.removeClass('opened_submenu');
        	$li.addClass('closed_submenu');
            $li.find('.submenu').slideToggle( "slow" );
            $li.find('span.fa').addClass('fa-chevron-down');
            $li.find('span.fa').removeClass('fa-chevron-up');
        } else if($li.is('.active')) {
        	$li.find('.submenu').slideToggle( "slow" );
        	$li.addClass('closed_submenu');
        	$li.find('span.fa').removeClass('fa-chevron-up');
            $li.find('span.fa').addClass('fa-chevron-down');
        } else {
        	$li.find('.submenu').slideToggle( "slow" );
        	$li.addClass('opened_submenu');
        	$li.find('span.fa').addClass('fa-chevron-up');
            $li.find('span.fa').removeClass('fa-chevron-down');
        }
    });

	$('body.main-scrollable .main__scroll').scrollbar();
	$('.scrollable').scrollbar({'disableBodyScroll' : true});
	$(window).on('resize', function() {
		$('body.main-scrollable .main__scroll').scrollbar();
		$('.scrollable').scrollbar({'disableBodyScroll' : true});
	});

	$('.selectize-dropdown-content').addClass('scrollable scrollbar-macosx').scrollbar({'disableBodyScroll' : true});
	// $('.nav-pills, .nav-tabs').tabdrop();

	$('body').on('click', '.header-navbar-mobile__menu button', function() {
		$('.dashboard').toggleClass('dashboard_menu');
	});

	


$(document).ready(function() {
  add_switch();
});
// /Switchery


// iCheck
$(document).ready(function() {
    add_icheck();
});

});