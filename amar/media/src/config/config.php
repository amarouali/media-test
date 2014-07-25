<?php 
return [
	'extensions'=>'jpg|png|gif|pdf',
	'path'		=>[ 
					'Media'	=>'img/uploads/%y/%m/%f',
					'User'	=>'img/users/%y/%m/%f',
					'Post'	=>'img/posts/%y/%f'
					],
	'limit'=>'5000',
	'prefix' =>'media',

];
 ?>