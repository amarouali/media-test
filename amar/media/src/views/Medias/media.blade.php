<div class="item {{ ($thumbID && $media->id === $thumbID)?'thumbnail' : '' }} ">

	<input type="hidden" value="{{$media->position}}" name="data[{{$media->id}}]">


		<div class="visu">{{HTML::image($media->file)}}</div>
		<?php echo basename($media->file); ?>

		<div class="actions">
			{{($thumbID !== false && $media->id !== $thumbID) ? HTML::link(URL::route('media/thumb',$media->id),'Mettre en image à la une - '): ''}} 
			{{HTML::link(URL::route('media/delete',$media->id),'Supprimer',['class'=>'del'])}}	

		</div>
</div>
