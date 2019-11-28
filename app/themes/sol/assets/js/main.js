(function(e) {
    e.fn.hoverIntent = function(t, n, r) {
        var i = {
            interval: 100,
            sensitivity: 7,
            timeout: 0
        };
        if (typeof t === "object") {
            i = e.extend(i, t)
        } else if (e.isFunction(n)) {
            i = e.extend(i, {
                over: t,
                out: n,
                selector: r
            })
        } else {
            i = e.extend(i, {
                over: t,
                out: t,
                selector: n
            })
        }
        var s, o, u, a;
        var f = function(e) {
            s = e.pageX;
            o = e.pageY
        };
        var l = function(t, n) {
            n.hoverIntent_t = clearTimeout(n.hoverIntent_t);
            if (Math.abs(u - s) + Math.abs(a - o) < i.sensitivity) {
                e('body').off("mousemove.hoverIntent", n, f);
                n.hoverIntent_s = 1;
                return i.over.apply(n, [t])
            } else {
                u = s;
                a = o;
                n.hoverIntent_t = setTimeout(function() {
                    l(t, n)
                }, i.interval)
            }
        };
        var c = function(e, t) {
            t.hoverIntent_t = clearTimeout(t.hoverIntent_t);
            t.hoverIntent_s = 0;
            return i.out.apply(t, [e])
        };
        var h = function(t) {
            var n = jQuery.extend({}, t);
            var r = this;
            if (r.hoverIntent_t) {
                r.hoverIntent_t = clearTimeout(r.hoverIntent_t)
            }
            if (t.type == "mouseenter") {
                u = n.pageX;
                a = n.pageY;
                e('body').on("mousemove.hoverIntent", r, f);
                if (r.hoverIntent_s != 1) {
                    r.hoverIntent_t = setTimeout(function() {
                        l(n, r)
                    }, i.interval)
                }
            } else {
                e('body').off("mousemove.hoverIntent", r, f);
                if (r.hoverIntent_s == 1) {
                    r.hoverIntent_t = setTimeout(function() {
                        c(n, r)
                    }, i.timeout)
                }
            }
        };
        return this.on({
            "mouseenter.hoverIntent": h,
            "mouseleave.hoverIntent": h
        }, i.selector)
    }
})(jQuery);

function makeTall(){
    var p = $(this).closest('ul');
    if(p.hasClass('submenu')) {

    } else {
        $(this).animate({'max-width':420},'slow');
        $(this).find('a').animate({'border-color': '#f09721'},'slow');
        $(this).find('.submenu').slideToggle( "slow" );
    }
    
 }
 function makeShort(){
    var p = $(this).closest('ul');
    if(p.hasClass('submenu')) {

    } else {
        $(this).find('.submenu').slideToggle( "slow" );
        $(this).animate({'max-width':65},'slow');
        $(this).find('a').animate({'border-color': '#fff'},'slow');
    }
    
 }

 function add_switch(){
  if ($(".js-switch")[0]) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#337ab7'
            });
        });
    }
}

function add_icheck(){
  if ($("input.flat")[0]) {
        $(document).ready(function () {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    }
}


$(document).ready(function () {

    $('.no-enter input').on('keydown',function(e){
       var key = e.keyCode;
       if(e.keyCode == 13) {
          e.preventDefault();
          return false;
        }
    })

add_switch();
add_icheck();

    // For Menu Slide              
   $('.menu-aside ul li').hoverIntent({ //
    timeout: 400, // For delay when mouse out in milsec
    over:makeTall,
    out:makeShort 
  });

    $('#show-menu-mobile').click(function(){
        $(this).toggleClass('open');
        $('body').toggleClass('mobile-open');
    });
// For plugins activation
   $( document ).ajaxComplete(function() {
      $('.menu-aside ul li').hoverIntent({ //
        timeout: 400, // For delay when mouse out in milsec
        over:makeTall,
        out:makeShort 
      });
    });
});