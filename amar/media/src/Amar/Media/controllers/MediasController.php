<?php 

namespace Amar\Media\controllers;

use Amar\Media\models\Media as Media;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class MediasController extends \BaseController {
public $layout='media::Layouts.default';

protected $media;
 	function __construct(Media $media){
 		$this->media = $media;
 	}

	protected function index($ref,$ref_id)
	{
		
		$model =new $ref;
        $thumbID = false;
       
        if($model->isFillable('media_id')){
        	$thumbID =$model->find($ref_id)->media_id;
        }

		$medias =$this->media->where('ref','=',$ref)->where('ref_id','=',$ref_id)->orderBy('position')->get();
		$this->layout->nest('content','media::Medias.index',compact('ref','ref_id','medias','thumbID'));
	}
	protected function media()
	{

		$this->layout->nest('content','media::Medias.media');
	}
	protected function test()
	{
		//return 'Thumb::all();';
		$this->layout->nest('content','media::Medias.test');
	}
    /**
    * Upload (Ajax)
    **/
    public function upload($ref,$ref_id){
  			$this->media->ref=$ref;	
  			$this->media->ref_id=$ref_id;	
  			$this->media->file=$_FILES['file'];
  			$this->media->save();

  			$model = new $ref;
  			$thumbID = false;
       		
       		if($model->isFillable('media_id')){
        	$thumbID =$model->find($ref_id)->media_id;
        	}
  			$thumbID =$model->find($ref_id)->media_id;	
			$view = View::make('media::Medias.media')
						->with('media',$this->media)
						->with('thumbID',$thumbID);
		    $view= $view->renderSections();
			return json_encode($view);
  	

    }
	  public function order(){

		if(Request::ajax()){
			$inputs=Input::all();
			$inputs= $inputs['data'];
			foreach($inputs as $k=>$v){
				DB::table('medias')
		        	->where('id',$k)
		        	->update(array('position'=>$v));

								

           }
           return 0;
      	}
	  		
	  	

        	
    }

	function delete($id)
	{
		
		if(Request::ajax()){
			$media =Media::findOrfail($id);
			$media->delete();
			
		}
		return 0;
	}

	    /**
    * Met l'image à la une
    **/
    public function thumb($id){
    	
    	$media=$this->media->findOrFail($id);
    	$ref = $media->ref;
        $ref_id = $media->ref_id;
        $model =new $ref;
        $model=$model->find($ref_id);
        $model->media_id=$id;
        $model->save();
 		return Redirect::route('media/index',[$ref,$ref_id]);


        
    	//return $ref->find($ref_id);
/*        $this->Media->id = $id;
        $media = $this->Media->findById($id, array('ref','ref_id'));
        if(empty($media)){
            throw new NotFoundException();
        }
        if(!$this->canUploadMedias($media['Media']['ref'], $media['Media']['ref_id'])){
            throw new ForbiddenException();
        }
        $ref = $media['Media']['ref'];
        $ref_id = $media['Media']['ref_id'];
        $this->loadModel($ref);
        $this->$ref->id = $ref_id;
        $this->$ref->saveField('media_id',$id);
        $this->redirect(array('action' => 'index', $ref, $ref_id));*/
    }
}