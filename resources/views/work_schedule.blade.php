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

            .top-text {
                width:50px;
            }
        </style>
    </head>
    <body>
        @if (Session::has('error_message'))
            <p>{{ Session::get('error_message') }}</p>
        @endif
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif   
        <form method="post">
            <input type="text" name="year" value={{ $year }} class="top-text" readonly>年
            <input type="text" name="month" value={{ $month }} class="top-text" readonly>月
            <input type="text" name="day" value={{ $day }} class="top-text" readonly>日
            {{ Session::get('name') }}さん
            <table>
                <tr>
                    <th>プロジェクト</th>
                    <td>
                        <select name="project_id">
                            @foreach ($projects as $project)
                                <option value={{ $project->id }}>{{ $project->project_name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>出勤タイプ</th>
                    <td>
                        <input type="radio" name="type" value={{ App\Models\WorkSchedule::TYPE_GO }} checked>{{ Config::get('const.TYPE')["1"] }}
                        <input type="radio" name="type" value={{ App\Models\WorkSchedule::TYPE_AM }}>{{ Config::get('const.TYPE')["2"] }}
                        <input type="radio" name="type" value={{ App\Models\WorkSchedule::TYPE_PM }}>{{ Config::get('const.TYPE')["3"] }}
                        <input type="radio" name="type" value={{ App\Models\WorkSchedule::TYPE_ALL }}>{{ Config::get('const.TYPE')["4"] }}
                    </td>
                </tr>
                <tr>
                    <th>作業内容</th>
                    <td>
                        <input type="checkbox" name="employment[]" value={{ App\Models\WorkSchedule::PROGRAM }}>{{ Config::get('const.EMPLOYMENT')["1"] }}
                        <input type="checkbox" name="employment[]" value={{ App\Models\WorkSchedule::DESIGN }}>{{ Config::get('const.EMPLOYMENT')["2"] }}
                        <input type="checkbox" name="employment[]" value={{ App\Models\WorkSchedule::SPEC }}>{{ Config::get('const.EMPLOYMENT')["3"] }}
                        <input type="checkbox" name="employment[]" value={{ App\Models\WorkSchedule::TEST }}>{{ Config::get('const.EMPLOYMENT')["4"] }}
                    </td>
                </tr>
                <tr>
                    <th>備考</th>
                    <td>
                        <input type="text" name="remarks" value="{{ old('remarks') }}">
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
            </table>
            {{ csrf_field() }}
            <input type="submit" value="登録">
        </form>
        <a href=/calendar/{{ $year }}/{{ $month }}>戻る</a>
    </body>
</html>