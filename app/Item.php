<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Plank\Metable\Metable;

class Item extends Model
{
    use Metable;

    public function user(){
        return $this->belongsTo('User', 'user_id');
    }

    //Code by Justin Cook: http://www.justin-cook.com/2006/03/31/php-parse-a-string-between-two-strings/
    public function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

}
