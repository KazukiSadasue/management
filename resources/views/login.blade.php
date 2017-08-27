<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>login</title>
    </head>
    <body>
        <h1>ログイン</h1>
        @if (Session::has('error_message'))
            <p>{{ Session::get('error_message') }}</p>
        @endif

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif        
        <form method="post">
            <table>
                <tr>
                    <th>メール</th>
                    <td><input type="text" name="email" value="{{ old('email') }}"></td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td><input type="password" name="password"></td>
                </tr>
            </table>
            {{ csrf_field() }}
            <input type="submit" value="ログイン">
        </form>
        <a href="create">新規作成</a>
        <br><a href="/admin/login">管理者ログイン</a>
    </body>
</html>