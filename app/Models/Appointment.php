<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

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

    /* Always show the purpose with a capital first letter,*/
    protected function purpose(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value === null ? null : Str::ucfirst(trim($value)),
            set: fn (?string $value) => $value === null ? null : Str::ucfirst(trim($value)),
        );
    }
}
