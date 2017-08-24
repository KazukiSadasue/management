<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkSchedulePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'project_id' => 'required',
            'type' => 'required|in:' . implode(",", array_keys(\Config("const.WORK_TYPE"))),
            'employment' => 'required',
            'employment.*' => 'in:' . implode(",", array_keys(\Config("const.EMPLOYMENT"))),
            'remarks' => 'max:255',
            "start_work_hour" => "workTime",
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'start_work_hour.work_time' =>'開始時間より後の時間を選択してください'
        ];
    }
}