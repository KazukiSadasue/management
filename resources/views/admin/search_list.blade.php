<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>admin-calendar</title>
        <link rel="stylesheet" type="text/css" href="/css/calendar.css">
        <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="/js/search.js"></script>
    </head>
    <body>
        <select id="year">
            @for ($i = $data['five_years_ago']; $i <= $data['after_five_years']; $i->addYear())
                <option value="{{ $i->year }}" @if ($i->year == $data['last_day']->year) selected @endif>{{ $i->year }}</option>
            @endfor
        </select>
        年
        <select id="month">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" @if ($i == $data['last_day']->month) selected @endif>{{ $i }}</option>
            @endfor
        </select>
        月
        <select id="user">
        </select>
        <input type="submit" id="send" value="検索">
        <a id="logout" href="/user/logout">ログアウト</a>
        
        <h3>
        @foreach ($users as $user) 
            @if ($user['id'] == $data['id']) {{$user["name"]}} @endif
        @endforeach
        さんの勤務表
        </h3>
        @if (isset($data['last_day']))
            <table>
                <tr>
                    <th>日付</th>
                    <th></th>
                    <th>出勤状況</th>
                    <th>時間</th>
                    <th>プロジェクト</th>
                </tr>
                @for ($i = $data['first_day']; $i <= $data['last_day']; $i->addDay())
                    <tr>
                        <td
                            @if ( isset( $data['holidays'][$i->format('d')] ) )
                                id="holi"
                            @endif
                            @if ($i->dayOfWeek == "6") id="sat" @endif
                            @if ($i->dayOfWeek == "0") id="sun" @endif 
                        >
                            <a href=/admin/search/{{ $data['id'] }}/{{ $i->format('Y/n/j') }}>
                                {{ $i->format('j日') }}{{ Config::get('const.WEEKDAY')[$i->dayOfWeek] }}
                            </a>
                        </td>
                        <td class="holiday">
                            @if ( isset( $data['holidays'][$i->format('d')] ) )
                                {{ $data['holidays'][$i->format('d')] }}
                            @endif
                        </td>
                        <td>
                            @if ( isset( $data['schedules'][$i->format('Y-m-d')] ) )
                                {{ \Config("const.WORK_TYPE." . $data['schedules'][$i->format('Y-m-d')]['type']) }}
                            @endif
                        </td>
                        <td>
                            @if ( isset( $data['schedules'][$i->format('Y-m-d')] ) )
                                {{ 
                                    Carbon\Carbon::createFromFormat('H:i:s', $data['schedules'][$i->format('Y-m-d')]['start_at'])->format('H:i')
                                    . '-' .
                                    Carbon\Carbon::createFromFormat('H:i:s', $data['schedules'][$i->format('Y-m-d')]['finish_at'])->format('H:i')
                                }}
                            @endif
                        </td>
                        <td>
                            @if ( isset( $data['schedules'][$i->format('Y-m-d')] ) )
                                {{ $data['schedules'][$i->format('Y-m-d')]['project_name'] }}
                            @endif
                        </td>
                    </tr>
                @endfor
            </table>
        @endif
    </body>
</html>