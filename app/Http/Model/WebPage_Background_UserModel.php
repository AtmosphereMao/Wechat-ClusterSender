<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class WebPage_Background_UserModel extends Model
{
    protected $table ='webpage_background_user';
    protected $primaryKey ='id';
    protected $fillable = ['image_name','image_filename','user_id'];
    public $timestamps=true;
}
