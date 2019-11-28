<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

//echo $this->user['id'];
?>
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
        <div id="message-users" class="scroll-view">
          <div class="list-group" id="message_users">
            <?php if(isset($current_user[0])) {?>
            <a data-id="<?php echo $current_user[0]['id'] ?>" href="<?php echo admin_url('messages/view/'.$current_user[0]['id'].'/') ?>" class="list-group-item list-group-item-action active">
              <?php echo $current_user[0]['fname'] .' '. $current_user[0]['lname']; ?>
            </a>
             <?php } ?>
            <?php if(!empty($message_users)) {?>
              <?php foreach ($message_users as $key => $value) { 
                if(isset($current_user[0]['id']) && $value['id'] != $current_user[0]['id']) {
                ?>
            <a data-id="<?php echo $value['id'] ?>" href="<?php echo admin_url('messages/view/'.$value['id'].'/') ?>" class="list-group-item list-group-item-action"><?php echo $value['fname'] .' '. $value['lname']; ?></a>
              <?php } } ?>
            <?php } ?>
          </div>
        </div>
      </div>
      
       <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
        <div id="message-box" class="pos-rel scroll-view">
          <div id="all-messages">
            <div id="messages-wrap">
            <?php if(!empty($messages)){ 
              $day = $messages[0]['day'];
              ?>
              <div class="message-group">
              <div class="message-date text-center" id="message-<?php echo $day?>"><?php echo date('d F Y', strtotime($day));?></div>
            <?php
            foreach ($messages as $key => $value) {
              if($value['has_read'] == 0) {
                $has_read = '<i class="fa fa-check" aria-hidden="true"></i>';
                $no_view = 'not-viewed';
              } else {
                $has_read = '<i class="fa fa-eye text-success" aria-hidden="true"></i>';
                $no_view = 'viewed';
              }
            ?>
            <?php if($value['day'] != $day ) {
              $day = $value['day'];
              ?>
              </div>
              <div class="message-group">
              <div class="message-date text-center"><?php echo date('d F Y', strtotime($day));?></div>
            <?php } ?>
            <?php if($value['user_id'] == $this->user['id']) { ?>
            <div class="m-send text-right <?php echo 'message-'.$value['id'] . ' '. $no_view;?>">
              <span class="bg-success">
              <?php
              echo nl2br($value['message']);
               if($value['attachments'] != '') {
                $ext = explode('.', $value['attachments']);
                $ex = end($ext);
                if(in_array($ex, $img_ext)) {  ?>
                <img src="<?php echo get_protected_media($value['attachments']); ?>">
              <?php  } else {
                echo get_protected_media($value['attachments']);
                }
              }
              ?>
              </span>
                <div class="up-m-date">
                  <span class="message-time"><?php echo date('H:i', strtotime($value['created'])); ?></span>
                  <span class="viewed-message"><?php echo $has_read ?></span>
                </div>
            </div>
            <?php } else { ?>
            <div class="m-recieve text-left"><span class="bg-light">
              <?php
              echo nl2br($value['message']);
               if($value['attachments'] != '') {
                $ext = explode('.', $value['attachments']);
                $ex = end($ext);
                if(in_array($ex, $img_ext)) {  ?>
                <img src="<?php echo get_protected_media($value['attachments']); ?>">
              <?php  } else {
                echo get_protected_media($value['attachments']);
                }
              }
              ?>
            </span>
                <div class="up-m-date">
                  <span class="message-time"><?php echo date('H:i', strtotime($value['created']));?></span>
                </div>
            </div>
             <?php } ?>
    
           <?php  }  ?>
            </div>
         <?php  } ?>
           
              </div>
            </div>
          <div id="send-box">
          <textarea class="message-area" placeholder="Your message"></textarea>
          <a class="send-message" href="#"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</a>
          <a class="send-attachment" href="#" data-toggle="tooltip" data-title="<?php echo __('Attach file','messages'); ?>"> <i class="fa fa-files-o" aria-hidden="true"></i> </a>
          <input type="file" name="" id="message-files" class="hide">
          <span class="message-info" data-toggle="tooltip" data-title="<?php echo __('Use (Shift+Enter) for new line','messages'); ?>"><i class="fa fa-info" aria-hidden="true"></i></span>
          </div>
          </div>
        </div>
      </div>
</div>
<script type="text/javascript">

var getc_u = '';
var getc_nu = '';
window.chh = '<?php echo $chd["has_update"] ?>';
window.chhm = '';
window.ist = 0;
window.chechdata = '';

