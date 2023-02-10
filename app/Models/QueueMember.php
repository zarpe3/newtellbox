<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueMember extends Model
{
    use HasFactory;
    protected $table = 'queue_member';
    public $timstamps = true;
    protected $fillable = [
        'uniqueid',
        'membername',
        'queue_name',
        'interface',
        'penalty',
        'paused',
    ];
}
