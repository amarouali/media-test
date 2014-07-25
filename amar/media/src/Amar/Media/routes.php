<?php 




Route::group(array('namespace' => 'Amar\Media\controllers','prefix'=>'media'), function()
{
	
	Route::get('index/{ref}/{ref_id}', ['as'=>'media/index','uses'=>'MediasController@index']);
	Route::post('upload/{ref}/{ref_id}', ['as'=>'media/upload','uses'=>'MediasController@upload']);
	Route::get('media', 'MediasController@media');
	Route::get('thumb/{id}', ['as'=>'media/thumb','uses'=>'MediasController@thumb']);
	Route::post('order', ['as'=>'media/order','uses'=>'MediasController@order']);
	Route::post('delete/{id}', ['as'=>'media/delete','uses'=>'MediasController@delete']);

});

