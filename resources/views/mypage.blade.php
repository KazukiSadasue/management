<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>mypage</title>
        <style>
            li {
                list-style:none;
                float:left;
                margin-left:5px;
                margin-right:5px;
            }
            .error{
                color:red;
            }
        </style>
        <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        
    </head>
    <body>
        <a href="logout">ログアウト</a>
        <h1>ようこそ{{ Session::get('name') }}さん</h1>
        <a href="start">勤務開始</a>
        <a href="finish">勤務終了</a>
        <hr>
        @if (Session::has('error_message'))
            <p class="error">{{ Session::get('error_message') }}</p>
        @endif
        <h2>勤怠履歴</h2>
        @if (count($histories) != 0)
            @foreach ($histories as $history)
                <p>
                    @if ($history->work_type == 1)
                        出勤
                    @endif
                    @if ($history->work_type == 2)
                        退勤
                    @endif
                    {{ $history->work_time }}
                </p>
            @endforeach
            {{ $histories->links() }}
        @else
        <p>勤怠履歴はありません</p>
        @endif
    </body>
</html>