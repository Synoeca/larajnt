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

    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        // 'first_name' => 'string',
        // 'last_name' => 'string',
        // 'phone' => 'int',
        // 'email' => 'email',
        // 'address1' => 'text',
        // 'address2' => 'text',
        // 'city' => 'string',
        // 'state' => 'string',
        // 'zip' => 'int'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
