<?php namespace Amar\Media;
	class Media {
		

		public function __construct($html,$url){
			$this->html=$html;
			$this->url=$url;
		}

		function get(){

			return 'media';
		}

		public function iframe($ref,$ref_id){
			
			$url=$this->url->route('media/index',[$ref,$ref_id]);
			return '<iframe src="' . $url. '" style="width:100%;" id="medias-' . $ref . '-' . $ref_id . '"></iframe>';
		

			
		}
	}
 ?>