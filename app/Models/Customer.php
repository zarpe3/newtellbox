<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'accountcode',
        'plan',
        'notify_voicemail',
    ];

    public function scopeGetAccountCode($query, $accountCode)
    {
        return $query->where('accountcode', $accountCode);
    }

    /**
     * Get all of the voicemails for the Customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function voicemails(): HasMany
    {
        return $this->hasMany(Voicemail::class, 'customer_id', 'id');
    }
}
