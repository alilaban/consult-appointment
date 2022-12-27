<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'expert_id'

    ];

 public function expert()
 {
     return $this->hasMany(Expert::class,'expert_id' );
 }
}
