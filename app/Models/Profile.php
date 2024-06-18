<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address1',
        'address2',
        'city',
        'state',
        'zip'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
