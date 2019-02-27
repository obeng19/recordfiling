<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    protected $fillable = [
        'user_id', 'username', 'date','region_id','activity',
    ];
    public function region(){
        return $this->belongsTo('App\Region','region_id','id');
    }
    public function hospital()
    {
        return $this->belongsTo('App\Hospital','hospital_id','id');
    }
}
