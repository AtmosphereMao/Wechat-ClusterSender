<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class WebPage_ContentModel extends Model
{
    protected $table ='webpage_content';
    protected $primaryKey ='id';
    protected $fillable = ['content_name','content_text','user_id'];
    public $timestamps=true;
}
