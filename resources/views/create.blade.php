<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>create</title>
    </head>
    <body>
        <h1>新規作成</h1>
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
                    <th>名前</th>
                    <td><input type="text" name="name" value="{{ old('name') }}"></td>
                </tr>
                <tr>
                    <th>メール</th>
                    <td><input type="text" name="email" value="{{ old('email') }}"></td>
                </tr>
                <tr>
                    <th>住所</th>
                    <td>
                        <select name="pref">
                                <option value="">---</option>
                            @foreach(config('pref') as $index => $name)
                                <option value="{{ $index }}" @if(old('pref') == $index) selected @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td><input type="password" name="password"></td>
                </tr>
            </table>
            {{ csrf_field() }}
            <input type="submit" value="作成">
        </form>
        <a href="login">ログイン画面</a>
    </body>
</html>