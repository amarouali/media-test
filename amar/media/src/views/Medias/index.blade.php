

<div class="bloc">
    <div class="content">
		

		
		<div id="plupload">
		    <div id="droparea" href="#">
		    	<p><?php echo "Déplacer les fichiers ici"; ?></p>
		    	<?php echo "ou"; ?><br/>
		    	<a id="browse" href="#"><?php echo "Parcourir"; ?></a>
		    	<p class="small"><?php echo 'extensions'; ?></p>
		    </div>
		</div>
		<table class="head" cellspacing="0">
			<thead>
				<tr>
					<th style="width:55%"><?php echo "Médias"; ?></th>
					<th style="width:20%"> &nbsp; </th>
					<th style="width:25%"><?php echo "Actions"; ?></th>
				</tr>
			</thead>
		</table>
		<div id="filelist">
			{{Form::open(['route'=>'media/order','id'=>'MediaIndexForm'])}}
			@foreach ($medias as $media)
				@include('media::Medias.media',['test'=>'je teste'])
			@endforeach
			
			{{Form::close()}}
		</div>

    </div>
</div>
@section('script')
@parent
{{HTML::script('packages/amar/media/js/jquery.form.js')}}
{{HTML::script('packages/amar/media/js/plupload.js')}}
{{HTML::script('packages/amar/media/js/plupload.html5.js')}}
{{HTML::script('packages/amar/media/js/plupload.flash.js')}}
<script>
	

jQuery(function(){
	$( "#filelist>form" ).sortable({
		update:function(){
			i = 0;
			$('#filelist>form>div').each(function(){
				i++;
				console.log($(this).find('input').val(0));
				$(this).find('input').val(i);
			});
			$('#MediaIndexForm').ajaxSubmit();
			
		}

	});

$('a.del').live('click',function(e){
		e.preventDefault();
		elem = $(this);
		console.log(elem.attr('href'));
		if(confirm('"Voulez vous vraiment supprimer ce média ?"')){
			$.post(elem.attr('href'),{},function(data){
				elem.parents('.item').slideUp();
			});
		}
		theFrame.animate({ height:theFrame.height() - 40 });
	});	

	var theFrame = $("#medias-{{$ref}}-{{$ref_id}}", parent.document.body);
	var uploader = new plupload.Uploader({
		runtimes : 'html5,flash',
		container: 'plupload',
		browse_button : 'browse',
		max_file_size : '50mb',
		flash_swf_url : "{{URL::to('packages/amar/media/js/plupload.flash.swf')}}",
		filters : [
			{title : "Accepted files", extensions : "<?php echo str_replace('|', ',', Config::get('media::extensions')) ; ?>"},
		],
		url : "{{URL::route('media/upload',[$ref,$ref_id])}}",
		drop_element : 'droparea',
		multipart:true,
		urlstream_upload:true
	});
	uploader.init();

	uploader.bind('FilesAdded', function(up, files) {
		for (var i in files) {
			$('#filelist>form').prepend('<div class="item" id="' + files[i].id + '">&nbsp; &nbsp;' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <div class="progressbar"><div class="progress"></div></div></div>');
		}
		uploader.start();
		$('#droparea').removeClass('dropping');
		theFrame.css({ height:$('body').height() + 40 });

	});	

	uploader.bind('UploadProgress', function(up, file) {
		$('#'+file.id).find('.progress').css('width',file.percent+'%')
	});

	uploader.bind('FileUploaded', function(up, file, response){
		console.log(response);
		var response = jQuery.parseJSON(response.response);

		if(response.error){
			alert(response.error)
		}else{
				
			$('#'+file.id).before(response);
		}
		$('#'+file.id).remove();
	});

	uploader.bind('Error',function(up, err){
		alert(err.message);
		$('#droparea').removeClass('dropping');
		uploader.refresh();
	});

	$('#droparea').bind({
       dragover : function(e){
           $(this).addClass('dropping');
       },
       dragleave : function(e){
           $(this).removeClass('dropping');
       }
	});
});


</script>
@stop
