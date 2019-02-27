<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use SoftDeletes;
    protected $fillable=[
       'cat_id','name','description'
    ];

    public function category(){
        return $this->belongsTo('App\Category','cat_id','id');

    }

}
