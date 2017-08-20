<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>calendar</title>
        <style>
            table {
                width: 800px;
                text-align: center;
                border-collapse: collapse;
            }

            table td{
                border:1px #000000 solid;
                border-width: 1px 0px;
            }

            #sat {
                color: blue;
            }

            #sun {
                color: red;
            }

            a {
                color: inherit;
                text-decoration: none;
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

        @if (isset($last_day))
            <table>
                <tr>
                    <th>日付</th>
                    <th>出勤状況</th>
                    <th>時間</th>
                    <th>プロジェクト</th>
                </tr>
                @for ($i = $first_day; $i <= $last_day; $i->addDay())
                    <tr>
                        <td @if ($i->dayOfWeek == "6") id="sat" @endif @if ($i->dayOfWeek == "0") id="sun" @endif>
                            <a href=/calendar/{{ $i->format('Y/n/j') }}>{{ $i->format('j日 (D)') }}</a>
                        </td>
                        <td>
                            出勤
                        </td>
                        <td>
                            00:00-00:00
                        </td>
                        <td>
                            testProject
                        </td>
                    </tr>
                @endfor
            </table>
        @endif
    </body>
</html>