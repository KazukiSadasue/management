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
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif   
        <form method="post">
            <input type="text" name="year" value="{{ $year }}" class="top-text" readonly>年
            <input type="text" name="month" value="{{ $month }}" class="top-text" readonly>月
            <input type="text" name="day" value="{{ $day }}" class="top-text" readonly>日
            {{ Session::get('name') }}さん
            <table>
                <tr>
                    <th>プロジェクト</th>
                    <td>
                        <select name="project_id">
                            @foreach ($data['projects'] as $project)
                                <option value="{{ $project->id }}"
                                    @if ( $project->id == old("project_id", $data['entry']['project_id']) )
                                        selected
                                    @endif
                                >{{ $project->project_name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>出勤タイプ</th>
                    <td>
                        @foreach (\Config("const.WORK_TYPE") as $key => $type)
                            <LABEL>
                                <input type="radio" name="type" value="{{ $key }}"
                                    @if ( $key == old("type", $data['entry']['type']) )
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
                                <input type="checkbox" name="employment[]" value="{{ $key }}"
                                    @if ( !$errors->any())
                                        @if ( !is_null( old("employment", $data['employment']) ) )
                                            @foreach ( old("employment", $data['employment']) as $old )
                                                @if ($old == $key)
                                                    checked
                                                @endif
                                            @endforeach
                                        @endif
                                    @elseif ( !is_null( old("employment") ) )
                                        @foreach ( old("employment") as $old )
                                            @if ($old == $key)
                                                checked
                                            @endif
                                        @endforeach
                                    @endif
                                >{{ $employment }}
                            </LABEL>
                        @endforeach
                       

                    </td>
                </tr>
                <tr>
                    <th>備考</th>
                    <td>
                        <input type="text" name="remarks" value=
                            @if ( !is_null( old('remarks', $data['entry']['remarks']) ) )
                                "{{ old('remarks', $data['entry']['remarks']) }}"
                            @endif
                        >
                    </td>
                </tr>
                <tr>
                    <th>勤務時間</th>
                    <td>
                        <select name="start_work_hour">
                            @for ($i = 0; $i <= 23; $i++)
                            <option value="{{ $i }}"
                            @if ( isset( $data['entry']['start_at'] ) )
                                @if ( $i == old( "start_work_hour", \Carbon\Carbon::createFromFormat("H:i:s", $data['entry']['start_at'])->format('G') ) )
                                    selected
                                @endif
                            @elseif ( $i == old( "start_work_hour" ) )
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
                                    @if ( isset( $data['entry']['start_at'] ) )
                                        @if ( $i == old( "start_work_min", \Carbon\Carbon::createFromFormat("H:i:s", $data['entry']['start_at'])->format('i') ) )
                                            selected
                                        @endif
                                    @endif
                                >{{ $i }}</option>
                            @endfor
                        </select>分～
                        <select name="finish_work_hour">
                            @for ($i = 0; $i <= 23; $i++)
                            <option value="{{ $i }}"
                            @if ( isset( $data['entry']['finish_at'] ) )
                                @if ( $i == old( "finish_work_hour", \Carbon\Carbon::createFromFormat("H:i:s", $data['entry']['finish_at'])->format('G') ) )
                                    selected
                                @endif
                            @elseif ( $i == old( "finish_work_hour" ) )
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
                                @if ( isset( $data['entry']['finish_at'] ) )
                                    @if ( $i == old( "finish_work_min", \Carbon\Carbon::createFromFormat("H:i:s", $data['entry']['finish_at'])->format('i') ) )
                                        selected
                                    @endif
                                @endif
                            >{{ $i }}</option>
                            @endfor
                        </select>分
                    </td>
                </tr>
            </table>
            <input type="hidden" name="update" value="{{ $data['update'] }}">
            <input type="hidden" name="id" value="{{ $data['entry']['id'] }}">
            {{ csrf_field() }}
            <input type="submit" value="登録">
        </form>
        <a href=/calendar/{{ $year }}/{{ $month }}>戻る</a>
    </body>
</html>