<?php namespace Amar\Media\models;
use \Eloquent;
use \Config;
use \Str;
class Media extends \Eloquent {
	protected $table = 'medias';
	protected $fillable = ['id','ref','ref_id','position','file'];
    public $timestamps=false;  
	

    public static function boot()
    {
        parent::boot();

        static::saving(function($media)
        {
        	//$extensions =explode('|', Config::get('media::extensions'));
        	if(isset($media->file) && is_array($media->file)){
			$ref_id 	= $media->ref_id;
			$pathinfo 	= pathinfo($media->file['name']);
			$extension  = strtolower($pathinfo['extension']) == 'jpeg' ? 'jpg' : strtolower($pathinfo['extension']);
			
			$filename =Str::slug($pathinfo['filename']);
			if(!Config::get('media::path.'.$media->ref)){
				$path = Config::get('media::path.Media');
			}else{
			 	$path = Config::get('media::path.'.$media->ref);
			}

			
			$search 	= array('/', '%id', '%mid', '%cid', '%y', '%m', '%f');
			$replace 	= array('/', $ref_id, ceil($ref_id/1000), ceil($ref_id/100), date('Y'), date('m'),$filename);
			$file  		= str_replace($search, $replace, $path) . '.' . $extension;
			self::testDuplicate($file);
			if(!file_exists(dirname(public_path().'/'.$file))){
				mkdir(dirname(public_path().'/'.$file),0777,true);
			}

			self::move_uploaded_file($media->file['tmp_name'],public_path().'/'.$file);
			chmod(public_path().'/'.$file,0777);
			$media->file = $file;
			//return dd($media->file['tmp_name']);
     		

        	}

        	return 'fau';
        });

		static::deleting(function($media){

				$file = $media->file;
				$info = pathinfo($file);
				foreach(glob(public_path().'/'.$info['dirname'].'/'.$info['filename'].'_*x*.jpg') as $v){
					unlink($v);
				}
				foreach(glob(public_path().'/'.$info['dirname'].'/'.$info['filename'].'.'.$info['extension']) as $v){
					unlink($v);
				}
				return true;
						
		});	

  	}

	public static function move_uploaded_file($filename, $destination){
		return move_uploaded_file($filename, $destination);
	}

	public  static function testDuplicate(&$dir,$count = 0){
		$file = $dir;
		
		if($count > 0){
			$pathinfo = pathinfo($dir);
			$file = $pathinfo['dirname'].'/'.$pathinfo['filename'].'-'.$count.'.'.$pathinfo['extension'];
		}
		if(!file_exists(public_path().'/'.$file)){
			$dir = $file;

		}else{
			$count++;
			self::testDuplicate($dir,$count);
		}
		
	}


}