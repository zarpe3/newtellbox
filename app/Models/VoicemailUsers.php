<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoicemailUsers extends Model
{
    use HasFactory;

    protected $table = 'voicemail_users';
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'context',
        'mailbox',
        'password',
        'fullname',
        'email',
        'pager',
        'tz',
        'attach',
        'saycid',
        'dialout',
        'callback',
        'review',
        'operator',
        'envelope',
        'sayduration',
        'saydurationm',
        'sendvoicemail',
        'delete',
        'nextaftercmd',
        'forcename',
        'forcegreetings',
        'hidefromdir',
    ];
}
