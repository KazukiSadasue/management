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
                         {{ Form::select('project_id', $data['projects'], null, ['placeholder' => '------']) }} 
                    </td>
                </tr> 
                <tr>
                    <th>出勤タイプ</th>
                    <td>
                        @foreach (\Config("const.WORK_TYPE") as $key => $type)
                            <LABEL>
                                {{ Form::radio('type', $key) }}
                                {{ $type }}
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
                        {{ Form::selectRange('start_work_hour', 0, 23, null, ['placeholder' => '--']) }}時
                        {{ Form::selectRange('start_work_min', 0, 59, null, ['placeholder' => '--']) }}分～
                        {{ Form::selectRange('finish_work_hour', 0, 23, null, ['placeholder' => '--']) }}時
                        {{ Form::selectRange('finish_work_min', 0, 59, null, ['placeholder' => '--']) }}分
                    </td>
                </tr>
                <tr>
                    <th>
                        承認
                    </th>
                    <td>
                        {{ Form::select('approval',['1' => '承認済', '0' => '未承認'], null, ['placeholder' => '---']) }}
                    </td>
                </tr>
            </table>
            {{ csrf_field() }}
            <input type="submit" value="検索">
            <a href="/admin/search">リセット</a>
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