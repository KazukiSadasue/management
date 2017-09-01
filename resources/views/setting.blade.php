<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="utf-8" />
</head>
<body>
 
<h1>Laravelで画像処理します</h1>
 
{!! Form::open(['action' => 'UserController@saveSetting', 'files' => true]) !!}
{!! Form::file('fileName') !!}
{!! Form::submit('アップロードする') !!}
{!! Form::close() !!}

@if (isset($path))
    <img src="{{ $path }}">
@endif

</body>
</html>