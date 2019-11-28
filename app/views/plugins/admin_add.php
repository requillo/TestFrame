<div class="container-fluid">
	<div class="panel defaul-panel">
		<div class="panel-body">
		<div class="container" >
			<div class="url hide"><?php echo url('api/json/plugins/add/');?></div>
            <div class="redir hide"><?php echo admin_url('plugins/');?></div>
		    <input type="file" name="file" id="file">
		    <!-- Drag and Drop container-->
		    <div class="upload-area text-center well well-lg"  id="uploadfile">
		        <span class="drop-here" style="cursor: pointer;">Drag and Drop file here Or Click to select file</span>
		    </div>
		</div>
		<div class="progress hide">
			<div class="the-prog" style="width: 0px; padding:0 10px; color: #fff;"></div>
		</div>
		</div>
	</div>
</div>
<style type="text/css">
.the-prog { background: #009ece; height: 100%; }
</style>
<script type="text/javascript">
	$(function() {

    // preventing page from redirecting
    $("html").on("dragover", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $("span.drop-here").text("Drag here");
    });

    $("html").on("dragleave", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $("span.drop-here").text("Drag and Drop file here Or Click to select file");
    });

    $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

    // Drag enter
    $('.upload-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("span.drop-here").text("Drop");
    });

    // Drag over
    $('.upload-area').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("span.drop-here").text("Drop");
    });

    // Drop
    $('.upload-area').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();

        $("span.drop-here").text("Uploading...");

        var file = e.originalEvent.dataTransfer.files;
        var fd = new FormData();

        fd.append('file', file[0]);

        uploadData(fd);
    });

    // Open file selector on div click
    $("#uploadfile").click(function(){
        $("#file").click();
    });

    // file selected
    $("#file").change(function(){
        var fd = new FormData();

        var files = $('#file')[0].files[0];

        fd.append('file',files);

        uploadData(fd);
    });
});

// Sending AJAX request and upload file
function uploadData(formdata){
	var u = $('.url').text();
    var r = $('.redir').text();
    $('.progress').removeClass('hide');

    $.ajax({
    	xhr: function() {
			    var xhr = new window.XMLHttpRequest();
			    xhr.upload.addEventListener("progress", function(evt) {
			      if (evt.lengthComputable) {
			        var percentComplete = evt.loaded / evt.total;
			        percentComplete = parseInt(percentComplete * 100);
			        $('.the-prog').css({'width' : percentComplete + '%'});
                    $('.the-prog').text('completed '+ percentComplete + '%');
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
        success: function(response){
            addThumbnail(response);
            window.location.href = r;
        }
    });
}

// Added thumbnail
function addThumbnail(data){
    $("#uploadfile h1").remove();
    var len = $("#uploadfile div.thumbnail").length;

    var num = Number(len);
    num = num + 1;

    var name = data.name;
    var size = convertSize(data.size);
    var src = data.src;
    // Creating an thumbnail
    $("#uploadfile").append('<div id="thumbnail_'+num+'" class=""></div>');
    // $("#thumbnail_"+num).append('<img src="'+src+'" width="100%" height="78%">');
    $("#thumbnail_"+num).append('<span class="size">'+size+'<span>');
}

// Bytes conversion
function convertSize(size) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (size == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(size) / Math.log(1024)));
    return Math.round(size / Math.pow(1024, i), 2) + ' ' + sizes[i];
}
</script>