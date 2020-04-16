<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class WebPage_BackgroundModel extends Model
{
    protected $table ='webpage_background';
    protected $primaryKey ='id';
    protected $fillable = ['background_name','image_filename'];
    public $timestamps=true;
}
