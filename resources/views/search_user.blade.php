<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Search</title>
        <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript">
        $(function() {
            $('#send').click(function() {
                var id = $('#user').val();
                var year = $('#year').val();
                var month = $('#month').val();
                window.location.href = '/admin/search/' + id + '/' + year + '/' + month;
            });
        });
        </script>
    </head>
    <body>
        <h1>ユーザー検索</h1>
        <select id="year">
            @for ($i = \Carbon\Carbon::now()->subYear(5); $i <= \Carbon\Carbon::now()->addYear(5); $i->addYear())
                <option value="{{ $i->year }}" @if ($i->year == \Carbon\Carbon::now()->year) selected @endif>{{ $i->year }}</option>
            @endfor
        </select>
        年
        <select id="month">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" @if ($i == \Carbon\Carbon::now()->month) selected @endif>{{ $i }}</option>
            @endfor
        </select>
        月
        <select id="user">
            @foreach ($users as $user) 
                <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
            @endforeach
        </select>
        <input type="submit" id="send" value="検索">
        <br><a id="logout" href="/user/logout">ログアウト</a>

    </body>
</html>