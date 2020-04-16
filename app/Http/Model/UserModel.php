<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table ='users';
    protected $primaryKey ='id';
    protected $fillable = ['username','password','rule','name','account_id'];
    public $timestamps=false;
}
