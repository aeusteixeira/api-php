<?php

namespace App\Models;
use App\Models\Model;

class City extends Model{
    protected $table = 'cities';
    
    public $id;
    public $name;
    public $state_id;
    public $created_at;
    public $updated_at;

}