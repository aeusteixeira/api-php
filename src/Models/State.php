<?php

namespace App\Models;
use App\Models\Model;

class State extends Model{
    protected $table = 'states';
    
    public $id;
    public $name;
    public $created_at;
    public $updated_at;

}