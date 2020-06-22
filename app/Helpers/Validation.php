<?php


class Validation
{
    public static array $errors = [];

    private static function isValidCreditCard($num) {
        $num = preg_replace('/[^\d]/', '', $num);
        $sum = '';

        for ($i = strlen($num) - 1; $i >= 0; -- $i) {
            $sum .= $i & 1 ? $num[$i] : $num[$i] * 2;
        }

        return array_sum(str_split($sum)) % 10 === 0;
    }

    public static function isCardValid($number, $name, $cvv, $expiration) {
        if(self::isValidCreditCard($number) === false){
            self::$errors['cardNumber'] = 'Invalid number of card';
        }
        return self::isValidCreditCard($number) and self::isValidData($name, $cvv, $expiration);
    }

    private static function isValidData($name, $cvv, $expiration) {
        return strlen($cvv) == 3 && self::isValidName($name) && self::isValidDate($expiration);
    }

    private static function isValidName($name) {
        if(isset($name)){
            return preg_match("/[0-9a-zA-Z]+/",$name) and ctype_upper(explode(' ', $name)[0]) and ctype_upper(explode(' ', $name)[1]);
        }else{
            self::$errors['name'] = 'Invalid name';
            return false;
        }
    }

    private static function isValidDate($expiration){
        $pos = strpos($expiration, '/');
        if($pos !== false){
            list($month, $year) = explode('/', $expiration);
            if ($year < date('Y') || $year == date('Y') && $month < date('m')) {
                return false;
            }
            $month = str_pad($month, 2, '0', STR_PAD_LEFT);
            if (!preg_match('/^20\d\d$/', $year)) {
                return false;
            }

            if (!preg_match('/^(0[1-9]|1[0-2])$/', $month)) {
                return false;
            }
            return true;
        }

        self::$errors['date'] = 'Invalid expiration';

        return false;
    }

}
