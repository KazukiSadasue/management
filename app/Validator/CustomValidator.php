<?php
namespace App\Validator;

use Carbon\Carbon;

class CustomValidator extends \Illuminate\Validation\Validator
{
    /**
     * 仕事時間のバリデーション
     *
     */
    public function validateWorkTime($attribute, $value, $parameters)
    {
        $start_hour = $this->getValue('start_work_hour');
        $start_min = $this->getValue('start_work_min');
        $finish_hour = $this->getValue('finish_work_hour');
        $finish_min = $this->getValue('finish_work_min');
        $start = Carbon::createFromTime($start_hour,$start_min);
        $finish = Carbon::createFromTime($finish_hour,$finish_min);

        return $start->lt($finish);
    }
}