getc_u = setInterval(function(){
                  var i = $('#message_users .active').attr('data-id');
                  var fdata = {
                      'data[to_person_id]' : i
                    }
                  $.getJSON( Jsapi+'messages/check-update/', fdata , function( data ) {
                      console.log(data);
                      window.chechdata = data;
                      if(window.chh != data.has_update || data.has_messages != 0) {
                        window.chh = data.has_update;
                        var pathtopage = window.location.href;
                      $('#all-messages').load(pathtopage + ' #messages-wrap', function(){
                       //  $('body').find('.loaderwrap').remove();
                       $('body').find('#user_is_typing').remove();
                        $("#messages-wrap span").linkify({
                            target: '_blank',
                            rel: 'nofollow'
                          });
                        var scr = $('#all-messages')[0].scrollHeight;
                        $('#all-messages').animate({scrollTop: scr},500);
                      });

                       $.getJSON( Jsapi+'messages/get-messages/', fdata , function( da ) {
                         console.log(da);
                       });
                      
                      }

                      if(data.is_typing == 1){
                        $('body').find('#user_is_typing').remove();
                        $('#send-box').append('<div id="user_is_typing" class="bg-primary"><div class="user_is">'+'<?php echo __("User is typing ...","messages") ?>'+'</div></div>')
                      } else {
                        $('body').find('#user_is_typing').remove();

                      }
                    });
                 },2000);

$(window).on("blur focus", function(e) {
    var prevType = $(this).data("prevType");
    
    if (prevType != e.type) {   //  reduce double fire issues
      clearInterval(getc_u);
      clearInterval(getc_nu);
      var i = $('#message_users .active').attr('data-id');
                var fdata = {
                  'data[to_person_id]' : i
                }
     
      getc_u = null;
      getc_nu = null;
        switch (e.type) {
            case "blur":
            console.log(e.type);
                // Check if has messages every x seconds
                // $.getJSON( Jsapi+'messages/do-update/', fdata , function( data ) {});
                getc_nu = setInterval(function(){
                  var i = $('#message_users .active').attr('data-id');
                  var fdata = {
                      'data[to_person_id]' : i
                    }
                  $.getJSON( Jsapi+'messages/check-update/', fdata , function( data ) {
                      // console.log(data);
                      window.chechdata = data;
                      if(window.chh != data.has_update) {
                        window.chh = data.has_update;
                        var pathtopage = window.location.href;  
                        pathtopage = pathtopage+'?no-update=1';                    
                      $('#all-messages').load(pathtopage + ' #messages-wrap', function(){
                       //  $('body').find('.loaderwrap').remove();
                        $('body').find('#user_is_typing').remove();
                        $("#messages-wrap span").linkify({
                            target: '_blank',
                            rel: 'nofollow'
                          });

                        var scr = $('#all-messages')[0].scrollHeight;
                        $('#all-messages').animate({scrollTop: scr},500);
                      });

                      $.getJSON( Jsapi+'messages/get-messages/', fdata , function( da ) {
                         console.log(da);
                       });
                      
                      }

                      if(data.is_typing == 1){
                        $('body').find('#user_is_typing').remove();
                        $('#send-box').append('<div id="user_is_typing" class="bg-primary"><div class="user_is">'+'<?php echo __("User is typing ...","messages") ?>'+'</div></div>');
                      } else {
                        $('body').find('#user_is_typing').remove();

                      }
                    });
                 },2000);
                break;
            case "focus":
            console.log(e.type);
                // Check if has messages every x seconds
                // $.getJSON( Jsapi+'messages/do-update/', fdata , function( data ) {});
                getc_u = setInterval(function(){
                  var i = $('#message_users .active').attr('data-id');
                  var fdata = {
                      'data[to_person_id]' : i
                    }
                  $.getJSON( Jsapi+'messages/check-update/', fdata , function( data ) {
                      // console.log(data);
                      window.chechdata = data;
                      if(window.chh != data.has_update || data.has_messages != 0) {
                        window.chh = data.has_update;
                        var pathtopage = window.location.href;
                      $('#all-messages').load(pathtopage + ' #messages-wrap', function(){
                       //  $('body').find('.loaderwrap').remove();
                       $('body').find('#user_is_typing').remove();
                        $("#messages-wrap span").linkify({
                            target: '_blank',
                            rel: 'nofollow'
                          });
                        var scr = $('#all-messages')[0].scrollHeight;
                        $('#all-messages').animate({scrollTop: scr},500);
                      });

                      $.getJSON( Jsapi+'messages/get-messages/', fdata , function( da ) {
                         console.log(da);
                       });
                      
                      }

                      if(data.is_typing == 1){
                        $('body').find('#user_is_typing').remove();
                        $('#send-box').append('<div id="user_is_typing" class="bg-primary"><div class="user_is">'+'<?php echo __("User is typing ...","messages") ?>'+'</div></div>');
                      } else {
                        $('body').find('#user_is_typing').remove();

                      }
                    });
                 },2000);
                break;
        }
    }

    $(this).data("prevType", e.type);
})

  
  $("#messages-wrap span").linkify();
  function get_message_box_height(bo){
    var h = $(window).innerHeight();
    var p = $("#message-box");
    var offset = p.offset();
    $("#message-box").innerHeight(h-offset.top-bo);
    $("#message-users").innerHeight(h-offset.top-bo);
    var g = $("#message-box").height();
    var y = $("#send-box").height();
    $("#all-messages").height(g-y);
  }
 get_message_box_height(70);

 $( window ).resize(function() {
   get_message_box_height(70);
});
$(document).ready( function(){
  $('#send-box .message-area').height(19);
  var scr = $('#all-messages')[0].scrollHeight;
  $('#all-messages').animate({scrollTop: scr},500);
});

