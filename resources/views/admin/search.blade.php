<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>search</title>
        <style>
            table {
                text-align: left;
                width: 600px;
                border: 1px solid;
                border-collapse: collapse;
            }

            td {
                border: 1px solid;
            }

            .top-text {
                width:50px;
            }
        </style>
    </head>
    <body>
          @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif   
        <form method="get">
            <table>
                <tr>
                    <th>
                        勤務日
                    </th>
                    <td>
                        {{ Form::date('start_date', \Carbon\Carbon::now()) }}
                        ～
                        {{ Form::date('end_date', \Carbon\Carbon::now()) }}
                    </td>
                </tr>
                 <tr>
                    <th>プロジェクト</th>
                    <td>
                         {{ Form::select('project_id', $data['projects']) }} 
                    </td>
                </tr> 
                <tr>
                    <th>出勤タイプ</th>
                    <td>
                        @foreach (\Config("const.WORK_TYPE") as $key => $type)
                            <LABEL>
                                <input type="radio" name="type" value="{{ $key }}"
                                    @if ( $key == old("type") )
                                        checked
                                    @endif
                                >{{ $type }}
                            </LAVEL>                        
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>作業内容</th>
                    <td>
                         @foreach (\Config("const.EMPLOYMENT") as $key => $employment)
                            <LABEL>
                                {{Form::checkbox("employment[${key}]", $key)}}
                                {{ $employment }}
                            </LABEL>
                        @endforeach 
                       

                    </td>
                </tr>
                <tr>
                    <th>勤務時間</th>
                    <td>
                        <select name="start_work_hour">
                            @for ($i = 0; $i <= 23; $i++)
                            <option value="{{ $i }}"
                            @if ( $i == old( "start_work_hour" ) )
                                selected
                            @elseif ( is_null( old("start_work_hour") ) )
                                @if ( $i == 10 )
                                    selected
                                @endif
                            @endif>{{ $i }}</option>
                            @endfor
                        </select>時
                        <select name="start_work_min">
                            @for ($i = 0; $i <= 59; $i++)
                                <option value="{{ $i }}"
                                    @if ( $i == old( "start_work_min" ) )
                                        selected
                                    @endif
                                >{{ $i }}</option>
                            @endfor
                        </select>分～
                        <select name="finish_work_hour">
                            @for ($i = 0; $i <= 23; $i++)
                            <option value="{{ $i }}"
                            @if ( $i == old( "finish_work_hour" ) )
                                selected
                            @elseif ( is_null( old("finish_work_hour") ) )
                                @if ( $i == 19 )
                                    selected
                                @endif
                            @endif>{{ $i }}</option>
                            @endfor
                        </select>時
                        <select name="finish_work_min">
                            @for ($i = 0; $i <= 59; $i++)
                            <option value="{{ $i }}"
                                @if ( $i == old( "finish_work_min" ) )
                                    selected
                                @endif
                            >{{ $i }}</option>
                            @endfor
                        </select>分
                    </td>
                </tr>
                <tr>
                    <th>
                        承認
                    </th>
                    <td>
                        {{ Form::select('approval',['1' => '承認済', '0' => '未承認']) }}
                    </td>
                </tr>
            </table>
            {{ csrf_field() }}
            <input type="submit" value="検索">
        </form> 
        <a href="/admin/calendar">戻る</a> 
        
        <table>
            <tr>
                <th>ユーザー名</th>
                <th>該当数</th>
                <th>詳細</th>
            </tr>
            @foreach ( $data['work_schedules'] as $work_schedule )
            <tr>
                <td>{{ $work_schedule['name'] }}</td>
                <td>{{ $work_schedule['target'] }}</td>
                <td><a href="">詳細</a></td>
            </tr>
            @endforeach
        </table>
    </body>
</html>