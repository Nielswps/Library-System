<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    private $typeData = null;

    public function getMeta($key = '', $default = ''){
        if($this->typeData == null){
            $this->typeData = json_decode($this->meta, true);
        }
        if($key == ''){
            return $this->typeData;
        } else if(array_key_exists($key, $this->typeData)){
            return $this->typeData[$key];
        } else{
            return $default;
        }
    }

    public function setMeta($key, $value){
        if($this->typeData == null){
            $this->typeData = json_decode($this->meta, true);
        }
        $this->typeData[$key] = $value;
    }

    public function user(){
        return $this->belongsTo('User', 'user_id');
    }
}
