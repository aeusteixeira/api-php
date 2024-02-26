<?php

namespace App\Models;
use App\Models\Model;

class Address extends Model{
    protected $table = 'addresses';
    
    public $id;
    public $user_id;
    public $city_id;
    public $street;
    public $zip_code;
    public $created_at;
    public $updated_at;

    public function city() {
        return $this->hasOne(City::class, 'id', $this->city_id);
    }
}