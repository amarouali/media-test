<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr"> 
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
        <title></title> 
        
        {{HTML::style('packages/amar/media/css/style.css')}}

    </head> 
    <body>
<div class="row">
  @if (Session::has('notif'))
    <div data-alert class="alert-box  {{Session::get('notif.type')}}">
      {{Session::get('notif.message')}}
      <a href="#" class="close">&times;</a>
    </div>
  @endif
      <div class="row">@yield('content',$content)</div>
</div>


@section('script')
{{HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js')}}
{{HTML::script('https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js')}}
@show    


</body> 
 
</html>
     