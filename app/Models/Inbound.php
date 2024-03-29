<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbound extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'customer_id',
        'did',
        'destiny_type',
        'destiny_value',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function voicemail()
    {
        return $this->hasOne(VoicemailUsers::class, 'mailbox', 'did');
    }
}
