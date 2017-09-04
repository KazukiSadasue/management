<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="utf-8" />
    <title>setting</title>
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/js/image_preview.js"></script>
</head>
<body>
 
<h1>ユーザー編集</h1>
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif        
{!! Form::open(['action' => 'UserController@update', 'files' => true]) !!}
<table>
    <tr>
        <th>画像</th>
        <td>
            <div class="preview">
                <img src="{{ Session::get('user')['image'] }}">
            </div>
            <br>{!! Form::file('fileName') !!}
            {!! Form::submit('アップロードする', ['name' => 'upload']) !!}
        </td>
    </tr>
    <tr>
        <th>名前</th>
        <td>{{ Form::text('name', Session::get('user')['name']) }}</td>
    </tr>
    <tr>
        <th>住所</th>
        <td>{{ Form::select('pref', config('pref'), Session::get('user')['pref']) }}</td>
    </tr>
</table>
{!! Form::submit('保存', ['name' => 'update']) !!}
{!! Form::close() !!}

<br><a href="/user/calendar">戻る</a>
</body>
</html>