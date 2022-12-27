<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;
    protected $fillable =[

        'address',
        'session_price',
        'consulting',
        'available_time_start',
        'available_time_end',
        'user_id',
    ];

    public function favorites()
    {
        return $this->belongsToMany(Favorite::class);//check
    }


    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
    //appointment

}
