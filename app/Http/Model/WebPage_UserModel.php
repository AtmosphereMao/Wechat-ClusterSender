<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class WebPage_UserModel extends Model
{
    protected $table ='webpage_user';
    protected $primaryKey ='id';
    protected $fillable = ['page_id','NickName','RemarkName','Province','City','user_id','page_css','page_title','page_content','page_background'];
    public $timestamps=true;
}
