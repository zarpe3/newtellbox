<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     */
    public function voicemails(): HasMany
    {
        return $this->hasMany(Voicemail::class, 'customer_id', 'id');
    }

    /**
     * Get all ivrs.
     */
    public function ivrs(): HasMany
    {
        return $this->hasMany(IVR::class, 'customer_id', 'id');
    }

    /**
     * Get All queues.
     */
    public function queues(): HasMany
    {
        return $this->hasMany(Queue::class, 'customer_id', 'id');
    }

    /**
     * Get all inbounds.
     */
    public function inbounds(): hasMany
    {
        return $this->hasMany(Inbound::class, 'customer_id', 'id');
    }
}
