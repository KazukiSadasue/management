<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>calendar</title>
        <link rel="stylesheet" type="text/css" href="/css/calendar.css">
        <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="/js/calendar.js"></script>
    </head>
    <body>
        <select id="year">
            @for ($i = $five_years_ago; $i <= $after_five_years; $i->addYear())
                <option value={{ $i->year }} @if ($i->year == $last_day->year) selected @endif>{{ $i->year }}</option>
            @endfor
        </select>
        年
        <select id="month">
            @for ($i = 1; $i <= 12; $i++)
                <option value={{ $i }} @if ($i == $last_day->month) selected @endif>{{ $i }}</option>
            @endfor
        </select>
        月
        <input type="submit" id="send" value="表示">
        {{ Session::get('name') }}さん
        
        @if (isset($last_day))
            <table>
                <tr>
                    <th>日付</th>
                    <th></th>
                    <th>出勤状況</th>
                    <th>時間</th>
                    <th>プロジェクト</th>
                </tr>
                @for ($i = $first_day; $i <= $last_day; $i->addDay())
                    <tr>
                        <td
                            @foreach ($holidays as $holiday) @if ($i->format('n-j') == $holiday->format('n-j')) id="holi" @endif @endforeach
                            @if ($i->dayOfWeek == "6") id="sat" @endif
                            @if ($i->dayOfWeek == "0") id="sun" @endif 
                        >
                            <a href=/calendar/{{ $i->format('Y/n/j') }}>
                                {{ $i->format('j日') }}{{ Config::get('const.WEEKDAY')[$i->dayOfWeek] }}
                            </a>
                        </td>
                        <td class="holiday">
                            @foreach ($holidays as $holiday) @if ($i->format('n-j') == $holiday->format('n-j')) {{ $holiday->getName() }} @endif @endforeach
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