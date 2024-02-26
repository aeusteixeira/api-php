<?php

namespace App\Models;
use App\Models\Model;

class User extends Model{
    protected $table = 'users';
    
    public $id;
    public $name;
    public $email;
    public $email_verified_at;
    public $password;
    public $remember_token;
    public $created_at;
    public $updated_at;

    public function address() {
        return $this->hasOne(Address::class, 'user_id', $this->id);
    }
}