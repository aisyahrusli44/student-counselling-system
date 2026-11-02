<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'preferred_date',
        'preferred_time',
        'purpose',
        'status',
        'rejection_reason',
    ];
    
     /*Get the student who owns this appointment.*/
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
