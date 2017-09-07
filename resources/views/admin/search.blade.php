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
        <script type="text/javascript">
            function detail(user_id) {
                var condition = location.search;
                if (condition == "") {
                    location.href = "/admin/search/detail?user_id=" + user_id;
                } else {
                    location.href = "/admin/search/detail" + condition + "&user_id=" + user_id;
                }  
            }
        </script>
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
                        {{ Form::date( 'start_date' ) }}
                        ～
                        {{ Form::date( 'end_date' ) }}
                    </td>
                </tr>
                 <tr>
                    <th>プロジェクト</th>
                    <td>
                         {{ Form::select('project_id', $projects, null, ['placeholder' => '------']) }} 
                    </td>
                </tr> 
                <tr>
                    <th>出勤タイプ</th>
                    <td>
                            {{ Form::radio("type", "", true, ['id' => 'type0']) }}
                            {{ Form::label("type0", "すべて") }}
                        @foreach (\Config("const.WORK_TYPE") as $key => $type)
                                {{ Form::radio("type", $key, false, ['id' => "type${key}"]) }}
                                {{ Form::label("type${key}", $type) }}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>作業内容</th>
                    <td>
                        @foreach (\Config("const.EMPLOYMENT") as $key => $employment)
                                {{Form::checkbox("employment[$key]", $key, false, ['id' => "employment${key}"])}}
                                {{ Form::label("employment${key}", $employment) }}
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
        
        <table>
            <tr>
                <th>ユーザー名</th>
                <th>該当数</th>
                <th></th>
            </tr>
            
            @foreach ( $data['work_schedules'] as $work_schedule )
            <tr>
                <td>{{ $work_schedule['name'] }}</td>
                <td>{{ $work_schedule['target'] }}</td>
                <td>
                    <input type="button" onclick="detail({{ $work_schedule['user_id'] }})" value="詳細">
                </td>
            </tr>
            @endforeach
        </table>
        <a href="/admin/calendar">戻る</a> 
    </body>
</html>