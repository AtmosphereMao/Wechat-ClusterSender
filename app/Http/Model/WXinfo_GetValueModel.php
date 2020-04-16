<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class WXinfo_GetValueModel extends Model
{
    protected $table ='wxinfo_getvalue';
    protected $primaryKey ='id';
    protected $fillable = ['user_id','friends_info'];
    public $timestamps=true;
}
