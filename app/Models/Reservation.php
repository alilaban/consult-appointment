<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $table ="reservations";
    protected $fillable =[
        'user_id',
        'expert_id',
        'availabe_time',
    ];
/**
 * Get the user that owns the Reservation
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function user()
{
    return $this->belongsTo(User::class,'user_id');
}
//should we add expert???

}
