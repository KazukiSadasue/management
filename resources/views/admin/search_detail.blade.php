<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>admin-calendar</title>
        <link rel="stylesheet" type="text/css" href="/css/calendar.css">
        <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="/js/admin_calendar.js"></script>
    </head>
    <body>
        <table>
            <tr>
                <th>日付</th>
                <th>出勤状況</th>
                <th>時間</th>
                <th>プロジェクト</th>
                <th>承認</th>
            </tr>
            @foreach ($schedules as $schedule)
                <tr>
                    <td>
                        <a href=/admin/calendar/{{ $schedule['user_id'] }}/{{ Carbon\Carbon::createFromFormat('Y-m-d', $schedule['day_at'])->format('Y/m/d') }}>
                            {{ $schedule['day_at'] }}
                        </a>
                    </td>
                    <td>{{ \Config("const.WORK_TYPE." . $schedule['type']) }}</td>
                    <td>
                        @if ( ! is_null($schedule['start_at'] ) )
                            {{ 
                                Carbon\Carbon::createFromFormat('H:i:s', $schedule['start_at'])->format('H:i')
                                . '-' .
                                Carbon\Carbon::createFromFormat('H:i:s', $schedule['finish_at'])->format('H:i')
                            }}
                        @endif
                    </td>
                    <td>{{ $schedule['project_name'] }}</td>
                    <td>{{ $schedule['approval'] == 1 ? '済' : '未' }}</td>
                </tr>
            @endforeach
        </table>
        <a href="/admin/search">戻る</a>
    </body>
</html>