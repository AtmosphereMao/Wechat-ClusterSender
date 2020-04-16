<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class WebPage_CssModel extends Model
{
    protected $table ='webpage_css';
    protected $primaryKey ='id';
    protected $fillable = ['css_name','css_filename','js_filename','snapshot_filename'];
    public $timestamps=true;
}
