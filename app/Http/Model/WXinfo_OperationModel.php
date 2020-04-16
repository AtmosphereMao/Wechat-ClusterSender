<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class WXinfo_OperationModel extends Model
{
    protected $table ='wxinfo_operation';
    protected $primaryKey ='id';
    protected $fillable = ['user_id','ip'];
    public $timestamps=true;
}
