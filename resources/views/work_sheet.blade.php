<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>work sheet</title>
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
        </style>
    </head>
    <body>
        <h3>{{ $year }}年 {{ $month }}月 {{ $day }}日 {{ Session::get('name') }}さん</h3>
        <form method="post">
            <table>
                <tr>
                    <th>プロジェクト</th>
                    <td>
                        <select name="project_id">
                            @foreach ($projects as $project)
                                <option value={{ $project['id'] }}>{{ $project['project_name'] }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>出勤タイプ</th>
                    <td>
                        <input type="radio" name="work_type" value={{ App\Models\WorkSheet::WORK_TYPE_GO }} checked>出勤
                        <input type="radio" name="work_type" value={{ App\Models\WorkSheet::WORK_TYPE_AM }}>午前休
                        <input type="radio" name="work_type" value={{ App\Models\WorkSheet::WORK_TYPE_PM }}>午後休
                        <input type="radio" name="work_type" value={{ App\Models\WorkSheet::WORK_TYPE_ALL }}>全休
                    </td>
                </tr>
                <tr>
                    <th>作業内容</th>
                    <td>
                        <input type="checkbox" name="work_data" value={{ App\Models\WorkSheet::WORK_DATA_PROGRAM }} checked>プログラム
                        <input type="checkbox" name="work_data" value={{ App\Models\WorkSheet::WORK_DATA_DESIGN }}>デザイン
                        <input type="checkbox" name="work_data" value={{ App\Models\WorkSheet::WORK_DATA_SPEC }}>仕様
                        <input type="checkbox" name="work_data" value={{ App\Models\WorkSheet::WORK_DATA_TEST }}>テスト
                    </td>
                </tr>
                <tr>
                    <th>備考</th>
                    <td>
                        <input type="textbox" name="remarks">
                    </td>
                </tr>
                <tr>
                    <th>勤務時間</th>
                    <td>
                        <select name="start_work_hour">
                            @for ($i = 0; $i <= 23; $i++)
                            <option value={{ $i }} @if ($i == 10) selected @endif>{{ $i }}</option>
                            @endfor
                        </select>時
                        <select name="start_work_min">
                            @for ($i = 0; $i <= 59; $i++)
                            <option value={{ $i }}>{{ $i }}</option>
                            @endfor
                        </select>分～
                        <select name="finish_work_hour">
                            @for ($i = 0; $i <= 23; $i++)
                            <option value={{ $i }} @if ($i == 19) selected @endif>{{ $i }}</option>
                            @endfor
                        </select>時
                        <select name="finish_work_min">
                            @for ($i = 0; $i <= 59; $i++)
                            <option value={{ $i }}>{{ $i }}</option>
                            @endfor
                        </select>分
                    </td>
                </tr>
                <tr>
                    <th>承認</th>
                    <td><input type="checkbox" name="approval" value="1"></td>
                </tr>
            </table>
            {{ csrf_field() }}
            <input type="submit" value="登録">
        </form>
        <a href=/calendar/{{ $year }}/{{ $month }}>戻る</a>
    </body>
</html>