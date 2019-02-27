<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'cat_id','subcat_id','region_id','done_by','docs','guest_show'
    ];
    public function category(){
        return $this->belongsTo('App\Category','cat_id','id');

    }
    public function subcategory(){
        return $this->belongsTo('App\Subcategory','cat_id','id');

    }
}
