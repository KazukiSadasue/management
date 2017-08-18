<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>create</title>
        <style>
            table {
                width:800px;
                text-align:center;
            }
        </style>
        <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="js/calendar.js"></script>
    </head>
    <body>
        <select id="year">
            @for ($i = -5; $i <= 5; $i++)
                <option value={{ \Carbon\Carbon::now()->year + $i }} @if ($i == 0) selected @endif>{{ \Carbon\Carbon::now()->year + $i }}</option>
            @endfor
        </select>
        年
        <select id="month">
            @for ($i = 1; $i <= 12; $i++)
                <option value={{ $i }} @if ($i == \Carbon\Carbon::now()->month) selected @endif>{{ $i }}</option>
            @endfor
        </select>
        月
        <input type="submit" id="send" value="表示">

        <table>
            <tr>
                <th>日付</th>
                <th>出勤状況</th>
                <th>時間</th>
                <th>プロジェクト</th>
            </tr>
            @for ($i = 1; $i <= 31; $i++)
            <tr>
                <td>{{ $i }}</td>
            </tr>
            @endfor
        </table>
    </body>
</html>