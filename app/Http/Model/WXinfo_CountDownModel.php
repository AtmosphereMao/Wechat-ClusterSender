<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class WXinfo_CountDownModel extends Model
{
    protected $table ='wxinfo_countdown';
    protected $primaryKey ='id';
    protected $fillable = ['user_id','ip'];
    public $timestamps=true;
}
