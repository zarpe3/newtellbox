<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $table = 'queue';
    public $timstamps = true;
    protected $fillable = [
        'customer_id',
        'name',
        'musiconhold',
        'announce',
        'context',
        'timeout',
        'monitor_join',
        'monitor_format',
        'queue_youarenext',
        'queue_thereare',
        'queue_callswaiting',
        'queue_holdtime',
        'queue_minutes',
        'queue_seconds',
        'queue_lessthan',
        'queue_thankyou',
        'queue_reporthold',
        'announce_frequency',
        'announce_round_seconds',
        'announce_holdtime',
        'retry',
        'wrapuptime',
        'maxlen',
        'servicelevel',
        'strategy',
        'joinempty',
        'leavewhenempty',
        'eventmemberstatus',
        'eventwhencalled',
        'reportholdtime',
        'memberdelay',
        'weight',
        'timeoutrestart',
        'periodic_announce',
        'periodic_announce_frequency',
        'ringinuse',
        'setinterfacevar',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function scopeCustomerId($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    public function agents()
    {
        return $this->hasMany(QueueMember::class, 'queue_name', 'name');
    }
}
