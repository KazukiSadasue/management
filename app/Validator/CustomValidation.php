<?php
namespace App\Validator;

class CustomValidation extends \Illuminate\Validation\Validator
{
    public function validateTestStringCheck($attribute, $value, $parameters)
    {
        $pos = strpos($value, 'test');
        
        if($pos === false) {
            return false;
        } else {
            return true;
        }
    }
}