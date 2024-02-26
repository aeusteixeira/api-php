<?php

namespace App\Models;
use App\Models\Model;

class User extends Model{
    protected $table = 'users';
    public $id;
    public $name;

    public function getComments() {
        return $this->getRelationship(Comments::class, 'user_id', $this->id);
    }
}