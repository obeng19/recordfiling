<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','done_by', 'code'];
    //
    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }
}
