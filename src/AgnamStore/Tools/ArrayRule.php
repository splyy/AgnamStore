<?php

namespace AgnamStore\Tools;

class ArrayRule {

    public static function rules(array $array, array $rules) {
        foreach ($rules as $key => $rule) {
            if (!array_key_exists($key, $array)) {
                throw new Exception('The key ' . $key . ' not exist in the array');
            }
            $value = $array[$key];
        }
    }

    private static function matchType($rule, $value, $key) {
        $fail = false;
        switch ($rule) {
            case 'numeric':
                if (!is_numeric($value))
                    $fail = TRUE;
                break;
            case 'int':
                if (!is_int($value))
                    $fail = TRUE;
                break;
            case 'float':
                if (!is_float($value))
                    $fail = TRUE;
                break;
            case 'double':
                if (!is_double($value))
                    $fail = TRUE;
                break;
            case 'string':
                if (!is_string($value))
                    $fail = TRUE;
                break;
            case 'bool':
                if (!is_bool($value))
                    $fail = TRUE;
                break;
            default:
                throw new Exception(__CLASS__.' Rules unknown');
                break;
        }
        
        if($fail){
            throw new Exception('The format of the value '.$key.' is not valid ('.$rule.')');
        }
    }

}