function resize_message_box(){
  var g = parseInt($("#message-box").height());
  var y =  parseInt($("#send-box").height());
  var t = (g-y)-18;
  $("#all-messages").height(t);
}
 

 $('body').on('change keyup keydown paste cut', '#send-box textarea', function () {
        $(this).height(0).height(this.scrollHeight - 20);
        window.ist = 1;
        resize_message_box();
        $('.form-error').removeClass('form-error');
    });

 $('body').on('click','.send-message', function(e){
  e.preventDefault();
  send_message();
 });

 $('body').on('keydown','.message-area', function(e){
  if (e.keyCode == 13 && !e.shiftKey) {
    e.preventDefault();
    send_message();
    return false;
  }
 })

 function send_message(){
  $('.form-error').removeClass('form-error');
  var ee = true;
  var i = $('#message_users .active').attr('data-id');
  var me =  $('.message-area');
  var m =  me.val();
  var h = '';
  
  if(m.replace(/\s+/g, '') == '') {
    me.val('');
    me.addClass('form-error');
    ee = false;
  }
  $('.message-area').val('');
  if($('body').find('#the-attachment').length){
   h = $('body').find('#the-attachment').text();
   if(h != ''){
    ee = true;
   }
  }
  if(ee){
    var fdata = {
      'data[to_person_id]' : i,
      'data[message]' : m,
      'data[attachments]' : h
    }
    $.getJSON( Jsapi+'messages/send-message/', fdata , function( data ) {
      console.log(data);
    if(data.ok == 'success'){
      var pathtopage = window.location.href;
      // alert(pathtopage);
      $('#all-messages').load(pathtopage + ' #messages-wrap', function(){
       //  $('body').find('.loaderwrap').remove();
        $("#messages-wrap span").linkify({
          target: '_blank',
          rel: 'nofollow'
        });
        $('body').find('.progress').remove();
      });
     
    } else {
      // $('body').find('.loaderwrap').remove();
    }
    $('.message-area').val('');
    $('#send-box .message-area').height(19);
    var scr = $('#all-messages')[0].scrollHeight;
    $('#all-messages').animate({scrollTop: scr},500);
    resize_message_box();
    });
  }

 }

// Check if person is typing
 setInterval(function(){
  var ch = [];
  var i = $('#message_users .active').attr('data-id');
  var fdata = {
      'data[to_person_id]' : i
    }
  if(window.ist == 1){
    window.ist = 0;
    ch['check'] = 'Typing';
     $.getJSON( Jsapi+'messages/is-typing/', fdata , function( data ) {
      ch = data;
     });
  } else {
    ch['check'] = 'Not typing';
     $.getJSON( Jsapi+'messages/is-not-typing/', fdata , function( data ) {
      ch = data;
     });
  }
  console.log(ch);
 },2000);

 $('.send-attachment').on('click', function(e){
   e.preventDefault();
   $('#message-files').click();
 });
 $('#message-files').on('change', function(){
  var fd = new FormData();
        var files = $('#message-files')[0].files[0];
        fd.append('attachment',files);
        fd.append('data[file]',1);
        sent_attachmen(fd);
        $('#send-box').append('<div class="progress"><div class="the-prog">'+'</div><div id="the-attachment"></div></div>');

 });


 function sent_attachmen(formdata){
  var u = Jsapi+'messages/file-upload/';
    $('body').find('.progress').removeClass('hide');
    $('body').find('.the-prog').removeClass('bg-success');
    $('body').find('.the-prog').addClass('bg-danger');
    $('body').find('.the-prog').css({'width' : 0 + '%'});

    $.ajax({
      xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total;
              percentComplete = parseInt(percentComplete * 100);
              $('body').find('.the-prog').css({'width' : percentComplete + '%'});
              $('body').find('.the-prog').text('Uploading '+ percentComplete + '%');
              console.log(percentComplete);
              if (percentComplete === 100) {
                
              }

            }
          }, false);

          return xhr;
        },
        url: u,
        type: 'post',
        data: formdata,
        contentType: false,
        processData: false,
        dataType: 'json',
        complete: function(xhr){
          console.log(xhr.responseText);
          $('body').find('#the-attachment').text(xhr.responseText);
          $('body').find('.the-prog').removeClass('bg-danger');
          $('body').find('.the-prog').addClass('bg-success');
          $('body').find('.the-prog').text('File has been uploaded');
          send_message();
        }
    });
}

</script>