<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>test</title>
    </head>
    <body>
        <h1>テスト</h1>
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif        
        <form method="post">
            {{ csrf_field() }}
            <input type="text">
            <input type="submit">
        </form>
    </body>
</html>