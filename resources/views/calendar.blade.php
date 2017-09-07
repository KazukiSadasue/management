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
        <span class="name">{{ Session::get('user')["name"] }}さん</span>
        <img id='icon' src="{{ Session::get('user')['image'] }}">
        <a id="logout" href="/user/logout">ログアウト</a>
        <a href="/user/setting">設定</a>
        
        <div>
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
            <input type="submit" id="send" value="表示">
        </div>
        <hr>
        
        @if (isset($data['last_day']))
            <table>
                <tr>
                    <th>日付</th>
                    <th></th>
                    <th>出勤状況</th>
                    <th>時間</th>
                    <th>プロジェクト</th>
                    <th>承認</th>
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
                            <a class="day" href=/user/calendar/{{ $i->format('Y/n/j') }}>
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
                                @if ( ! is_null( $data['schedules'][$i->format('Y-m-d')]['start_at'] ) )
                                    {{ 
                                        Carbon\Carbon::createFromFormat('H:i:s', $data['schedules'][$i->format('Y-m-d')]['start_at'])->format('H:i')
                                        . '-' .
                                        Carbon\Carbon::createFromFormat('H:i:s', $data['schedules'][$i->format('Y-m-d')]['finish_at'])->format('H:i')
                                    }}
                                @endif
                            @endif
                        </td>
                        <td>
                            @if ( isset( $data['schedules'][$i->format('Y-m-d')] ) )
                                {{ $data['schedules'][$i->format('Y-m-d')]['project_name'] }}
                            @endif
                        </td>
                        <td>
                            @if ( isset( $data['schedules'][$i->format('Y-m-d')] ) )
                                {{ $data['schedules'][$i->format('Y-m-d')]['approval'] == 1 ? '済' : '未' }}
                            @endif
                        </td>
                    </tr>
                @endfor
            </table>
        @endif
    </body>
</html>