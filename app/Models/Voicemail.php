<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voicemail extends Model
{
    use HasFactory;
    protected $table = 'voicemails';

    protected $fillable = [
        'customer_id',
        'name',
        'duration',
        'msg_num',
        'dst',
        'src',
        'created_at',
        'updated_at',
        'audio',
    ];
}
